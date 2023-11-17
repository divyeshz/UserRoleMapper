<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Module extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['code', 'name', 'is_active', 'is_in_menu', 'display_order', 'parent_id', 'created_by', 'updated_by', 'deleted_by', 'is_deleted'];

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($module) {
            $module->id = Str::uuid();
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
            $module->is_deleted = 1; // Update the is_deleted column
            $module->save(); // Save the changes
        });

        static::restoring(function ($module) {
            $module->is_deleted = 0; // Set is_deleted to 0 when restoring
        });
    }

    public function parentModule()
    {
        return $this->belongsTo(Module::class, 'parent_id','id');
    }

    public function childModules()
    {
        return $this->hasMany(Module::class, 'parent_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_module', 'module_id', 'permission_id')
            ->withPivot('is_active')
            ->withTimestamps();
    }
}
