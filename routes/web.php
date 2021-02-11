<?php

use App\Http\Livewire\Saves;
use App\Http\Livewire\ShowSave;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NewsletterController;

Auth::routes();

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/saves', Saves::class)->middleware('auth');
Route::get('/saves/{save}', ShowSave::class)->middleware('auth');

Route::post('/subscribe', [NewsletterController::class, 'subscribe']);

// Reddit OAuth
Route::group(['prefix' => 'reddit'], function () {
    Route::get('redirect', [LoginController::class, 'redirectToProvider'])->name('reddit.redirect');
    Route::get('callback', [LoginController::class, 'handleProviderCallback']);
});

/**
 * OLD -- TO REFACTOR
 */
// Route::group(['prefix' => 'saves', 'middleware' => 'auth'], function () {
//     Route::get('/', [SaveController::class, 'index']);
//     Route::post('/', [SaveController::class, 'store']);
// });

// Route::group(['prefix' => 'saves/{save}', 'middleware' => 'auth'], function () {
//     Route::delete('/', [SaveController::class, 'destroy']);
//     Route::post('/tags', [SaveTagController::class, 'store']);
//     Route::delete('/tags/{tag}', [SaveTagController::class, 'destroy']);
// });

// Route::get('/filters', [FilterController::class, 'index'])->middleware('auth');
