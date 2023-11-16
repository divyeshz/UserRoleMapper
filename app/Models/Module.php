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
        });

        static::deleting(function ($module) {
            $module->is_deleted = 1; // Update the is_deleted column
            $module->save(); // Save the changes
        });

        static::restoring(function ($module) {
            $module->is_deleted = 0; // Set is_deleted to 0 when restoring
        });
    }

    public function parentModule()
    {
        return $this->belongsTo(Module::class, 'parent_id');
    }

    public function childModules()
    {
        return $this->hasMany(Module::class, 'parent_id');
    }
}
