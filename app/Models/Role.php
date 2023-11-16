<?php

namespace App\Models;

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
        });

        static::deleting(function ($role) {
            $role->is_deleted = 1; // Update the is_deleted column
            $role->save(); // Save the changes
        });

        static::restoring(function ($role) {
            $role->is_deleted = 0; // Set is_deleted to 0 when restoring
        });
    }
}
