<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['code', 'name', 'is_active', 'is_in_menu', 'display_order', 'parent_id', 'created_by', 'updated_by', 'deleted_by', 'is_deleted'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active'     => 'boolean',
        'is_in_menu'    => 'boolean',
        'is_deleted'    => 'boolean',
    ];

    protected static function booted()
    {
        parent::booted();
        static::bootMethod();
    }

    /**
     * The function returns the parent module of the current module.
     */
    public function parentModule()
    {
        return $this->belongsTo(Module::class, 'parent_id','id');
    }

    /**
     * The function returns all child modules associated with a parent module.
     */
    public function childModules()
    {
        return $this->hasMany(Module::class, 'parent_id');
    }

    /**
     * The function returns a many-to-many relationship between the current object and the Permission
     * model, with additional pivot data and timestamps.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_module', 'module_id', 'permission_id')
            ->withPivot('is_active')
            ->withTimestamps();
    }
}
