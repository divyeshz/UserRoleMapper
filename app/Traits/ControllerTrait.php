<?php

namespace App\Traits;

use App\Models\Module;

trait ControllerTrait
{

    /**
     * The function retrieves active modules with their parent modules, ordered by display order.
     *
     * - The module has a non-null parent_id
     * - The module is active (is_active = 1)
     * - The modules are ordered by display_order
     */
    protected static function modules()
    {

        $modules = Module::whereNotNull('parent_id')->with('parentModule')->where('is_active', 1)->orderBy('display_order')->get();
        return $modules;
    }

    /**
     * The function "uniqueModules" returns a collection of parent modules that are active and ordered
     * by display order.
     */
    protected static function uniqueModules()
    {

        $parentModules = Module::whereNull('parent_id')->where('is_active', 1)->orderBy('display_order')->get();
        return $parentModules;
    }

}
