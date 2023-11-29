<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table ='teachers';

    protected $fillable = [
        'user_id',
        'active'
    ];

    public function members()
    {
        return $this->hasMany(Jamoa::class, 'teacher_id', 'user_id');
    }

    public function plan_id()
    {
        return $this->hasMany(JamoaPlan::class,'user_id','user_id');
    }
    public function sold_id()
    {
        return $this->hasMany(ProductSold::class,'user_id','user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function teacher_user()
    {
        return $this->hasOne(TeacherUser::class, 'teacher_id', 'id');
    }
}
