<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ball extends Model
{
    use HasFactory;
    protected $table = 'tg_balls';
    protected $fillable = [
        'user_id',
        'ball',
        'active'
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
