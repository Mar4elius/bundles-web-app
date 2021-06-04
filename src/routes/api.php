<?php
// Support
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Controllers
use App\Http\Controllers\Api\BundleController;
use App\Http\Controllers\Api\CartBundleController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OptionController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    // Bundles
    Route::prefix('bundles')->group(function () {
        Route::get('/search', [BundleController::class, 'search']);
        Route::get('/additional', [BundleController::class, 'getAdditionalBundles']);
        Route::get('/filter-options', [BundleController::class, 'getFilterOptions']);
        Route::get('/sort-options', [BundleController::class, 'getSortOptions']);
        Route::get('/show', [BundleController::class, 'getBundleDetails']);
    });

    // Products
    Route::resource('products', ProductController::class);
    Route::prefix('products')->group(function () {
        Route::get('/all', [ProductController::class, 'all']);
    });

    // Carts
    Route::resource('carts', CartController::class);

    // Cart Bundles
    Route::prefix('cart-bundles')->group(function () {
        Route::patch('/{cart_bundle}/products/{product}', [CartBundleController::class, 'updateCartBundleProduct'])->name('cart-bundles.product.update');
    });
    Route::resource('cart-bundles', CartBundleController::class);

    // User
    Route::resource('user', UserController::class);

    // Options
    Route::prefix('options')->group(function () {
        Route::get('/countries', [OptionController::class, 'getCountries']);
        Route::get('/countries/{country}/provinces', [OptionController::class, 'getProvinces']);
    });
});
