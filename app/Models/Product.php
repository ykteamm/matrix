<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'tg_products';
    protected $fillable = [
        'id',
        'p_name',
        'amount',
        'code',
        'warehouse_id',
        'product_category_id',
    ];

    public function journal()
    {
        return $this->hasMany(ProductJournal::class, 'product_id', 'id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class,'product_category_id','id');
    }
}
