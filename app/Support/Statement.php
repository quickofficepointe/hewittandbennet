<?php

namespace App\Support;

use App\Models\Student;
use Illuminate\Support\Collection;

/** Builds a running-balance fee statement (invoices = debit, payments = credit). */
class Statement
{
    public static function for(Student $student): Collection
    {
        $debits = $student->invoices()->get()->map(fn ($invoice) => [
            'date' => $invoice->invoice_date,
            'reference' => $invoice->invoice_no,
            'description' => $invoice->description,
            'debit' => (float) $invoice->amount,
            'credit' => 0.0,
            'payment' => null,
            'sort' => $invoice->invoice_date->format('Ymd').'0'.$invoice->id,
        ]);

        $credits = $student->payments()->get()->map(fn ($payment) => [
            'date' => $payment->paid_on,
            'reference' => $payment->receipt_no,
            'description' => 'Payment - '.(\App\Models\Payment::METHODS[$payment->method] ?? $payment->method).($payment->reference ? " ({$payment->reference})" : ''),
            'debit' => 0.0,
            'credit' => (float) $payment->amount,
            'payment' => $payment,
            'sort' => $payment->paid_on->format('Ymd').'1'.$payment->id,
        ]);

        $balance = 0;

        return $debits->concat($credits)->sortBy('sort')->values()->map(function ($line) use (&$balance) {
            $balance += $line['debit'] - $line['credit'];

            return $line + ['balance' => $balance];
        });
    }
}
