<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseJournal extends Model
{
    use HasFactory;
    protected $table = 'tg_purchase_journals';
    protected $fillable = [
        'id',
        'user_id',
        'sold_id',
        'old',
        'new',
    ];
}
