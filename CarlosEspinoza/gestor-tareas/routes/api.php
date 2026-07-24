<?php

use App\Http\Controllers\TareasController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tareas', TareasController::class);