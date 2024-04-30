<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DegreeController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\SubCategoryController;

use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\UniversityController;
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
    // Route::apiResource('roles', RoleController::class);
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

//university routes
Route::middleware('auth:admin')->controller(UniversityController::class)->prefix('universities')->group(function () {
    Route::post('/', 'store')->middleware('permission:university-create');
    Route::patch('/{university}', 'update')->middleware('permission:university-edit');
    Route::delete('/{university}', 'destroy')->middleware('permission:university-delete');
});

//degree routes
Route::middleware('auth:admin')->controller(DegreeController::class)->prefix('degrees')->group(function () {
    Route::post('/', 'store')->middleware('permission:degree-create');
    Route::patch('/{degree}', 'update')->middleware('permission:degree-edit');
    Route::delete('/{degree}', 'destroy')->middleware('permission:degree-delete');
});

// category routes
Route::middleware('auth:admin')->controller(CategoryController::class)->prefix('category')->group(function () {
    Route::post('/', 'store')->middleware('permission:category-create');
    Route::put('/{category}', 'update')->middleware('permission:category-edit');
    Route::delete('/{category}', 'destroy')->middleware('permission:category-delete');
});


// subcategory routes
Route::middleware('auth:admin')->controller(SubCategoryController::class)->prefix('subcategory')->group(function () {
    Route::post('/', 'store')->middleware('permission:subcategory-create');
    Route::put('/{subcategory}', 'update')->middleware('permission:subcategory-edit');
    Route::delete('/{subcategory}', 'destroy')->middleware('permission:subcategory-delete');
});

// Courses routes
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{course}', [CourseController::class, 'show']);
Route::middleware('auth:admin')->controller(CourseController::class)->prefix('courses')->group(function () {
    Route::post('/', 'store')->middleware('permission:course-create');
    Route::put('/{courses}', 'update')->middleware('permission:course-edit');
    Route::delete('/{courses}', 'destroy')->middleware('permission:course-delete');
});

//  events routes
// Route::apiResource('events', EventController::class);
// Route::apiResource('events.attendees', AttendeeController::class)->scoped()->except(['update']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);
Route::middleware('auth:admin')->controller(EventController::class)->prefix('events')->group(function () {
    Route::post('/', 'store')->middleware('permission:event-create');
    Route::put('/{events}', 'update')->middleware('permission:event-edit');
    Route::put('/{events}/image', 'updateEventImage')->middleware('permission:event-image-edit');
    Route::delete('/{events}', 'destroy')->middleware('permission:event-delete');
});


Route::apiResource('events.attendees', AttendeeController::class)->scoped()->except(['update']);
// Route::middleware('auth:api')->controller(AttendeeController::class)->prefix('/events/{event}/attendees')->group(function () {
//     Route::get('/', 'index');
//     Route::post('/{attendee}', 'store');
//     Route::delete('/{attendee}', 'destroy')->middleware('can:delete,experience');
// });
