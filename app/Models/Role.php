<?php

namespace App\Models;
use App\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'is_active', 'created_by', 'updated_by', 'deleted_by', 'is_deleted'];

    protected static function booted()
    {
        parent::booted();
        static::bootMethod();
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id')
            ->withPivot('is_active')
            ->withTimestamps();
    }

    public function hasRole($module, $action)
    {
        foreach ($this->permissions as $permission) {
           if($permission->hasPermission($module, $action)){
                return true;
           }
        }
        return false;
    }
}
