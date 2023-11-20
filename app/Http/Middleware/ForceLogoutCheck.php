<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ForceLogoutCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Check if the user has an active token
        if (!$request->user()->tokens->isEmpty()) {
            return $next($request);
        }

        // If no active tokens found, force logout
        Auth::logout();
        return redirect()->route('loginForm')->with('success', 'You were forcefully logged out.!!!'); // Redirect to the login page
    }
}
