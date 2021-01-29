<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\SaveTagController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\LoginController;

Auth::routes();

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::group(['prefix' => 'saves', 'middleware' => 'auth'], function () {
    Route::get('/', [SaveController::class, 'index']);
    Route::post('/', [SaveController::class, 'store']);
});

Route::group(['prefix' => 'saves/{save}', 'middleware' => 'auth'], function () {
    Route::delete('/', [SaveController::class, 'destroy']);
    Route::post('/tags', [SaveTagController::class, 'store']);
    Route::delete('/tags/{tag}', [SaveTagController::class, 'destroy']);
});

// Filters
Route::get('/filters', [FilterController::class, 'index'])->middleware('auth');

// User
// Route::get('/user', function() { return Auth::user(); })->middleware('auth');

// Reddit OAuth
Route::group(['prefix' => 'reddit'], function () {
    Route::get('redirect', [LoginController::class, 'redirectToProvider'])->name('reddit.redirect');
    Route::get('callback', [LoginController::class, 'handleProviderCallback']);
});
