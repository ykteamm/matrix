<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeComment extends Model
{
    use HasFactory;
    protected $table = 'tg_grade_comments';
    protected $fillable = [
        'user_id',
        'teacher_id',
        'comment'
    ];
}
