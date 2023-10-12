<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MegaTurnirTeacher extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'teacher_id','id');
    }

    public function teacher_shogird()
    {
        return $this->hasMany(MegaTurnirTeacherStudent::class,'teacher_id','id');
    }
}
