<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait ModulePermissionTrait
{
    /**
     * The function checks if a user has permission to access a module in a PHP application, granting
     * access to users with the 'admin' type without further permission checks.
     *
     * @param $moduleName The moduleName parameter represents the name of the module for which the
     * permission is being checked. It is a string value that identifies a specific module in the
     * application.
     *
     * @param $action The "action" parameter represents the specific action or operation that the user
     * is trying to perform within the module. It could be a CRUD operation like create, read, update,
     * or delete, or any other custom action defined within the module.
     *
     * @return boolean value. If the user is an admin, it will return true. If the user is not an
     * admin and does not have access to the specified module and action, it will return false.
     */
    public function hasModulePermission($moduleName, $action = '')
    {
        $user = Auth::user();

        /* this code block is granting access to users with the 'admin' type
        without any further permission checks. */
        if (Auth::user()->type == 'admin') {
            return true;
        } else {
            if ($user->hasAccess($moduleName, $action)) {
                return true;
            } else {
                // No permission found for the module
                return false;
            }
        }
    }
}
