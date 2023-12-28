<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\SymbolController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('watchlist')->name('watchlist.')->group(function() {
    Route::get('/', [WatchlistController::Class, 'getWatchLists']);
    Route::post('symbol', [WatchlistController::Class, 'storeWatchListSymbol']);
    Route::delete('symbol', [WatchlistController::Class, 'deleteWatchListSymbol']);
});

Route::prefix('exams')->name('exam.')->group(function() {
    Route::get('/', [ExamController::class, 'getExams']);
});
Route::get('/questions/start-exam/{examId}', [ExamController::class, 'getExamQuestions'])->name('questions.exam_queries');


// Route::get('/start-exam/{examId}', [ExamController::class, 'getExamQuestions']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('userposts')->name('post.')->group(function() {
        Route::get('/all', [PostController::class, 'getUserPosts']);
        Route::get('/users/{id}', [UserController::class, 'getUserById']);

        // Add other routes for different post types as needed
    });
});
Route::get('/user-data', [UserController::class, 'getUserData']);
// Route::get('/userposts/all', [PostController::class, 'getUserPosts'])->name('post.all');


Route::get('/symbol/search', [SymbolController::Class, 'search']);
