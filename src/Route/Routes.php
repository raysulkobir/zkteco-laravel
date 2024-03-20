<?php

use Illuminate\Support\Facades\Route;
use Raysulkobir\ZktecoLaravel\Http\Controllers\CronJobManagementController;

Route::get('/get-attendance-log', [CronJobManagementController::class, 'getAttendanceLog']);
Route::get('/get-attendance', [CronJobManagementController::class, 'getAttendance']);
Route::get('/get-employee', [CronJobManagementController::class, 'getEmployee']);
