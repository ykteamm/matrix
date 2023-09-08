<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McDeadlinePharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'region_id',
        'pharmacy_id',
        'day',
        'discount'
    ];
}
