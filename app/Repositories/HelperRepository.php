<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HelperRepository
{
  public function setDetail($user_id, $price, $error, $status = 2)
  {
    return DB::table('tg_details')->insert([
      'price' => $price,
      'status' => $status,
      'message' => $error,
      'admin_id' => Session::get('user')->id,
      'user_id' => (int)$user_id,
      'is_active' => true,
      'created_at' => now()
    ]);
  }
}
