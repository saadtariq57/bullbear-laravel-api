<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AblyController,
    AutomationController,
    BotController,
    EducationController,
    ExamController,
    ExamResultController,
    FollowerController,
    GroupController,
    HomeController,
    LiveController,
    MessageController,
    NotificationController,
    PersonalSessionController,
    PostController,
    RegisterController,
    RichTvPicksController,
    SubscriptionPlanController,
    SubscriptionStatusController,
    SymbolController,
    UserController,
    WatchlistController,
    WidgetController,
    StockScreenerController,
    ContactController,
    TradingReportController,
    EmailCollectorController
};

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

/*
|--------------------------------------------------------------------------
| Non-Authenticated Routes
|--------------------------------------------------------------------------
*/
// Performence routes
Route::get('/categories-with-reports', [TradingReportController::class, 'getCategoriesWithReports']);
Route::get('/report-profits/{reportId}', [TradingReportController::class, 'getReportProfits']);
// Authentication & User Registration
Route::get('/check-login', function () {
    if (auth()->check()) {
        return response()->json(['loggedIn' => true]);
    } else {
        return response()->json(['loggedIn' => false]);
    }
});
Route::post('/check-username-availability', [RegisterController::class, 'checkUsernameAvailability'])->name('checkUsernameAvailability');

// Ably Authentication (Non-Authenticated Routes)
Route::get('/ably/authenticate', [AblyController::class, 'authenticate'])->middleware('auth:sanctum');
Route::post('/ably/authenticate', [AblyController::class, 'authenticate'])->middleware('auth:sanctum');

// Home
Route::get('/color-options', [HomeController::class, 'colorOptions']);
Route::get('/fetch-link-data', [HomeController::class, 'fetchLinkData']);

// Posts (Public Access)
Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('/user-feed', [PostController::class, 'getUserFeed']);
Route::get('/singlePost/{singlePostID}', [PostController::class, 'getSinglePost']);
Route::post('/submit-comment', [PostController::class, 'submitComment']);
Route::post('/edit-comment', [PostController::class, 'editComment']);
Route::post('/delete-comment', [PostController::class, 'deleteComment']);
Route::get('/reaction-types', [PostController::class, 'getReactionTypes']);
Route::post('/add-or-update-reaction', [PostController::class, 'addOrUpdateReaction']);
Route::post('/remove-reaction', [PostController::class, 'removeReaction']);
Route::get('/posts/{postId}/comments', [PostController::class, 'fetchPostComments']);

// User Profile Actions (Public Access)
Route::post('/uploadCover', [UserController::class, 'updateCoverPhoto']);
Route::post('/removeCover', [UserController::class, 'removeCoverPhoto']);
Route::post('/profileImage', [UserController::class, 'updateProfilePhoto']);

// Voting on Posts (Public Access)
Route::post('/add-vote', [PostController::class, 'addVote']);
Route::post('/remove-vote', [PostController::class, 'removeVote']);

// Watchlist Routes
Route::prefix('watchlist')->name('watchlist.')->group(function () {
    Route::get('/', [WatchlistController::class, 'getWatchLists']);
    Route::get('/featured', [WatchlistController::class, 'getFeaturedWatchlists'])->name('featured');
    Route::get('/managewatchlists', [WatchlistController::class, 'getWatchLists']);
    Route::get('/symbols/{watchlistId}', [WatchlistController::class, 'getSymbols']);
    Route::get('/editWatchlistData/{watchlistId}', [WatchlistController::class, 'getWatchListAllData']);
    Route::post('/symbol', [WatchlistController::class, 'storeWatchListSymbol']);
    Route::post('/copyWatchlist', [WatchlistController::class, 'copyWatchlist']);
    Route::put('/update/{watchlist}', [WatchlistController::class, 'UserUpdate'])->name('UserUpdate');
    Route::get('/store', [WatchlistController::class, 'UserStore'])->name('UserStore');
    Route::put('/update-positions', [WatchlistController::class, 'updatePositions'])->name('update-positions');
    Route::put('/update-privacy', [WatchlistController::class, 'updatePrivacy'])->name('update-privacy');
    Route::delete('/symbol', [WatchlistController::class, 'deleteWatchListSymbol']);
    Route::delete('/deletewatchlist', [WatchlistController::class, 'deleteWatchList']);
});

// Subscription Routes (Public Access)
Route::get('/subscriptionStatus', [SubscriptionStatusController::class, 'getStatus'])->name('getStatus');
Route::get('/pricingPlans', [SubscriptionPlanController::class, 'userIndex'])->name('userIndex');
Route::get('/subscription-plans/{id}', [SubscriptionPlanController::class, 'showSubscriptionPlan']);

// Additional Public Routes
// Videos
Route::get('/videos', [EducationController::class, 'getVideosByPlaylist']);

// E-books
Route::get('/ebooks', [EducationController::class, 'index']);
Route::get('/ebooks/recommended', [EducationController::class, 'getRecommendedEbooks'])->name('ebooks.recommended');
Route::get('/ebooks/download/{id}', [EducationController::class, 'download']);

