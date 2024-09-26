<?php

use Illuminate\Support\Facades\Route;

// universal resource locator
// Remember api/
// https://tickets-please.test/api/
// tickets/{id}/edit

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');




// Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);

// Route::get('/tickets', function () {
//     return response()->json([
//         'tickets' => \App\Models\Ticket::get(),
//     ], 200);
// });

// Route::get('/', function () {
//     return response()->json([
//         'name' => config('app.name'),
//         'message' => 'Hello, API!',
//     ], 200);
// });

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
