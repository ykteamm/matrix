<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'tg_user';


    public function journal()
    {
        return $this->hasMany(ProductJournal::class, 'user_id', 'id');
    }
    public function member()
    {
        return $this->hasMany(Member::class,'user_id','id');
    }
    public function admin_pharmacies()
    {
        return $this->hasMany(PharmUser::class,'user_id','id');
    }
    public function ball()
    {
        return $this->hasMany(Ball::class,'user_id','id');
    }
    public function pharmacy_user()
    {
        return $this->hasMany(PharmacyUser::class,'user_id','id');
    }
    public function new_elchi()
    {
        return $this->hasMany(NewElchi::class,'user_id','id');
    }
    public function battle_user1()
    {
        return $this->hasMany(BattleDay::class,'u1id','id');
    }
    public function battle_user2()
    {
        return $this->hasMany(BattleDay::class,'u2id','id');
    }
    public function shift()
    {
        return $this->hasMany(Shift::class,'user_id','id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class,'region_id','id');
    }
    public function pharmacy()
    {
        return $this->hasMany(PharmacyUser::class,'user_id','id');
    }
    public function pro_sold()
    {
        return $this->hasMany(ProductSold::class,'user_id','id');
    }
    public function order()
    {
        return $this->hasMany(Order::class,'user_id','id');
    }
    public function liga_user()
    {
        return $this->hasMany(LigaKingUser::class,'user_id','id');
    }
//
//    public function tools()
//    {
//        return $this->morphToMany(Tool::class, 'toolable');
//    }
    // public function condition_question()
    // {
    //     return $this->hasMany(ConditionQuestion::class,'pill_question_id','id');
    // }
}
