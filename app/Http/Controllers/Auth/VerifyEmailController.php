<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Lang;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect(RouteServiceProvider::HOME)->with('message', Lang::get('session_messages.Thank you for signing up! Your email address is now confirmed. Please complete your order by clicking Basket in the top corner.'));
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect(RouteServiceProvider::HOME)->with('message', Lang::get('session_messages.Thank you for signing up! Your email address is now confirmed. Please complete your order by clicking Basket in the top corner.'));
    }
}
