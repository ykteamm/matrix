<?php

namespace App\Repositories;

use App\Interfaces\Repositories\HelperRepository as HelperRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HelperRepository implements HelperRepositoryInterface
{
  public function setDetail($price, $izoh, $user_id, $message, $status = 2)
  {
    return DB::table('tg_details')->insert([
      'price' => $price,
      'status' => $status,
      'message' => $izoh ?? $message,
      'admin_id' => Session::get('user')->id,
      'user_id' => (int)$user_id,
      'is_active' => true,
      'created_at' => now()
    ]);
  }
}
