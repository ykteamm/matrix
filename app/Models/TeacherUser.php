<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'teacher_id'
    ];
}
