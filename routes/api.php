<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\SymbolController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/check-login', function () {
    if (auth()->check()) {
        return response()->json(['loggedIn' => true]);
    } else {
        return response()->json(['loggedIn' => false]);
    }
});

Route::get('/color-options', [HomeController::class, 'colorOptions']);
Route::get('/fetch-link-data', [HomeController::class, 'fetchLinkData']);
Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('/user-feed', [PostController::class, 'getUserFeed']);
Route::get('/user-profile', [PostController::class, 'getUserProfileFeed']);
Route::get('/user-group/{groupId}', [PostController::class, 'getUserGroupFeed']);
Route::post('/submit-comment', [PostController::class, 'submitComment']);
Route::post('/edit-comment', [PostController::class, 'editComment']);
Route::post('/delete-comment', [PostController::class, 'deleteComment']);
Route::get('/reaction-types', [PostController::class, 'getReactionTypes']);
Route::post('/add-or-update-reaction', [PostController::class, 'addOrUpdateReaction']);
Route::post('/remove-reaction', [PostController::class, 'removeReaction']);
Route::get('/posts/{postId}/comments', [PostController::class, 'fetchPostComments']);

Route::post('/add-vote', [PostController::class, 'addVote']);
Route::post('/remove-vote', [PostController::class, 'removeVote']);

Route::get('/suggested-chats', [GroupController::class, 'suggestedChats']);
Route::get('/joined-chats', [GroupController::class, 'joinedChats']);

//Watchlist Routes
Route::prefix('watchlist')->name('watchlist.')->group(function() {
    Route::get('/', [WatchlistController::Class, 'getWatchLists']);
    Route::get('/managewatchlists', [WatchlistController::Class, 'getWatchLists']);
    Route::get('/symbols/{watchlistId}', [WatchlistController::class, 'getSymbols']);
    Route::post('symbol', [WatchlistController::Class, 'storeWatchListSymbol']);
    Route::delete('symbol', [WatchlistController::Class, 'deleteWatchListSymbol']);
    Route::put('update/{watchlist}', [WatchlistController::class, 'update'])->name('update');
    Route::put('update-positions', [WatchlistController::class, 'updatePositions'])->name('update-positions');
    Route::delete('deletewatchlist', [WatchlistController::class, 'deleteWatchList']);
});

//Exam Routes

Route::prefix('exams')->name('exam.')->group(function() {
    Route::get('/', [ExamController::class, 'getExams']);
    Route::get('/questions/start-exam/{examId}', [ExamController::class, 'getExamQuestions'])->name('questions.exam_queries');
});

// Route to show all exams
Route::get('/exams', [ExamController::class, 'getAllExams'])->name('exams.all');

//Authenticated routes
Route::middleware(['auth:sanctum'])->group(function () {

    //User Data Route
    Route::get('/userdata', [UserController::class, 'getUserData'])->name('userdata');

    //Exam Routes

    //initiating an exam
    Route::get('/exams/initiate/{examId}', [ExamController::class, 'initiateExam']);

    //All Questions Of Exam
    Route::get('/exams/{examId}/questions', [ExamController::class, 'getExamQuestions']);

    // Route to calculate and store exam results
    Route::post('/exam/submit/{examId}', [ExamController::class, 'submitExam'])->name('exam.submit');
    // Route to retrieve and show exam result
    Route::get('/exam/result/{examResultId}', [ExamController::class, 'getExamResult'])->name('exam.result');


    //User Feed Routes
    Route::prefix('userposts')->name('post.')->group(function() {
        Route::get('/all', [PostController::class, 'getUserPosts'])->name('all');
        Route::get('/text', [PostController::class, 'getTextPosts'])->name('text');
        Route::get('/image', [PostController::class, 'getImagePosts'])->name('image');
        Route::get('/video', [PostController::class, 'getVideoPosts'])->name('video');
        Route::get('/recent', [PostController::class, 'getRecentPosts'])->name('recent');
        Route::get('/bookmarks', [PostController::class, 'getBookmarkedPosts'])->name('bookmarks');
        Route::post('/create', [PostController::class, 'createPost'])->name('create');
    });
});


//Additional Routes
Route::get('/symbol/search', [SymbolController::Class, 'search']);
Route::get('/symbol/groups', [SymbolController::Class, 'groups']);