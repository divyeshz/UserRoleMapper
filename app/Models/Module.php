<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Module extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['code', 'name', 'is_active', 'is_in_menu', 'display_order', 'parent_id', 'created_by', 'updated_by', 'deleted_by', 'is_deleted'];

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($user) {
            $user->id = Str::uuid();
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
