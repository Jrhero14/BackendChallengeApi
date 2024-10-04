<?php

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
    Route::post('/register', \App\Http\Controllers\Api\Auth\RegisterController::class)->name('register');
    Route::post('/login', \App\Http\Controllers\Api\Auth\LoginController::class)->name('login');
    Route::post('/logout', \App\Http\Controllers\Api\Auth\LogoutController::class)->name('logout');
    Route::get('/refresh-token', \App\Http\Controllers\Api\Auth\RefreshController::class)->name('refresh-token');
});

Route::get('/ping', \App\Http\Controllers\Api\PingController::class)->name('ping');
