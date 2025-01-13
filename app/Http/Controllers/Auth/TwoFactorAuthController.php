<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthController extends Controller
{
    public function create(): View
    {
        return view('auth.google2fa.create-form');
    }

    public function store(Request $request): View|RedirectResponse
    {
        try {
            $request->validate([
                'email' => ['required', 'string', 'email', 'min:8', 'max:50'],
                'password' => 'required|string|max:120',
            ]);

            $user = User::where('email', $request->email)->firstOrFail();

            if (!Hash::check($request['password'], $user->password)) {
                throw new ModelNotFoundException();
            }

            $google2fa = app(Google2FA::class);
            $google2faSecret = $google2fa->generateSecretKey();

            $user->fill(['google2fa_secret' => $google2faSecret])->update();

            $g2faUrl = $google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $google2faSecret
            );

            $writer = new Writer(
                new ImageRenderer(
                    new RendererStyle(400),
                    new ImagickImageBackEnd()
                )
            );

            $qrcode_image = base64_encode($writer->writeString($g2faUrl));

            return view('auth.google2fa.setup', ['QR_Image' => $qrcode_image, 'secret' => $google2faSecret, 'email' => $user->email]);
        } catch (ValidationException $e) {
            return back()->withInput($request->all())
                ->with('error', trans('auth.email_not_identified'))->withErrors($e->errors());
        } catch (ModelNotFoundException $e) {
            return back()->with('error', trans('auth.email_not_identified'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function complete(Request $request): RedirectResponse
    {
        if (!$request->email || !$user = User::where('email', $request->email)->first()) {
            return back()->with('error', trans('auth.email_not_identified'));
        }

        if (!$user->google2fa_secret) {
            return back()->with('error', trans('auth.email_not_verified'));
        }

        return redirect()->route('login')->with('success', trans('auth.email_verified_login'));
    }

}
