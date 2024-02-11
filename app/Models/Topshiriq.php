<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topshiriq extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'topshiriq';
    protected $fillable = ['name','description','first_date','end_date','number','star','status','key'];
}
