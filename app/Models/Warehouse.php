<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'tg_warehouses';
    protected $fillable = [
        'id',
        'name',
        'active',
    ];
}
