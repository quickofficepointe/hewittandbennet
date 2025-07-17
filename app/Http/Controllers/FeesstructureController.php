<?php

namespace App\Http\Controllers;

use App\Models\feesstructure;
use App\Models\fees_statement;
use App\Models\student_data;
use App\Models\paymentreceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class FeesstructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        $feeStructures = PaymentReceipt::all();
        // Check if the user is logged in and has an email
        if ($user && $user->email) {
            // Try to retrieve the student based on the user's email
            $studentByEmail = student_data::where('email', $user->email)->first();

            // If a student is found by email, use that student's data
            if ($studentByEmail) {
                $student = $studentByEmail;
            } else {
                // If not found, try to retrieve the student based on the student number
                $studentByStudentNo = student_data::where('student_no', $user->student_no)->first();

                // If a student is found by student number, use that student's data
                if ($studentByStudentNo) {
                    $student = $studentByStudentNo;
                } else {
                    // Student not found by email or student number
                    return redirect()->back()->with('error', 'Student not found with the provided email address or student number.');
                }
            }

            // Retrieve all fee structures for the student by student number
            $feeStructures = fees_statement::where('student_no', $student->student_no)->get();

            if ($feeStructures->count() > 0) {
                // Render the view and pass the feeStructures data
                return view('dashboards.student.feesstatement.index', ['feeStructures' => $feeStructures]);
            } else {
                // Fee structures not found
                return redirect()->back()->with('error', 'Fee structures not found for this student.');
            }
        } else {
            // User not logged in or has no email
            return redirect()->back()->with('error', 'User not logged in or has no email address.');
        }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(feesstructure $feesstructure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(feesstructure $feesstructure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, feesstructure $feesstructure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(feesstructure $feesstructure)
    {
        //
    }
}
