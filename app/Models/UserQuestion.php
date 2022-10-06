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
        'pill_question_id',
        'knowledge_question_id',
    ];

    // public function condition_question()
    // {
    //     return $this->hasMany(ConditionQuestion::class,'pill_question_id','id');
    // }
}
