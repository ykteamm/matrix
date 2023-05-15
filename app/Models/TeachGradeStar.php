<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachGradeStar extends Model
{
    use HasFactory;

    protected $table = 'teach_grade_stars';

    public function tester()
    {
        return $this->belongsTo(User::class,'tester_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
