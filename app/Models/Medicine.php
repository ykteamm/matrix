<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table='tg_medicine';
    use HasFactory;

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}