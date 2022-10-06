<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConditionQuestion extends Model
{
    use HasFactory;

    protected $table = 'tg_condition_questions';
    protected $fillable = [
        'id',
        'name',
        'pill_question_id',
    ];

    public function pill_question()
    {
        return $this->belongsTo(PillQuestion::class,'pill_question_id','id');
    }

    public function knowledge_question()
    {
        return $this->hasMany(KnowledgeQuestion::class,'condition_question_id','id');
    }
}
