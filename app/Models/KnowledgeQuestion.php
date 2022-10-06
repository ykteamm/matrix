<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeQuestion extends Model
{
    use HasFactory;

    protected $table = 'tg_knowledge_questions';
    protected $fillable = [
        'id',
        'name',
        'condition_question_id',
    ];

    public function condition_question()
    {
        return $this->belongsTo(ConditionQuestion::class,'condition_question_id','id');
    }
}
