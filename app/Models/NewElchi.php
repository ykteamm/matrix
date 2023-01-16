<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewElchi extends Model
{
    use HasFactory;
    protected $table = 'tg_new_elchi';
    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
