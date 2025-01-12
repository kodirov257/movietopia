<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\Auth\VerificationController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['as' => 'api.', 'namespace' => 'Api'], function () {
    Route::middleware('guest')->group(function () {
        Route::post('/register', [RegistrationController::class, 'register'])->name('registration.register');

        Route::post('/verify-email', [VerificationController::class, 'verifyByEmail'])
            ->middleware(['throttle:api:6,1'])->name('verification.email.verify');
        Route::post('/verify-email/resend', [VerificationController::class, 'sendEmailVerificationNotification'])
            ->middleware(['throttle:api:6,1'])->name('verification.email.send');

        Route::post('/forgot-password-email', [PasswordResetController::class, 'sendResetByEmail'])->name('password.email.send');
        Route::post('/reset-password-email', [PasswordResetController::class, 'resetByEmail'])->name('password.email.reset');

        Route::post('/login', [LoginController::class, 'login'])->name('signin');
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/auth/me', [UserController::class, 'info']);

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::get('/search-regions', [SearchController::class, 'searchRegions']);
    Route::get('/search-celebrities', [SearchController::class, 'searchCelebrities']);
    Route::get('/search-films', [SearchController::class, 'searchFilms']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
