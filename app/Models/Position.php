<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'position_json',
        'added_by',
        'rol_name',
    ];

    protected $casts = [
        'position_json' => 'array',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'rol_id', 'id');
    }
    
}
