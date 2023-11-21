<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jamoa extends Model
{
    use HasFactory;

    protected $table = 'tg_jamoalar';

    protected $fillable = ['teacher_id','user_id'];

    // teacher_id ni ishlatish

    public function teacher_id()
    {
        return $this->hasMany(ProductSold::class,'user_id','teacher_id');
    }

    public function user_id()
    {
        return $this->hasMany(ProductSold::class,'user_id','user_id');
    }

    // user_id ni ishlatish
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
