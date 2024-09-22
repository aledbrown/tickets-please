<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//:Remember api/
// https://tickets-please.test/api/
// universal resource locator
// tickets/{id}/edit
// users


Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

// Route::get('/', function () {
//     return response()->json([
//         'name' => config('app.name'),
//         'message' => 'Hello, API!',
//     ], 200);
// });

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
