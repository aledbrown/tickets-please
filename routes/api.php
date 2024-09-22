<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//:Remember api/

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::get('/', function () {
    return response()->json([
        'name' => config('app.name'),
        'message' => 'Hello, API!',
    ], 200);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
