<?php

use App\Auth\Controllers\AuthController;
use App\ShortUrl\Controllers\ShortUrlController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'getOauthToken']);
    Route::post('/signup', [AuthController::class, 'signup']);
});

Route::group(['prefix' => 'short_urls', 'middleware' => 'auth:api'], function () {
    Route::post('/', [ShortUrlController::class, 'create']);
    Route::get('/', [ShortUrlController::class, 'listByUser']);
    Route::put('/{id}', [ShortUrlController::class, 'update']);
    Route::get('/{id}/analytics', [ShortUrlController::class, 'getAnalytics']);
});
