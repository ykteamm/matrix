<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnirTeamGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'group_id',
        'month',
    ];

    public function team()
    {
        return $this->belongsTo(TurnirTeam::class,'team_id','id');
    }

    public function group()
    {
        return $this->belongsTo(TurnirGroup::class,'group_id','id');
    }
}
