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
        $host = substr(request()->getHttpHost(),0,3);

        // return $registers;
        // $register = TestRegister::join('tg_region', function ($join) {
        //     $join->on(function ($on) {
        //         $on->whereJsonContains('tg_test_register.elchi->region', 'tg_region.id');
        //     });
        // })->get();
     
        return view('userControl.register',compact('registers','region','district','host'));
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
