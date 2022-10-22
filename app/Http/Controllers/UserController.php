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
        $users=User::where('admin','false')->get();
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
}
