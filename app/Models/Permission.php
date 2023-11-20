<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
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

        static::creating(function ($permission) {
            $permission->id = Str::uuid();
            $userId = auth()->id() ?? null;
            $permission->created_by = $userId; // Update the created_by column
        });

        static::updating(function ($permission) {
            $userId = auth()->id() ?? null;
            $permission->updated_by = $userId; // Update the updated_by column
        });

        static::deleting(function ($permission) {
            $userId = auth()->id() ?? null;
            $permission->deleted_by = $userId; // Update the deleted_by column
            $permission->is_deleted = 1; // Update the is_deleted column
            $permission->save(); // Save the changes
        });

        static::restoring(function ($permission) {
            $permission->is_deleted = 0; // Set is_deleted to 0 when restoring
        });
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
