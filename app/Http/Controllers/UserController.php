<?php

namespace App\Http\Controllers;

use App\Models\NewUsers;
use App\Models\User;
use App\Models\Member;
use App\Models\Ball;
use App\Models\BattleDay;
use App\Models\BattleHistory;
use App\Models\ElchiBattleSetting;
use App\Models\Medicine;
use App\Models\Price;
use App\Models\Exercise;
use App\Models\ElchiExercise;
use App\Models\ElchiUserExercise;
use App\Models\NewElchi;
use App\Models\ProductSold;
use App\Models\TestRegister;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Services\ElchiService;
use App\Services\ElchiBattleService;
class UserController extends Controller
{
    public function index()
    {
        $users=User::with('new_elchi')->orderBy('id')->get();
        $new_users=NewUsers::all();
        // return $users;
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
        // DB::table('tg_user')
        //     ->where('status',3)
        //     ->update(['status'=>1]);
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
            if ($item=='new'){
                $id=substr($key,4);
                $new_elchi = new NewElchi([
                    'user_id' => $id,
                ]);

                $new_elchi->save();
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
    public function userTest(Request $request)
    {
        $r=$request->all();
        unset($r['_token']);

        // return $r;
        foreach ($r as $key=> $item){
            if ($item=='test'){
                $test=substr($key,5);

                DB::table('tg_user')
                    ->where('id',$test)
                    ->update(['status'=>1]);
                
                
            }

        }
        return redirect()->back();

    }
    public function userNew(Request $request)
    {
        $r=$request->all();
        unset($r['_token']);

        // return $r;
        foreach ($r as $key=> $item){
            if ($item=='new'){
                $id=substr($key,4);
                $delete = NewElchi::where('user_id',$id)->delete();
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
        // $saves = DB::table('tg_user')->get();

        // foreach ($saves as $key => $value) {
        //     $new = DB::table('tg_balls')->insert([
        //         'user_id' => $value->id,
        //         'ball' => 1000,
        //         'active' => 0,
        //     ]);
        // }

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
                $week_date = DB::table('tg_elchi_battle_settings')
                ->first();
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
        $endday = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( Carbon::now() ) ) ));
        $startday = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( Carbon::now() ) ) ));
        $all_user = User::pluck('id');
        $users=[];
        foreach($all_user as $id)
        {
            $transactions= ProductSold::whereBetween('created_at', [$startday, $endday])
            ->select(DB::raw('DATE(created_at) as date'))
            ->where('user_id',$id)
            ->groupBy('date')
            ->get('date');
            $sizeof = sizeof($transactions);
                if($sizeof >= 3)
                {
                    $users[] = $id;
                }
        }
        $userid = User::with('battle_user1','battle_user2')->whereIn('id',$users)->get();
        // return $userid;
        // $battle_day = BattleDay::with('u1id','u2id')->where('u1id',27)->orWhere('u2id',27)->get();
        // return $battle_day;
        
        return view ('elchilar.select',compact('userid'));
    }
    public function elchiBattleSelectStore(Request $request)
    {
        if($request->user1 == $request->user2)
        {
            return redirect()->back();
        }
        $userIn[]=$request->user1;
        $userIn[]=$request->user2;
        $battle_day_count = BattleDay::whereIn('u1id',$userIn)->where('u2id',$userIn)->where('ends',0)->orderBy('id','DESC')->limit(1)->get();

            
        // return $battle_day_count;
        if(count($battle_day_count) == 1)
        {
            $st_day = $battle_day_count[0]->end_day;
            $start_index_day = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $st_day ) ) ));
            $end_index_day = date('Y-m-d',(strtotime ( '+'.$request->day.' day' , strtotime ( $st_day ) ) ));

            $arrayDate = array();
            $Variable1 = strtotime($start_index_day);
            $Variable2 = strtotime($end_index_day);
            $sum = 0;
            for ($currentDate = $Variable1; $currentDate <= $Variable2;$currentDate += (86400)) 
            {                        
                $Store = date('w', $currentDate);
                if($Store == 0)
                {
                    $sum += 1;
                }else{
                    $arrayDate[] = date('Y-m-d', $currentDate);

                }
            }
            if($sum > 0)
            {
                for ($i=1; $i <= $sum; $i++) { 
                    $ends = date('w',(strtotime ( '+1 day' , strtotime ( end($arrayDate) ) ) ));
                    if($ends == 0)
                    {
                        $endsw = date('Y-m-d',(strtotime ( '+2 day' , strtotime ( end($arrayDate) ) ) ));
                    }else{
                        $endsw = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( end($arrayDate) ) ) ));
                    }
                    $arrayDate[] = $endsw;
                }
            }
            $start_day = $arrayDate[0];
            $end_day = end($arrayDate);
            $new_battle = new BattleDay([
                'u1id' => $request->user1,
                'u2id' => $request->user2,
                'price1' => 0,
                'price2' => 0,
                'days' => $request->day,
                'start_day' => $start_day,
                'end_day' => $end_day,
            ]);
            $new_battle->save();

        }else{
            $user1 = BattleDay::where('u1id',$request->user1)->orWhere('u2id',$request->user1)->where('ends',0)->orderBy('id','DESC')->limit(1)->get();
            $user2 = BattleDay::where('u1id',$request->user2)->orWhere('u2id',$request->user2)->where('ends',0)->orderBy('id','DESC')->limit(1)->get();
            if($user1[0]->end_day >= $user2[0]->end_day )
            {
                $st_day = $user1[0]->end_day;
            $start_index_day = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $st_day ) ) ));
            $end_index_day = date('Y-m-d',(strtotime ( '+'.$request->day.' day' , strtotime ( $st_day ) ) ));

            $arrayDate = array();
            $Variable1 = strtotime($start_index_day);
            $Variable2 = strtotime($end_index_day);
            $sum = 0;
            for ($currentDate = $Variable1; $currentDate <= $Variable2;$currentDate += (86400)) 
            {                        
                $Store = date('w', $currentDate);
                if($Store == 0)
                {
                    $sum += 1;
                }else{
                    $arrayDate[] = date('Y-m-d', $currentDate);

                }
            }
            if($sum > 0)
            {
                for ($i=1; $i <= $sum; $i++) { 
                    $ends = date('w',(strtotime ( '+1 day' , strtotime ( end($arrayDate) ) ) ));
                    if($ends == 0)
                    {
                        $endsw = date('Y-m-d',(strtotime ( '+2 day' , strtotime ( end($arrayDate) ) ) ));
                    }else{
                        $endsw = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( end($arrayDate) ) ) ));
                    }
                    $arrayDate[] = $endsw;
                }
            }
            $start_day = $arrayDate[0];
            $end_day = end($arrayDate);
                $new_battle = new BattleDay([
                    'u1id' => $request->user1,
                    'u2id' => $request->user2,
                    'price1' => 0,
                    'price2' => 0,
                    'days' => $request->day,
                    'start_day' => $start_day,
                    'end_day' => $end_day,
                ]);
                $new_battle->save();
            }else{
                $st_day = $user1[0]->end_day;
            $start_index_day = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $st_day ) ) ));
            $end_index_day = date('Y-m-d',(strtotime ( '+'.$request->day.' day' , strtotime ( $st_day ) ) ));

            $arrayDate = array();
            $Variable1 = strtotime($start_index_day);
            $Variable2 = strtotime($end_index_day);
            $sum = 0;
            for ($currentDate = $Variable1; $currentDate <= $Variable2;$currentDate += (86400)) 
            {                        
                $Store = date('w', $currentDate);
                if($Store == 0)
                {
                    $sum += 1;
                }else{
                    $arrayDate[] = date('Y-m-d', $currentDate);

                }
            }
            if($sum > 0)
            {
                for ($i=1; $i <= $sum; $i++) { 
                    $ends = date('w',(strtotime ( '+1 day' , strtotime ( end($arrayDate) ) ) ));
                    if($ends == 0)
                    {
                        $endsw = date('Y-m-d',(strtotime ( '+2 day' , strtotime ( end($arrayDate) ) ) ));
                    }else{
                        $endsw = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( end($arrayDate) ) ) ));
                    }
                    $arrayDate[] = $endsw;
                }
            }
            $start_day = $arrayDate[0];
            $end_day = end($arrayDate);
                $new_battle = new BattleDay([
                    'u1id' => $request->user1,
                    'u2id' => $request->user2,
                    'price1' => 0,
                    'price2' => 0,
                    'days' => $request->day,
                    'start_day' => $start_day,
                    'end_day' => $end_day,
                ]);
                $new_battle->save();
            }
            // return abs(strtotime('2023-01-22')-strtotime('2023-01-24'))/86400;

            // return 1234;
        }
        // return $battle_day2_count;
        return 123;

        $inputs = $request->all();
        $battle_service = new ElchiBattleService;
        $elchi_battle = $battle_service->battleDefault($inputs);
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
        if(count($get_battles) > 0)
        {
            foreach ($get_battles as $key => $gets) {
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
                        $pow = pow(10,($ball1-$ball2)/400);
                        $e = 1/(1+$pow);
                        $r2 = $d*(0.5-$e)+round($price2*$d/20000000);

                        $r1 = $d*(0.5-$e)+round($price1*$d/20000000);
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
        ->whereDate('start_day',date('Y-m-d',strtotime($start)))
        ->whereDate('end_day',date('Y-m-d',strtotime($end)))
        ->get();
        $history_array1=[];
        $history_array2=[];
        $history = BattleHistory::whereDate('start_day',date('Y-m-d',strtotime($start)))
        ->whereDate('end_day',date('Y-m-d',strtotime($end)))
        ->get();    
        foreach ($history as $key => $value) {
            $id1 = $key.$value->win_user_id;
            $history_array1[$id1] = array('ball'=>$value->ball1,'day' => json_decode($value->day1));
            $id2 = $key.$value->lose_user_id;
            $history_array1[$id2] = array('ball'=>$value->ball2,'day' => json_decode($value->day2));
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
        // return $getter;
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

                $battleArray[]=array('id1' =>$id1,'id2' =>$id2, 'sum1'=>$get->sum1,'sum2'=>$get->sum2,'ball1' => $ball1,'ball2' => $ball2,'user1'=>$user1->last_name.' '.$user1->first_name,'user2'=>$user2->last_name.' '.$user2->first_name);

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
                $battleArray[]=array('id1' =>$id1,'id2' =>$id2,'sum1'=>$get->sum1,'sum2'=>$get->sum2,'ball1' => $ball1,'ball2' => $ball2,'user2'=>$user1->last_name.' '.$user1->first_name,'user1'=>$user2->last_name.' '.$user2->first_name);
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
    public function elchiHis($id)
    {
        $getter = BattleHistory::where('win_user_id',$id)
        ->orWhere('lose_user_id',$id)->get();
        // return $getter;
        return view('elchilar.history',compact('getter','id'));
    }
    public function elchiBattleExercise()
    {
        $medicine = Medicine::orderBy('id','ASC')->get();
        $price = Price::where('shablon_id',3)->get();
        return view('elchilar.exercise',compact('medicine','price'));
        // return $shablon;
    }
    public function elchiBattleExerciseStore(Request $request)
    {
        $inputs = $request->all();
        unset($inputs['_token']);
        $exercise = new Exercise($inputs);
        $exercise->save();
        if($exercise->id){
            return redirect()->back();
        }
    }
    public function elchiUserBattleExercise()
    {
        $medicine = Medicine::orderBy('id','ASC')->get();
        $price = Price::where('shablon_id',3)->get();
        return view('elchilar.user-exercise',compact('medicine','price'));
        // return $shablon;
    }
    public function elchiUserBattleExerciseStore(Request $request)
    {
        // return $request;
        $inputs = $request->all();
        unset($inputs['_token']);
        $users = User::where('admin','false')->get();
        foreach ($users as $key => $value) {
            $inputs['user_id'] = $value->id;
            $exercise = new ElchiUserExercise($inputs);
            $exercise->save();
        }
        return redirect()->back();
    }
    public function userRegister()
    {
        $registers = TestRegister::orderBy('id','ASC')->get();
        $region = Region::pluck('name','id');
        $district = DB::table('tg_district')->pluck('name','id');
        // return $registers;
        // $register = TestRegister::join('tg_region', function ($join) {
        //     $join->on(function ($on) {
        //         $on->whereJsonContains('tg_test_register.elchi->region', 'tg_region.id');
        //     });
        // })->get();
     
        return view('userControl.register',compact('registers','region','district'));
    }
    public function userCancel(Request $request)
    {   
        $user = TestRegister::where('id',$request->id)->first('elchi');
        $user = json_decode($user->elchi);
        // return $user;
        $response = Http::post('notify.eskiz.uz/api/auth/login', [
            'email' => 'mubashirov2002@gmail.com',
            'password' => 'PM4g0AWXQxRg0cQ2h4Rmn7Ysoi7IuzyMyJ76GuJa'
        ]);
        $token = $response['data']['token'];

        $sms = Http::withToken($token)->post('notify.eskiz.uz/api/message/sms/send', [
            'mobile_phone' => '998'.$user->phone,
            'message' => 'jang.novatio.uz saytida qilgan registratsiyangiz bekor qilindi'.' '.$request->comment,
            'from' => '4546',
            'callback_url' => 'http://0000.uz/test.php'
        ]);
        if($sms['status'])
        {   
            $update = TestRegister::where('id',$request->id)->update([
                'status' => 0,
            ]);
        }
        return [
            'status' => 200,
        ];
    }
    public function userSuccess(Request $request)
    {
        $user = TestRegister::where('id',$request->id)->first('elchi');
        $user = json_decode($user->elchi);
        
        $last_user = User::orderBy('id','DESC')->first('username');
            $username = 'nvt'.(intval(substr($last_user->username,3))+1);
            $password = rand(1000, 9999);
            
            $new = DB::table('tg_user')->insert([
                'password' => Hash::make($password),
                'last_login' => NULL,
                'is_superuser' => FALSE,
                'username' => $username,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone_number' => '+998'.$user->phone,
                'is_staff' => FALSE,
                'is_active' => TRUE,
                'is_verified' => TRUE,
                'date_joined' => date_now(),
                'district_id' => $user->district,
                'region_id' => $user->region,
                'specialty_id' => 1,
                'email' => NULL,
                'tg_id' => 990821015,
                'birthday' => $user->year.'-'.$user->month.'-'.$user->day,
                'admin' => FALSE,
                'write_time' => date_now(),
                'salary' => 1500000,
                'image' => $user->photo,
                'pr' => $password,
                'tg_file_id' => NULL,
                'rol_id' => 27,
                'last_seen' => NULL,
                'teacher' => FALSE,
                'image_change' => TRUE,
                'pharmacy_id' => NULL,
                'image_url' => 'https://telegra.ph//file/04f99aa16eebd4af2a42c.jpg',
                'status' => 1,
                'level' => 0,
                'rm' => 0
            ]);
        
        if($new == 1)
        {
            $response = Http::post('notify.eskiz.uz/api/auth/login', [
                'email' => 'mubashirov2002@gmail.com',
                'password' => 'PM4g0AWXQxRg0cQ2h4Rmn7Ysoi7IuzyMyJ76GuJa'
            ]);
            $token = $response['data']['token'];
    
            $sms = Http::withToken($token)->post('notify.eskiz.uz/api/message/sms/send', [
                'mobile_phone' => '998'.$user->phone,
                'message' => 'jang.novatio.uz saytida qilgan registratsiyangiz qabul qilindi.'.' '.' '.'Login: '.$username.' '.' '.'Parol: '.$password,
                'from' => '4546',
                'callback_url' => 'http://0000.uz/test.php'
            ]);
            if($sms['status'])
            {   
                $update = TestRegister::where('id',$request->id)->update([
                    'status' => 1,
                ]);
            }
        }

        return [
            'status' => 200
        ];
    }
}
