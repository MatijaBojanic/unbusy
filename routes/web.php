<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/async/documentation', function () {
    return view('asyncapi');
});

Route::get('/.well-known/ai-plugin.json', function () {
    return Storage::disk('public')->response('.well-known/ai-plugin.json');
})->middleware(\App\Http\Middleware\HandlePreflight::class);

Route::get('/.well-known/openapi.json', function () {
    return Storage::disk('public')->response('.well-known/api-docs.json');
});

Route::get('logo.png', function () {
    return Storage::disk('public')->response('logo.png');
});


Route::get('legal', function () {
    return Storage::disk('public')->response('legal');
});
