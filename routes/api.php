<?php

use App\Http\Controllers\Api\Auth\UserAuthController;
use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\StateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('api')->group(function () {
// Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);
// Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
// Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
// Route::post('me', [AuthController::class, 'me'])->middleware('auth:api');
// });

Route::controller(UserAuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh')->middleware('auth:api');
    Route::get('me', 'me')->middleware('auth:api');
});

Route::apiResource('courses', CourseController::class);
Route::apiResource('events', EventController::class);
// Route::apiResource('events.attendees', AttendeeController::class)->scoped(['attendee' => 'event']);
Route::apiResource('events.attendees', AttendeeController::class)->scoped()->except(['update']);


Route::middleware('auth:api')->controller(ProfileController::class)->prefix('/profile/edit')->group(function () {
    Route::patch('info', 'updateInformation');
    Route::post('avatar', 'updateAvatar');
    Route::get('avatar', 'selectAvatar');
    Route::delete('edit', 'destroy');
});

Route::controller(ProfileController::class)->prefix('profile/{user}')->group(function () {
    Route::get('/', 'index')->name('index');
});


//countries & states
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{country}', [CountryController::class, 'show']);
Route::get('/countries/{country}/states', [StateController::class, 'index']);

