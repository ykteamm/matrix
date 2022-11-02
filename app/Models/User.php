<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'tg_user';

    public function journal()
    {
        return $this->hasMany(ProductJournal::class, 'user_id', 'id');
    }
    public function member()
    {
        return $this->hasMany(Member::class,'user_id','id');
    }
    // public function condition_question()
    // {
    //     return $this->hasMany(ConditionQuestion::class,'pill_question_id','id');
    // }
}
