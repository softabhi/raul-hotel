<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/rooms', [ApiController::class, 'rooms']);
Route::get('/rooms/{id}', [ApiController::class, 'room']);
Route::post('/bookings', [ApiController::class, 'book']);

Route::get('/foods', [ApiController::class, 'foods']);
Route::get('/foods/{id}', [ApiController::class, 'food']);
Route::post('/orders', [ApiController::class, 'order']);
