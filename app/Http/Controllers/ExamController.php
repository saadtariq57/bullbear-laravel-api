<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\ExamQuestion;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class ExamController extends Controller
{

    public function getAllExams(Request $request)
    {
        // Retrieve query parameters
        $search = $request->query('search');
        $type = $request->query('type');
        // Initialize the query builder for Exam
        $query = Exam::query();

        // Filter by exam type if provided
        if ($type) {
            $query->where('type', $type);
        }

        // Implement search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%");
            });
        }

        // Fetch all exams (will paginate by category blocks manually)
        $exams = $query->orderBy('type')
                       ->orderBy('category')
                       ->orderByDesc('created_at')
                       ->get();

        // Get the exams IDs for results lookup
        $examIds = $exams->pluck('id')->toArray();

        // Retrieve the authenticated user, if any
        $user = $request->user();
        $userId = $user ? $user->id : null;

        // Initialize an empty collection for latest results
        $latestResults = collect();

        if ($userId) {
            // Fetch the latest exam_result for each exam for the user
            $latestResults = ExamResult::where('user_id', $userId)
                                ->whereIn('exam_id', $examIds)
                                ->orderBy('exam_id')
                                ->orderByDesc('exam_date')
                                ->get()
                                ->groupBy('exam_id')
                                ->map(function ($group) {
                                    return $group->first();
                                });
        }

        // Define the cutoff date for attempting the exam
        $oneWeekAgo = Carbon::now()->subWeek();

        // Attach 'canAttempt' to each exam
        $exams->transform(function ($exam) use ($latestResults, $oneWeekAgo, $userId) {
            if (!$userId) {
                // No authenticated user; cannot attempt
                $exam->canAttempt = false;
            } else {
                $lastResult = $latestResults->get($exam->id);

                if (!$lastResult) {
                    // User has never attempted this exam
                    $exam->canAttempt = true;
                } else {
                    // Parse the last attempt date
                    $lastAttemptDate = Carbon::parse($lastResult->exam_date);
                    // Determine if the last attempt was at least one week ago
                    $exam->canAttempt = $lastAttemptDate->lessThanOrEqualTo($oneWeekAgo);
                }
            }

            return $exam;
        });

        // Group exams by Type and then by Category
        $groupedExams = $exams->groupBy('type')->map(function ($typeGroup) {
            return $typeGroup->groupBy('category');
        });

        // Flatten grouped exams into category blocks for manual pagination
        $categoryBlocks = collect();
        foreach ($groupedExams as $type => $categories) {
            foreach ($categories as $category => $items) {
                $categoryBlocks->push([
                    'type' => $type,
                    'category' => $category,
                    'exams' => $items->values(),
                ]);
            }
        }

        $categoriesPerPage = 4;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginatedBlocks = $categoryBlocks
            ->slice(($currentPage - 1) * $categoriesPerPage, $categoriesPerPage)
            ->values();

        $paginator = new LengthAwarePaginator(
            $paginatedBlocks,
            $categoryBlocks->count(),
            $categoriesPerPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        // Reconstruct nested structure using only paginated blocks
        $paginatedGrouped = $paginatedBlocks->groupBy('type')->map(function ($blocks) {
            return $blocks->mapWithKeys(function ($block) {
                return [$block['category'] => $block['exams']];
            });
        });

        // Prepare the final response structure
        $response = [
            'data' => $paginatedGrouped,
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],
        ];

        return response()->json($response);
    }

    public function initiateExam($examId)
    {
        $exam = Exam::with(['questions' => function ($query) {
            $query->orderBy('id')->first();
        }])->find($examId);

        if ($exam && $exam->questions->isNotEmpty()) {
            $firstQuestionId = $exam->questions->first()->id;
            $examNameFormatted = strtolower(str_replace(' ', '-', $exam->title));
            $timeLimit = $exam->per_question_time_limit;

            return response()->json([
                'firstQuestionId' => $firstQuestionId,
                'examName' => $examNameFormatted,
                'examId' => $examId,
                'timeLimit' => $timeLimit,
            ]);
        } else {
            return response()->json(['error' => 'No questions found for this exam'], 404);
        }
    }


    public function getExamQuestions($examId)
    {
        $questions = ExamQuestion::where('exam_id', $examId)->get();
        if ($questions->isNotEmpty()) {
            return response()->json(['questions' => $questions]);
        } else {
            return response()->json(['error' => 'No questions found for this exam'], 404);
        }
    }

    public function submitExam(Request $request, $examId)
    {
        $user = auth()->user();
        $userAnswers = $request->input('userAnswers');
        $totalTimeSpent = 0;

        // Logic to calculate the results
        $totalQuestions = count($userAnswers);
        $correctAnswers = 0;
        foreach ($userAnswers as $answer) {
            $totalTimeSpent += $answer['timeSpent'];
            $question = ExamQuestion::find($answer['questionId']);
            if ($question && $question->correct_answer === $answer['answer']) {
                $correctAnswers++;
            }
        }

        $percentage = ($correctAnswers / $totalQuestions) * 100;

        // Store the results in the database
        $examResult = ExamResult::create([
            'user_id' => $user->id,
            'exam_id' => $examId,
            'exam_date' => now(),
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'percentage' => $percentage,
            'time_consumed' => $totalTimeSpent,
        ]);

        // Return the result ID for redirection
        return response()->json(['examResultId' => $examResult->id]);
    }

    public function getExamResult($examResultId)
    {
        $examResult = ExamResult::find($examResultId);

        if ($examResult) {
            // Return the result data
            return response()->json($examResult);
        } else {
            abort(404, 'Result not found');
        }
    }

    public function getAllExamResult()
    {
        $results = ExamResult::orderBy('exam_date', 'desc')->get();
        return response()->json($results);
    }

    public function getRecommendedExams(Request $request)
    {
        $user = $request->user();
        // Recommend the latest 5 exams that the user hasn't taken yet.
        $takenExamIds = ExamResult::where('user_id', $user->id)->pluck('exam_id')->toArray();

        $recommendedExams = Exam::whereNotIn('id', $takenExamIds)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        return response()->json($recommendedExams);
    }

    public function getPastPerformance(Request $request)
    {
        $user = $request->user();

        // Fetch past exam results with related exam details
        $pastResults = ExamResult::where('user_id', $user->id)
                                 ->with('exam')
                                 ->orderBy('exam_date', 'desc')
                                 ->take(5)
                                 ->get();

        return response()->json($pastResults);
    }

    // Admin panel Routes Below

    /**
     * Display a listing of exam results for admin.
     */
    public function resultsIndex(Request $request)
    {
        $search = $request->query('search');
        
        $query = ExamResult::with(['user', 'exam'])
            ->orderBy('exam_date', 'desc');

        // Search functionality
        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('exam', function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%");
            });
        }

        $results = $query->paginate(15);

        return view('admin.exams.results.index', compact('results'));
    }

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $exams = Exam::where('title', 'LIKE', "%{$search}%")
                ->orWhere('category', 'LIKE', "%{$search}%")
                ->paginate(10);
        } else {
            $exams = Exam::paginate(10);
        }

        return view('admin.exams.index', compact('exams'));
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
            'type' => 'required|in:basic,advanced',
            'description' => 'nullable|string',
            'number_of_questions' => 'required|integer|min:1',
            'per_question_time_limit' => 'required|integer|min:1',
            'featured_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('featured_img')) {
            $data['featured_img'] = $request->file('featured_img')->store(
                "photos/" . now()->year . "/" . now()->month, 'public'
            );
        }

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

        $dbQuestions = $exam->questions;

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
            'questions.*.featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
                if ($question) { // Check if the question exists
                    // Handle image upload if provided
                    if (isset($questionData['featured_image']) && $questionData['featured_image'] instanceof UploadedFile) {
                        $path = $questionData['featured_image']->store(
                            "photos/" . now()->year . "/" . now()->month, 'public'
                        );
                        $questionData['featured_image'] = $path;
                    }
                    // Update the existing question with the new data
                    $question->update($questionData);
                }
            } else {
                // Handle image upload if provided
                if (isset($questionData['featured_image']) && $questionData['featured_image'] instanceof UploadedFile) {
                    $path = $questionData['featured_image']->store(
                        "photos/" . now()->year . "/" . now()->month, 'public'
                    );
                    $questionData['featured_image'] = $path;
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
            'type' => 'required|in:basic,advanced',
            'description' => 'nullable|string',
            'number_of_questions' => 'required|integer|min:1',
            'per_question_time_limit' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('featured_img')) {
            $data['featured_img'] = $request->file('featured_img')->store(
                "photos/" . now()->year . "/" . now()->month, 'public'
            );
        } else {
            $data['featured_img'] = $exam->featured_img;
        }

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
        if ($search) {
            $categories = ExamCategory::where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
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
        $category = $examCategory;
        return view('admin.exams.categories.edit', compact('category'));
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
