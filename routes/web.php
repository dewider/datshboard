<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/{widgetModel}', [DashboardController::class, 'detail'])->name('widgetDetail');
