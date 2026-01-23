<?php

use App\Http\Controllers\ReportesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Subscription_reportsController;

Route::get('Reportes/index/', [ReportesController::class, 'index']);
Route::get('Subscription_reports/export/', [Subscription_reportsController::class, 'export']);
