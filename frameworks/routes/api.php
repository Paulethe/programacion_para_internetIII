<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;

Route::get('/tareas', [TareaController::class, 'index']);
Route::post('/tareas', [TareaController::class, 'store']);
Route::delete('/tareas/{id}', [TareaController::class, 'destroy']);