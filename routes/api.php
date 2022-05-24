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

Route::post('/search_users', [\App\Http\Controllers\UserController::class, 'findByEmail']);
Route::post('/search_address', [\App\Http\Controllers\GeocodingController::class, 'searchAddress']);
Route::post('/search_address_google', [\App\Http\Controllers\GeocodingController::class, 'searchAddressUsingGoogleMaps']);

Route::middleware('locale:it')->group(function () {
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [\App\Http\Controllers\AuthController::class, 'me']);
});
