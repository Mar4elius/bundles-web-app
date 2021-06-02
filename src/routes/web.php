<?php

use App\Http\Controllers\Web\BundleController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\StripeController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Order is important here. Custom routes MUST go before resource.
Route::prefix('bundles')->group(function () {
    Route::get('/search', [BundleController::class, 'search'])->name('bundles.search');
});
Route::resource('bundles', BundleController::class);
Route::resource('payment', StripeController::class);

// User Profile routes
Route::middleware(['auth', 'verified'])->prefix('profile')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('profile');
});
