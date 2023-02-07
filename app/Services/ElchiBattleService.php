<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\ElchiBattleSetting;
use App\Models\Member;
use App\Models\Battle;
use App\Models\BattleHistory;
use App\Models\Ball;
use Illuminate\Bus\Batch;

class ElchiBattleService
{
        
    $setting = ElchiBattleSetting::first();
    $weekStartDate = date_now()->startOfWeek()->format('Y-m-d');
    $weekEndDate = date_now()->endOfWeek()->format('Y-m-d');
    $startday = date('Y-m-d',(strtotime ( '+'.($setting->start_day).' day' , strtotime ( $weekStartDate ) ) ));
    $endday = date('Y-m-d',(strtotime ( '+'.($setting->end_day ).' day' , strtotime ( $weekStartDate ) ) ));
    unset($array['_token']);
    $users = [$array['user1'],$array['user2']];

        $battle=array();
        $day = 10;
        foreach ($users as $key => $user) {
            $count = 0;
            $sum = 0;
            for ($i=0; $i < $day; $i++) { 
                $date = date('Y-m-d',(strtotime ( '-'.$i.' day' , strtotime ( $startday) ) ));
                $summa = DB::table('tg_productssold')
                        ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                        ->whereDate('tg_productssold.created_at','=',$date)
                        ->where('tg_user.id','=',$user)
                        ->join('tg_user','tg_user.id','tg_productssold.user_id')
                        ->orderBy('tg_user.id','ASC')
                        ->groupBy('tg_user.id')->first();
                if(isset($summa->allprice))
                {
                    $sum+=$summa->allprice;
                }
                $count += DB::table('tg_smena')->whereDate('created_from',$date)
                ->where('user_id',$user)
                ->count();
            }
            if($count != 0)
            {
                $battle[]= array('id' => $user, 'price' => round($sum/$count));
            }else{
                $battle[]= array('id' => $user, 'price' => 0);
            }
        }
        $sums = array_column($battle, 'price');
        array_multisort($sums, SORT_ASC, $battle);
    $issetbattleDay = Battle::select('end','id')->whereDate('start_day','>=',$weekStartDate)->whereDate('start_day','<=',$weekEndDate)->orderBy('id','DESC')->first();
    if($issetbattleDay == NULL || $issetbattleDay->end == 0)
    {
        for ($i=0; $i < count($battle)/2; $i++) { 
            $save = DB::table('tg_battle')->insert([
                'start_day' => date('Y-m-d',strtotime($startday)),
                'end_day' => date('Y-m-d',strtotime($endday)),
                'created_at' => date_now()->format('Y-m-d'),
                'user1_id' => $battle[$i*2]['id'],
                'user2_id' => $battle[($i*2)+1]['id'],
                'bot' => 0,
                'sum1' => $battle[$i*2]['price'],
                'sum2' => $battle[($i*2)+1]['price'],
                'end' => 0
            ]);
        }
    }else{
        for ($i=0; $i < count($battle)/2; $i++) { 
            $save = DB::table('tg_battle')->insert([
                'start_day' => date('Y-m-d',(strtotime ( '+'.($setting->start_day + 7).' day' , strtotime ( $weekStartDate ) ) )),
                'end_day' => date('Y-m-d',(strtotime ( '+'.($setting->end_day +7).' day' , strtotime ( $weekStartDate ) ) )),
                'created_at' => date_now()->format('Y-m-d'),
                'user1_id' => $battle[$i*2]['id'],
                'user2_id' => $battle[($i*2)+1]['id'],
                'bot' => 0,
                'sum1' => $battle[$i*2]['price'],
                'sum2' => $battle[($i*2)+1]['price'],
                'end' => 0
            ]);
        }
    }
}

