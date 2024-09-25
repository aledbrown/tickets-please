<?php

use App\Http\Controllers\Api\V1\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// api/v1/tickets/{id}
Route::apiResource('tickets', TicketController::class);