// Symbols
Route::get('/symbol/search', [SymbolController::class, 'search']);
Route::get('/unique-symbols', [SymbolController::class, 'getUniqueSymbols']);
Route::get('/exclude-unique-symbols', [SymbolController::class, 'getAllExcludingUniqueSymbols']);
Route::get('/searchSymbol/default', [SymbolController::class, 'defaultSymbol']);

// Suggested Chats and Group Searches
Route::get('/suggested-chats', [GroupController::class, 'suggestedChats']);
Route::get('/searchGroups', [GroupController::class, 'siteGroupSearch']);
Route::get('/searchGroups/default', [GroupController::class, 'defaultGroups']);

// Search Members
Route::get('/searchMembers', [UserController::class, 'siteUserSearch']);
Route::get('/searchMembers/default', [UserController::class, 'defaultMembers']);

// Widgets
Route::get('/getWidget', [WidgetController::class, 'getWidgetsByCategory']);
Route::get('/quotes/{symbol}', [WidgetController::class, 'getQuote']);
Route::get('/getquotes/{symbols}', [WidgetController::class, 'getQuotes']);
Route::get('/market-collections/{type}', [WidgetController::class, 'getCollection']);
Route::get('/crypto-collections/{type}', [WidgetController::class, 'getCryptoCollection']);
Route::get('/calendar/{type}', [WidgetController::class, 'getCalendar']);
Route::get('/widget/{id}', [WidgetController::class, 'show']);
Route::get('/fund-ownership/{symbol}', [WidgetController::class, 'getFundOwnership']);
Route::get('/options/{symbol}', [WidgetController::class, 'getOptions']);
Route::get('/ohlc-data/intraday/{symbol}', [WidgetController::class, 'fetchIntradayOHLCData']);
Route::get('/ohlc-data/daily/{symbol}', [WidgetController::class, 'fetchDailyOHLCData']);
Route::get('/getGroups', [WidgetController::class, 'getActiveGroups']);
Route::get('/searchGroups', [WidgetController::class, 'searchGroups']);

// External News & WordPress Posts
Route::get('/fetch-wordpress-posts', [WidgetController::class, 'fetchPostWordpress']);
Route::get('/fetch-author-posts', [WidgetController::class, 'fetchAuthorPosts']);
Route::get('/fetch-comments', [WidgetController::class, 'fetchComments']);
Route::post('/post-comment', [WidgetController::class, 'postComment']);
Route::get('/fetch-prioritized-internal-news', [WidgetController::class, 'fetchPrioritizedInternalNews']);
Route::get('/fetch-prioritized-technical-analysis', [WidgetController::class, 'fetchPrioritizedTechnicalAnalysis']);

Route::get('/external-news/{symbol}', [WidgetController::class, 'fetchExternalNews']);

// Rich TV Picks
Route::get('/richTvPicks', [RichTvPicksController::class, 'getPicks'])->name('richTvPicks.getPicks');

// Live & Webinars
Route::get('/richtv-live', [LiveController::class, 'getEmbeddedCode']);
Route::get('/webinars', [LiveController::class, 'getWebinars']);

//Exams Non Authenticated
Route::get('/exams', [ExamController::class, 'getAllExams'])->name('exams.all');

//Contact Form
Route::post('/contact', [ContactController::class, 'submit']);

