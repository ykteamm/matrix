<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $table = 'tg_pharmacy';
    protected $fillable = [
        'id',
        'name',
        'phone_number',
        'location',
        'image',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id','id');
    }

<<<<<<< HEAD

    public function pharm_users()
    {
        return $this->hasmany(PharmUser::class,'pharmacy_id','id');
    }

    public function accept_product()
    {
        return $this->hasMany(Accept::class,'pharmacy_id','id');
=======
    public function shablon_pharmacy()
    {
        return $this->hasMany(ShablonPharmacy::class,'pharmacy_id','id');
>>>>>>> ad204834b4c54bef02fa6d4743645a295a73f822
    }
}
