<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmUser extends Model
{
    use HasFactory;
    protected $table='tg_pharm_users';
    protected $fillable=[
        'user_id',
        'pharmacy_id'
    ];

    public function pharmacy()
    {
        $this->belongsTo(Pharmacy::class,'pharmacy_id','id');
    }
}
