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
use App\Http\Controllers\MauticController;
use App\Http\Controllers\MenuController;

use App\Models\MenuItem;
use Illuminate\Support\Facades\Route;


Auth::routes(['verify' => true]);
Broadcast::routes();

// Public routes

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('feed');
    }
    return view('home');
})->name('home');


// Fetch all menu items from the database
$menu_items = MenuItem::all();

foreach ($menu_items as $menu_item) {
    if($menu_item->view_name != null){
    Route::get($menu_item->url . '/' . urlencode(json_encode($menu_item->widget_id)), function () use ($menu_item) {
        // Dynamically load a view based on the 'view_name' field
        return view('markets.market', ['menu_item' => $menu_item]);
    })->name($menu_item->title);
}
}



Route::get('/ceo-interviews', function () {
    return view('ceo-interviews');
})->name('ceo-interviews');

Route::get('/ceo-single', function () {
    return view('ceo-single');
})->name('ceo-single');

Route::get('/earning-calendar', function () {
    return view('calendars.earning-calendar');
})->name('earning-calendar');
Route::get('/economic-calendar', function () {
    return view('calendars.economic-calendar');
})->name('economic-calendar');
Route::get('/holiday-calendar', function () {
    return view('calendars.holiday-calendar');
})->name('holiday-calendar');
Route::get('/dividend-calendar', function () {
    return view('calendars.dividend-calendar');
})->name('dividend-calendar');
Route::get('/splits-calendar', function () {
    return view('calendars.splits-calendar');
})->name('splits-calendar');
Route::get('/ipo-calendar', function () {
    return view('calendars.ipo-calendar');
})->name('ipo-calendar');
Route::get('/futures-expiry-calendar', function () {
    return view('calendars.futures-expiry-calendar');
})->name('futures-expiry-calendar');
Route::get('/webinar', function () {
    return view('webinar');
})->name('webinar');
Route::get('/richtv-live', function () {
    return view('markets.market');
})->name('richtv-live');

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

// RichTv Pro
Route::get('/richtvpro/watchlist', function () {
    return view('markets.market');
})->name('watchlistpro');

// pricing page route
Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

// Checkout page
Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');
Route::get('/checkout/thank-you', function () {
    return view('checkout');
})->name('thank-you');

Route::get('/groups', [HomeController::class, 'groupPage'])->name('group');
// Routes requiring authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/feed', [HomeController::class, 'feedPage'])->name('feed');
    Route::get('/single-post', [HomeController::class, 'post'])->name('single-post');
    Route::get('/profile/{username}', [HomeController::class, 'profilePage'])->name('profile');
    Route::get('/groups/{group_id}/{group_name}/{any?}', [HomeController::class, 'singleGroupPage'])->where('any', '.*')->name('groups.single');
    
    // Profile route
    Route::get('/profile/{username}/setting', [HomeController::class, 'profileSettings'])->name('profile.setting');
    // Route::get('/profile/{username}/setting', function () {
    //     return view('profile.setting');
    // })->name('profile.setting');
    // Route::get('/profile/{username}/follow', function () {
    //     return view('profile.follow');
    // })->name('profile.follow');

    Route::get('/profile/{username}/notification', function () {
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

    Route::get('/previous-results', function () {
        return view('exams.previous-results');
    })->name('exams.previous-results');

    // RichTv Pro
    Route::get('/watchlist-ideas', function () {
        return view('markets.market');
    })->name('watchlistpro-ideas');
    Route::get('/pro-picks', function () {
        return view('markets.market');
    })->name('propicks');
    Route::get('/personal-access', function () {
        return view('markets.market');
    })->name('personal-access');
    Route::get('/specialize-reports', function () {
        return view('markets.market');
    })->name('specialize-reports');
    Route::get('/single-report', function () {
        return view('feed');
    })->name('single-report');
    Route::get('/technical-analysis', function () {
        return view('markets.market');
    })->name('technical-analysis');
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

        // Menusroutes
        Route::prefix('admin/menus')->name('admin.menus.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::post('/', [MenuController::class, 'store'])->name('store');
            Route::get('/{menu}', [MenuController::class, 'edit'])->name('edit');
            Route::post('/{menu}', [MenuController::class, 'update'])->name('update');
        });

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
