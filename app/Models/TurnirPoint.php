<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnirPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'point',
        'team_id',
        'tour',
        'month',
    ];

    public function team()
    {
        return $this->belongsTo(TurnirTeam::class,'team_id','id');
    }
}
