<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\HealthCheckController;

// Health
Route::get('/health-check', [HealthCheckController::class, 'healthCheck']);
