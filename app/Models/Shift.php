<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected $table = 'tg_shift';
    protected $fillable = [
        'id',
        'open_date',
        'close_date',
        'user_id',
        'pharma_id',
        'shift',
        'admin_check',
        'open_image',
        'close_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class,'pharma_id','id');
    }
}
