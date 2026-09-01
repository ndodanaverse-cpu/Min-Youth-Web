<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Requires the authenticated user to have completed OTP activation.
 */
class EnsureUserIsActivated
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() !== null && ! $request->user()->isActivated()) {
            $destination = \Illuminate\Support\Facades\Route::has('otp.verify')
                ? 'otp.verify'
                : 'home';

            return redirect()->route($destination)
                ->with('status', 'Please verify your account to continue.');
        }

        return $next($request);
    }
}
