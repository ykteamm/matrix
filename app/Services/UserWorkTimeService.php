<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserWorkTimeService
{
  private $calendar;
  private $month;

  public function initCalendar($month)
  {
    $this->month = $month;
    $date = Carbon::parse($month)->startOfMonth()->format("m.Y");
    $this->calendar = DB::table('tg_calendar')->where('year_month', $date)->get()->first();
  }

  private function shiftUser($id, $day)
  {
    return DB::table('tg_shift')
      ->where('user_id', $id)
      ->whereDate('created_at', $day)
      ->get()->first();
  }

  private function isNotToday($day) 
  {
    return strtotime(date("Y-m-d")) > strtotime($day);
  }

  public function getDaysHoursMinutesByUserId($id)
  {
    $workedDays = $this->workedDays();
    $total = ['days' => count($workedDays), 'hours' => 0, 'minutes' => 0,];
    $minusTotal = ['days' => 0, 'hours' => 0, 'minutes' => 0];
    $workedTotal = ['days' => 0, 'hours' => 0, 'minutes' => 0];

    foreach ($workedDays as $day) {
      $daily = $this->usuallyOneDayMinutes($day, $id);
      $user = $this->shiftUser($id, $day);

      if (!$user && $this->isNotToday($day)) {
        $minusTotal['days'] += 1;
        $dayUsually = round((strtotime($daily->finish_work) - strtotime($daily->start_work)) / 60) - 60;
        $minusTotal['minutes'] += $dayUsually;
        $minusTotal['hours'] += round($dayUsually / 60);
      }
      if ($user && $this->isNotToday($day)) {
        $workedTotal['days'] += 1;
        $difOpen = strtotime(date("H:i", strtotime($user->open_date))) - strtotime($daily->start_work);
        $difClose = strtotime($daily->finish_work) - strtotime(date("H:i", strtotime($user->close_date)));
        $dayMinus = 0;
        if ($difClose > 600) {
          $dayMinus += round($difClose / 60);
        }
        if ($difOpen > 600) {
          $dayMinus += round($difOpen / 60);
        }
        if ($dayMinus > 0) {
          $minusTotal['minutes'] += $dayMinus;
          $minusTotal['hours'] += round($dayMinus / 60);
        }
      }
      if ($this->isNotToday($day)) {
        $dayUsually = round((strtotime($daily->finish_work) - strtotime($daily->start_work)) / 60) - 60;
        $total['minutes'] += $dayUsually;
        $total['hours'] += round($dayUsually / 60);
      }
      $workedTotal['hours'] = $total['hours'] - $minusTotal['hours'];
      $workedTotal['minutes'] = $total['minutes'] - $minusTotal['minutes'];
    }
    return compact('total', 'minusTotal', 'workedTotal');
  }

  private function usuallyUserWorksHistory($id)
  {
    return DB::table('daily_works')
      ->select('start', 'finish', 'start_work', 'finish_work')
      ->where(fn ($q) => $q
        ->where('user_id', $id)
        ->where('start', '<=',  $this->eMonth())
        ->where('finish', '>=', $this->sMonth()))
      ->orWhere(fn ($q) => $q
        ->where('user_id', $id)
        ->where('start', '<=',  $this->eMonth())
        ->where('finish', '=', NULL))
      ->orderBy('start')
      ->get();
  }

  private function usuallyOneDayMinutes($day, $id)
  {
    $dailyWorkHistory = $this->usuallyUserWorksHistory($id);
    $data = null;
    foreach ($dailyWorkHistory as $daily) {
      $d = strtotime($day);
      $start = strtotime($daily->start);
      $finish = strtotime($daily->finish);
      if ($d >= $start && $d <= $finish) {
        $data = $daily;
      } else if ($d >= $start && $finish == NULL) {
        $data = $daily;
      }
    }
    if ($data == null) {
      dd("$id idli userga vaqt biriktirilmagan");
    }
    return $data;
  }

  private function workedDays()
  {
    $days = json_decode($this->calendar->day_json);
    $except = json_decode($this->calendar->add_day);
    $workedDays = [];
    for ($i = 1; $i <= count($days); $i++) {
      $isRedDay = $days[$i - 1] == 'false' || in_array($i, $except);
      if (!$isRedDay) {
        $workedDays[] = date("Y-m-d", (strtotime($this->sMonth()) + ($i - 1) * 86400));
      }
    }
    return $workedDays;
  }

  public function sMonth()
  {
    return Carbon::parse($this->month)->startOfMonth()->format("Y-m-d");
  }

  public function eMonth()
  {
    return Carbon::parse($this->month)->endOfMonth()->format("Y-m-d");
  }

  public function mon()
  {
    return $this->month;
  }
}
