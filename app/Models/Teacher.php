<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function teacher_user()
    {
        return $this->hasOne(TeacherUser::class, 'teacher_id', 'id');
    }
}
