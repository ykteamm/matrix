<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'hospital_id',           
        'branch_name',           
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class,'hospital_id','id');
    }
}
