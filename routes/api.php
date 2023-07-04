<?php

use App\Http\Controllers\API\TodoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('todos', TodoController::class);
