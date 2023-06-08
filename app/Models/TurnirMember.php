<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnirMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'tour',
        'month',
    ];

    public function team()
    {
        return $this->belongsTo(TurnirTeam::class,'team_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
