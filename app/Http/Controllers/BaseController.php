<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function modules()
    {

        $modules = Module::whereNotNull('parent_id')->with('parentModule')->where('is_active', 1)->orderBy('display_order')->get();
        return $modules;
    }

    public function uniqueModules()
    {

        $parentModules = Module::whereNull('parent_id')->where('is_active', 1)->orderBy('display_order')->get();
        return $parentModules;
    }
}
