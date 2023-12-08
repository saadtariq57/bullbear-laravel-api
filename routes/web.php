<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SymbolController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\WatchlistController;

Auth::routes();

Route::get('/', function () {
    if (auth()->check()) {
        return view('feed');
    }
    return view('home');
})->name('home');

Route::get('/groups', function () {
    return view('groups.index');
})->name('groups.index');

Route::get('/groups-single', function () {
    return view('groups.chat-single');
})->name('groups.chat-single');

Route::get('/settings', function () {
        return view('profile.setting');
})->name('profile.setting');

Route::get('/exams', function () {
    return view('exams.index');
})->name('exams.index');

Route::get('/user-profile', function () {
    return view('profile.index');
})->name('profile.index');

Route::get('/single-stock', function () {
    return view('single-stock');
})->name('single-stock');

Route::get('/user-feed', function () {
    return view('feed');
})->name('feed');

Route::get('/watchlist', function () {
    return view('watchlist.index');
})->name('watchlist.index');

Route::get('/manageWatchlist', function () {
    return view('watchlist.manageWatchlist');
})->name('watchlist.manageWatchlist');

Route::get('/createwatchlist', function () {
    return view('watchlist.createwatchlist');
})->name('watchlist.createwatchlist');

Route::get('/ceo-interviews', function () {
    return view('ceo-interviews');
})->name('ceo-interviews');

Route::get('/ceo-single', function () {
    return view('ceo-single');
})->name('ceo-single');

Route::get('/earning-calender', function () {
    return view('earning-calender');
})->name('earning-calender');

Route::get('/trading-school', function () {
    return view('trading-school');
})->name('trading-school');
Route::get('/widgets', function () {
    return view('widgets');
})->name('widgets');

// Public Routes
#Route::get('/groups', [GroupController::class, 'groupsPage'])->name('groups.group');
#Route::get('/exams', [ExamController::class, 'examPage'])->name('exams');
// Route::get('/watchlist', [WatchlistController::class, 'watchlistPage'])->name('watchlist');

// Guest Routes only accessible for non logged in members
Route::group(['middleware' => ['guest']], function () {
    // Add routes that are only accessible to guests here
});

