<?php

namespace App\Http\Controllers\Portal\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Unit;

abstract class StudentPortalController extends Controller
{
    protected function student(): Student
    {
        $student = auth()->user()->student;
        abort_unless($student, 403, 'Your login is not linked to a student record. Please contact the registrar.');

        return $student->load('course', 'intake', 'campus');
    }

    protected function authorizeUnit(Student $student, Unit $unit): void
    {
        abort_unless($unit->isTakenBy($student), 403, 'This unit is not part of your course.');
    }
}
