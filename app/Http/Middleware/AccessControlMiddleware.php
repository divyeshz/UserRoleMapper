<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccessControlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $requestedRoute = explode(".", $request->route()->getName()); // Get requested route name
        $permissions = $user->roles->flatMap->permissions; // Get all permissions associated with user roles

        if($requestedRoute[0] == 'dashboard' || $requestedRoute[0] == 'profile' ||  $requestedRoute[0] == 'changePassword'){
            return $next($request);
        }

        foreach ($permissions as $permission) {
            foreach ($permission->modules as $module) {

                // User has permission for the requested route
                if (strtolower($module['name']) === $requestedRoute['0']) {

                    // User has permission to view 'list' & 'status update' route
                    if (($module->pivot['add_access'] || $module->pivot['edit_access'] || $module->pivot['delete_access'] || $module->pivot['view_access']) && ($requestedRoute['1'] == 'list' || $requestedRoute['1'] == 'status')) {
                        return $next($request);
                    }

                    // User has permission to view 'add' route
                    if ($module->pivot['add_access'] && ($requestedRoute['1'] == 'addForm' || $requestedRoute['1'] == 'store')) {
                        return $next($request);
                    }

                    // User has permission to view 'edit' route
                    if ($module->pivot['edit_access'] && ($requestedRoute['1'] == 'editForm' || $requestedRoute['1'] == 'update')) {
                        return $next($request);
                    }

                    // User has permission to view 'view' route
                    if ($module->pivot['view_access'] && ($requestedRoute['1'] == 'show')) {
                        return $next($request);
                    }

                    // User has permission to view 'delete' route
                    if ($module->pivot['delete_access'] && ($requestedRoute['1'] == 'destroy' || $requestedRoute['1'] == 'delete' || $requestedRoute['1'] == 'restore')) {
                        return $next($request);
                    }
                }
            }
        }

        // No permission found for the requested route
        return response()->view('pages.forbidden');
    }
}
