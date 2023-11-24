<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function modules()
    {
        $modules = Module::whereNotNull('parent_id')
            ->with('parentModule')
            ->where('is_active', 1)
            ->orderBy('display_order')
            ->get();

        return $modules;
    }

    public function uniqueModules()
    {

        $modules = Module::whereNotNull('parent_id')
            ->with('parentModule')
            ->where('is_active', 1)
            ->orderBy('display_order')
            ->get();

        $uniqueModules = $modules
            ->groupBy('parent_id') // Group modules by parent_id
            ->map(function ($groupedModules) {
                return $groupedModules->first()->parentModule; // Get the first parentModule from each group
            })
            ->values();

        return $uniqueModules;
    }
}
