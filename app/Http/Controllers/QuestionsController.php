<?php

namespace App\Http\Controllers;

use App\Models\online_exams;
use App\Models\questions;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $exams = online_exams::all();
    return view('dashboards.student.onlineexams.index', compact('exams'));
}


    public function start($online_exams_id, $set = 1)
    {
        // Check if the user is logged in
        if (!auth()->check()) {
            // Redirect to the login page
            return redirect()->route('login');
        }

        // Assuming you have a model called 'OnlineExam' that represents exams
        $exam = online_exams::find($online_exams_id);
        $totalTime = $exam->duration;

        if (!$exam) {
            // Handle the case where the exam with the given ID is not found
            return abort(404); // You can customize the error response as needed
        }

        // Get all questions related to this exam
        $allQuestions = $exam->questions;

        // Paginate the questions based on the current set and the desired number of questions per page
        $questionsPerPage = 3; // You can change this to your desired number

        // Paginate the questions using Laravel's built-in paginate method
        $questions = $allQuestions->slice(($set - 1) * $questionsPerPage, $questionsPerPage);

        // Calculate the overall question number based on the current set and question index within the set
        $questionNumberStart = ($set - 1) * $questionsPerPage + 1;

        return view('dashboards.student.onlineexams.exams', compact('questions', 'exam', 'totalTime', 'set', 'questionNumberStart'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }
    public function store(Request $request)
    {
        // Validate the incoming request data
    $validatedData = $request->validate([

        'online_exams_id' => 'required|exists:online_exams,id', // Make sure the online exam exists
        'text' => 'required|string',
    ]);

    // Create a new question using the validated data
    questions::create($validatedData);

    // Redirect to a success page or return a response as needed
    return redirect()->route('tutor_exams.index')->with('success', 'Question created successfully.');
}
}