<?php

namespace App\Http\Controllers\Portal\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Expenses are recorded by Accounts and approved by the Director before counting as spent. */
class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::with('category', 'recorder', 'approver')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('category_id'), fn ($q) => $q->where('expense_category_id', $request->category_id))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('expense_date', '>=', $request->from))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('expense_date', '<=', $request->to))
            ->latest('expense_date')->latest('id');

        $total = (clone $expenses)->sum('amount');

        return view('portal.accounts.expenses', [
            'expenses' => $expenses->paginate(30)->withQueryString(),
            'total' => $total,
            'categories' => ExpenseCategory::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'description' => 'required|string|max:255',
            'payee' => 'nullable|string|max:150',
            'amount' => 'required|numeric|min:1',
            'expense_date' => 'required|date|before_or_equal:today',
            'method' => ['required', Rule::in(array_keys(Payment::METHODS))],
            'reference' => 'nullable|string|max:100',
        ]);

        Expense::create($data + ['status' => 'pending', 'recorded_by' => auth()->id()]);

        return back()->with('success', 'Expense recorded and sent to the Director for approval.');
    }

    public function destroy(Expense $expense)
    {
        abort_unless($expense->status === 'pending', 422, 'Only pending expenses can be deleted.');
        $expense->delete();

        return back()->with('success', 'Expense deleted.');
    }

    public function storeCategory(Request $request)
    {
        ExpenseCategory::create($request->validate(['name' => 'required|string|max:100|unique:expense_categories,name']));

        return back()->with('success', 'Expense category added.');
    }
}
