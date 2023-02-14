<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigaKingSold extends Model
{
    use HasFactory;

    public function liga_user()
    {
        return $this->hasMany(LigaKingUser::class,'liga_id','id');
    }
}
