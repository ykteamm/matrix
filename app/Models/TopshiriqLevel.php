<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopshiriqLevel extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'topshiriq_level';
    protected $fillable = ['daraja','name','number_star'];
}
