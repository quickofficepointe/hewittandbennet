<?php

namespace App\Http\Controllers\Portal\Student;

use App\Models\Payment;
use App\Support\Statement;

class FeeController extends StudentPortalController
{
    public function index()
    {
        $student = $this->student();

        return view('portal.student.fees', [
            'student' => $student,
            'lines' => Statement::for($student),
            'feeItems' => $student->course->feeItems()->orderByRaw('term_no IS NULL DESC')->orderBy('term_no')->get(),
        ]);
    }

    public function receipt(Payment $payment)
    {
        abort_unless($payment->student_id === $this->student()->id, 403);
        $payment->load('student.course', 'receiver');

        return view('portal.receipt', compact('payment'));
    }
}
