<?php

use App\Http\Controllers\Api\auth\ForgotPasswordController;
use App\Http\Controllers\Api\auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\UserAuthController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\Course\CategoryController;
use App\Http\Controllers\Api\Course\SubCategoryController;
use App\Http\Controllers\Api\Education\DegreeController;
use App\Http\Controllers\Api\Education\EducationController;
use App\Http\Controllers\Api\Education\UniversityController;
use App\Http\Controllers\Api\Event\AttendeeController;
use App\Http\Controllers\Api\Event\TagController;
use App\Http\Controllers\Api\Experience\ExperienceController;
use App\Http\Controllers\Api\Location\CountryController;
use App\Http\Controllers\Api\Location\CountryStateController;
use App\Http\Controllers\Api\Profiles\UserProfileController;
use App\Http\Controllers\Api\Payment\PaypalController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SubscriptionController;
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

Route::post('password/forgot', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('password/reset', [ResetPasswordController::class, 'resetPassword']);

Route::middleware('auth:api')->controller(AttendeeController::class)->prefix('events')->group(function () {
    Route::get('/me', 'showUserEvents');
});

Route::middleware('auth:api')->controller(AttendeeController::class)->prefix('/events/{event}/attendees')->group(function () {
    // Route::get('/', 'index');
    // Route::get('/{attendee}', 'show');

    Route::post('/', 'store');
    Route::delete('/', 'destroy');

});

Route::middleware('auth:api')->controller(UserProfileController::class)->prefix('/profile')->group(function () {
    Route::patch('/edit/info', 'updateInformation');
    Route::patch('/edit/password', 'updatePassword');
    Route::patch('/edit/avatar', 'updateAvatar');
    Route::delete('/edit/avatar', 'deleteAvatar');
    Route::delete('/', 'destroy');
    Route::get('index', 'index');
});

//subscription routes
Route::get('/', [SubscriptionController::class, 'index'])->middleware('permission:subscription-viewall');
Route::middleware('auth:api')->controller(SubscriptionController::class)->prefix('subscriptions')->group(function () {
    Route::patch('/select', 'selectSubscription');
});

Route::middleware('auth:api')->controller(ExperienceController::class)->group(function () {
    Route::get('/users/{user}/experiences', 'index');
    Route::post('/experiences', 'store');
    Route::post('/experiences/all', 'storeAll');
    Route::put('/experiences/{experience}', 'update')->middleware('can:update,experience');
    Route::delete('/experiences/{experience}', 'destroy')->middleware('can:delete,experience');
});


//countries & states
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{country}', [CountryController::class, 'show']);
Route::get('/countries/{country}/states', [CountryStateController::class, 'index']);

//education routes
Route::get('/universities', [UniversityController::class, 'index']);
Route::get('/degrees', [DegreeController::class, 'index']);
Route::middleware('auth:api')->controller(EducationController::class)->group(function () {
    Route::get('/users/{user}/education', 'index');
    Route::post('/education', 'store');
    Route::post('/education/all', 'storeAll');
    Route::put('/education/{education}', 'update')->middleware('can:update,education');
    Route::delete('/education/{education}', 'destroy')->middleware('can:update,education');
});

// category routes
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{category}', [CategoryController::class, 'show']);
// subactegory routes
Route::get('/subcategory', [SubCategoryController::class, 'index']);
Route::get('/subcategory/{subcategory}', [SubCategoryController::class, 'show']);

// tags routes
Route::middleware('auth:api')->controller(TagController::class)->prefix('/tags')->group(function () {
    Route::get('/me', 'userIndex');
    Route::put('/me', 'userUpdate');
    // Route::get('/', 'index');
    // Route::get('/{tag}', 'show');
});
Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/all', [TagController::class, 'all']);
Route::get('/tags/{tag}', [TagController::class, 'show']);


//verify email
Route::post('/email/verification-notification', [VerifyEmailController::class, 'send'])
    ->middleware(['auth:api'])
    ->name('verification.send');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, 'verify'])
    ->middleware(['auth:api', 'signed'])
    ->name('verification.verify');

// 'throttle:6,1'

//contact us form
Route::post('/contactus', ContactUsController::class);

Route::get('search/{term}', SearchController::class);



// paypal payment 

Route::middleware('auth:api')->controller(PaypalController::class)->prefix('/payment/paypal')->group(function () {
    Route::post('/create-order', 'processTransaction');
    Route::post('/capture-order', 'successTransaction');
});