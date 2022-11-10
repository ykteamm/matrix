<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table='tg_stocks';
    protected $fillable=[
        'medicine_id',
        'pharmacy_id',
        'created_by',
        'number'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id','id');
    }

    public function user_created()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }

    public function user_updated()
    {
        return $this->belongsTo(User::class, 'updated_by','id');
    }
    use HasFactory;
}
