<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\SymbolController;
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

Route::get('/symbol/search', [SymbolController::Class, 'search']);
