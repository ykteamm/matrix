<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyUser extends Model
{
    use HasFactory;

    protected $table = 'tg_pharmacy_users';
    protected $fillable = [
        'id',
        'user_id',
        'pharma_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class,'pharma_id','id');
    }
}
