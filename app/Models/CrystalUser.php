<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrystalUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'crystal',
        'comment',
        'active',
        'add_date',
    ];
}
