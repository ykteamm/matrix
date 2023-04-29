<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremyaTask extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'premya_id',
        'prodaja'
    ];
}
