<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekrut extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'last_name',
        'phone',
        'region_id',
        'district_id',
        'rm_id',
        'xolat',
        'age',
        'link',
        'grafik',
        'group_id',
    ];


    public function group()
    {
        return $this->belongsTo(RekrutGroup::class,'group_id','id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'rm_id','id');
    }
}
