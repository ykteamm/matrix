<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\ElchiBattleSetting;
use App\Models\Member;
use App\Models\Battle;
use Illuminate\Bus\Batch;

class ElchiBattleService
{
    public function battle()
    {
        $setting = ElchiBattleSetting::first();
        $dayName = date('l',(strtotime (  date_now() ) ) );
        $startday = date('Y-m-d',(strtotime ( '+'.($setting->start_day).' day' , strtotime ( date_now() ) ) ));
        $endday = date('Y-m-d',(strtotime ( '+'.($setting->end_day ).' day' , strtotime ( date_now() ) ) ));
        $battleDay = Battle::select('end','id')->whereDate('created_at',$startday)->orderBy('id','DESC')->first();
        if(battleDay($setting->start_day) == $dayName && $battleDay == NULL || $battleDay->end == 0)
        {
            $exists1 = DB::table('tg_battle')
            ->whereDate('start_day',date('Y-m-d',strtotime($startday)))
            ->whereDate('end_day',date('Y-m-d',strtotime($endday)))
            ->pluck('user1_id');
        
            $exists2 = DB::table('tg_battle')
            ->whereDate('start_day',date('Y-m-d',strtotime($startday)))
            ->whereDate('end_day',date('Y-m-d',strtotime($endday)))
            ->pluck('user2_id');

            $users = Member::with('user')
            ->whereNotIn('user_id',[60,72])
            ->whereNotIn('user_id',$exists1)
            ->whereNotIn('user_id',$exists2)
            ->get();

        $battle=array();
        $day = 30;
        foreach ($users as $key => $user) {
            $count = 0;
            $sum = 0;
            for ($i=0; $i < $day; $i++) { 
                $date = date('Y-m-d',(strtotime ( '-'.$i.' day' , strtotime ( $startday) ) ));
                $summa = DB::table('tg_productssold')
                        ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                        ->whereDate('tg_productssold.created_at','=',$date)
                        ->where('tg_user.id','=',$user->user_id)
                        ->join('tg_user','tg_user.id','tg_productssold.user_id')
                        ->orderBy('tg_user.id','ASC')
                        ->groupBy('tg_user.id')->first();
                if(isset($summa->allprice))
                {
                    $sum+=$summa->allprice;
                }
                $count += DB::table('tg_smena')->whereDate('created_from',$date)
                ->where('user_id',$user->user_id)
                ->count();
            }
            if($count != 0)
            {
                $battle[]= array('id' => $user->user_id, 'price' => round($sum/$count));
            }else{
                $battle[]= array('id' => $user->user_id, 'price' => 0);
            }
        }
        $sums = array_column($battle, 'price');
        array_multisort($sums, SORT_ASC, $battle);
        if (count($battle)%2 == 0) {
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
                    'end' => 1
                ]);
            }
        } else {
            $last = $battle[count($battle)-1];
            unset($battle[count($battle)-1]);
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
                    'end' => 1
                ]);
            }
            $save = DB::table('tg_battle')->insert([
                'start_day' => date('Y-m-d',strtotime($startday)),
                    'end_day' => date('Y-m-d',strtotime($endday)),
                'created_at' => date_now()->format('Y-m-d'),
                'user1_id' => $last['id'],
                'user2_id' => $battle[count($battle)-1]['id'],
                'bot' => 1,
                'sum1' => $last['price'],
                'sum2' => $battle[count($battle)-1]['price'],
                'end' => 1
            ]);
        }
        }
        
        // return $battle;
    }
    public function battleDefault($array)
    {
        dd($array);
        $setting = ElchiBattleSetting::first();
        $dayName = date('l',(strtotime (  date_now() ) ) );
        $startday = date('Y-m-d',(strtotime ( '+'.($setting->start_day).' day' , strtotime ( date_now() ) ) ));
        $endday = date('Y-m-d',(strtotime ( '+'.($setting->end_day ).' day' , strtotime ( date_now() ) ) ));
        $battleDay = Battle::select('end','id')->whereDate('created_at',$startday)->orderBy('id','DESC')->first();
          
        $setting = ElchiBattleSetting::first();
        $dayName = date('l',(strtotime (  date_now() ) ) );
        $startday = date('Y-m-d',(strtotime ( '+'.($setting->start_day).' day' , strtotime ( date_now() ) ) ));
        $endday = date('Y-m-d',(strtotime ( '+'.($setting->end_day ).' day' , strtotime ( date_now() ) ) ));
        $battleDay = Battle::select('end','id')->whereDate('created_at',$startday)->orderBy('id','DESC')->first();
        if(battleDay($setting->start_day) == $dayName && $battleDay == NULL || $battleDay->end == 0)
        {
            $exists1 = DB::table('tg_battle')
            ->whereDate('start_day',date('Y-m-d',strtotime($startday)))
            ->whereDate('end_day',date('Y-m-d',strtotime($endday)))
            ->pluck('user1_id');
        
            $exists2 = DB::table('tg_battle')
            ->whereDate('start_day',date('Y-m-d',strtotime($startday)))
            ->whereDate('end_day',date('Y-m-d',strtotime($endday)))
            ->pluck('user2_id');

            $users = Member::with('user')
            ->whereNotIn('user_id',[60,72])
            ->whereNotIn('user_id',$exists1)
            ->whereNotIn('user_id',$exists2)
            ->get();

        $battle=array();
        $day = 30;
        foreach ($users as $key => $user) {
            $count = 0;
            $sum = 0;
            for ($i=0; $i < $day; $i++) { 
                $date = date('Y-m-d',(strtotime ( '-'.$i.' day' , strtotime ( $startday) ) ));
                $summa = DB::table('tg_productssold')
                        ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                        ->whereDate('tg_productssold.created_at','=',$date)
                        ->where('tg_user.id','=',$user->user_id)
                        ->join('tg_user','tg_user.id','tg_productssold.user_id')
                        ->orderBy('tg_user.id','ASC')
                        ->groupBy('tg_user.id')->first();
                if(isset($summa->allprice))
                {
                    $sum+=$summa->allprice;
                }
                $count += DB::table('tg_smena')->whereDate('created_from',$date)
                ->where('user_id',$user->user_id)
                ->count();
            }
            if($count != 0)
            {
                $battle[]= array('id' => $user->user_id, 'price' => round($sum/$count));
            }else{
                $battle[]= array('id' => $user->user_id, 'price' => 0);
            }
        }
        $sums = array_column($battle, 'price');
        array_multisort($sums, SORT_ASC, $battle);
        if (count($battle)%2 == 0) {
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
                    'end' => 1
                ]);
            }
        } else {
            $last = $battle[count($battle)-1];
            unset($battle[count($battle)-1]);
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
                    'end' => 1
                ]);
            }
            $save = DB::table('tg_battle')->insert([
                'start_day' => date('Y-m-d',strtotime($startday)),
                    'end_day' => date('Y-m-d',strtotime($endday)),
                'created_at' => date_now()->format('Y-m-d'),
                'user1_id' => $last['id'],
                'user2_id' => $battle[count($battle)-1]['id'],
                'bot' => 1,
                'sum1' => $last['price'],
                'sum2' => $battle[count($battle)-1]['price'],
                'end' => 1
            ]);
        }
        }
        
        // return $battle;
    }
}
