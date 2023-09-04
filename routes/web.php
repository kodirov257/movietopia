<?php

use Illuminate\Support\Facades\Route;
use JeroenNoten\LaravelAdminLte\Http\Controllers\DarkModeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('register', 'Auth\RegistrationController@create')->name('register.show');
    Route::post('register', 'Auth\RegistrationController@register')->name('register');
    Route::post('register/complete', 'Auth\RegistrationController@completeRegistration')->name('register.complete');

    Route::get('/verify-email', 'Auth\VerificationController@verifyEmailForm')->name('verification.email.notice');
    Route::get('/verify-email/{id}/{hash}', 'Auth\VerificationController@verifyEmail')
        ->middleware(['signed', 'throttle:6,1'])->name('verification.email.verify');
    Route::post('/verify-email/resend', 'Auth\VerificationController@sendEmailVerificationNotification')
        ->middleware(['throttle:6,1'])->name('verification.email.send');

    Route::get('/forgot-password', 'Auth\PasswordResetController@showEmail')->name('password.email.request');
    Route::post('/forgot-password-email', 'Auth\PasswordResetController@sendResetByEmail')->name('password.email.send');
    Route::get('/reset-password-email/{token}', 'Auth\PasswordResetController@showResetByEmail')->name('password.email.reset.show');
    Route::post('/reset-password-email', 'Auth\PasswordResetController@resetByEmail')->name('password.email.reset');

    Route::get('/two-factor-auth', 'Auth\TwoFactorAuthController@create')->name('two-factor-auth.create');
    Route::post('/two-factor-auth', 'Auth\TwoFactorAuthController@store')->name('two-factor-auth.store');
    Route::post('/two-factor-auth/complete', 'Auth\TwoFactorAuthController@complete')->name('two-factor-auth.complete');

    Route::get('/login', 'Auth\LoginController@loginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login')->name('signin');

});

Route::middleware('auth')->group(function () {
    Route::get('/confirm-password', 'Auth\ConfirmPasswordController@show')->name('password.confirm.show');
    Route::post('/confirm-password', 'Auth\ConfirmPasswordController@confirm')->name('password.confirm');

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::middleware('2fa')->group(function () {
        Route::put('/password', 'Auth\UserController@updatePassword')->name('password.update');
        Route::post('/2fa', 'Auth\LoginController@google2fa')->name('2fa');
    });
});

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'namespace' => 'Admin', 'middleware' => ['auth', 'can:admin-panel', '2fa']], function () {
    Route::get('/', 'DashboardController@index')->name('home');

    Route::resource('users', 'UserController');
    Route::post('users/{user}/remove-avatar', 'UserController@removeAvatar')->name('remove-avatar');

    Route::resource('genres', 'GenreController');
    Route::resource('country-regions', 'CountryRegionController');
    Route::resource('companies', 'CompanyController');
    Route::resource('positions', 'PositionController');

    Route::group(['namespace' => 'Celebrity'], function () {
        Route::resource('celebrities', 'CelebrityController');
        Route::group(['prefix' => 'celebrities/{celebrity}', 'as' => 'celebrities.'], function () {
            Route::get('update-biography', 'CelebrityController@editBiography')->name('biography.edit');
            Route::put('update-biography', 'CelebrityController@updateBiography')->name('biography.update');
            Route::post('remove-photo', 'CelebrityController@removePhoto')->name('remove_photo');

            Route::resource('relatives', 'CelebrityRelativeController')->except('index');

            Route::resource('trademarks', 'TrademarkController')->except('index');
            Route::group(['prefix' => 'trademarks/{trademark}', 'as' => 'trademarks.'], function () {
                Route::post('first', 'TrademarkController@first')->name('first');
                Route::post('up', 'TrademarkController@up')->name('up');
                Route::post('down', 'TrademarkController@down')->name('down');
                Route::post('last', 'TrademarkController@last')->name('last');
            });

            Route::resource('trivias', 'TriviaController')->except('index');
            Route::group(['prefix' => 'trivias/{trivia}', 'as' => 'trivias.'], function () {
                Route::post('first', 'TriviaController@first')->name('first');
                Route::post('up', 'TriviaController@up')->name('up');
                Route::post('down', 'TriviaController@down')->name('down');
                Route::post('last', 'TriviaController@last')->name('last');
            });

            Route::resource('quotes', 'QuoteController')->except('index');
            Route::group(['prefix' => 'quotes/{quote}', 'as' => 'quotes.'], function () {
                Route::post('first', 'QuoteController@first')->name('first');
                Route::post('up', 'QuoteController@up')->name('up');
                Route::post('down', 'QuoteController@down')->name('down');
                Route::post('last', 'QuoteController@last')->name('last');
            });
        });
    });

    Route::post('/darkmode/toggle', [DarkModeController::class, 'toggle'])
        ->name('darkmode.toggle');
});

Route::get('/', function () {
    return view('welcome');
})->name('home');
