<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AdminProfileController;
use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CourseLectureController;
use App\Http\Controllers\Api\CourseSectionController;
use App\Http\Controllers\Api\DegreeController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\SubCategoryController;

use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UniversityController;
use App\Http\Controllers\Api\UserController;
use App\Models\CourseLecture;
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
    Route::patch('/{subscription}', 'updatePrice')->middleware('permission:subscription-edit');
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
    Route::put('/{course}', 'update')->middleware('permission:course-edit');
    Route::put('/{course}/image', 'updateCourseImage')->middleware('permission:course-image-edit');
    Route::delete('/{course}', 'destroy')->middleware('permission:course-delete');
});


// courses sections routes
Route::get('/courses/{course}/sections', [CourseSectionController::class, 'index']);
Route::get('/courses/{course}/sections/{section}', [CourseSectionController::class, 'show'])->scopeBindings();

Route::middleware('auth:admin')->controller(CourseSectionController::class)->prefix('/courses/{course}/sections')->scopeBindings()->group(function () {
    Route::post('/', 'store')->middleware('permission:course-sections-create');
    Route::put('/{section}', 'update')->middleware('permission:course-sections-edit');
    Route::delete('/{section}', 'destroy')->middleware('permission:course-sections-delete');
});

// course section lectures routes
Route::get('/courses/{course}/sections/{section}/lectures', [CourseLectureController::class, 'index'])->scopeBindings();
Route::get('/courses/{course}/sections/{section}/lectures/{lecture}', [CourseLectureController::class, 'show'])->scopeBindings();
Route::middleware('auth:admin')->controller(CourseLectureController::class)->prefix('/courses/{course}/sections/{section}/lectures')->scopeBindings()->group(function () {
    Route::post('/', 'store')->middleware('permission:course-lectures-create');
    Route::put('/{lecture}', 'update')->middleware('permission:course-lectures-edit');
    Route::put('/{lecture}/video', 'updateLectureVideo')->middleware('permission:course-lecture-image-edit');
    Route::delete('/{lecture}', 'destroy')->middleware('permission:course-lectures-delete');
});

//  events routes
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);
Route::middleware('auth:admin')->controller(EventController::class)->prefix('events')->group(function () {
    Route::post('/', 'store');
    Route::put('/{events}', 'update')->middleware('permission:event-edit');
    Route::put('/{events}/image', 'updateEventImage')->middleware('permission:event-image-edit');
    Route::delete('/{events}', 'destroy')->middleware('permission:event-delete');
});

//  event attendees routes
Route::middleware('auth:admin')->controller(AttendeeController::class)->prefix('/events/{event}/attendees')->scopeBindings()->group(function () {
    Route::get('/', 'index');
    Route::get('/{attendee}', 'show');
    // Route::post('/', 'store');
    // Route::delete('/{attendee}', 'destroy');
    // Route::post('/{attendee}', 'show');
});

//  tags routes
Route::middleware('auth:admin')->controller(TagController::class)->prefix('/tags')->group(function () {
    // Route::get('/', 'index');
    // Route::get('/{tag}', 'show');
    Route::post('/', 'store');
    Route::put('/{tag}', 'update');
    Route::delete('/{tag}', 'destroy');
});

//profile
Route::middleware('auth:admin')->controller(AdminProfileController::class)->prefix('admin/profile/edit')->group(function () {
    Route::patch('/password', 'updatePassword');
    Route::patch('/avatar', 'updateAvatar');
    Route::delete('/avatar', 'deleteAvatar');
});
