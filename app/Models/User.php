<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tg_user';

    public function plan_id()
    {
        return $this->hasMany(JamoaPlan::class,'user_id','user_id');
    }
    public function sold_id()
    {
        return $this->hasMany(ProductSold::class,'user_id','user_id');
    }


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
    public function shift_30()
    {
        return $this->hasMany(Shift::class,'user_id','id')->whereDate('open_date','>=','2023-03-25');
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

    public function dailywork()
    {
        return $this->hasOne(DailyWork::class, 'user_id', 'id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'user_id', 'id');
    }

    public function teacher_user()
    {
        return $this->hasOne(TeacherUser::class, 'user_id', 'id');
    }

    public function turnir_member()
    {
        return $this->hasOne(TurnirMember::class, 'user_id', 'id');
    }

}
