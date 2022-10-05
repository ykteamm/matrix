<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = [
        'hospital_name',     
    ];

    ublic function branch()
    {
        return $this->hasMany(Branch::class, 'hospital_id', 'id');
    }p
}
