<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accept extends Model
{
    protected $table='tg_accepts';
    protected $fillable=[
        'medicine_id',
        'pharmacy_id',
        'created_by',
        'number'
    ];
    use HasFactory;
}
