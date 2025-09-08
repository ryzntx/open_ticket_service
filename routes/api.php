<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'index']);
Route::post('/tickets', [\App\Http\Controllers\Api\TicketController::class, 'store']);
Route::get('/categories/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'show']);
