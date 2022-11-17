<?php

namespace App\Http\Controllers;

use App\Models\NewUsers;
use App\Models\User;
use App\Models\Member;
use App\Models\Ball;
use App\Models\BattleHistory;
use App\Models\ElchiBattleSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Services\ElchiService;

class UserController extends Controller
{
    public function index()
    {
        $users=User::orderBy('id')->get();
        $new_users=NewUsers::all();
        $arr=[];
        foreach ($new_users as $user){
            $d = json_decode($user->message);
            if (isset($d->data )){
                $arr[]=array('id'=>$user->id,'tg_id'=>$user->tg_id,'data'=>$d->data);
            }
        }
        return view('userControl.index',compact('users','arr'));
    }

    public function controlWorker(Request $request, $action)
    {

        $r=$request->all();
        // return $r;
        unset($r['_token']);
        DB::table('tg_user')
            ->where('status',3)
            ->update(['status'=>1]);
        foreach ($r as $key=> $item){
            if ($item=='id'){
                $id=substr($key,3);
                DB::table('tg_user')
                    ->where('id',$id)
                    ->update(['status'=>$action]);
            }
            if ($item=='test'){
                $test=substr($key,5);

                DB::table('tg_user')
                    ->where('id',$test)
                    ->update(['status'=>3]);
            }
            if ($item=='rm'){
                $test=substr($key,3);
                $rm = DB::table('tg_user')
                    ->where('id',$test)->first();
                $json = [
                    "dash" => "true",
                    "bilim" =>"true",
                    "elchi" => "true",
                    "grade" => "true",
                    "pharmacy" =>"true",
                ];
                $new = DB::table('tg_positions')
                ->insertGetId([
                    'position_json' => json_encode($json),
                    'rol_name' => 'RM-'.$rm->first_name,
                    'created_at' => date_now(),
                    'update_at' => date_now(),
                ]);
                DB::table('tg_user')
                    ->where('id',$test)
                    ->update(['rm'=>1,'rol_id'=>$new]);
            }
            if ($item=='cap'){
                $test=substr($key,4);
                $rm = DB::table('tg_user')
                    ->where('id',$test)->first();
                // return $rm;
                if($rm->rm != 1)
                {
                    $json = [
                        "dash" => "true",
                        "bilim" =>"true",
                        "elchi" => "true",
                        "grade" => "true",
                        "pharmacy" =>"true",
                    ];
                    $new = DB::table('tg_positions')
                    ->insertGetId([
                        'position_json' => json_encode($json),
                        'rol_name' => 'Capitan-'.$rm->first_name,
                        'created_at' => date_now(),
                        'update_at' => date_now(),
                    ]);
                    DB::table('tg_user')
                        ->where('id',$test)
                        ->update(['level'=>2,'rol_id'=>$new]);
                }else{
                    DB::table('tg_user')
                        ->where('id',$test)
                        ->update(['level'=>2]);
                }
                
            }

            

        }
        return redirect()->back();
    }

