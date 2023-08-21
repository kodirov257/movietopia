<?php

namespace App\Service\Auth;

use App\Entity\User\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthenticationService
{
    public static function getHomeRouteName(): string
    {
        if (Auth::user()->isAdmin()) {
            return 'dashboard.home';
        }

        return 'home';
    }

    public static function getHomeRoute(): string
    {
        $route = self::getHomeRouteName();

        session(['url.intended' => route($route)]);

        return route($route);
    }

    /**
     * @throws \Throwable
     */
    public function register(Request $request): User
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' =>$request->name,
                'email' => $request->email,
                'role' => User::ROLE_USER,
                'status' => User::STATUS_WAIT,
                'password' => Hash::make($request->password),
                'email_verify_token' => Str::uuid() . '_' . date('Y-m-d-H:i:s'),
            ]);

            $user->profile()->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ]);

            Session::put('auth', ['email' => $user->email]);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
