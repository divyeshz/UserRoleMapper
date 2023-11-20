<?php

namespace App\Models;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['name', 'description', 'is_active', 'created_by', 'updated_by', 'deleted_by', 'is_deleted'];

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($role) {
            $role->id = Str::uuid();
            $userId = auth()->id() ?? null;
            $role->created_by = $userId;
        });

        static::updating(function ($role) {
            $userId = auth()->id() ?? null;
            $role->updated_by = $userId;
        });

        static::deleting(function ($role) {
            $userId = auth()->id() ?? null;
            $role->deleted_by = $userId;
            $role->is_deleted = 1; // Update the is_deleted column
            $role->save(); // Save the changes
        });

        static::restoring(function ($role) {
            $role->is_deleted = 0; // Set is_deleted to 0 when restoring
        });
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
}
