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
    public function handle(Request $request, Closure $next, $moduleName, $action): Response
    {
        $user = Auth::user();

        $permissions = $user->roles->flatMap->permissions; // Get all permissions associated with user roles

        foreach ($permissions as $permission) {
            foreach ($permission->modules as $module) {

                // User has permission for the requested route
                if (strtolower($module['name']) === $moduleName) {

                    // User has permission to Access 'list' & 'status update' route
                    if (($module->pivot['add_access'] || $module->pivot['edit_access'] || $module->pivot['delete_access'] || $module->pivot['view_access']) && ($action == 'list' || $action == 'status' || $action == 'forceLogout')) {
                        return $next($request);
                    }

                    // User has permission to Access 'add' route
                    if ($module->pivot['add_access'] && ($action == 'add')) {
                        return $next($request);
                    }

                    // User has permission to Access 'edit' route
                    if ($module->pivot['edit_access'] && ($action == 'edit')) {
                        return $next($request);
                    }

                    // User has permission to Access 'view' route
                    if ($module->pivot['view_access'] && ($action == 'view')) {
                        return $next($request);
                    }

                    // User has permission to Access 'soft delete', 'hard delete' & 'restore' route
                    if ($module->pivot['delete_access'] && ($action == 'delete' || $action == 'restore' )) {
                        return $next($request);
                    }
                }
            }
        }

        // No permission found for the requested route
        return response()->view('pages.forbidden');
    }
}
