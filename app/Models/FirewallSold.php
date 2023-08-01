<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirewallSold extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class,'medicine_id','id');
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class,'pharmcy_id','id');
    }
}
