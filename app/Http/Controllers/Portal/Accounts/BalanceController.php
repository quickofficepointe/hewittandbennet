<?php

namespace App\Http\Controllers\Portal\Accounts;

use App\Http\Controllers\Controller;
use App\Models\courses;
use App\Models\Student;
use App\Support\Statement;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    /** Student balances / fee defaulters list. */
    public function index(Request $request)
    {
        $query = Student::with('course')->withBalance()
            ->when($request->filled('course_id'), fn ($q) => $q->where('course_id', $request->course_id))
            ->when($request->input('status', 'active') !== 'all', fn ($q) => $q->where('status', $request->input('status', 'active')))
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($q) => $q
                ->where('admission_no', 'like', "%{$request->q}%")
                ->orWhere('first_name', 'like', "%{$request->q}%")
                ->orWhere('last_name', 'like', "%{$request->q}%")));

        $students = $query->get()->each(fn ($s) => $s->setAttribute('outstanding', (float) $s->billed - (float) $s->paid));

        $students = match ($request->input('filter', 'owing')) {
            'owing' => $students->filter(fn ($s) => $s->outstanding > 0),
            'cleared' => $students->filter(fn ($s) => $s->outstanding <= 0),
            default => $students,
        };

        if ($request->filled('min')) {
            $students = $students->filter(fn ($s) => $s->outstanding >= (float) $request->min);
        }

        return view('portal.accounts.balances', [
            'students' => $students->sortByDesc('outstanding')->values(),
            'courses' => courses::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function statement(Student $student)
    {
        $student->load('course');

        return view('portal.accounts.statement', [
            'student' => $student,
            'lines' => Statement::for($student),
        ]);
    }
}
