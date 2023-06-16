<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnirTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status'
    ];

    public function users()
    {
        return $this->hasMany(TurnirMember::class,'team_id','id');
    }

    public function turnir_member()
    {
        return $this->hasMany(TurnirMember::class,'team_id','id');
    }

    public function turnir_point()
    {
        return $this->hasMany(TurnirMember::class,'team_id','id');
    }

    public function team_group()
    {
        return $this->hasMany(TurnirTeamGroup::class,'team_id','id');
    }
}
