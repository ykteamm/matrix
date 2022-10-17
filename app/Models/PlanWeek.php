<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanWeek extends Model
{
    use HasFactory;
    protected $table='tg_planweeks';
    protected $fillable=[
        'plan_id',
        'calendar_id',
        'workday',
        'startday',
        'endday',
        'plan'
    ];

    public function plan()
    {
        return  $this->belongsTo(Plan::class);
    }
    public function calendar()
    {
        return  $this->belongsTo(Calendar::class);
    }

}