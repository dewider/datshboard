<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/widget/{widgetModel}', [DashboardController::class, 'detail'])->name('widgetDetail');

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/widget/{widgetModel}', [AdminController::class, 'widgetDetail'])->name('adminWidgetDetail');
    Route::patch('/admin/widget/{widgetModel}', [AdminController::class, 'widgetUpdateConfig'])->name('adminWidgetUpdateConfig');
    
    Route::get('/admin/add-widget/', [AdminController::class, 'addWidget']);
});

require __DIR__.'/auth.php';
