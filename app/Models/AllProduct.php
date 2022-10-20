<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllProduct extends Model
{
    use HasFactory;

    protected $table = 'tg_all_products';
    protected $fillable = [
        'id',
        'name',
        'category_id',
    ];
}
