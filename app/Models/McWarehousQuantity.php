<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McWarehousQuantity extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'warehouse_id',
        'product_id',
        'quantity',
        'active',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class,'product_id','id');
    }
}
