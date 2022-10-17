<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table='tg_plans';
    protected $fillable=[
        'id',
        'number',
        'user_id',
        'medicine_id'
    ];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }
    public function medicine()
    {
        return $this->hasOne(Medicine::class);
    }

    public function planweek()
    {
        return $this->hasMany(PlanWeek::class);
    }
}