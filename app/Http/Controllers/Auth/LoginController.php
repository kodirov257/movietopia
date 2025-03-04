<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthenticationService;
use Google2FA;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private AuthenticationService $service;

    public function __construct(AuthenticationService $service)
    {
        session(['url.intended' => url()->previous()]);
        $this->middleware('guest')->except('logout');
        $this->service = $service;
    }

    public function loginForm(): View
    {
        try {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->previous()]);
            }

            return view('auth.login');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            $this->service->authenticate($request);

            $request->session()->regenerate();

            return $this->service->authenticated();
        } catch (ValidationException $e) {
            return redirect()->route('login')->withInput($request->only($request->username(), 'remember'))->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->route('login')->withInput($request->only($request->username(), 'remember'))->withErrors([
            $request->username() => trans('auth.failed'),
                'password' => trans('auth.wrong_password'),
            ]);
        }
    }

    public function google2fa(Request $request): RedirectResponse
    {
        return redirect()->route(AuthenticationService::getHomeRouteName());
    }

    public function logout(Request $request): RedirectResponse
    {
        try {
            Auth::guard('web')->logout();

            Google2FA::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('dashboard.home');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors($e->getMessage());
        }
    }
}
