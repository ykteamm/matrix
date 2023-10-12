<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MegaTurnirUserBattle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user1()
    {
        return $this->belongsTo(User::class,'user1id','id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class,'user2id','id');
    }
}
