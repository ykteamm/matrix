<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestReview extends Model
{
    use HasFactory;

    protected $table = 'test_reviews';

    public function tester()
    {
        return $this->belongsTo(User::class,'tester_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    public function test()
    {
        return $this->belongsTo(TeachStudQues::class,'test_id','id');
    }
}
