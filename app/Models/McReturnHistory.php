<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McReturnHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'amount'
    ];
}
