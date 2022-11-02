<?php

namespace App\Http\Controllers;

use App\Models\NewUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        $users=User::get();
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
    public function addUser(Request $request)
    {
        $r=$request->all();
        unset($r['_token']);
//        dd($arr);
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
}
