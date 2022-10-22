<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'tg_product_categories';
    protected $fillable = [
        'id',
        'cat_name',
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'product_category_id', 'id');
    }
}
