<?php

namespace App\Http\Controllers\Portal\Accounts;

use App\Http\Controllers\Controller;
use App\Models\courses;
use App\Models\FeeStructureItem;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    public function index(Request $request)
    {
        $courses = courses::with(['feeItems' => fn ($q) => $q->orderByRaw('term_no IS NULL DESC')->orderBy('term_no')->orderBy('name')])
            ->orderBy('name')->get();
        $selected = $courses->firstWhere('id', (int) $request->input('course_id')) ?? $courses->first();

        return view('portal.accounts.fees', compact('courses', 'selected'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'term_no' => 'nullable|integer|min:1|max:12',
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
        ]);

        FeeStructureItem::create($data);

        return redirect()->route('portal.accounts.fees.index', ['course_id' => $data['course_id']])->with('success', 'Fee item added.');
    }

    public function destroy(FeeStructureItem $item)
    {
        $item->delete();

        return back()->with('success', 'Fee item removed. Existing invoices are not affected.');
    }
}
