<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'tg_question';
    protected $fillable = [
        'id',
        'name',
        'sort',
        'grade',
        'department_id',
    ];

    public function pill()
    {
        return $this->hasMany(Pill::class, 'question_id', 'id');
    }
}
