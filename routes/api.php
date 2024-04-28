<?php

use App\Http\Controllers\Api\Auth\UserAuthController;
use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\CountryStateController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\DegreeController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UniversityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

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

Route::middleware('auth:api')->controller(ExperienceController::class)->group(function () {
    Route::get('/users/{user}/experiences', 'index');
    Route::post('/experiences', 'store');
    Route::put('/experiences/{experience}', 'update')->middleware('can:update,experience');
    Route::delete('/experiences/{experience}', 'destroy')->middleware('can:delete,experience');
});

Route::controller(ProfileController::class)->prefix('profile/{user}')->group(function () {
    Route::get('/', 'index')->name('index');
});


//countries & states
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{country}', [CountryController::class, 'show']);
Route::get('/countries/{country}/states', [CountryStateController::class, 'index']);

Route::get('/universities', [UniversityController::class, 'index']);
Route::get('/degrees', [DegreeController::class, 'index']);

