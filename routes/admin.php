<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AdminAuthController::class)->prefix("admin")->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:admin');
    Route::post('refresh', 'refresh')->middleware('auth:admin');
    Route::get('me', 'me')->middleware('auth:admin');
});


// Route::middleware(['auth:admin', 'role:super_admin|admin'])->group(function () {
// });

Route::middleware(['auth:admin', 'role:super_admin'])->group(function () {
    Route::apiResource('roles', RoleController::class);
    Route::get('permissions', [PermissionController::class, 'index']);
    Route::apiResource('users', UserController::class)->only(['index', 'show']);
    Route::apiResource('admins', AdminController::class);
    Route::apiResource('hospitals', HospitalController::class)->except('show');

    //sub routes
    Route::get('subscriptions', [SubscriptionController::class, 'index']);
    Route::get('subscriptions/{subscription}', [SubscriptionController::class, 'show']);
    Route::patch('subscriptions/{subscription}', [SubscriptionController::class, 'update']);
});

