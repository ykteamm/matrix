<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'tg_members';
    protected $fillable = [
        'id',
        'user_id',
        'team_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class,'team_id','id');
    }
}
