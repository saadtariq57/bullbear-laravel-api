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

Route::get('/earning-calendar', function () {
    return view('earning-calendar');
})->name('earning-calendar');
Route::get('/economic-calendar', function () {
    return view('economic-calendar');
})->name('economic-calendar');
Route::get('/holiday-calendar', function () {
    return view('holiday-calendar');
})->name('holiday-calendar');
Route::get('/dividend-calendar', function () {
    return view('dividend-calendar');
})->name('dividend-calendar');
Route::get('/splits-calendar', function () {
    return view('splits-calendar');
})->name('splits-calendar');
Route::get('/ipo-calendar', function () {
    return view('ipo-calendar');
})->name('ipo-calendar');
Route::get('/futures-expiry-calendar', function () {
    return view('futures-expiry-calendar');
})->name('futures-expiry-calendar');
Route::get('/webinar', function () {
    return view('webinar');
})->name('webinar');

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

Route::get('/markets/indices', function () {
    return view('markets.market');
})->name('indices');
Route::get('/markets/indices/indices-futures', function () {
    return view('markets.market');
})->name('indices-futures');
Route::get('/markets/indices/major-indices', function () {
    return view('markets.market');
})->name('major-indices');
Route::get('/markets/indices/indices-realtime', function () {
    return view('markets.market');
})->name('major-indices');
Route::get('/markets/indices/world-indices', function () {
    return view('markets.market');
})->name('world-indices');
Route::get('/markets/indices/global-indices', function () {
    return view('markets.market');
})->name('global-indices');
Route::get('/markets/indices/dow-jones-futures', function () {
    return view('single-stock');
})->name('dow-jones-futures');
Route::get('/markets/indices/s&p-500-futures', function () {
    return view('single-stock');
})->name('s&p-500-futures');
Route::get('/markets/indices/nasdaq-futures', function () {
    return view('single-stock');
})->name('nasdaq-futures');

Route::get('/markets/stocks', function () {
    return view('markets.market');
})->name('stocks');
Route::get('/markets/stocks/stocks-screener', function () {
    return view('markets.market');
})->name('stock-screener');
Route::get('/markets/stocks/trading-stocks', function () {
    return view('markets.market');
})->name('trading-stocks');
Route::get('/markets/stocks/united-states', function () {
    return view('markets.market');
})->name('united-states');
Route::get('/markets/stocks/pre-market', function () {
    return view('markets.market');
})->name('pre-market');
Route::get('/markets/stocks/americas', function () {
    return view('markets.market');
})->name('americas');
Route::get('/markets/stocks/europe', function () {
    return view('markets.market');
})->name('europe');
Route::get('/markets/stocks/52-week-high', function () {
    return view('markets.market');
})->name('52-week-high');
Route::get('/markets/stocks/52-week-low', function () {
    return view('markets.market');
})->name('52-week-low');
Route::get('/markets/stocks/most-active', function () {
    return view('markets.market');
})->name('most-active');
Route::get('/markets/stocks/top-gainers', function () {
    return view('markets.market');
})->name('top-gainers');
Route::get('/markets/stocks/top-losers', function () {
    return view('markets.market');
})->name('top-losers');
Route::get('/markets/stocks/world-adrs', function () {
    return view('markets.market');
})->name('world-adrs');
Route::get('/markets/stocks/marijuana-stocks', function () {
    return view('markets.market');
})->name('marijuana-stocks');
Route::get('/markets/stocks/top-bank-stocks', function () {
    return view('markets.market');
})->name('top-bank-stocks');

Route::get('/markets/commodities', function () {
    return view('markets.market');
})->name('commodities');
Route::get('/markets/commodities/real-time-commodities', function () {
    return view('markets.market');
})->name('real-time-commodities');
Route::get('/markets/commodities/metals', function () {
    return view('markets.market');
})->name('metals');
Route::get('/markets/commodities/energy', function () {
    return view('markets.market');
})->name('energy');
Route::get('/markets/commodities/grains', function () {
    return view('markets.market');
})->name('grains');
Route::get('/markets/commodities/softs', function () {
    return view('markets.market');
})->name('softs');
Route::get('/markets/commodities/meats', function () {
    return view('markets.market');
})->name('meats');
Route::get('/markets/commodities/commodity-indices', function () {
    return view('markets.market');
})->name('commodity-indices');

