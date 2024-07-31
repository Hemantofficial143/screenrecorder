<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class Google2FAMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        $devicesEnrolledObject = new \App\Models\AuthenticatorDevice;
        $devicesEnrolled = $devicesEnrolledObject->getDevicesByUser($user->user_id,true);

        if($user && $devicesEnrolled > 0 && !$request->session()->get('2fa_verified')){
            return redirect()->route('2fa-verify');
        }

        return $next($request);
    }
}
