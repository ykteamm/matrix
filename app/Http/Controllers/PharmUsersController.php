<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Models\PharmUser;
use App\Models\User;
use Illuminate\Http\Request;

class PharmUsersController extends Controller
{
    public function index()
    {
        $users=User::where('status',1)->get();
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
}
