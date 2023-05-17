<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedStockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FinanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function() {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('users')->name('users.')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/create', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('/{id}', [UserController::class, 'update'])->name('update');
        Route::post('/update-password/{id}', [UserController::class, 'updatePassword'])->name('update-password');
        Route::get('/delete/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('feedstock')->name('feedstock.')->group(function() {
        Route::get('/', [FeedStockController::class, 'index'])->name('index');
        Route::post('/create', [FeedStockController::class, 'store'])->name('create');
        Route::post('/update/{id}', [FeedStockController::class, 'update'])->name('update');
        Route::get('/{id}', [FeedStockController::class, 'show'])->name('show');
    });

    Route::prefix('products')->name('products.')->group(function() {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::post('/cart', [ProductController::class, 'addToCart'])->name('addToCart');
        Route::post('/clear-cart', [ProductController::class, 'clearToCart'])->name('clearToCart');
        Route::post('/create', [ProductController::class, 'store'])->name('create');
        
    });

    Route::prefix('finance')->name('finance.')->group(function() {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::post('/store', [FinanceController::class, 'store'])->name('store');
    });

    Route::get('/cart', function() {
        return view('erp.cart.index');
    })->name('cart');

});


require __DIR__.'/auth.php';
