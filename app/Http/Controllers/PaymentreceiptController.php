<?php

namespace App\Http\Controllers;

use App\Models\fees_statement;
use App\Models\paymentreceipt;
use App\Models\student_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
class PaymentreceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getStudentInfo($studentNumber)
{
    // Query the database to find the student by their student number
    $student = student_data::where('student_no', $studentNumber)->first();

    if ($student) {
        return response()->json(['success' => true, 'student' => $student]);
    } else {
        return response()->json(['success' => false]);
    }
}

    public function index()
    {
        $paymentReceipts = PaymentReceipt::all();
        return view('dashboards.staff.accounts.index',compact('paymentReceipts'));
    }
    public function print($id)
{
    $paymentReceipt = PaymentReceipt::findOrFail($id);

    return view('dashboards.staff.accounts.print', compact('paymentReceipt'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentDate = Carbon::now();
        $dayOfWeekAbbreviation = strtoupper(substr($currentDate->format('D'), 0, 1));
        $ReceiptNo = 'HBIC' . $dayOfWeekAbbreviation . str_pad(PaymentReceipt::count() + 1, 3, '0', STR_PAD_LEFT);

        $validatedData = $request->validate([
            'Name' => 'required|string',
            'student_no' => 'required|string',
            'Amount' => 'required|numeric',
            'contact' => 'required|numeric',
            'paymentfor' => 'required|string',
            'modeofpayment' => 'required|string',
            'served_by' => 'required|exists:users,id',
        ]);

        $studentNumber = $request->input('student_no');
        $amountPaid = $request->input('Amount');

        // Fetch the student by their student number
        $student = student_data::where('student_no', $studentNumber)->first();
        if ($student) {
            // Get the student's course fee
            $course_fee = $student->course_fee;

            // Calculate the new fee balance for the student
            $existingBalance = $student->fee_balance ?? $course_fee; // Use the existing balance or set it to the course fee initially
            $newBalance = $existingBalance - $amountPaid; // Deduct the amount paid from the existing balance

            // Update the student's fee balance in the database
            $student->update(['fee_balance' => $newBalance]);

            // Create a new payment receipt record in the database
            $paymentReceipt = PaymentReceipt::create([
                'ReceiptNo' => $ReceiptNo,
                'Name' => $request->input('Name'),
                'student_no' => $studentNumber,
                'Amount' => $amountPaid,
                'contact' => $request->input('contact'),
                'paymentfor' => $request->input('paymentfor'),
                'modeofpayment' => $request->input('modeofpayment'),
                'served_by' => $request->input('served_by'),
            ]);

            // Calculate the remaining amount based on individual payments
            $remainingAmount = $course_fee - $student->paymentReceipts->sum('Amount');

            // Create a new fees statement record in the database
            fees_statement::create([
                'student_no' => $studentNumber,
                'course_fee' => $course_fee,
                'paid_amount' => $amountPaid,
                'remaining_amount' => $remainingAmount,
                'payment_date' => now(),
            ]);
        } else {
            Log::info("Student not found with student_no: $studentNumber");
        }

        return redirect()->route('Paymentreceipt.index')
            ->with('success', 'Payment receipt created successfully.');
    }









    /**
     * Display the specified resource.
     */
    public function show(paymentreceipt $paymentreceipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(paymentreceipt $paymentreceipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, paymentreceipt $paymentreceipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(paymentreceipt $paymentreceipt)
    {
        //
    }
}
