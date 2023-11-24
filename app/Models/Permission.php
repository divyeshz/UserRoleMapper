<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;

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
        static::moduleTrait();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id')
            ->withPivot('is_active')
            ->withTimestamps();
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'permission_module', 'permission_id', 'module_id')
            ->withPivot('add_access', 'edit_access', 'delete_access', 'view_access')
            ->withTimestamps();
    }
}
