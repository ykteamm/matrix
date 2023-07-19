<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnirGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function team_group()
    {
        return $this->hasMany(TurnirTeamGroup::class,'group_id','id');
    }
}
