<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait ModulePermissionTrait
{
    public function hasModulePermission($moduleName, $action = '')
    {
        $user = Auth::user();

        /* this code block is granting access to users with the 'admin' type
        without any further permission checks. */
        if (Auth::user()->type == 'admin') {
            return true;
        } else {
            $permissions = $user->roles->flatMap->permissions; // Get all permissions associated with user roles

            foreach ($permissions as $permission) {
                foreach ($permission->modules as $module) {

                    // User has permission for the module
                    if ($moduleName != "" && $action == "") {
                        if (strtolower($module['code']) === $moduleName && ($module->pivot['add_access'] || $module->pivot['edit_access'] || $module->pivot['delete_access'] || $module->pivot['view_access'])) {
                            return true;
                        }
                    }
                    if ($moduleName != "" && $action != "") {
                        if (strtolower($module['code']) === $moduleName) {

                            // User has permission to Access 'add'
                            if ($module->pivot['add_access'] && ($action == 'add')) {
                                return true;
                            }

                            // User has permission to Access 'edit'
                            if ($module->pivot['edit_access'] && ($action == 'edit')) {
                                return true;
                            }

                            // User has permission to Access 'view'
                            if ($module->pivot['view_access'] && $action == 'view') {
                                return true;
                            }

                            // User has permission to Access 'soft delete', 'hard delete' & 'restore'
                            if ($module->pivot['delete_access'] && ($action == 'delete' || $action == 'restore')) {
                                return true;
                            }

                        }


                    }
                }
            }

            // No permission found for the module
            return false;
        }
    }
}
