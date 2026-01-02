<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\StockPurchaseController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [StockPurchaseController::class, 'dashboard'])->name('dashboard');
    Route::resource('purchases', StockPurchaseController::class)->except(['show']);

    // API routes for live prices
    Route::get('/api/prices', [PriceController::class, 'index'])->name('api.prices');
    Route::post('/api/prices/refresh', [PriceController::class, 'refresh'])->name('api.prices.refresh');
});
