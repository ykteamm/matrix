<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PillQuestion extends Model
{
    use HasFactory;

    protected $table = 'tg_pill_questions';
    protected $fillable = [
        'id',
        'name',
        'knowledge_id',
    ];

    public function condition_question()
    {
        return $this->hasMany(ConditionQuestion::class,'pill_question_id','id');
    }

    public function knowledge()
    {
        return $this->belongsTo(Knowledge::class,'knowledge_id','id');
    }
}
