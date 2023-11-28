<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'is_active', 'created_by', 'updated_by', 'deleted_by', 'is_deleted'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    protected static function booted()
    {
        parent::booted();
        static::bootMethod();
    }

    /**
     * The function returns a many-to-many relationship between the current object and the Role class,
     * with additional pivot data and timestamps.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id')
            ->withPivot('is_active')
            ->withTimestamps();
    }

    /**
     * The function "modules" returns a many-to-many relationship between the current object and the
     * Module class, with additional pivot columns and timestamps.
     */
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'permission_module', 'permission_id', 'module_id')
            ->withPivot('add_access', 'edit_access', 'delete_access', 'view_access')
            ->withTimestamps();
    }

    /**
     * The function checks if a user has permission to perform a specific action on a module.
     *
     * return either true, false, or an error message.
     */
    public function hasPermission($module, $action)
    {
        $moduleData = $this->modules->where('code', $module)->first();
        if ($moduleData) {
            foreach ($this->modules as $value) {
                if ($action == "") {
                    return true;
                }
                if ($value->pivot[$action . '_access'] && $value->code == $module) {
                    return true;
                }

            }
        } else {
            return false;
        }
    }
}