Route::middleware(['auth'])->group(function() {

    // For Admin users
    Route::middleware(['role'])->group(function() {
        // Admin Dashboard route
        Route::get('/admin', [HomeController::class, 'index'])->name('admin.index');

        // Grouping for SymbolController
        Route::prefix('admin/symbols')->name('admin.symbols.')->group(function() {
            Route::get('/', [SymbolController::class, 'index'])->name('index');
            Route::get('create', [SymbolController::class, 'create'])->name('create');
            Route::post('store', [SymbolController::class, 'store'])->name('store');
            Route::get('edit/{symbol}', [SymbolController::class, 'edit'])->name('edit');
            Route::put('update/{symbol}', [SymbolController::class, 'update'])->name('update');
            Route::delete('delete/{symbol}', [SymbolController::class, 'destroy'])->name('destroy');
            Route::get('search', [SymbolController::class, 'search'])->name('search');
        });

        // route group for WidgetController
        Route::prefix('admin/widgets')->name('admin.widgets.')->group(function() {
            Route::get('/', [WidgetController::class, 'index'])->name('index');
            Route::get('create', [WidgetController::class, 'create'])->name('create');
            Route::post('store', [WidgetController::class, 'store'])->name('store');
            Route::get('{widget}', [WidgetController::class, 'edit'])->name('edit');
            Route::put('{widget}', [WidgetController::class, 'update'])->name('update');
            Route::delete('{widget}', [WidgetController::class, 'destroy'])->name('destroy');
            Route::match(['get', 'post'], '{widget}/symbols', [WidgetController::class, 'showSymbols'])->name('symbols');
        });

        // route group for ExamController
        Route::prefix('admin/exams')->name('admin.exams.')->group(function() {
            // Exams Routes
            Route::get('/', [ExamController::class, 'index'])->name('index');
            Route::get('create', [ExamController::class, 'create'])->name('create');
            Route::post('/', [ExamController::class, 'store'])->name('store');
            Route::get('{exam}/edit', [ExamController::class, 'edit'])->name('edit');
            Route::put('{exam}', [ExamController::class, 'update'])->name('update');
            Route::delete('{exam}', [ExamController::class, 'destroy'])->name('destroy');
            
            // Questions Routes
            Route::match(['get', 'post'], '{exam}/add_questions', [ExamController::class, 'addQuestions'])->name('add_questions');

            // Categories Routes
            Route::get('categories', [ExamController::class, 'categoriesIndex'])->name('categories.index');
            Route::get('categories/create', [ExamController::class, 'categoriesCreate'])->name('categories.create');
            Route::post('categories', [ExamController::class, 'categoriesStore'])->name('categories.store');
            Route::get('categories/{examCategory}/edit', [ExamController::class, 'categoriesEdit'])->name('categories.edit');
            Route::put('categories/{examCategory}', [ExamController::class, 'categoriesUpdate'])->name('categories.update');
            Route::delete('categories/{examCategory}', [ExamController::class, 'categoriesDestroy'])->name('categories.destroy');
        });

        // route group for GroupController
        Route::prefix('admin/groups')->name('admin.groups.')->group(function() {
            Route::get('/', [GroupController::class, 'index'])->name('index');
            Route::get('create', [GroupController::class, 'create'])->name('create');
            Route::post('/', [GroupController::class, 'store'])->name('store');
            Route::get('{group}/edit', [GroupController::class, 'edit'])->name('edit');
            Route::put('{group}', [GroupController::class, 'update'])->name('update');
            Route::delete('{group}', [GroupController::class, 'destroy'])->name('destroy');
            // Additional routes for group management can be added here
        });

        // route group for GroupController
        Route::prefix('admin/users')->name('admin.users.')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('{user}', [UserController::class, 'update'])->name('update');
        Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
        // Additional routes for user management can be added here
        });

        // Route group for SubscriptionPlanController
        Route::prefix('admin/settings/subscription_plans')->name('admin.settings.subscription_plans.')->group(function() {
            Route::get('/', [SubscriptionPlanController::class, 'index'])->name('index');
            Route::get('create', [SubscriptionPlanController::class, 'create'])->name('create');
            Route::post('/', [SubscriptionPlanController::class, 'store'])->name('store');
            Route::get('{subscription_plan}/edit', [SubscriptionPlanController::class, 'edit'])->name('edit');
            Route::put('{subscription_plan}', [SubscriptionPlanController::class, 'update'])->name('update');
            Route::delete('{subscription_plan}', [SubscriptionPlanController::class, 'destroy'])->name('destroy');
            // Additional routes for subscription plan management can be added here
        });

        // TODO: Group routes for other controllers similarly.
        // Example for BookmarkController (adjust as needed for other controllers):
        Route::prefix('admin/bookmarks')->name('admin.bookmarks.')->group(function() {
            // Define routes for BookmarkController methods here
        });

        // Continue this pattern for other controllers like CommentController, ConfigController, etc.
    });

    // For Regular users
    Route::get('/feed', [HomeController::class, 'feedPage'])->name('feed');
    Route::get('/profile', [UserController::class, 'profilePage'])->name('profile');
    Route::get('/exams/{exam_name}', [ExamController::class, 'singleExamPage'])->name('exam.single');
    Route::get('/exam-results', [ExamController::class, 'examResultsPage'])->name('exam.results');
    Route::get('/groups/{group_name}', [GroupController::class, 'singleGroupPage'])->name('group.single');
    Route::get('/watchlist/{watchlist_id}', [WatchlistController::class, 'singleWatchlistPage'])->name('watchlist.single');
});