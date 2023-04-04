<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Models\PharmUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmUsersController extends Controller
{
    public function index()
    {
        $phar_user=DB::table('tg_pharm_users')
            ->groupBy('user_id')
            ->get('user_id');
        $arr=[];
        foreach ($phar_user as $id){
            $arr[]=$id->user_id;
        }
        $users=User::where('status',1)
            ->where('admin',TRUE)
            ->whereNotIn('id',$arr)
            ->get();
        $pharmacies=Pharmacy::all();
        return view('pharmuser.index',compact('users','pharmacies'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'user_id'=>'required',
           'pharmacy_id'=>'required'
        ]);
        $r=$request->all();
        unset($r['_token']);
        $id=$r['user_id'];
        foreach ($r['pharmacy_id'] as $item){
            $p=new PharmUser();
            $p->user_id=$id;
            $p->pharmacy_id=$item;
            $p->save();
        }
        return redirect()->back();
    }

    public function allshow()
    {
        $pharm=User::where('admin',TRUE)->with('admin_pharmacies')->get();
        $arr=[];
        foreach ($pharm as $p){
            if(isset($p->admin_pharmacies[0])){
                $arr[]=$p;
            }
        }
        return view('pharmuser.show',compact('arr'));
    }

    public function allshowbypharm()
    {
        $arr=Pharmacy::with('pharm_users')->get();
        return view('pharmuser.showbypharm',compact('arr'));
    }

    public function edit($id)
    {
        $pharm_user=PharmUser::where('user_id',$id)->get();
        $pharmacy=Pharmacy::all();
//        dd($pharm_user);
        // return $pharm_user;
        $user=User::where('id',$id)->first();
        return view('pharmuser.edit',compact('id','pharm_user','user','pharmacy'));
    }

    public function editby($id)
    {
        $pharm_user=PharmUser::where('pharmacy_id',$id)->get();
        $users=User::where('admin',TRUE)->get();
//        dd($pharm_user);
        $pharmacy=Pharmacy::where('id',$id)->first();
        return view('pharmuser.editby',compact('id','pharm_user','users','pharmacy'));
    }

    public function updateby(Request $request, $id)
    {
        $r=$request->all();
        unset($r['_token']);
        if(isset($r['pharmacy_id'])){

            $pharm_user=PharmUser::where('user_id',$id)->get();
            // dd($pharm_user);
            if(isset($pharm_user[0])) {
                foreach ($pharm_user as $p) {
                    $i = 0;

                    foreach ($r['pharmacy_id'] as $item) {

                        $query = PharmUser::where('user_id', $id)->where('pharmacy_id', $item)->first();

                        if (!$query) {
                            $newP = new PharmUser();
                            $newP->pharmacy_id = $item;
                            $newP->user_id = $id;
                            $newP->save();
                        }
                        if ($p->pharmacy_id == $item) {
                            $i++;
                        }

                    }
                    if ($i == 0) {
                        PharmUser::where('user_id', $id)->where('pharmacy_id', $p->pharmacy_id)->delete();
                    }
                }
            }else{
                foreach ($r['pharmacy_id'] as $item) {
                    $p = new PharmUser();
                    $p->pharmacy_id = $item;
                    $p->user_id = $id;
                    $p->save();
                }
            }
        }else{
            PharmUser::where('user_id',$id)->delete();
        }
        return redirect()->route('pharm.users.bypharm');

    }
    public function update(Request $request, $id)
    {
        $r=$request->all();
        unset($r['_token']);

        if(isset($r['pharmacy_id'])){
            $pharm_user=PharmUser::where('user_id',$id)->get();
            foreach ($pharm_user as $p){
                $i=0;
                foreach ($r['pharmacy_id'] as $item){

                    $query=PharmUser::where('user_id',$id)->where('pharmacy_id',$item)->first();
                    if(!$query){
                        $p=new PharmUser();
                        $p->user_id=$id;
                        $p->pharmacy_id=$item;
                        $p->save();
                    }
                    if ($p->pharmacy_id==$item){
                        $i++;
                    }


                }
                if($i==0){
                    PharmUser::where('user_id',$id)->where('pharmacy_id',$p->pharmacy_id)->delete();
                }
            }
        }
        else{
            PharmUser::where('pharmacy_id',$id)->delete();
        }
        return redirect()->back();
    }
}
