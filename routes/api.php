<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RefreshController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Review\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/login', LoginController::class)->name('login');
    Route::post('/logout', LogoutController::class)->name('logout');
    Route::get('/refresh-token', RefreshController::class)->name('refresh-token');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'product'
], function ($router) {
    Route::get('/', [ProductController::class, 'index'])->name('get-products');
    Route::get('/get/{id}', [ProductController::class, 'showByIdProduct'])->name('get-by-id-product');
    Route::get('/user/{id}', [ProductController::class, 'showByIdUser'])->name('get-by-id-user');

    Route::get('/search', [ProductController::class, 'searchProduct'])->name('search-product');

    Route::post('/create', [ProductController::class, 'create'])->name('create-product');
    Route::put('/update/{id}', [ProductController::class, 'updateData'])->name('update-product');
    Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('delete-product');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'review'
], function ($router) {

    Route::get('/', [ReviewController::class, 'index'])->name('get-reviews');
    Route::get('/get/{id}', [ReviewController::class, 'byIdReview'])->name('get-reviews-by-id-review');
    Route::get('/user/{id}', [ReviewController::class, 'byUserId'])->name('get-reviews-by-userId');
    Route::get('/product/{id}', [ReviewController::class, 'byProductId'])->name('get-reviews-by-productId');
    Route::get('/search', [ReviewController::class, 'searchReview'])->name('search-review');

    Route::post('/create', [ReviewController::class, 'createReview'])->name('search-review');
    Route::put('/update/{id}', [ReviewController::class, 'updateReview'])->name('update-review');
    Route::delete('/delete/{id}', [ReviewController::class, 'deleteReview'])->name('delete-review');

});
