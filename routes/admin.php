<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

//admin auth
Route::controller(AdminAuthController::class)->prefix("admin")->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:admin');
    Route::post('refresh', 'refresh')->middleware('auth:admin');
    Route::get('me', 'me')->middleware('auth:admin');
});

//super admin only routes
Route::middleware(['auth:admin', 'role:super_admin'])->group(function () {
    Route::apiResource('roles', RoleController::class);
    Route::get('permissions', [PermissionController::class, 'index']);
    Route::apiResource('admins', AdminController::class);
});

//hospital routes
Route::middleware('auth:admin')->controller(HospitalController::class)->prefix('hospitals')->group(function () {
    Route::get('/', 'index')->middleware('permission:hospital-viewall');
    Route::post('/', 'store')->middleware('permission:hospital-create');
    Route::put('/{hospital}', 'update')->middleware('permission:hospital-edit');
    Route::delete('/{hospital}', 'destroy')->middleware('permission:hospital-delete');
});

//user routes
Route::get('/users', [UserController::class, 'index'])->middleware(['auth:admin', 'permission:user-viewall']);

//subscription routes
Route::middleware('auth:admin')->controller(SubscriptionController::class)->prefix('subscriptions')->group(function () {
    Route::get('/', 'index')->middleware('permission:subscription-viewall');
    Route::patch('/{subscription}', 'update')->middleware('permission:subscription-edit');
});

