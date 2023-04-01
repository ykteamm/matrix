<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserMoneyService
{
  private Collection $data;
  private UserWorkTimeService $workTime;

  public function __construct(UserWorkTimeService $workTime)
  {
    $this->workTime = $workTime;
    $this->data = new Collection;
  }

  public function setMonth($month)
  {
    $this->workTime->initCalendar($month);
  }

  public function moneyInfo()
  {
    $usersWithFacts = $this->usersWithFacts();
    foreach ($usersWithFacts as $user) {
      $daysHoursMinutes = $this->workTime->getDaysHoursMinutesByUserId($user->id);
      $totalMaosh = $this->maosh($user->allprice);
      $perMinuteMaosh = $totalMaosh / $daysHoursMinutes['total']['minutes'];
      $jarima = $perMinuteMaosh * $daysHoursMinutes['minusTotal']['minutes'];
      $item = [
        'id' => $user->id,
        'name' => $user->name,
        'famname' => $user->famname,
        'fact' => number_format($user->allprice),
        'totalMaosh' => number_format(round($totalMaosh)),
        'jarima' => number_format(round($jarima)),
        'oylik' => number_format(round($totalMaosh - $jarima)),
        'workedTotal' => $daysHoursMinutes['workedTotal'],
        'total' => $daysHoursMinutes['total'],
        'minusTotal' => $daysHoursMinutes['minusTotal'],
      ];
      $this->data->push($item);
    }
    return $this->data;
  }

  private function maosh($fact)
  {
    if ($fact < 25000000) {
      $koef = 2000000 / 15000000;
      $oylik = $fact * $koef;
    } elseif ($fact >= 25000000 && $fact < 35000000) {
      $koef = 3500000 / 25000000;
      $oylik = $fact * $koef;
    } else {
      $koef = 5000000 / 35000000;
      $oylik = $fact * $koef;
    }
    return $oylik;
  }


  public function yearMonths()
  {
    return DB::table('tg_calendar')->pluck('year_month');
  }

  private function usersWithFacts()
  {
    // $daily = DB::table('daily_works')
    //   ->select('user_id')
    //   ->groupBy('user_id')
    //   ->pluck('user_id');

    return DB::table('tg_productssold')
      ->selectRaw('SUM(tg_productssold.price_product * tg_productssold.number) as allprice, tg_productssold.user_id as id, tg_user.first_name AS name, tg_user.last_name AS famname')
      ->leftJoin('tg_user', 'tg_user.id', 'tg_productssold.user_id')
      ->whereBetween('tg_productssold.created_at', [$this->workTime->sMonth(), $this->workTime->eMonth()])
      // ->whereDate('tg_productssold.created_at', '>=', '2023-03-15')
      // ->whereIn('tg_user.id', $daily)
      ->groupBy('tg_productssold.user_id', 'name', 'famname')
      ->orderBy('allprice', 'DESC')
      ->get();
  }
}
