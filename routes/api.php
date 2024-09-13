<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\SymbolController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AblyController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\SubscriptionStatusController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\MenuController;


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
Route::get('/exam/results', [ExamResultController::class, 'index']);
Route::get('/api/exam/{examId}/questions', [ExamResultController::class, 'getExamQuestions']);
Route::get('/api/exam/titles', [ExamResultController::class, 'getAllExamTitles']);

Route::get('/check-login', function () {
    if (auth()->check()) {
        return response()->json(['loggedIn' => true]);
    } else {
        return response()->json(['loggedIn' => false]);
    }
});
Route::post('/check-username-availability', [RegisterController::class, 'checkUsernameAvailability']);

Route::get('/ably/authenticate', [AblyController::class, 'authenticate'])->middleware('auth:sanctum');
Route::post('/ably/authenticate', [AblyController::class, 'authenticate'])->middleware('auth:sanctum');

Route::get('/menus', [MenuController::class, 'fetchMenu']);
Route::get('/menu_items', [MenuController::class, 'fetchMenuItems']);

Route::get('/color-options', [HomeController::class, 'colorOptions']);
Route::get('/fetch-link-data', [HomeController::class, 'fetchLinkData']);
Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('/user-feed', [PostController::class, 'getUserFeed']);
Route::get('/singlePost/{singlePostID}', [PostController::class, 'getSinglePost']);
Route::get('/user-profile/{userName?}', [PostController::class, 'getUserProfileFeed']);
Route::get('/user-group/{groupId}', [PostController::class, 'getUserGroupFeed']);
Route::post('/submit-comment', [PostController::class, 'submitComment']);
Route::post('/edit-comment', [PostController::class, 'editComment']);
Route::post('/delete-comment', [PostController::class, 'deleteComment']);
Route::get('/reaction-types', [PostController::class, 'getReactionTypes']);
Route::post('/add-or-update-reaction', [PostController::class, 'addOrUpdateReaction']);
Route::post('/remove-reaction', [PostController::class, 'removeReaction']);
Route::get('/posts/{postId}/comments', [PostController::class, 'fetchPostComments']);


Route::post('/uploadCover', [UserController::class, 'updateCoverPhoto']);
Route::post('/removeCover', [UserController::class, 'removeCoverPhoto']);
Route::post('/profileImage', [UserController::class, 'updateProfilePhoto']);

Route::post('/add-vote', [PostController::class, 'addVote']);
Route::post('/remove-vote', [PostController::class, 'removeVote']);

Route::prefix('watchlist')->name('watchlist.')->group(function () {
    Route::get('/', [WatchlistController::Class, 'getWatchLists']);
    Route::get('/managewatchlists', [WatchlistController::Class, 'getWatchLists']);
    Route::get('/symbols/{watchlistId}', [WatchlistController::class, 'getSymbols']);
    Route::get('/editWatchlistData/{watchlistId}', [WatchlistController::class, 'getWatchListAllData']);
    Route::post('symbol', [WatchlistController::Class, 'storeWatchListSymbol']);
    Route::post('copyWatchlist', [WatchlistController::Class, 'copyWatchlist']);
    Route::put('update/{watchlist}', [WatchlistController::class, 'update'])->name('update');
    Route::put('update-positions', [WatchlistController::class, 'updatePositions'])->name('update-positions');
    Route::put('update-privacy', [WatchlistController::class, 'updatePrivacy'])->name('update-privacy');
    Route::delete('symbol', [WatchlistController::Class, 'deleteWatchListSymbol']);
    Route::delete('deletewatchlist', [WatchlistController::class, 'deleteWatchList']);
    
});

//Exam Routes

Route::prefix('exams')->name('exam.')->group(function () {
    Route::get('/', [ExamController::class, 'getExams']);
    Route::get('/questions/start-exam/{examId}', [ExamController::class, 'getExamQuestions'])->name('questions.exam_queries');
});

// Route to show all exams
Route::get('/exams', [ExamController::class, 'getAllExams'])->name('exams.all');

