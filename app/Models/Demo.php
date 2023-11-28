<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Demo extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'name', 'description', 'created_by', 'updated_by', 'deleted_by', 'is_deleted'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    protected static function booted()
    {
        parent::booted();
        static::bootMethod();
    }

}
