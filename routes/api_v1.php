<?php

use App\Http\Controllers\Api\V1\AuthorTicketsController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // api/v1/tickets/{id}
    Route::apiResource('tickets', TicketController::class)->except('update');
    Route::put('tickets/{ticket}', [TicketController::class, 'replace']);
    // api/v1/authors/{id}
    Route::apiResource('authors', AuthorController::class);
    // api/v1/authors/{id}/tickets
    Route::apiResource('authors.tickets', AuthorTicketsController::class)->except(['update']);
    Route::put('authors/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'replace']);
});
