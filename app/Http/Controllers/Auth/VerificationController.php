<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Models\User\User;
use App\Services\Auth\AuthenticationService;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use PragmaRX\Google2FA\Google2FA;

class VerificationController extends Controller
{
    public function verifyEmailForm(Request $request): RedirectResponse|View
    {
        try {
            $session = Session::get('auth');
            if (!$session || !$email = $session['email']) {
                return redirect()->route('register')->with('error', trans('auth.email_not_found'));
            }

            if (!$user = User::where('email', $email)->first()) {
                return redirect()->route('register')->with('error', trans('auth.email_not_found'));
            }

            return $user->hasVerifiedEmail()
                ? redirect()->intended(AuthenticationService::getHomeRoutePath())
                : view('auth.verify', compact('user'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function verifyEmail(EmailVerificationRequest $request): RedirectResponse|View
    {
        if ($request->user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('success', trans('auth.email_verified_login'));
        }

        if ($request->user->markEmailAsVerified()) {
            event(new Verified($request->user));
        }

        if ($request->user->isAdmin()) {
            $google2fa = app(Google2FA::class);
            $secret = $request->user->google2fa_secret;
            $g2faUrl = $google2fa->getQRCodeUrl(
                config('app.name'),
                $request->user->email,
                $secret
            );

            $writer = new Writer(
                new ImageRenderer(
                    new RendererStyle(400),
                    new ImagickImageBackEnd()
                )
            );

            $qrcode_image = base64_encode($writer->writeString($g2faUrl));

            return view('auth.google2fa.register', ['QR_Image' => $qrcode_image, 'secret' => $secret, 'email' => $request->user->email]);
        }

        return redirect()->route('login')->with('success', trans('auth.email_verified_login'));
    }

    public function sendEmailVerificationNotification(Request $request): RedirectResponse
    {
        try {
            $request->validate(['email' => ['required', 'string', 'email', 'min:8', 'max:50']]);

            if (!$user = User::where('email', $request->email)->first()) {
                return redirect()->back()->with('error', trans('auth.email_not_found'));
            }

            if ($user->hasVerifiedEmail()) {
                return redirect()->intended(AuthenticationService::getHomeRoutePath() . '?verified=1');
            }

            $user->sendEmailVerificationNotification();

            return back()->with('status', 'verification-link-sent');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
