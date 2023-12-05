<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->query('search');

        if($search) {
            $exams = Exam::where('title', 'LIKE', "%{$search}%")
                             ->orWhere('category', 'LIKE', "%{$search}%")
                             // ... add other fields if needed
                             ->paginate(10);
        } else {
            $exams = Exam::paginate(10);
        }

        return view('admin.exams.index', compact('exams'));
        //return view('admin.symbols.index', ['symbols' => $symbols]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ExamCategory::all();
        return view('admin.exams.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'number_of_questions' => 'required|integer|min:1',
            'per_question_time_limit' => 'required|integer|min:1',
        ]);

        $exam = Exam::create($data);

        return redirect()->route('admin.exams.index', $exam->id)->with('success', 'Exam created successfully. Now add questions for the exam.');
    }

        /**
     * Show the form for adding questions to an exam.
     */
    public function addQuestions(Request $request, Exam $exam)
    {
        // Check if the request method is POST
        if ($request->isMethod('post')) {
            return $this->storeQuestions($request, $exam);
        }

        $dbQuestions = $exam->questions; // This fetches the related questions using the assumed relationship

        return view('admin.exams.add_questions', compact('exam', 'dbQuestions'));
    }

    /**
     * Store the questions of a specific exam.
     */
    public function storeQuestions(Request $request, Exam $exam)
    {
        $data = $request->validate([
            'exam_id' => 'required|integer',
            'questions.*.id' => 'nullable|integer',
            'questions.*.question_text' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_answer' => 'required|in:A,B,C,D',
            'questions.*.featured_image' => 'nullable|file|image', // Adjusted for actual image upload
        ]);

        // Get list of IDs of questions currently in the database for the exam
        $existingQuestionIds = $exam->questions()->pluck('id')->toArray();

        // Extract IDs from the submitted data
        $submittedQuestionIds = array_filter(array_column($data['questions'], 'id'));

        // Determine which questions have been removed in the new submission
        $questionsToDelete = array_diff($existingQuestionIds, $submittedQuestionIds);
        if (!empty($questionsToDelete)) {
            ExamQuestion::whereIn('id', $questionsToDelete)->delete();
        }

        // Process each submitted question
        foreach ($data['questions'] as $questionData) {
            // Check if a question ID is provided (existing question)
            if (isset($questionData['id'])) {
                $question = $exam->questions()->find($questionData['id']);
                if ($question) { // Check if the question really exists in the database
                    // Handle image upload if provided
                    if (isset($questionData['featured_image']) && $questionData['featured_image'] instanceof UploadedFile) {
                        // $path = $questionData['featured_image']->store('path/to/store');
                        // $questionData['featured_image'] = $path;
                    }
                    // Update the existing question with the new data
                    $question->update($questionData);
                }
            } else { // New question (no ID provided)
                // Handle image upload if provided
                if (isset($questionData['featured_image']) && $questionData['featured_image'] instanceof UploadedFile) {
                    // $path = $questionData['featured_image']->store('path/to/store');
                    // $questionData['featured_image'] = $path;
                }
                // Create a new question
                $exam->questions()->create($questionData);
            }
        }

        return redirect()->route('admin.exams.index')->with('success', 'Questions updated successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        $categories = ExamCategory::all();
        return view('admin.exams.edit', compact('exam', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'number_of_questions' => 'required|integer|min:1',
            'per_question_time_limit' => 'required|integer|min:1',
        ]);

        $exam->update($data);

        return redirect()->route('admin.exams.index')->with('success', 'Exam updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('admin.exams.index')->with('success', 'Exam deleted successfully.');
    }

     /**
     * Display a listing of the exam categories.
     */
    public function categoriesIndex(Request $request)
    {
        $search = $request->query('search');
        if($search) {
            $categories = ExamCategory::where('name', 'LIKE', "%{$search}%")
                             ->orWhere('description', 'LIKE', "%{$search}%")
                             // ... add other fields if needed
                             ->paginate(10);
        } else {
            $categories = ExamCategory::paginate(10);
        }

        return view('admin.exams.categories.index', compact('categories'));
    }


    /**
     * Show the form for creating a new exam category.
     */
    public function categoriesCreate()
    {
        return view('admin.exams.categories.create');
    }

    /**
     * Store a newly created exam category in storage.
     */
    public function categoriesStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:exam_categories,name',
            'description' => 'nullable|string'
        ]);

        ExamCategory::create($data);

        return redirect()->route('admin.exams.categories.index')->with('success', 'Exam category created successfully.');
    }

    /**
     * Show the form for editing the specified exam category.
     */
    public function categoriesEdit(ExamCategory $examCategory)
    {
        return view('admin.exams.categories.edit', compact('examCategory'));
    }

    /**
     * Update the specified exam category in storage.
     */
    public function categoriesUpdate(Request $request, ExamCategory $examCategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:exam_categories,name,' . $examCategory->id,
            'description' => 'nullable|string'
        ]);

        $examCategory->update($data);

        return redirect()->route('admin.exams.categories.index')->with('success', 'Exam category updated successfully.');
    }

    /**
     * Remove the specified exam category from storage.
     */
    public function categoriesDestroy(ExamCategory $examCategory)
    {
        $examCategory->delete();

        return redirect()->route('admin.exams.categories.index')->with('success', 'Exam category deleted successfully.');
    }
}
