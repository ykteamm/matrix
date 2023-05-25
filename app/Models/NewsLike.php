<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLike extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'news_id',
        'positive'
    ];
}
