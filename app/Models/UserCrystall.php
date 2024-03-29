<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCrystall extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'crystall',
        'comment',
        'add_date',
    ];
}
