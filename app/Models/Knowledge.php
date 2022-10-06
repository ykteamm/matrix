<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Knowledge extends Model
{
    use HasFactory;

    protected $table = 'tg_knowledge';
    protected $fillable = [
        'id',
        'name'
    ];

    // public function question()
    // {
    //     return $this->belongsTo(Question::class,'question_id','id');
    // }
}
