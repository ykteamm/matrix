<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestRegister extends Model
{
    use HasFactory;
    protected $table='tg_test_register';
    protected $fillable = [
        'elchi',
        'status'
    ];

}
