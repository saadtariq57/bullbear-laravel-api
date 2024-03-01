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
Broadcast::routes();

// Public routes
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('feed');
    }
    return view('home');
})->name('home');

Route::get('/ceo-interviews', function () {
    return view('ceo-interviews');
})->name('ceo-interviews');

Route::get('/ceo-single', function () {
    return view('ceo-single');
})->name('ceo-single');

Route::get('/earning-calender', function () {
    return view('earning-calender');
})->name('earning-calender');
Route::get('/economic-calender', function () {
    return view('economic-calender');
})->name('economic-calender');

Route::get('/trading-school', function () {
    return view('trading-school');
})->name('trading-school');

Route::get('/exams', function () {
    return view('exams.index');
})->name('exams.index');

Route::get('/quote/{symbol}', function () {
    return view('single-stock');
})->name('single-stock');
Route::get('/email-alerts', function () {
    return view('email-alerts');
})->name('email-alerts');

// Profile route
Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/groups', [HomeController::class, 'groupPage'])->name('group');
// Routes requiring authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/feed', [HomeController::class, 'feedPage'])->name('feed');
    Route::get('/single-post', [HomeController::class, 'post'])->name('single-post');
    Route::get('/profile', [HomeController::class, 'profilePage'])->name('profile');
    Route::get('/groups/{group_id}/{group_name}', [HomeController::class, 'singleGroupPage'])->name('groups.single');
    // Profile route
    Route::get('/profile/setting', function () {
        return view('profile.setting');
    })->name('profile.setting');
    Route::get('/profile/follow', function () {
        return view('profile.follow');
    })->name('profile.follow');

    Route::get('/profile/notification', function () {
        return view('profile.notification');
    })->name('profile.notification');



    // Single Exam route
    Route::get('/exam/{examName}/question/{questionId}', [ExamController::class, 'getExamQuestions'])
    ->name('exam.question')
    ->where('examName', '[a-zA-Z0-9\-]+')
    ->where('questionId', '[0-9]+');

    // Exam Results route
    Route::get('/exam/result/{id}', function () {
        return view('exams.exam-result');
    })->name('exams.exam-result');

});

// Routes for Watchlist with prefix
Route::prefix('watchlist')->name('watchlist.')->group(function () {
    Route::get('/', [WatchlistController::class, 'index'])->name('index');
    Route::get('manage', [WatchlistController::class, 'manage'])->name('manage');
    Route::get('store', [WatchlistController::class, 'store'])->name('store');
    Route::get('edit/{watchlist}', [WatchlistController::class, 'edit'])->name('edit');
    Route::delete('{watchlist}', [WatchlistController::class, 'destroy'])->name('destroy');
});


Route::get('/widgets', function () {
    return view('widgets');
})->name('widgets');

Route::middleware(['auth'])->group(function () {

    // For Admin users
    Route::middleware(['role'])->group(function () {
        // Admin Dashboard route
        Route::get('/admin', [HomeController::class, 'index'])->name('admin.index');

        // Grouping for SymbolController
        Route::prefix('admin/symbols')->name('admin.symbols.')->group(function () {
            Route::get('/', [SymbolController::class, 'index'])->name('index');
            Route::get('create', [SymbolController::class, 'create'])->name('create');
            Route::post('store', [SymbolController::class, 'store'])->name('store');
            Route::get('edit/{symbol}', [SymbolController::class, 'edit'])->name('edit');
            Route::put('update/{symbol}', [SymbolController::class, 'update'])->name('update');
            Route::delete('delete/{symbol}', [SymbolController::class, 'destroy'])->name('destroy');
            Route::get('search', [SymbolController::class, 'search'])->name('search');
        });

        // route group for WidgetController
        Route::prefix('admin/widgets')->name('admin.widgets.')->group(function () {
            Route::get('/', [WidgetController::class, 'index'])->name('index');
            Route::get('create', [WidgetController::class, 'create'])->name('create');
            Route::post('store', [WidgetController::class, 'store'])->name('store');
            Route::get('{widget}', [WidgetController::class, 'edit'])->name('edit');
            Route::put('{widget}', [WidgetController::class, 'update'])->name('update');
            Route::delete('{widget}', [WidgetController::class, 'destroy'])->name('destroy');
            Route::match(['get', 'post'], '{widget}/symbols', [WidgetController::class, 'showSymbols'])->name('symbols');
        });

        // route group for ExamController
        Route::prefix('admin/exams')->name('admin.exams.')->group(function () {
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
        Route::prefix('admin/groups')->name('admin.groups.')->group(function () {
            Route::get('/', [GroupController::class, 'index'])->name('index');
            Route::get('create', [GroupController::class, 'create'])->name('create');
            Route::post('/', [GroupController::class, 'store'])->name('store');
            Route::get('{group}/edit', [GroupController::class, 'edit'])->name('edit');
            Route::put('{group}', [GroupController::class, 'update'])->name('update');
            Route::delete('{group}', [GroupController::class, 'destroy'])->name('destroy');

            // Categories Routes
            Route::get('categories', [GroupController::class, 'categoriesIndex'])->name('categories.index');
            Route::get('categories/create', [GroupController::class, 'categoriesCreate'])->name('categories.create');
            Route::post('categories', [GroupController::class, 'categoriesStore'])->name('categories.store');
            Route::get('categories/{groupCategory}/edit', [GroupController::class, 'categoriesEdit'])->name('categories.edit');
            Route::put('categories/{groupCategory}', [GroupController::class, 'categoriesUpdate'])->name('categories.update');
            Route::delete('categories/{groupCategory}', [GroupController::class, 'categoriesDestroy'])->name('categories.destroy');
        });

        // route group for GroupController
        Route::prefix('admin/users')->name('admin.users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('{user}', [UserController::class, 'update'])->name('update');
            Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
            // Additional routes for user management can be added here
        });

        // Route group for SubscriptionPlanController
        Route::prefix('admin/settings/subscription_plans')->name('admin.settings.subscription_plans.')->group(function () {
            Route::get('/', [SubscriptionPlanController::class, 'index'])->name('index');
            Route::get('create', [SubscriptionPlanController::class, 'create'])->name('create');
            Route::post('/', [SubscriptionPlanController::class, 'store'])->name('store');
            Route::get('{subscription_plan}/edit', [SubscriptionPlanController::class, 'edit'])->name('edit');
            Route::put('{subscription_plan}', [SubscriptionPlanController::class, 'update'])->name('update');
            Route::delete('{subscription_plan}', [SubscriptionPlanController::class, 'destroy'])->name('destroy');
            // Additional routes for subscription plan management can be added here
        });

    });
});