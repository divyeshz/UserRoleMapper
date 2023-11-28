<?php

namespace App\Models;

use App\Traits\BootTrait;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModulePermissionTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, BootTrait, ModulePermissionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['first_name', 'last_name', 'email', 'email_verified_at', 'password', 'is_active', 'is_first_login', 'code', 'type', 'created_by', 'updated_by', 'deleted_by', 'is_deleted'];

    protected static function booted()
    {
        parent::booted();
        static::moduleTrait();
    }

    /**
     * The function "roles" defines a many-to-many relationship between the current class and the
     * "Role" class, using the "role_user" pivot table, with additional pivot data "is_active" and
     * timestamps.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id')->withPivot('is_active')->withTimestamps();
    }

    /**
     * The function checks if a user has access to a specific module and action based on their roles.
     *
     * return a boolean value. It returns true if any of the roles in the  array have access to
     * the specified  and , and false otherwise.
     */
    public function hasAccess($module, $action)
    {
        foreach ($this->roles as $role) {
            if ($role->hasRole($module, $action)) {
                return true;
            }
        }
        return false;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'is_first_login' => 'boolean',
        'is_deleted' => 'boolean',
    ];
}
