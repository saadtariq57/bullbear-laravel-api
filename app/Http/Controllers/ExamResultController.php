<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = ExamResult::orderBy('exam_date', 'desc')->get(); // Or fetch results based on your specific requirements
        return response()->json($results);
    }
    public function getAllExams(Request $request)
{
    $search = $request->query('search');

    if ($search) {
        $exams = Exam::where('title', 'LIKE', "%{$search}%")
            ->orWhere('category', 'LIKE', "%{$search}%")
            ->paginate(10);
    } else {
        $exams = Exam::paginate(10);
    }

    // Extract only the titles from the exams
    $examTitles = $exams->pluck('title')->toArray();

    return response()->json(['examTitles' => $examTitles]);
}

    public function getExamQuestions($examId)
    {
        // \Log::info("Received exam ID: $examId");

        $questions = ExamQuestion::where('exam_id', $examId)->get();
        if ($questions->isNotEmpty()) {
            return response()->json(['questions' => $questions]);
        } else {
            return response()->json(['error' => 'No questions found for this exam'], 404);
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
    public function show(ExamResult $examResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExamResult $examResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamResult $examResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamResult $examResult)
    {
        //
    }
}
