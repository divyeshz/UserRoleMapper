<?php

namespace App\Traits;

use App\Models\Module;

trait ControllerTrait
{

    protected static function modules()
    {

        $modules = Module::whereNotNull('parent_id')->with('parentModule')->where('is_active', 1)->orderBy('display_order')->get();
        return $modules;
    }

    protected static function uniqueModules()
    {

        $parentModules = Module::whereNull('parent_id')->where('is_active', 1)->orderBy('display_order')->get();
        return $parentModules;
    }

}
