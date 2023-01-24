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
    public function battle()
    {
        $setting = ElchiBattleSetting::first();
        $dayName = date('l',(strtotime (  date_now() ) ) );
        $weekStartDate = date_now()->startOfWeek()->format('Y-m-d');
        $weekEndDate = date_now()->endOfWeek()->format('Y-m-d');
        $startday = date('Y-m-d',(strtotime ( '+'.($setting->start_day).' day' , strtotime ( $weekStartDate ) ) ));
        $endday = date('Y-m-d',(strtotime ( '+'.($setting->end_day ).' day' , strtotime ( $weekStartDate ) ) ));
        $issetbattleDay = Battle::select('end','id')->whereDate('start_day','>=',$weekStartDate)->whereDate('start_day','<=',$weekEndDate)->orderBy('id','DESC')->first();
        
        if(battleDay($setting->start_day) == $dayName && ($issetbattleDay == NULL || $issetbattleDay->end == 0))
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
            $day = 10;
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
    }
    public function battleDefault($array)
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
    public function battleEnd()
    {
        $weekStartDate = date_now()->startOfWeek()->format('Y-m-d');
        $weekEndDate = date_now()->endOfWeek()->format('Y-m-d');
        $pluk = BattleHistory::distinct()->pluck('start_day');
        $issetbattleDay = Battle::select('start_day','end_day')
        ->whereDate('start_day','>=',$weekStartDate)
        ->whereDate('start_day','<=',$weekEndDate)
        ->whereDate('end_day','<=',date_now()->format('Y-m-d'))
        ->whereNotIn('start_day',$pluk)
        ->distinct()
        ->get();
        if(count($issetbattleDay) > 0)
        {
            foreach ($issetbattleDay as $key => $gets) {
                $getter = DB::table('tg_battle')
                ->whereDate('start_day',$gets->start_day)
                ->whereDate('end_day',$gets->end_day)
                ->get();

                $sumarray1 = [];
                $sumarray2 = [];
                $d=100;

                $arrayDate = array();
                $Variable1 = strtotime($gets->start_day);
                $Variable2 = strtotime($gets->end_day);
                for ($currentDate = $Variable1; $currentDate <= $Variable2;$currentDate += (86400)) 
                {                        
                $Store = date('Y-m-d', $currentDate);
                $arrayDate[] = $Store;
                }

                foreach ($getter as $keys => $get) {
                    $price1=0;
                    $price2=0;
                        $user1 = DB::table('tg_productssold')
                                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                                ->whereDate('tg_productssold.created_at','>=',$gets->start_day)
                                ->whereDate('tg_productssold.created_at','<=',$gets->end_day)
                                ->where('tg_user.id','=',$get->user1_id)
                                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                                ->orderBy('tg_user.id','ASC')
                                ->groupBy('tg_user.id')->first();
                        $user2 = DB::table('tg_productssold')
                                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                                ->whereDate('tg_productssold.created_at','>=',$gets->start_day)
                                ->whereDate('tg_productssold.created_at','<=',$gets->end_day)
                                ->where('tg_user.id','=',$get->user2_id)
                                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                                ->orderBy('tg_user.id','ASC')
                                ->groupBy('tg_user.id')->first();

                                $sumarray1 = [];
                                $sumarray2 = [];
                            foreach ($arrayDate as $key => $value) {
                                $user11 = DB::table('tg_productssold')
                                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                                ->whereDate('tg_productssold.created_at',$value)
                                ->where('tg_user.id','=',$get->user1_id)
                                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                                ->orderBy('tg_user.id','ASC')
                                ->groupBy('tg_user.id')->first();
                                $user22 = DB::table('tg_productssold')
                                ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                                ->whereDate('tg_productssold.created_at',$value)
                                ->where('tg_user.id','=',$get->user2_id)
                                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                                ->orderBy('tg_user.id','ASC')
                                ->groupBy('tg_user.id')->first();
                                if(!isset($user11->allprice))
                                {
                                    $sumarray1[]=0;
                                }else{
                                    $sumarray1[]=$user11->allprice;
                                }
                                if(!isset($user22->allprice))
                                {
                                    $sumarray2[]=0;
                                }else{
                                    $sumarray2[]=$user22->allprice;
                                }
                            }
                        if(!isset($user1->allprice))
                        {
                            $price1 += 0;
                        }else{
                            $price1 += $user1->allprice;
                        }
                        if(!isset($user2->allprice))
                        {
                            $price2 += 0;
                        }else{
                            $price2 += $user2->allprice;
                        }

                        

                    
                    
                    $ball1 = Ball::where('user_id',$get->user1_id)
                    ->value('ball');
                    if($ball1 == NULL)
                    {
                        $new = new Ball([
                            'user_id' => $get->user1_id,
                            'ball' => 1000,
                            'active' => 0,
                        ]);
                        $new->save();
                    }
                    $ball2 = Ball::where('user_id',$get->user2_id)
                    ->value('ball');
                    if($ball2 == NULL)
                    {
                        $new = new Ball([
                            'user_id' => $get->user2_id,
                            'ball' => 1000,
                            'active' => 0,
                        ]);
                        $new->save();
                    }
                    $ball1 = Ball::where('user_id',$get->user1_id)
                    ->value('ball');
                    $ball2 = Ball::where('user_id',$get->user2_id)
                    ->value('ball');
                    if($price1 > $price2)
                    {
                        $pow = pow(10,($ball2-$ball1)/400);
                        $e = 1/(1+$pow);
                        $r1 = $d*(1-$e)+round($price1*$d/10000000);
                        
                        $pow = pow(10,($ball1-$ball2)/400);
                        $e = 1/(1+$pow);
                        $r2 = $d*(0-$e)- ($price2*$d/10000000);
                        if($get->bot == 1)
                        {
                            $battleArray[]=array('a1' => $sumarray1,'a2' => $sumarray2,'id1' =>$get->user1_id,'id2' =>$get->user2_id,'win' => $r1,'lose'=>$r2,'bot'=>1,'i'=>0);
                        }else{
                            $battleArray[]=array('a1' => $sumarray1,'a2' => $sumarray2,'id1' =>$get->user1_id,'id2' =>$get->user2_id,'win' => $r1,'lose'=>$r2,'bot'=>0,'i'=>0);
                        }
                    }
                    if($price2 > $price1)
                    {
                        $pow = pow(10,($ball1-$ball2)/400);
                        $e = 1/(1+$pow);
                        $r2 = $d*(1-$e)+round($price2*$d/10000000);
                        
                        $pow = pow(10,($ball2-$ball1)/400);
                        $e = 1/(1+$pow);
                        $r1 = $d*(0-$e)-round($price1*$d/10000000);
                        if($get->bot == 1)
                        {
                            $battleArray[]=array('a1' => $sumarray1,'a2' => $sumarray2,'id1' =>$get->user2_id,'id2' =>$get->user1_id,'win' => $r2,'lose'=>$r1,'bot'=>1,'i'=>1);
                        }else{
                            $battleArray[]=array('a1' => $sumarray1,'a2' => $sumarray2,'id1' =>$get->user2_id,'id2' =>$get->user1_id,'win' => $r2,'lose'=>$r1,'bot'=>0,'i'=>0);
                        }   
                    }
                    if($price2 == $price1)
                    {
                            if($ball1 > $ball2)
                            {
                                $pow = pow(10,($ball2-$ball1)/400);
                                $e = 1/(1+$pow);
                                $r1 = $d*(0.5-$e)+round($price1*$d/20000000);

                                $pow = pow(10,($ball1-$ball2)/400);
                                $e = 1/(1+$pow);
                                $r2 = $d*(0.5-$e)+round($price2*$d/20000000);

                            }else{
                                $pow = pow(10,($ball2-$ball1)/400);
                                $e = 1/(1+$pow);
                                $r2 = $d*(0.5-$e)+round($price2*$d/20000000);

                                $pow = pow(10,($ball1-$ball2)/400);
                                $e = 1/(1+$pow);
                                $r1 = $d*(0.5-$e)+round($price1*$d/20000000);
                            }
                        if($get->bot == 1)
                        {
                            $battleArray[]=array('a1' => $sumarray1,'a2' => $sumarray2,'id1' =>$get->user1_id,'id2' =>$get->user2_id,'win' => $r1,'lose'=>$r2,'bot'=>1,'i'=>0);
                        }else{
                            $battleArray[]=array('a1' => $sumarray1,'a2' => $sumarray2,'id1' =>$get->user1_id,'id2' =>$get->user2_id,'win' => $r1,'lose'=>$r2,'bot'=>0,'i'=>0);
                        }
                    }
                }
                foreach ($battleArray as $key => $value) {
                    if($value['win'] < 0)
                    {
                        $win = $value['win']*(-1);
                    }else{
                        $win = $value['win'];
                    }
                    if($value['lose'] < 0)
                    {
                        $lose = $value['lose']*(-1);
                    }else{
                        $lose = $value['lose'];
                    }
                    $balls1 = Ball::where('user_id',$value['id1'])
                    ->value('ball');
                    $balls2 = Ball::where('user_id',$value['id2'])
                    ->value('ball');
                    // dd($value['win']);

                    $new = new BattleHistory([
                        'win_user_id' => $value['id1'],
                        'lose_user_id' => $value['id2'],
                        'day1' => json_encode($value['a1']),
                        'day2' => json_encode($value['a2']),
                        'start_day' => $get->start_day,
                        'end_day' => $get->end_day,
                        'ball1' => round($win),
                        'ball2' => round($lose),
                        'uball1' => round($balls1+$value['win']),
                        'uball2' => round($balls2+$value['lose']),
                    ]);
                    $new->save();

                    if($new->id)
                    {
                        if($value['bot'] == 1)
                        {
                            $getball = Ball::where('user_id',$value['id1'])->value('ball');
                            $newball = $getball+$value['win'];
                            $update1 = Ball::where('user_id',$value['id1'])->update([
                                'ball' => round($newball)
                            ]);
                        }else{
                            $getball = Ball::where('user_id',$value['id1'])->value('ball');
                            $newball = $getball+$value['win'];
                            $update1 = Ball::where('user_id',$value['id1'])->update([
                                'ball' => round($newball)
                            ]);
                            $getball = Ball::where('user_id',$value['id2'])->value('ball');
                            $newball = $getball+$value['lose'];
                            $update1 = Ball::where('user_id',$value['id2'])->update([
                                'ball' => round($newball)
                            ]);
                        }
                        
                        
                    }
                }
                
            }

            // return $battleArray;
        }
    }
}
