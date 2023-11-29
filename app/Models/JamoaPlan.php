<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamoaPlan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'tg_jamoalar_plan';

    protected $fillable = ['user_id','plan_pul','start_day','end_day'];

}
