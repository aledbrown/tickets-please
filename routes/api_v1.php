<?php

use App\Http\Controllers\Api\V1\AuthorTicketsController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// api/v1/tickets/{id}
Route::middleware('auth:sanctum')->apiResource('tickets', TicketController::class);
// api/v1/authors/{id}
Route::middleware('auth:sanctum')->apiResource('authors', AuthorController::class);
// api/v1/authors/{id}/tickets
Route::middleware('auth:sanctum')->apiResource('authors.tickets', AuthorTicketsController::class);
