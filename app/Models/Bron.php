<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bron extends Model
{
    use HasFactory;

    protected $fillable = [
        'bron_puli',
        'pharmacy_id',
        'status',
        'date'
    ];

    public function region()
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id');
    }
}
