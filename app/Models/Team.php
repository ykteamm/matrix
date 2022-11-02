<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'tg_teams';
    protected $fillable = [
        'id',
        'name',
        'region_id',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id','id');
    }

    public function member()
    {
        return $this->hasMany(Member::class,'team_id','id');
    }
}
