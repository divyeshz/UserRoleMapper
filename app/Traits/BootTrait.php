<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait BootTrait
{
    protected static function moduleTrait()
    {
        static::creating(function ($module) {
            $module->id = Str::uuid()->toString();
            $userId = auth()->id() ?? null;
            $module->created_by = $userId;
        });

        static::updating(function ($module) {
            $userId = auth()->id() ?? null;
            $module->updated_by = $userId;
        });

        static::deleting(function ($module) {
            $userId = auth()->id() ?? null;
            $module->deleted_by = $userId;
            $module->is_deleted = 1;
            $module->save();
        });

        static::restoring(function ($module) {
            $module->is_deleted = 0;
        });
    }
}
