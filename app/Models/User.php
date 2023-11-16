<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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

        static::creating(function ($user) {
            $user->id = Str::uuid();
        });

        static::deleting(function ($user) {
            $user->is_deleted = 1; // Update the is_deleted column
            $user->save(); // Save the changes
        });

        static::restoring(function ($user) {
            $user->is_deleted = 0; // Set is_deleted to 0 when restoring
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
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
    ];
}
