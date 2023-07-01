<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmOrder extends Model
{
    use HasFactory;


    protected $fillable = [
        'number',
        'status',
        'date',
        'discount',
        'summa',
        'discount_summa',
        'pharmacy_id',
        'user_id',
        'outer',
    ];

}
