<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\AjaxResponse;

class AccessControlMiddleware
{
    use AjaxResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $moduleName, $action): Response
    {
        $user = Auth::user();

        /* this code block is granting access to users with the 'admin' type
        without any further permission checks. */
        if (Auth::user()->type == 'admin') {
            return $next($request);
        } else {
            if ($request->user()->hasAccess($moduleName, $action)) {
                return $next($request);
            } else {
                // No permission found for the module
                return redirect()->route('forbidden');
            }
        }

    }
}
