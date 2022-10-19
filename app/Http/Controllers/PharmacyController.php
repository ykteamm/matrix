<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PharmacyUser;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\DB;
use Session;

class PharmacyController extends Controller
{
    public function pharmaUserStore(Request $request,$id)
    {
        $new = new PharmacyUser([
            'user_id' => $id,
            'pharma_id' => $request->pharma_id
        ]);

        $new->save();
        return redirect()->back();
    }
    public function userPharmaStore(Request $request,$id)
    {
        $new = new PharmacyUser([
            'user_id' => $request->user_id,
            'pharma_id' => $id
        ]);

        $new->save();
        return redirect()->back();
    }
    public function pharmacy($id)
    {
        $pharma = Pharmacy::find($id);


        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $regions = DB::table('tg_region')->get();

        }else{
            $r_id_array = [];
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)){
               $r_id_array[] = $key;
                }
            }

        }
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $users = DB::table('tg_user')
        ->where('tg_user.admin',FALSE)
        
        ->get();


        }else{
            $users = DB::table('tg_user')
            ->where('tg_user.admin',FALSE)
            ->whereIn('region_id',$r_id_array)->get();

        }
        return view('pharmacy-index',compact('pharma','users'));
    }

}