Route::get('/markets/cryptocurrency', function () {
    return view('markets.market');
})->name('cryptocurrency');
Route::get('/markets/cryptocurrency/all-cryptocurrencies', function () {
    return view('markets.market');
})->name('all-cryptocurrencies');
Route::get('/markets/cryptocurrency/cryptocurrency-pairs', function () {
    return view('markets.market');
})->name('cryptocurrency-pairs');
Route::get('/markets/cryptocurrency/bitcoin-etfs', function () {
    return view('markets.market');
})->name('bitcoin-etfs');
Route::get('/markets/cryptocurrency/bitcoin', function () {
    return view('markets.market');
})->name('bitcoin');
Route::get('/markets/cryptocurrency/ethereum', function () {
    return view('markets.market');
})->name('ethereum');
Route::get('/markets/cryptocurrency/cardano', function () {
    return view('markets.market');
})->name('cardano');
Route::get('/markets/cryptocurrency/solana', function () {
    return view('markets.market');
})->name('solana');
Route::get('/markets/cryptocurrency/dogecoin', function () {
    return view('markets.market');
})->name('dogecoin');
Route::get('/markets/cryptocurrency/shiba-inu', function () {
    return view('markets.market');
})->name('shiba-inu');
Route::get('/markets/currencies', function () {
    return view('markets.market');
})->name('currencies');
Route::get('/markets/currencies/currency-rates', function () {
    return view('markets.market');
})->name('currency-rates');
Route::get('/markets/currencies/single-currency-crosses', function () {
    return view('markets.market');
})->name('single-currency-crosses');
Route::get('/markets/currencies/live-currency-cross-rates', function () {
    return view('markets.market');
})->name('live-currency-cross-rates');
Route::get('/markets/currencies/exchange-rates-table', function () {
    return view('markets.market');
})->name('exchange-rates-table');
Route::get('/markets/currencies/forward-rates', function () {
    return view('markets.market');
})->name('forward-rates');
Route::get('/markets/currencies/currency-futures', function () {
    return view('markets.market');
})->name('currency-futures');
Route::get('/markets/currencies/currency-options', function () {
    return view('markets.market');
})->name('currency-options');
Route::get('/markets/etfs', function () {
    return view('markets.market');
})->name('etfs');
Route::get('/markets/etfs/world-etfs', function () {
    return view('markets.market');
})->name('world-etfs');
Route::get('/markets/etfs/major-etfs', function () {
    return view('markets.market');
})->name('major-etfs');
Route::get('/markets/etfs/usa-etfs', function () {
    return view('markets.market');
})->name('usa-etfs');
Route::get('/markets/etfs/marijuana-etfs', function () {
    return view('markets.market');
})->name('marijuana-etfs');

Route::get('/markets/funds', function () {
    return view('markets.market');
})->name('funds');
Route::get('/markets/funds/world-funds', function () {
    return view('markets.market');
})->name('world-funds');
Route::get('/markets/funds/major-funds', function () {
    return view('markets.market');
})->name('major-funds');

Route::get('/markets/bonds', function () {
    return view('markets.market');
})->name('bonds');
Route::get('/markets/bonds/us-treasury-yield-curve', function () {
    return view('markets.market');
})->name('us-treasury-yield-curve');
Route::get('/markets/bonds/world-cds', function () {
    return view('markets.market');
})->name('world-cds');
Route::get('/markets/bonds/world-government-bonds', function () {
    return view('markets.market');
})->name('world-government-bonds');
Route::get('/markets/bonds/forward-rates', function () {
    return view('markets.market');
})->name('forward-rates');
Route::get('/markets/bonds/financial-futures', function () {
    return view('markets.market');
})->name('financial-futures');
Route::get('/markets/bonds/government-bond-spreads', function () {
    return view('markets.market');
})->name('government-bond-spreads');
Route::get('/markets/bonds/bond-indices', function () {
    return view('markets.market');
})->name('bond-indices');

Route::get('/markets/certificates', function () {
    return view('markets.market');
})->name('certificates');
Route::get('/markets/certificates/major-certificates', function () {
    return view('markets.market');
})->name('major-certificates');
Route::get('/markets/certificates/world-certificates', function () {
    return view('markets.market');
})->name('world-certificates');


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