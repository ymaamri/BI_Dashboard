<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/api/report', [DashboardController::class, 'getReport']);
Route::get('/api/monthly-evolution', [DashboardController::class, 'getMonthlyEvolution']);
Route::get('/api/scatter-data', [DashboardController::class, 'getScatterData']);
Route::get('/api/employee-category', [DashboardController::class, 'getEmployeeCategoryData']);
Route::get('/api/heatmap-data', [DashboardController::class, 'getHeatmapData']);