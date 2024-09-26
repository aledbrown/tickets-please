<?php

use Illuminate\Support\Facades\Route;

//:Remember api/
// https://tickets-please.test/api/
// universal resource locator
// tickets/{id}/edit
// users


Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');
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