//Email Collector
Route::post('/email-collector', [EmailCollectorController::class, 'collect']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {

    // Ably Authentication (Authenticated)
    Route::get('/ably/authenticate', [AblyController::class, 'authenticate']);
    Route::post('/ably/authenticate', [AblyController::class, 'authenticate']);

    // Home (Authenticated)
    Route::get('/color-options', [HomeController::class, 'colorOptions']);
    Route::get('/fetch-link-data', [HomeController::class, 'fetchLinkData']);

    // Posts (Authenticated)
    Route::post('/create-post', [PostController::class, 'createPost']);
    Route::post('/update-post', [PostController::class, 'updatePost']);
    Route::delete('/delete-post/{id}', [PostController::class, 'deletePost']);
    Route::get('/user-feed', [PostController::class, 'getUserFeed']);
    Route::get('/user-profile/{userName?}', [PostController::class, 'getUserProfileFeed']);
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

    // User Profile Actions (Authenticated)
    Route::post('/uploadCover', [UserController::class, 'updateCoverPhoto']);
    Route::post('/update-cover-position', [UserController::class, 'updateCoverPosition']);
    Route::post('/removeCover', [UserController::class, 'removeCoverPhoto']);
    Route::post('/profileImage', [UserController::class, 'updateProfilePhoto']);

    // Groups (Authenticated)
    Route::get('/joined-chats', [GroupController::class, 'joinedChats']);
    Route::get('/joined-chats-share', [GroupController::class, 'joinedChatsShare']);
    Route::post('/groups/join/{groupId}', [GroupController::class, 'joinGroup']);
    Route::get('/groups/{id}', [GroupController::class, 'getGroupById']);
    Route::post('/group-cover-position', [GroupController::class, 'groupCoverPosition']);
    Route::post('/uploadGroupCover', [GroupController::class, 'updateGroupCover']);
    Route::post('/removeGroupCover', [GroupController::class, 'removeGroupCoverPhoto']);
    Route::post('/profileGroupImage', [GroupController::class, 'GroupProfilePhoto']);
    Route::get('groups/{groupId}/members', [GroupController::class, 'getGroupMembers']);
    Route::get('groups/{groupId}/check', [GroupController::class, 'checkUserGroupRole']);
    Route::post('/groups/{groupId}/update-member', [GroupController::class, 'updateGroupMember']);
    Route::post('/groups/{groupId}/remove-member', [GroupController::class, 'removeGroupMember']);

    // Messages (Authenticated)
    Route::get('/{groupId}/messages', [MessageController::class, 'groupMessages']);
    Route::post('/groups/{groupId}/send-message', [MessageController::class, 'sendMessage']);
    Route::put('/groups/{groupId}/messages/{messageId}', [MessageController::class, 'editMessage']);
    Route::delete('/groups/{messageId}/delete', [MessageController::class, 'deleteMessage']);

    // User Data Routes (Authenticated)
    Route::get('/userdata', [UserController::class, 'getUserData'])->name('userdata');
    Route::post('/user/update', [UserController::class, 'updateUserData']);
    Route::post('/profileData/{userName}', [UserController::class, 'getUserProfileData'])->name('userProfileData');
    Route::post('/users/{user}/follow', [FollowerController::class, 'store']);
    Route::delete('/users/{user}/unfollow', [FollowerController::class, 'destroy']);
    Route::get('/suggested-followers', [FollowerController::class, 'suggestedFollowers']);
    Route::get('/{userId}/notifications', [NotificationController::class, 'getNotifications']);
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
    Route::get('/exams/initiate/{examId}', [ExamController::class, 'initiateExam']);
    Route::get('/exams/{examId}/questions', [ExamController::class, 'getExamQuestions']);
    Route::post('/exams/submit/{examId}', [ExamController::class, 'submitExam'])->name('exam.submit');
    Route::get('/exams/result/{examResultId}', [ExamController::class, 'getExamResult'])->name('exam.result');
    Route::get('/exams/results', [ExamController::class, 'getAllExamResult']);
    Route::get('/exams/recommended', [ExamController::class, 'getRecommendedExams'])->name('exams.recommended');
    Route::get('/exams/past-performance', [ExamController::class, 'getPastPerformance'])->name('exams.pastPerformance');
    
    // User Account Settings (Authenticated)
    Route::post('/update-password', [UserController::class, 'updatePassword'])->name('update-password');
    Route::post('/privacy-settings', [UserController::class, 'updatePrivacySettings'])->name('privacy-settings');

    // User Feed Routes (Authenticated)
    Route::prefix('userposts')->name('post.')->group(function () {
        Route::get('/all', [PostController::class, 'getUserPosts'])->name('all');
        Route::get('/text', [PostController::class, 'getTextPosts'])->name('text');
        Route::get('/image', [PostController::class, 'getImagePosts'])->name('image');
        Route::get('/video', [PostController::class, 'getVideoPosts'])->name('video');
        Route::get('/recent', [PostController::class, 'getRecentPosts'])->name('recent');
        Route::get('/bookmarks', [PostController::class, 'getBookmarkedPosts'])->name('bookmarks');
        Route::post('/create', [PostController::class, 'createPost'])->name('create');
        Route::post('/share-post', [PostController::class, 'sharePost']);
    });

});

/*
|--------------------------------------------------------------------------
| Protected Routes (Requires Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/createUserSubscription', [SubscriptionPlanController::class, 'createUserSubscription'])->name('createUserSubscription');

    Route::get('/subscriptionInvoices', [SubscriptionStatusController::class, 'getInvoices'])->name('getInvoices');
    Route::post('/cancelSubscription/{subscriptionName}', [SubscriptionStatusController::class, 'cancelSubscription'])->name('cancelSubscription');
    Route::post('/updatePaymentMethod', [SubscriptionStatusController::class, 'updatePaymentMethod'])->name('updatePaymentMethod');

    Route::get('/personal_sessions', [PersonalSessionController::class, 'userIndex'])->name('personal_sessions.userIndex');
    Route::post('/personal_sessions', [PersonalSessionController::class, 'userStore'])->name('personal_sessions.userStore');
    Route::put('/personal_sessions/{id}', [PersonalSessionController::class, 'userUpdate'])->name('personal_sessions.userUpdate');

    Route::get('/stock-screener', [StockScreenerController::class, 'screener'])->name('stock.screener');

    Route::get('/ebooks/download/{id}', [EducationController::class, 'download']);
    Route::get('/courses', [EducationController::class, 'courseIndex']);
});

/*
|--------------------------------------------------------------------------
| Additional Public Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| API Routes with API Key Authentication
|--------------------------------------------------------------------------
*/
Route::middleware('api.key')->group(function () {
    Route::get('/bots/active', [BotController::class, 'apiActiveIndex'])->name('api.bots.active');
    Route::get('/automation/last-personality', [AutomationController::class, 'getLastPersonality'])->name('api.automation.last-personality');
    Route::post('/automation/create-post', [AutomationController::class, 'createPost'])->name('api.automation.create-post');
});