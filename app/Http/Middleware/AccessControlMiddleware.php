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


        // if (Auth::user()->type == 'admin') {
        //     return $next($request);
        // } else {
        //     $permissions = $user->roles->flatMap->permissions; // Get all permissions associated with user roles

        //     foreach ($permissions as $permission) {
        //         foreach ($permission->modules as $module) {

        //             // User has permission for the module
        //             if (strtolower($module['code']) === $moduleName) {

        //                 // User has permission to Access 'forceLogout'
        //                 if (($module->pivot['add_access'] || $module->pivot['edit_access'] || $module->pivot['delete_access'] || $module->pivot['view_access']) && ($action == 'forceLogout')) {
        //                     return $next($request);
        //                 }

        //                 // User has permission to Access 'add'
        //                 if ($module->pivot['add_access'] && ($action == 'add')) {
        //                     return $next($request);
        //                 }

        //                 // User has permission to Access 'edit'
        //                 if ($module->pivot['edit_access'] && ($action == 'edit' || $action == 'status')) {
        //                     return $next($request);
        //                 }

        //                 // User has permission to Access 'edit' than change the status
        //                 if (!$module->pivot['edit_access'] && $action == 'status') {
        //                     return $this->error(401, "You don't have permission to do this.");
        //                 }

        //                 // User has permission to Access 'view'
        //                 if ($module->pivot['view_access'] && ($action == 'view')) {
        //                     return $next($request);
        //                 }

        //                 // User has permission to Access 'soft delete', 'hard delete' & 'restore'
        //                 if ($module->pivot['delete_access'] && ($action == 'delete' || $action == 'restore')) {
        //                     return $next($request);
        //                 }
        //             }
        //         }
        //     }

        //     // No permission found for the module
        //     return redirect()->route('forbidden');
        // }

    }
}
