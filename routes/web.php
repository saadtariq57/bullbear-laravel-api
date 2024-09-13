<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SymbolController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\EmailTemplateController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;

Auth::routes(['verify' => true]);
Broadcast::routes();


Route::post('/api/initiate-signup', [RegisterController::class, 'initiateSignUp'])->name('initiate.signup');
Route::get('/complete-registration/{token}', [RegisterController::class, 'showCompleteRegistrationForm'])->name('complete.registration.form');
Route::post('/complete-registration', [RegisterController::class, 'completeRegistration'])->name('complete.registration');
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

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
            // Categories Routes
            Route::get('categories', [WidgetController::class, 'categoriesIndex'])->name('categories.index');
            Route::get('categories/create', [WidgetController::class, 'categoriesCreate'])->name('categories.create');
            Route::post('categories', [WidgetController::class, 'categoriesStore'])->name('categories.store');
            Route::get('categories/{category}/edit', [WidgetController::class, 'categoriesEdit'])->name('categories.edit');
            Route::put('categories/{category}', [WidgetController::class, 'categoriesUpdate'])->name('categories.update');
            Route::delete('categories/{category}', [WidgetController::class, 'categoriesDestroy'])->name('categories.destroy');

            // Widget Routes
            Route::get('/', [WidgetController::class, 'index'])->name('index');
            Route::get('create', [WidgetController::class, 'create'])->name('create');
            Route::post('store', [WidgetController::class, 'store'])->name('store');
            Route::get('{widget}', [WidgetController::class, 'edit'])->name('edit');
            Route::put('{widget}', [WidgetController::class, 'update'])->name('update');
            Route::delete('{widget}', [WidgetController::class, 'destroy'])->name('destroy');
            Route::match(['get', 'post'], '{widget}/symbols', [WidgetController::class, 'showSymbols'])->name('symbols');
        });
        
        Route::prefix('admin/live')->name('admin.live.')->group(function () {
            Route::get('/', [LiveController::class, 'index'])->name('index');
            Route::post('/store', [LiveController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [LiveController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [LiveController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [LiveController::class, 'destroy'])->name('destroy');
        });
        
        Route::prefix('admin/webinar')->name('admin.webinar.')->group(function () {
            Route::get('/', [LiveController::class, 'showWebinars'])->name('index');
            Route::post('/store', [LiveController::class, 'storeWebinars'])->name('store');
            Route::get('/edit/{id}', [LiveController::class, 'editWebinars'])->name('edit');
            Route::post('/update/{id}', [LiveController::class, 'updateWebinars'])->name('update');
            Route::delete('/destroy/{id}', [LiveController::class, 'destroyWebinars'])->name('destroy');
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
        // Route::prefix('admin/watchlist')->name('admin.watchlist.')->group(function () {
        //     Route::get('/', [WatchlistController::class, 'AdminIndex'])->name('index');
        //     Route::get('create', [WatchlistController::class, 'WatchlistCreate'])->name('create');
        //     Route::get('edit', [WatchlistController::class, 'WatchlistEdit'])->name('edit');
        // });

        // mass emails routes
        Route::prefix('admin/emails')->name('admin.emails.')->group(function () {
            Route::get('/', [EmailTemplateController::class, 'index'])->name('index');  // View all templates
            Route::get('/editors/{id}', [EmailTemplateController::class, 'editor'])->name('editor');  // Edit template in TinyMCE
            Route::post('/{id}', [EmailTemplateController::class, 'update'])->name('update');  // Update existing template
            Route::post('/', [EmailTemplateController::class, 'saveAsNewTemplate'])->name('saveAsNew');  // Save as a new template
            Route::post('/', [EmailTemplateController::class, 'sendEmails'])->name('send');
        });
        
        // route group for GroupController
        Route::prefix('admin/groups')->name('admin.groups.')->group(function () {
            Route::get('/', [GroupController::class, 'index'])->name('index');
            Route::get('create', [GroupController::class, 'create'])->name('create');
            Route::post('/', [GroupController::class, 'store'])->name('store');
            Route::get('{group}/edit', [GroupController::class, 'edit'])->name('edit');
            Route::put('{group}', [GroupController::class, 'update'])->name('update');
            Route::delete('{group}', [GroupController::class, 'destroy'])->name('destroy');
            // Member Routes
            Route::get('{group}/members', [GroupController::class, 'showMembers'])->name('members');
            // Update a single member
            Route::post('{group}/updateMember', [GroupController::class, 'updateMember'])->name('updateMember');

            // Remove a single member
            Route::delete('{group}/removeMember', [GroupController::class, 'removeMember'])->name('removeMember');


            // Group Categories Routes
            Route::get('categories', [GroupController::class, 'categoriesIndex'])->name('categories.index');
            Route::get('categories/create', [GroupController::class, 'categoriesCreate'])->name('categories.create');
            Route::post('categories', [GroupController::class, 'categoriesStore'])->name('categories.store');
            Route::get('categories/{category}/edit', [GroupController::class, 'categoriesEdit'])->name('categories.edit');
            Route::put('categories/{category}', [GroupController::class, 'categoriesUpdate'])->name('categories.update');
            Route::delete('categories/{category}', [GroupController::class, 'categoriesDestroy'])->name('categories.destroy');
        });

        // route group for UserController
        Route::prefix('admin/users')->name('admin.users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('{user}', [UserController::class, 'update'])->name('update');
            Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
            Route::get('search', [UserController::class, 'search'])->name('search');
            // Additional routes for user management can be added here
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

        // Route group for PostController
        Route::prefix('admin/posts')->name('admin.posts.')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('index');
            Route::get('create', [PostController::class, 'create'])->name('create');
            Route::post('/', [PostController::class, 'store'])->name('store');
            Route::get('{post}/edit', [PostController::class, 'edit'])->name('edit');
            Route::put('{post}', [PostController::class, 'update'])->name('update');
            Route::delete('{post}', [PostController::class, 'destroy'])->name('destroy');
            Route::get('search', [PostController::class, 'search'])->name('search');
            // Additional routes for post management can be added here
            Route::get('view/{post}', [PostController::class, 'view'])->name('view');
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

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');