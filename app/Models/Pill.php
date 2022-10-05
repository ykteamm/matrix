<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pill extends Model
{
    use HasFactory;

    protected $table = 'tg_pills';
    protected $fillable = [
        'id',
        'question_id',
        'name'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class,'question_id','id');
    }
}
