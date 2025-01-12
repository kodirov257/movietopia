<?php

use App\Http\Controllers\Admin\Celebrity\CelebrityController;
use App\Http\Controllers\Admin\Celebrity\CelebrityRelativeController;
use App\Http\Controllers\Admin\Celebrity\QuoteController;
use App\Http\Controllers\Admin\Celebrity\TrademarkController;
use App\Http\Controllers\Admin\Celebrity\TriviaController as CelebrityTriviaController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CountryRegionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Film\AlternateVersionController;
use App\Http\Controllers\Admin\Film\CompanyController as FilmCompanyController;
use App\Http\Controllers\Admin\Film\ConnectionController;
use App\Http\Controllers\Admin\Film\CreditController;
use App\Http\Controllers\Admin\Film\FilmCompanyReleaseDateController;
use App\Http\Controllers\Admin\Film\FilmController;
use App\Http\Controllers\Admin\Film\FilmReleaseDateController;
use App\Http\Controllers\Admin\Film\GoofController;
use App\Http\Controllers\Admin\Film\GoofTypeController;
use App\Http\Controllers\Admin\Film\LocationController;
use App\Http\Controllers\Admin\Film\SloganController;
use App\Http\Controllers\Admin\Film\SynopsisController;
use App\Http\Controllers\Admin\Film\TriviaController as FilmTriviaController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\TwoFactorAuthController;
use App\Http\Controllers\Auth\UserController as AuthUserController;
use App\Http\Controllers\Auth\VerificationController;
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
    Route::get('register', [RegistrationController::class, 'create'])->name('register.show');
    Route::post('register', [RegistrationController::class, 'register'])->name('register');
    Route::post('register/complete', [RegistrationController::class, 'completeRegistration'])->name('register.complete');

    Route::get('/verify-email', [VerificationController::class, 'verifyEmailForm'])->name('verification.email.notice');
    Route::get('/verify-email/{id}/{hash}', [VerificationController::class, 'verifyEmail'])
        ->middleware(['signed', 'throttle:6,1'])->name('verification.email.verify');
    Route::post('/verify-email/resend', [VerificationController::class, 'sendEmailVerificationNotification'])
        ->middleware(['throttle:6,1'])->name('verification.email.send');

    Route::get('/forgot-password', [PasswordResetController::class, 'showEmail'])->name('password.email.request');
    Route::post('/forgot-password-email', [PasswordResetController::class, 'sendResetByEmail'])->name('password.email.send');
    Route::get('/reset-password-email/{token}', [PasswordResetController::class, 'showResetByEmail'])->name('password.email.reset.show');
    Route::post('/reset-password-email', [PasswordResetController::class, 'resetByEmail'])->name('password.email.reset');

    Route::get('/two-factor-auth', [TwoFactorAuthController::class, 'create'])->name('two-factor-auth.create');
    Route::post('/two-factor-auth', [TwoFactorAuthController::class, 'store'])->name('two-factor-auth.store');
    Route::post('/two-factor-auth/complete', [TwoFactorAuthController::class, 'complete'])->name('two-factor-auth.complete');

    Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('signin');

});

