<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MegaTurnirTeacherStudent extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id','id');
    }

    public function shogird()
    {
        return $this->belongsTo(User::class,'shogird_id','id');
    }
}
