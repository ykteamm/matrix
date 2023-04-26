<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'teacher_id',
        'first_view',
        'day',
        'week_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id','id');
    }
}
