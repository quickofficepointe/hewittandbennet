<?php

namespace App\Http\Controllers\Portal\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with('student', 'receiver')
            ->when($request->filled('method'), fn ($q) => $q->where('method', $request->method))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('paid_on', '>=', $request->from))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('paid_on', '<=', $request->to))
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($q) => $q
                ->where('receipt_no', 'like', "%{$request->q}%")
                ->orWhere('reference', 'like', "%{$request->q}%")
                ->orWhereHas('student', fn ($s) => $s->where('admission_no', 'like', "%{$request->q}%")
                    ->orWhere('first_name', 'like', "%{$request->q}%")->orWhere('last_name', 'like', "%{$request->q}%"))))
            ->latest('paid_on')->latest('id');

        $total = (clone $payments)->sum('amount');

        return view('portal.accounts.payments.index', [
            'payments' => $payments->paginate(30)->withQueryString(),
            'total' => $total,
        ]);
    }

    /** Step 1: search for the student. Step 2 (with ?student=): the payment form. */
    public function create(Request $request)
    {
        $student = $request->filled('student') ? Student::with('course')->findOrFail($request->student) : null;

        $matches = ! $student && $request->filled('q')
            ? Student::with('course')->where(fn ($q) => $q
                ->where('admission_no', 'like', "%{$request->q}%")
                ->orWhere('first_name', 'like', "%{$request->q}%")
                ->orWhere('last_name', 'like', "%{$request->q}%")
                ->orWhere('phone', 'like', "%{$request->q}%")
                ->orWhere('id_number', 'like', "%{$request->q}%"))
                ->take(20)->get()
            : collect();

        return view('portal.accounts.payments.create', compact('student', 'matches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:1',
            'method' => ['required', Rule::in(array_keys(Payment::METHODS))],
            'reference' => ['nullable', 'string', 'max:100', Rule::requiredIf(in_array($request->method, ['mpesa', 'bank', 'cheque'], true))],
            'paid_on' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:255',
        ]);

        if (! empty($data['reference']) && Payment::where('method', $data['method'])->where('reference', $data['reference'])->exists()) {
            return back()->withInput()->withErrors(['reference' => 'A payment with this transaction reference has already been recorded.']);
        }

        $payment = DB::transaction(fn () => Payment::create($data + [
            'receipt_no' => Payment::nextReceiptNo(),
            'received_by' => auth()->id(),
        ]));

        return redirect()->route('portal.accounts.payments.receipt', $payment)->with('success', 'Payment recorded. Receipt '.$payment->receipt_no.' is ready to print.');
    }

    public function receipt(Payment $payment)
    {
        $payment->load('student.course', 'receiver');

        return view('portal.receipt', compact('payment'));
    }

    /** Reverses a payment captured in error. */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('portal.accounts.payments.index')->with('success', "Receipt {$payment->receipt_no} reversed.");
    }
}