Route::middleware('auth')->group(function () {
    Route::get('/confirm-password', [ConfirmPasswordController::class, 'show'])->name('password.confirm.show');
    Route::post('/confirm-password', [ConfirmPasswordController::class, 'confirm'])->name('password.confirm');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('2fa')->group(function () {
        Route::put('/password', [AuthUserController::class, 'updatePassword'])->name('password.update');
        Route::post('/2fa', [LoginController::class, 'google2fa'])->name('2fa');
    });
});

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth', 'can:admin-panel', '2fa']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::resource('users', UserController::class);
    Route::post('users/{user}/remove-avatar', [UserController::class, 'removeAvatar'])->name('remove-avatar');

    Route::resource('genres', GenreController::class);
    Route::resource('country-regions', CountryRegionController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('languages', LanguageController::class);
    Route::resource('types', TypeController::class);

    Route::resource('celebrities', CelebrityController::class);
    Route::group(['prefix' => 'celebrities/{celebrity}', 'as' => 'celebrities.'], function () {
        Route::get('update-biography', [CelebrityController::class, 'editBiography'])->name('biography.edit');
        Route::put('update-biography', [CelebrityController::class, 'updateBiography'])->name('biography.update');
        Route::post('remove-photo', [CelebrityController::class, 'removePhoto'])->name('remove_photo');

        Route::resource('relatives', CelebrityRelativeController::class)->except('index');

        Route::resource('trademarks', TrademarkController::class)->except('index');
        Route::group(['prefix' => 'trademarks/{trademark}', 'as' => 'trademarks.'], function () {
            Route::post('first', [TrademarkController::class, 'first'])->name('first');
            Route::post('up', [TrademarkController::class, 'up'])->name('up');
            Route::post('down', [TrademarkController::class, 'down'])->name('down');
            Route::post('last', [TrademarkController::class, 'last'])->name('last');
        });

        Route::resource('trivias', CelebrityTriviaController::class)->except('index');
        Route::group(['prefix' => 'trivias/{trivia}', 'as' => 'trivias.'], function () {
            Route::post('first', [CelebrityTriviaController::class, 'first'])->name('first');
            Route::post('up', [CelebrityTriviaController::class, 'up'])->name('up');
            Route::post('down', [CelebrityTriviaController::class, 'down'])->name('down');
            Route::post('last', [CelebrityTriviaController::class, 'last'])->name('last');
        });

        Route::resource('quotes', QuoteController::class)->except('index');
        Route::group(['prefix' => 'quotes/{quote}', 'as' => 'quotes.'], function () {
            Route::post('first', [QuoteController::class, 'first'])->name('first');
            Route::post('up', [QuoteController::class, 'up'])->name('up');
            Route::post('down', [QuoteController::class, 'down'])->name('down');
            Route::post('last', [QuoteController::class, 'last'])->name('last');
        });
    });

    Route::resource('films', FilmController::class);
    Route::group(['prefix' => 'films/{film}', 'as' => 'films.'], function () {
        Route::get('update-description', [FilmController::class, 'editDescription'])->name('description.edit');
        Route::put('update-description', [FilmController::class, 'updateDescription'])->name('description.update');
        Route::get('update-storyline', [FilmController::class, 'editStoryline'])->name('storyline.edit');
        Route::put('update-storyline', [FilmController::class, 'updateStoryline'])->name('storyline.update');
        Route::post('remove-poster', [FilmController::class, 'removePoster'])->name('remove_poster');

        Route::resource('slogans', SloganController::class)->except('index');
        Route::group(['prefix' => 'slogans/{slogan}', 'as' => 'slogans.'], function () {
            Route::post('first', [SloganController::class, 'first'])->name('first');
            Route::post('up', [SloganController::class, 'up'])->name('up');
            Route::post('down', [SloganController::class, 'down'])->name('down');
            Route::post('last', [SloganController::class, 'last'])->name('last');
        });

        Route::resource('synopses', SynopsisController::class)->except('index');
        Route::group(['prefix' => 'synopses/{synopsis}', 'as' => 'synopses.'], function () {
            Route::post('first', [SynopsisController::class, 'first'])->name('first');
            Route::post('up', [SynopsisController::class, 'up'])->name('up');
            Route::post('down', [SynopsisController::class, 'down'])->name('down');
            Route::post('last', [SynopsisController::class, 'last'])->name('last');
        });

        Route::resource('trivias', FilmTriviaController::class)->except('index');
        Route::group(['prefix' => 'trivias/{trivia}', 'as' => 'trivias.'], function () {
            Route::post('first', [FilmTriviaController::class, 'first'])->name('first');
            Route::post('up', [FilmTriviaController::class, 'up'])->name('up');
            Route::post('down', [FilmTriviaController::class, 'down'])->name('down');
            Route::post('last', [FilmTriviaController::class, 'last'])->name('last');
        });

        Route::resource('goofs', GoofController::class)->except('index');
        Route::group(['prefix' => 'goofs/{goof}', 'as' => 'goofs.'], function () {
            Route::post('first', [GoofController::class, 'first'])->name('first');
            Route::post('up', [GoofController::class, 'up'])->name('up');
            Route::post('down', [GoofController::class, 'down'])->name('down');
            Route::post('last', [GoofController::class, 'last'])->name('last');
        });

        Route::resource('credits', CreditController::class)->except('index');
        Route::group(['prefix' => 'credits/{credit}', 'as' => 'credits.'], function () {
            Route::post('first', [CreditController::class, 'first'])->name('first');
            Route::post('up', [CreditController::class, 'up'])->name('up');
            Route::post('down', [CreditController::class, 'down'])->name('down');
            Route::post('last', [CreditController::class, 'last'])->name('last');
        });

        Route::resource('connections', ConnectionController::class)->except('index');
        Route::group(['prefix' => 'connections/{connection}', 'as' => 'connections.'], function () {
            Route::post('first', [ConnectionController::class, 'first'])->name('first');
            Route::post('up', [ConnectionController::class, 'up'])->name('up');
            Route::post('down', [ConnectionController::class, 'down'])->name('down');
            Route::post('last', [ConnectionController::class, 'last'])->name('last');
        });

        Route::resource('locations', LocationController::class)->except('index');
        Route::group(['prefix' => 'locations/{location}', 'as' => 'locations.'], function () {
            Route::post('first', [LocationController::class, 'first'])->name('first');
            Route::post('up', [LocationController::class, 'up'])->name('up');
            Route::post('down', [LocationController::class, 'down'])->name('down');
            Route::post('last', [LocationController::class, 'last'])->name('last');
        });

        Route::resource('companies', FilmCompanyController::class)->except('index');
        Route::group(['prefix' => 'companies/{company}', 'as' => 'companies.'], function () {
            Route::post('first', [FilmCompanyController::class, 'first'])->name('first');
            Route::post('up', [FilmCompanyController::class, 'up'])->name('up');
            Route::post('down', [FilmCompanyController::class, 'down'])->name('down');
            Route::post('last', [FilmCompanyController::class, 'last'])->name('last');

            Route::resource('release-dates', FilmCompanyReleaseDateController::class)->except('index');
            Route::group(['prefix' => 'release-dates/{releaseDate}', 'as' => 'release-dates.'], function () {
                Route::post('first', [FilmCompanyReleaseDateController::class, 'first'])->name('first');
                Route::post('up', [FilmCompanyReleaseDateController::class, 'up'])->name('up');
                Route::post('down', [FilmCompanyReleaseDateController::class, 'down'])->name('down');
                Route::post('last', [FilmCompanyReleaseDateController::class, 'last'])->name('last');
            });
        });

        Route::resource('release-dates', FilmReleaseDateController::class)->except('index');
        Route::group(['prefix' => 'release-dates/{releaseDate}', 'as' => 'release-dates.'], function () {
            Route::post('first', [FilmReleaseDateController::class, 'first'])->name('first');
            Route::post('up', [FilmReleaseDateController::class, 'up'])->name('up');
            Route::post('down', [FilmReleaseDateController::class, 'down'])->name('down');
            Route::post('last', [FilmReleaseDateController::class, 'last'])->name('last');
        });

        Route::resource('alternate-versions', AlternateVersionController::class)->except('index');
        Route::group(['prefix' => 'alternate-versions/{alternateVersion}', 'as' => 'alternate-versions.'], function () {
            Route::post('first', [AlternateVersionController::class, 'first'])->name('first');
            Route::post('up', [AlternateVersionController::class, 'up'])->name('up');
            Route::post('down', [AlternateVersionController::class, 'down'])->name('down');
            Route::post('last', [AlternateVersionController::class, 'last'])->name('last');
        });
    });

    Route::resource('goof-types', GoofTypeController::class);
    Route::group(['prefix' => 'goof-types/{goofType}', 'as' => 'goof-types.'], function () {
        Route::post('first', [GoofTypeController::class, 'first'])->name('first');
        Route::post('up', [GoofTypeController::class, 'up'])->name('up');
        Route::post('down', [GoofTypeController::class, 'down'])->name('down');
        Route::post('last', [GoofTypeController::class, 'last'])->name('last');
    });

    Route::post('/darkmode/toggle', [DarkModeController::class, 'toggle'])
        ->name('darkmode.toggle');
});

Route::get('/', function () {
    return view('welcome');
})->name('home');
