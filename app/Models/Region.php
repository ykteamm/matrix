<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'tg_region';
    protected $fillable = [
        'name',
        'sort'
    ];

    public function team()
    {
        return $this->hasMany(Team::class,'region_id','id');
    }

    public function pharmacy()
    {
        return $this->hasMany(Pharmacy::class,'region','id');
    }
}