//Authenticated routes
Route::middleware(['auth:sanctum'])->group(function () {

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

    Route::post('/uploadCover', [UserController::class, 'updateCoverPhoto']);
    Route::post('/update-cover-position', [UserController::class, 'updateCoverPosition']);
    Route::post('/removeCover', [UserController::class, 'removeCoverPhoto']);
    Route::post('/profileImage', [UserController::class, 'updateProfilePhoto']);

    Route::post('/add-vote', [PostController::class, 'addVote']);
    Route::post('/remove-vote', [PostController::class, 'removeVote']);

    
    Route::get('/joined-chats', [GroupController::class, 'joinedChats']);
    Route::post('/groups/join/{groupId}', [GroupController::class, 'joinGroup']);
    Route::get('/groups/join/{id}', [GroupController::class, 'getGroupById']);
    Route::post('/group-cover-position', [GroupController::class, 'groupCoverPosition']);
    Route::post('/uploadGroupCover', [GroupController::class, 'updateGroupCover']);
    Route::post('/removeGroupCover', [GroupController::class, 'removeGroupCoverPhoto']);
    Route::post('/profileGroupImage', [GroupController::class, 'GroupProfilePhoto']);
    Route::get('groups/{groupId}/members', [GroupController::class, 'getGroupMembers']);
    Route::get('groups/{groupId}/check', [GroupController::class, 'checkUserGroupRole']);
    Route::post('/groups/{groupId}/update-member', [GroupController::class, 'updateGroupMember']);
    Route::post('/groups/{groupId}/remove-member', [GroupController::class, 'removeGroupMember']);
    
    Route::get('/{groupId}/messages', [MessageController::class, 'groupMessages']);
    Route::post('/groups/{groupId}/send-message', [MessageController::class, 'sendMessage']);
    Route::put('/groups/{groupId}/messages/{messageId}', [MessageController::class, 'editMessage']);
    Route::delete('/groups/{messageId}/delete', [MessageController::class, 'deleteMessage']);
    

    //User Data Route
    Route::get('/userdata', [UserController::class, 'getUserData'])->name('userdata');
    Route::post('/user/update', [UserController::class, 'updateUserData']);
    // Route::post('/user/update', 'UserController@update')->middleware('auth:api');
    Route::post('/profileData/{userName}', [UserController::class, 'getUserProfileData'])->name('userProfileData');
    Route::post('/users/{user}/follow', [FollowerController::class, 'store']);
    Route::delete('/users/{user}/unfollow', [FollowerController::class, 'destroy']);
    Route::get('/{userId}/notifications', [NotificationController::class, 'getNotifications']);
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);


    // user Album
    // Route::get('/userAlbumData', [UserController::class, 'getUserAlbumData'])->name('getUserAlbumData');
    //Exam Routes
    //initiating an exam
    Route::get('/exams/initiate/{examId}', [ExamController::class, 'initiateExam']);
    //All Questions Of Exam
    Route::get('/exams/{examId}/questions', [ExamController::class, 'getExamQuestions']);
    // Route to calculate and store exam results
    Route::post('/exam/submit/{examId}', [ExamController::class, 'submitExam'])->name('exam.submit');
    // Route to retrieve and show exam result
    Route::get('/exam/result/{examResultId}', [ExamController::class, 'getExamResult'])->name('exam.result');
    Route::get('/pricingPlans', [SubscriptionPlanController::class, 'userIndex'])->name('userIndex');
    Route::post('/createUserSubscription', [SubscriptionPlanController::class, 'createUserSubscription'])->name('createUserSubscription');
    // Route::get('/subscriptionStatus', [SubscriptionStatusController::class, 'getStatus'])->middleware(Subscribed::class);
    Route::get('/subscriptionStatus', [SubscriptionStatusController::class, 'getStatus'])->name('getStatus');
    Route::get('/subscriptionInvoices', [SubscriptionStatusController::class, 'getInvoices'])->name('getInvoices');
    Route::post('/cancelSubscription/{subscriptionName}', [SubscriptionStatusController::class, 'cancelSubscription'])->name('cancelSubscription');
    Route::post('/updatePaymentMethod', [SubscriptionStatusController::class, 'updatePaymentMethod'])->name('updatePaymentMethod');
    // Route::delete('/removePaymentMethod/{id}', [SubscriptionStatusController::class, 'destroyPaymentMethod'])->name('destroyPaymentMethod');
    Route::post('/update-password', [UserController::class, 'updatePassword'])->name('update-password');
    Route::post('/privacy-settings', [UserController::class, 'updatePrivacySettings'])->name('privacy-settings');

    //User Feed Routes
    Route::prefix('userposts')->name('post.')->group(function () {
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
Route::get('/unique-symbols', [SymbolController::class, 'getUniqueSymbols']);
Route::get('/exclude-unique-symbols', [SymbolController::class, 'getAllExcludingUniqueSymbols']);
Route::get('/suggested-chats', [GroupController::class, 'suggestedChats']);
Route::get('/searchGroups', [GroupController::Class, 'siteGroupSearch']);
Route::get('/searchMembers', [UserController::Class, 'siteUserSearch']);
Route::get('/searchSymbol/default', [SymbolController::Class, 'defaultSymbol']);
Route::get('/searchGroups/default', [GroupController::Class, 'defaultGroups']);
Route::get('/searchMembers/default', [UserController::Class, 'defaultMembers']);

Route::get('/fetch-wordpress-posts', [WidgetController::class, 'fetchPostWordpress']);
Route::get('/external-news/{symbol}', [WidgetController::class, 'fetchExternalNews']);
// user widgets
Route::get('/getWidget', [WidgetController::class, 'getWidgetsByCategory']);
Route::get('/widget/{id}', [WidgetController::class, 'show']);
Route::get('/fund-ownership/{symbol}', [WidgetController::class, 'getFundOwnership']);
Route::get('/options/{symbol}', [WidgetController::class, 'getOptions']);
Route::get('/ohlc-data/{symbol}', [WidgetController::class, 'fetchOHLCData']);
Route::get('/getGroups', [WidgetController::class, 'getActiveGroups']);
Route::get('/searchGroups', [WidgetController::class, 'searchGroups']);

Route::get('/richtv-live', [LiveController::class, 'getEmbeddedCode']);
Route::get('/webinars', [LiveController::class, 'getWebinars']);