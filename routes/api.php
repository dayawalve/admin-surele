<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\AuthController;


Route::post('/login', [AuthController::class, 'login']);

Route::get('/get-basic-settings', [CommonController::class, 'getBasicSettings']);
Route::get('/get-all-domains', [CommonController::class, 'getAllDomains']);
Route::get('/auto-logged-out', [CommonController::class, 'autoLogoutAll']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get-domains', [CommonController::class, 'getDomains']);
    Route::post('/add-screenshots', [CommonController::class, 'storeScreenshots']);
    Route::post('/store-tracking-data', [CommonController::class, 'storeTrackingData']);
    Route::post('/employee-daily-activity', [CommonController::class, 'EmployeeDailyActivity']);
    Route::get('/employee-work-time', [CommonController::class, 'EmployeeWorkTime']);
    Route::post('/submit-ideal-time-reason', [CommonController::class, 'submitIdealTimeReason']);
    Route::post('/logout', [AuthController::class, 'logout']);
});