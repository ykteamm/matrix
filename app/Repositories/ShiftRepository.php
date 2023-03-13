<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ShiftRepository as ShiftRepositoryInterface;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ShiftRepository implements ShiftRepositoryInterface
{
  public function unchecked($column = 'admin_check', $active = 1)
  {
    return Shift::with('user', 'pharmacy', 'user.region')
      // ->whereDate('created_at', '>=', '2023-01-30')
      ->whereDate('created_at', '>=', '2023-03-7')
      ->where($column, NULL)
      ->where('active', $active)
      ->orderBy('id', 'DESC')->get();
  }
  public function checked($date, &$paginated, $column = 'admin_check', $active = 1)
  {
    $query = Shift::with('user', 'pharmacy', 'user.region')
      // ->whereDate('created_at', '>=', '2023-01-30')
      ->whereDate('created_at', '>=', '2023-03-7')
      ->where($column, '!=', NULL)
      ->where('active', $active);
    if ($date !== NULL) {
      $paginated = false;
      $checkedshifts = $query->whereDate('created_at', $date)->orderBy('id', 'ASC')->get();
    } else {
      $checkedshifts = $query->orderBy('id', 'ASC')->paginate(10);
    }
    return $checkedshifts;
  }

  public function update($shift_id, $values)
  {
    return Shift::where('id', $shift_id)->update($values);
  }

  public function updateAdminCheck($shift_id, $error, $column = 'admin_check')
  {
    return Shift::where('id', $shift_id)->update([
      $column => array('check' => $error == '' ? "ok" : $error)
    ]);
  }

  public function delete($shift_id)
  {
    return Shift::where('id', $shift_id)->delete();
  }

  public function setDetail($price, $izoh, $user_id, $message)
  {
    return DB::table('tg_details')->insert([
      'price' => $price,
      'status' => 2,
      'message' => $izoh ?? $message,
      'admin_id' => Session::get('user')->id,
      'user_id' => (int)$user_id,
      'is_active' => true,
      'created_at' => now()
    ]);
  }
}
