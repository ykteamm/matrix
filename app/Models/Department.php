<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'tg_department';
    protected $fillable = [
        'id',
        'name',
        'sort',
        'status',
    ];

    // public function question()
    // {
    //     return $this->belongsTo(Question::class,'question_id','id');
    // }
}