    public function userRm(Request $request)
    {
        $r=$request->all();
        unset($r['_token']);
        // return $r;/

        foreach ($r as $key=> $item){
            if ($item=='rm'){
                $test=substr($key,3);
                $cap = DB::table('tg_user')
                    ->where('id',$test)->first();
                if($cap->level != 2)
                {
                    $rol_id = DB::table('tg_user')->where('id',$test)->first();
                DB::table('tg_positions')->where('id',$rol_id->rol_id)->delete();
                }
                
                DB::table('tg_user')
                    ->where('id',$test)
                    ->update(['rm'=>0,'rol_id'=>NULL]);
                
            }

        }
        return redirect()->back();

    }
    public function userCap(Request $request)
    {
        $r=$request->all();
        unset($r['_token']);

        // return $r;
        foreach ($r as $key=> $item){
            if ($item=='cap'){
                $test=substr($key,4);
                $rm = DB::table('tg_user')
                    ->where('id',$test)->first('rm');
                if($rm->rm != 1)
                {
                    $rol_id = DB::table('tg_user')->where('id',$test)->first();
                    DB::table('tg_positions')->where('id',$rol_id->rol_id)->delete();
                    DB::table('tg_user')
                    ->where('id',$test)
                    ->update(['level'=>1,'rol_id'=>NULL]);
                }else{
                    DB::table('tg_user')
                    ->where('id',$test)
                    ->update(['level'=>1]);
                }
                
                
            }

        }
        return redirect()->back();

    }
    public function userExit(Request $request)
    {
        $r=$request->all();
        unset($r['_token']);
        foreach ($r as $key=> $item){
            if ($item=='exit'){
                $test=substr($key,5);
                $rm = DB::table('tg_user')
                    ->where('id',$test)->update([
                        'status' => 1
                    ]);
            }

        }
        return redirect()->back();
    }
    public function addUser(Request $request)
    {
        $r=$request->all();
        unset($r['_token']);
        foreach ($r as $key=> $item) {
            $id[] = substr($key, 3);
        }
        foreach ($id as $item){
            $response = Http::post('http://128.199.2.165:8100/api/v1/user/create/', [
                'tg_id' => $item,
            ]);
            return $response;
        }

        return redirect()->back();
    }
    public function adminList(Request $request)
    {

        $elchi = DB::table('tg_user')
        ->where('admin',TRUE)
        ->where('rm',0)
        ->select('tg_user.last_seen','tg_positions.id as pid','tg_positions.rol_name','tg_user.id','tg_user.tg_id','tg_user.username','tg_user.birthday','tg_user.phone_number','tg_user.first_name','tg_user.last_name','tg_region.name as v_name')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->leftjoin('tg_positions','tg_positions.id','tg_user.rol_id')
        ->orderBy('tg_user.last_seen','ASC')
        ->get();
        $posi = DB::table('tg_positions')->get();
        return view('rol-setting.user',compact('elchi','posi'));
    }
    public function rmList(Request $request)
    {

        $elchi = DB::table('tg_user')
        ->where('rm',1)
        ->select('tg_user.last_seen','tg_positions.id as pid','tg_positions.rol_name','tg_user.id','tg_user.tg_id','tg_user.username','tg_user.birthday','tg_user.phone_number','tg_user.first_name','tg_user.last_name','tg_region.name as v_name')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->leftjoin('tg_positions','tg_positions.id','tg_user.rol_id')
        ->orderBy('tg_user.last_seen','ASC')
        ->get();
        $posi = DB::table('tg_positions')->get();
        return view('rol-setting.user',compact('elchi','posi'));
    }
    public function capList(Request $request)
    {

        $elchi = DB::table('tg_user')
        ->where('level',2)
        ->select('tg_user.last_seen','tg_positions.id as pid','tg_positions.rol_name','tg_user.id','tg_user.tg_id','tg_user.username','tg_user.birthday','tg_user.phone_number','tg_user.first_name','tg_user.last_name','tg_region.name as v_name')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->leftjoin('tg_positions','tg_positions.id','tg_user.rol_id')
        ->orderBy('tg_user.last_seen','ASC')
        ->get();
        $posi = DB::table('tg_positions')->get();
        return view('rol-setting.user',compact('elchi','posi'));
    }
    public function userList(Request $request)
    {

        $elchi = DB::table('tg_user')
        ->whereIn('level',[0,1])
        ->where('admin',FALSE)
        ->where('rm',0)
        ->select('tg_user.last_seen','tg_positions.id as pid','tg_positions.rol_name','tg_user.id','tg_user.tg_id','tg_user.username','tg_user.birthday','tg_user.phone_number','tg_user.first_name','tg_user.last_name','tg_region.name as v_name')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->leftjoin('tg_positions','tg_positions.id','tg_user.rol_id')
        ->orderBy('tg_user.last_seen','ASC')
        ->get();
        $posi = DB::table('tg_positions')->get();
        return view('rol-setting.user',compact('elchi','posi'));
    }
    public function elchiBattleSetting()
    {
        $weekStartDate = date_now()->startOfWeek()->format('Y-m-d');
        $weekEndDate = date_now()->endOfWeek()->format('Y-m-d');
        $week_date = DB::table('tg_battle')
        ->select('start_day','end_day')
        ->whereDate('start_day','>=',$weekStartDate)
        ->whereDate('end_day','<=',$weekEndDate)
        ->distinct()
        ->first();
        if(isset($week_date->start_day))
        {
            $week_start = date('l',(strtotime ( $week_date->start_day ) ));
            $week_end = date('l',(strtotime ( $week_date->end_day ) ));
        }else{
            $lastWeekStartDate = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $weekStartDate ) ) ));
            $lastWeekEndDate = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $weekEndDate ) ) ));
            $week_date = DB::table('tg_battle')
            ->select('start_day','end_day')
            ->whereDate('start_day','>=',$lastWeekStartDate)
            ->whereDate('end_day','<=',$lastWeekEndDate)
            ->distinct()
            ->first();
            if(isset($week_date->start_day))
            {
                $week_start = date('l',(strtotime ( $week_date->start_day ) ));
                $week_end = date('l',(strtotime ( $week_date->end_day ) ));
            }else{
                $week_date = DB::table('tg_battle')
                ->select('start_day','end_day')
                ->latest()->first();
                $week_start = date('l',(strtotime ( $week_date->start_day ) ));
                $week_end = date('l',(strtotime ( $week_date->end_day ) ));
            }
            
        }
        $elchi_service = new ElchiService();
        $week_start = $elchi_service->battleSetting($week_start);
        $week_end = $elchi_service->battleSetting($week_end);
        // return $week_start;

        
        $settings = ElchiBattleSetting::first();
        if(isset($settings->start_day))
        {
            $weekStartDate = date_now()->startOfWeek()->format('Y-m-d');
            $weekEndDate = date_now()->endOfWeek()->format('Y-m-d');
            $week_dates = DB::table('tg_battle')
            ->select('start_day','end_day')
            ->whereDate('start_day','>=',$weekStartDate)
            ->whereDate('end_day','<=',$weekEndDate)
            ->distinct()
            ->first();
            if(isset($week_dates->start_day))
            {
                $start = date('l',(strtotime ( '+'.($settings->start_day+7).' day' , strtotime ( $weekStartDate ) ) ));
            $end = date('l',(strtotime ( '+'.($settings->end_day+7).' day' , strtotime ( $weekStartDate ) ) ));
            $now_start = date('d.m.Y',(strtotime ( '+'.($settings->start_day+7).' day' , strtotime ( $weekStartDate ) ) ));
            $now_end = date('d.m.Y',(strtotime ( '+'.($settings->end_day+7).' day' , strtotime ( $weekStartDate ) ) ));
            }else{
                $start = date('l',(strtotime ( '+'.$settings->start_day.' day' , strtotime ( $weekStartDate ) ) ));
            $end = date('l',(strtotime ( '+'.$settings->end_day.' day' , strtotime ( $weekStartDate ) ) ));
            $now_start = date('d.m.Y',(strtotime ( '+'.($settings->start_day).' day' , strtotime ( $weekStartDate ) ) ));
            $now_end = date('d.m.Y',(strtotime ( '+'.($settings->end_day).' day' , strtotime ( $weekStartDate ) ) ));
            }
            $elchi_battle = new ElchiService();
            $start = $elchi_battle->battleSetting($start);
            $end = $elchi_battle->battleSetting($end);
        }else{
            $start = 0;
            $end = 0;
            $now_start = 0;
            $now_end = 0;
        }
        
        
        return view('elchilar.setting',compact('week_start','week_end','week_date','start','end','now_start','now_end'));
    }
    public function elchiBattleSettingStore(Request $request)
    {
        $inputs = $request->all();
        $delete = ElchiBattleSetting::where('id','>=',1)->delete();
        $new = new ElchiBattleSetting($inputs);
        $new->save();
        if($new->id){
            return redirect()->back();
        }
    }
    public function elchiBattleSelect()
    {
        
        $settings = ElchiBattleSetting::first();
        if(!isset($settings->start_day))
        {
            return view('elchilar.error');
        }
        $weekStartDate = date_now()->startOfWeek()->format('Y-m-d');
        $weekEndDate = date_now()->endOfWeek()->format('Y-m-d');
        $week_date = DB::table('tg_battle')
        ->select('start_day','end_day')
        ->whereDate('start_day','>=',$weekStartDate)
        ->whereDate('end_day','<=',$weekEndDate)
        ->distinct()
        ->first();
        $startday = date('d.m.Y',(strtotime ( '+'.($settings->start_day).' day' , strtotime ( $weekStartDate ) ) ));
        $endday = date('d.m.Y',(strtotime ( '+'.($settings->end_day ).' day' , strtotime ( $weekStartDate ) ) ));
        
        
        $get_date = DB::table('tg_battle')
        ->whereDate('start_day','>=',date('Y-m-d',strtotime($startday)))
        ->whereDate('end_day','<=',date('Y-m-d',strtotime($endday)))
        ->where('end',1)
        ->orderBy('id', 'DESC')->first();
        // return $get_date;

        if (isset($get_date->start_day))
        {
            $start = date('l',(strtotime ( '+'.($settings->start_day+7).' day' , strtotime ( $weekStartDate ) ) ));
            $end = date('l',(strtotime ( '+'.($settings->end_day+7).' day' , strtotime ( $weekStartDate ) ) ));
            $startdays = date('d.m.Y',(strtotime ( '+'.($settings->start_day+7).' day' , strtotime ( $weekStartDate ) ) ));
            $enddays = date('d.m.Y',(strtotime ( '+'.($settings->end_day+7).' day' , strtotime ( $weekStartDate ) ) ));
        
        }else{
            $start = date('l',(strtotime ( '+'.($settings->start_day).' day' , strtotime ( $weekStartDate ) ) ));
            $end = date('l',(strtotime ( '+'.($settings->end_day).' day' , strtotime ( $weekStartDate ) ) ));
            $startdays = date('d.m.Y',(strtotime ( '+'.($settings->start_day).' day' , strtotime ( $weekStartDate ) ) ));
            $enddays = date('d.m.Y',(strtotime ( '+'.($settings->end_day).' day' , strtotime ( $weekStartDate ) ) ));
        
        }

        
        $elchi_battle = new ElchiService();
        $starts = $elchi_battle->battleSetting($start);
        $ends = $elchi_battle->battleSetting($end);

        $exists1 = DB::table('tg_battle')
        ->whereDate('start_day',$startdays)
        ->whereDate('end_day',$enddays)
        ->pluck('user1_id');
        $exists2 = DB::table('tg_battle')
        ->whereDate('start_day',$startdays)
        ->whereDate('end_day',$enddays)
        ->pluck('user2_id');

        $usersarray = Member::with('user')
        ->whereNotIn('user_id',[60,72])
        ->whereNotIn('user_id',$exists1)
        ->whereNotIn('user_id',$exists2)
        ->get();
        #battle
        $settings = ElchiBattleSetting::first();
        $weekStartDate = date_now()->startOfWeek()->format('Y-m-d');
        $weekEndDate = date_now()->endOfWeek()->format('Y-m-d');
        $week_date = DB::table('tg_battle')
        ->select('start_day','end_day')
        ->whereDate('start_day','>=',$weekStartDate)
        ->whereDate('end_day','<=',$weekEndDate)
        ->distinct()
        ->first();
        $startday = date('d.m.Y',(strtotime ( '+'.($settings->start_day).' day' , strtotime ( $weekStartDate ) ) ));
        $endday = date('d.m.Y',(strtotime ( '+'.($settings->end_day ).' day' , strtotime ( $weekStartDate ) ) ));
        
        
        $get_date = DB::table('tg_battle')
        ->whereDate('start_day','>=',$startday)
        ->whereDate('end_day','<=',$endday)
        ->where('end',1)
        ->latest()
        ->first();

        if (!isset($get_date->start_day)) {
        $exists2 = DB::table('tg_battle')
        ->whereDate('start_day',$startday)
        ->whereDate('end_day',$endday)
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
        // $now = Carbon::now();
        // $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        // $weekEndDate = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $now->endOfWeek()->format('Y-m-d') ) ) ));
        // $now = Carbon::now();
        // $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        // $weekEndDate = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $now->endOfWeek()->format('Y-m-d') ) ) ));
        
        // $get_date = DB::table('tg_battle')
        // ->whereDate('start_day','>=',$startday)
        // ->whereDate('end_day','<=',$endday)
        // ->get();
        // if(count($get_date)==0)
        // {
            if (count($battle)%2 ==0) {
                for ($i=0; $i < count($battle)/2; $i++) { 
                    $save = DB::table('tg_battle')->insert([
                        'start_day' => $startday,
                        'end_day' => $endday,
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
                        'start_day' => $startday,
                        'end_day' => $endday,
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
                    'start_day' => $startday,
                    'end_day' => $endday,
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

        // }

        return view ('elchilar.select',compact('usersarray','starts','startdays','ends','enddays'));
    }
    public function elchiBattleSelectStore(Request $request)
    {
        $inputs = $request->all();
        $settings = ElchiBattleSetting::first();
        $weekStartDate = date_now()->startOfWeek()->format('Y-m-d');
        $weekEndDate = date_now()->endOfWeek()->format('Y-m-d');
        $week_date = DB::table('tg_battle')
        ->select('start_day','end_day')
        ->whereDate('start_day','>=',$weekStartDate)
        ->whereDate('end_day','<=',$weekEndDate)
        ->distinct()
        ->first();
        $startday = date('d.m.Y',(strtotime ( '+'.($settings->start_day).' day' , strtotime ( $weekStartDate ) ) ));
        $endday = date('d.m.Y',(strtotime ( '+'.($settings->end_day ).' day' , strtotime ( $weekEndDate ) ) ));
        
        
        $get_date = DB::table('tg_battle')
        ->whereDate('start_day','>=',$startday)
        ->whereDate('end_day','<=',$endday)
        ->where('end',1)
        ->latest()
        ->first();
        if(isset($get_date->start_day))
        {
            $start = date('Y-m-d',(strtotime ( '+'.($settings->start_day+7).' day' , strtotime ( $weekStartDate ) ) ));
        $end = date('Y-m-d',(strtotime ( '+'.($settings->end_day+7).' day' , strtotime ( $weekStartDate ) ) ));
        
        }else{
            $start = date('Y-m-d',(strtotime ( '+'.($settings->start_day).' day' , strtotime ( $weekStartDate ) ) ));
            $end = date('Y-m-d',(strtotime ( '+'.($settings->end_day).' day' , strtotime ( $weekStartDate ) ) ));
            
        }
        
        $day = 10;
        $count1 = 0;
        $sum1 = 0;
        $count2 = 0;
        $sum2 = 0;
        $s_array=[];
        for ($i=0; $i < $day; $i++) { 
            $date = date('Y-m-d',(strtotime ( '-'.($i+7).' day' , strtotime ( $start ) ) ));
            $summa1 = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                    ->whereDate('tg_productssold.created_at','=',$date)
                    ->where('tg_user.id','=',$inputs['user1'])
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->orderBy('tg_user.id','ASC')
                    ->groupBy('tg_user.id')->first();
            if(isset($summa1->allprice))
            {
                $sum1+=$summa1->allprice;
            }
            $count1 += DB::table('tg_smena')->whereDate('created_from',$date)
            ->where('user_id',$inputs['user1'])
            ->count();

            $summa2 = DB::table('tg_productssold')
                    ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                    ->whereDate('tg_productssold.created_at','=',$date)
                    ->where('tg_user.id','=',$inputs['user2'])
                    ->join('tg_user','tg_user.id','tg_productssold.user_id')
                    ->orderBy('tg_user.id','ASC')
                    ->groupBy('tg_user.id')->first();
            if(isset($summa2->allprice))
            {
                $sum2+=$summa2->allprice;
            }
            $count2 += DB::table('tg_smena')->whereDate('created_from',$date)
            ->where('user_id',$inputs['user2'])
            ->count();
        }
        if($count1 != 0)
            {
                $summ1 = round($sum1/$count1);
            }else{
                $summ1 = 0;
            }
        if($count2 != 0)
            {
                $summ2 = round($sum2/$count2);
            }else{
                $summ2 = 0;
            }
        
        $new = DB::table('tg_battle')->insert([
            'start_day' => $start,
            'end_day' => $end,
            'created_at' => date_now()->format('Y-m-d'),
            'user1_id' => $inputs['user1'],
            'user2_id' => $inputs['user2'],
            'bot' => 0,
            'sum1' => $summ1,
            'sum2' => $summ2,
            'end' => 0

        ]);
        return redirect()->back();
    }
    public function elchiBattle()
    {
        $pluk = BattleHistory::distinct()->pluck('start_day');
        $weekEndDate = date_now()->format('Y-m-d');
        $get_battles = DB::table('tg_battle')
        ->select('start_day','end_day')
        ->whereDate('start_day','>=','2022-11-06')
        ->whereDate('end_day','<=',$weekEndDate)
        ->whereNotIn('start_day',$pluk)
        ->distinct()
        ->get();
        // return $get_battles;
        if(count($get_battles) > 0)
        {
            foreach ($get_battles as $key => $gets) {
                $getter = DB::table('tg_battle')
                ->whereDate('start_day',$gets->start_day)
                ->whereDate('end_day',$gets->end_day)
                ->get();
                
                $d=100;
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
                    $ball2 = Ball::where('user_id',$get->user2_id)
                    ->value('ball');
                    if($price1 > $price2)
                    {
                        $pow = pow(10,($ball2-$ball1)/400);
                        $e = 1/(1+$pow);
                        $r1 = $d*(1-$e)+round($price1*$d/10000000);
                        
                        $pow = pow(10,($ball1-$ball2)/400);
                        $e = 1/(1+$pow);
                        $r2 = $d*(0-$e)-round($price2*$d/10000000);
                        if($get->bot == 1)
                        {
                            $battleArray[]=array('id1' =>$get->user1_id,'id2' =>$get->user2_id,'win' => $r1,'lose'=>$r2,'bot'=>1,'i'=>0);
                        }else{
                            $battleArray[]=array('id1' =>$get->user1_id,'id2' =>$get->user2_id,'win' => $r1,'lose'=>$r2,'bot'=>0,'i'=>0);
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
                            $battleArray[]=array('id1' =>$get->user2_id,'id2' =>$get->user1_id,'win' => $r2,'lose'=>$r1,'bot'=>1,'i'=>1);
                        }else{
                            $battleArray[]=array('id1' =>$get->user2_id,'id2' =>$get->user1_id,'win' => $r2,'lose'=>$r1,'bot'=>0,'i'=>0);
                        }   
                    }
                    if($price2 == $price1)
                    {
                        $pow = pow(10,($ball1-$ball2)/400);
                        $e = 1/(1+$pow);
                        $r2 = $d*(0.5-$e)+round($price2*$d/20000000);

                        $r1 = $d*(0.5-$e)+round($price1*$d/20000000);
                        if($get->bot == 1)
                        {
                            $battleArray[]=array('id1' =>$get->user1_id,'id2' =>$get->user2_id,'win' => $r1,'lose'=>$r2,'bot'=>1,'i'=>0);
                        }else{
                            $battleArray[]=array('id1' =>$get->user1_id,'id2' =>$get->user2_id,'win' => $r1,'lose'=>$r2,'bot'=>0,'i'=>0);
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
                    $new = new BattleHistory([
                        'win_user_id' => $value['id1'],
                        'lose_user_id' => $value['id2'],
                        'start_day' => $get_battles[0]->start_day,
                        'end_day' => $get_battles[0]->end_day,
                        'ball1' => $win,
                        'ball2' => $lose,
                    ]);
                    $new->save();

                    if($new->id)
                    {
                        if($value['bot'] == 1)
                        {
                            $getball = Ball::where('user_id',$value['id1'])->value('ball');
                            $newball = $getball+$value['win'];
                            $update1 = Ball::where('user_id',$value['id1'])->update([
                                'ball' => $newball
                            ]);
                        }else{
                            $getball = Ball::where('user_id',$value['id1'])->value('ball');
                            $newball = $getball+$value['win'];
                            $update1 = Ball::where('user_id',$value['id1'])->update([
                                'ball' => $newball
                            ]);
                            $getball = Ball::where('user_id',$value['id2'])->value('ball');
                            $newball = $getball+$value['lose'];
                            $update1 = Ball::where('user_id',$value['id2'])->update([
                                'ball' => $newball
                            ]);
                        }
                        
                        
                    }
                }
            }
        }

        
        $weekEndDate = date_now()->endOfWeek()->format('Y-m-d');

        $get_battles = DB::table('tg_battle')
        ->select('start_day','end_day')
        ->whereDate('start_day','>=','2022-11-06')
        ->whereDate('start_day','<=',$weekEndDate)
        ->distinct()
        ->get();

        return view('elchilar.battle',compact('get_battles'));
    }
    public function getBattle($start,$end)
    {
        
        $getter = DB::table('tg_battle')
        ->whereDate('start_day',$start)
        ->whereDate('end_day',$end)
        ->get();
        $history_array1=[];
        $history_array2=[];
        $history = BattleHistory::whereDate('start_day',$start)
        ->whereDate('end_day',$end)
        ->get();    
        foreach ($history as $key => $value) {
            $id1 = $key.$value->win_user_id;
            $history_array1[$id1] = array('ball'=>$value->ball1);
            $id2 = $key.$value->lose_user_id;
            $history_array1[$id2] = array('ball'=>$value->ball2);
        }
        
        $arrayDate = array();
        $Variable1 = strtotime($start);
        $Variable2 = strtotime($end);
        for ($currentDate = $Variable1; $currentDate <= $Variable2;$currentDate += (86400)) 
        {                        
        $Store = date('Y-m-d', $currentDate);
        $arrayDate[] = $Store;
        $user_array1 = [];
        $user_array2 = [];
        $sum1=0;
        $sum2=0;
        $d=100;
        }
        foreach ($getter as $keys => $get) {
            $id1 = $keys.$get->user1_id;
            $id2 = $keys.$get->user2_id;
            foreach ($arrayDate as $key => $value) {
                $user1 = DB::table('tg_productssold')
                        ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                        ->whereDate('tg_productssold.created_at','=',$value)
                        ->where('tg_user.id','=',$get->user1_id)
                        ->join('tg_user','tg_user.id','tg_productssold.user_id')
                        ->orderBy('tg_user.id','ASC')
                        ->groupBy('tg_user.id')->first();
                $user2 = DB::table('tg_productssold')
                        ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice,tg_user.id')
                        ->whereDate('tg_productssold.created_at','=',$value)
                        ->where('tg_user.id','=',$get->user2_id)
                        ->join('tg_user','tg_user.id','tg_productssold.user_id')
                        ->orderBy('tg_user.id','ASC')
                        ->groupBy('tg_user.id')->first();
                if(!isset($user1->allprice))
                {
                    $sum1 = 0;
                }else{
                    $sum1 = $user1->allprice;
                }
                if(!isset($user2->allprice))
                {
                    $sum2 = 0;
                }else{
                    $sum2 = $user2->allprice;
                }
                
                $user_array1[$id1][] = $sum1;
                $user_array2[$id2][] = $sum2;

            }
            
            // $ball1 = Ball::where('user_id',$get->user1_id)
            // ->value('ball');
            // $ball2 = Ball::where('user_id',$get->user2_id)
            // ->value('ball');
            $price1 = array_sum($user_array1[$id1]);
            $price2 = array_sum($user_array2[$id2]);
            if($price1 > $price2)
            {
                // $pow = pow(10,($ball2-$ball1)/400);
                // $e = 1/(1+$pow);
                // $r1 = $d*(1-$e)+round($price1*$d/10000000);
                
                // $pow = pow(10,($ball1-$ball2)/400);
                // $e = 1/(1+$pow);
                // $r2 = $d*(0-$e)-round($price2*$d/10000000);

                $user1 = DB::table('tg_user')->select('last_name','first_name')
                ->where('id',$get->user1_id)
                ->first();
                $user2 = DB::table('tg_user')->select('last_name','first_name')
                ->where('id',$get->user2_id)
                ->first();
                $ball1 = Ball::where('user_id',$get->user1_id)->value('ball');
                $ball2 = Ball::where('user_id',$get->user2_id)->value('ball');

                $battleArray[]=array('id1' =>$id1,'id2' =>$id2, 'sum1'=>$price1,'sum2'=>$price2,'ball1' => $ball1,'ball2' => $ball2,'user1'=>$user1->last_name.' '.$user1->first_name,'user2'=>$user2->last_name.' '.$user2->first_name);

            }
            if($price2 > $price1)
            {
                // $pow = pow(10,($ball1-$ball2)/400);
                // $e = 1/(1+$pow);
                // $r2 = $d*(1-$e)+round($price2*$d/10000000);
                
                // $pow = pow(10,($ball2-$ball1)/400);
                // $e = 1/(1+$pow);
                // $r1 = $d*(0-$e)-round($price1*$d/10000000);

                $user1 = DB::table('tg_user')->select('last_name','first_name')
                ->where('id',$get->user1_id)
                ->first();
                $user2 = DB::table('tg_user')->select('last_name','first_name')
                ->where('id',$get->user2_id)
                ->first();
                $ball1 = Ball::where('user_id',$get->user1_id)->value('ball');
                $ball2 = Ball::where('user_id',$get->user2_id)->value('ball');
                $battleArray[]=array('id1' =>$id1,'id2' =>$id2,'sum1'=>$price2,'sum2'=>$price1,'ball1' => $ball1,'ball2' => $ball2,'user2'=>$user1->last_name.' '.$user1->first_name,'user1'=>$user2->last_name.' '.$user2->first_name);
            }
        }
        
        $weekEndDate = date_now()->endOfWeek()->format('Y-m-d');

        $get_battles = DB::table('tg_battle')
        ->select('start_day','end_day')
        ->whereDate('start_day','>=','2022-11-06')
        ->whereDate('start_day','<=',$weekEndDate)
        ->distinct()
        ->get();

        // return $user_array2;
        // return $history_array1;

        return view('elchilar.battle',compact('history_array1','history_array2','user_array1','user_array2','get_battles','battleArray','arrayDate'));

    }
}
