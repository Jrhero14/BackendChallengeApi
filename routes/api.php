<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RefreshController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\ProductController;
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
    Route::get('/{id}', [ProductController::class, 'showByIdProduct'])->name('get-by-id-product');
    Route::get('/user/{id}', [ProductController::class, 'showByIdUser'])->name('get-by-id-user');
    Route::post('/create', [ProductController::class, 'create'])->name('create-product');
    Route::put('/update/{id}', [ProductController::class, 'updateData'])->name('create-product');
    Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('create-product');
});

Route::get('/ping', \App\Http\Controllers\Api\PingController::class)->name('ping');
