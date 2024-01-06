<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMedicine extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'tg_category';
    protected $fillable = ['name','sort'];

}
