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
}
