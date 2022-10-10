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
        'name',
        'number'
    ];

    public function pill_question()
    {
        return $this->hasMany(PillQuestion::class,'knowledge_id','id');
    }
}
