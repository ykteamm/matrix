<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuestion extends Model
{
    use HasFactory;

    protected $table = 'tg_user_questions';
    protected $fillable = [
        'id',
        'user_id',
        'step1',
        'step3',
        'question_step',
        'created_at',
        'updated_at',
    ];

    // public function condition_question()
    // {
    //     return $this->hasMany(ConditionQuestion::class,'pill_question_id','id');
    // }
}
