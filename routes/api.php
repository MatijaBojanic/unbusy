<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [\App\Http\Controllers\AuthenticationController::class, 'logout']);

    Route::post('bus-lines', [\App\Http\Controllers\BusLineController::class, 'store']);

    Route::delete('bus-lines/{busLine}', [\App\Http\Controllers\BusLineController::class, 'destroy']);
});

Route::post('/login', [\App\Http\Controllers\AuthenticationController::class, 'login']);

Route::get('bus-lines/{busLine}', [\App\Http\Controllers\BusLineController::class, 'show']);

Route::get('bus-lines', [\App\Http\Controllers\BusLineController::class, 'index']);
