<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $table = 'tg_pharmacy';
    protected $fillable = [
        'id',
        'name',
        'phone_number',
        'location',
        'image',
    ];
}
