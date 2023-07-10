<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Rekrut;
use App\Models\Teacher;
use App\Models\TeacherUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RekrutController extends Controller
{
    public function addUser()
    {
        $regions = Region::all();
        $districts = DB::table('tg_district')->get();

        $rms = User::whereIn('rm',[1,2])->get();

        $teachers = Teacher::with('user')->get();

        $rekruts= DB::table('rekruts')
        ->select('tg_user.first_name as f','tg_user.last_name as l','tg_region.name as r',
                 'tg_region.name as r','tg_district.name as d',
                 'rekruts.full_name as fname','rekruts.phone','rekruts.status','rekruts.id as rid','rekruts.comment'
                 )
        ->join('tg_user','tg_user.id','rekruts.rm_id')
        ->join('tg_region','tg_region.id','rekruts.region_id')
        ->join('tg_district','tg_district.id','rekruts.district_id')
        ->orderBy('rid','ASC')
        ->get();

        return view('rekrut.add',[
            'regions' => $regions,
            'districts' => $districts,
            'rms' => $rms,
            'rekruts' => $rekruts,
            'teachers' => $teachers,
        ]);

    }
    public function saveUser(Request $request)
    {
        $new = Rekrut::create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'region_id' => $request->region_id,
            'district_id' => $request->district_id,
            'rm_id' => $request->rm_id,
        ]);

        return redirect()->back();
    }
    public function rekrut()
    {

        $rekruts= DB::table('rekruts')
        ->select('tg_user.first_name as f','tg_user.last_name as l','tg_region.name as r',
                 'tg_region.name as r','tg_district.name as d',
                 'rekruts.full_name as fname','rekruts.phone','rekruts.status','rekruts.comment','rekruts.id'
                 )
        ->join('tg_user','tg_user.id','rekruts.rm_id')
        ->join('tg_region','tg_region.id','rekruts.region_id')
        ->join('tg_district','tg_district.id','rekruts.district_id')
        ->where('rekruts.rm_id',Session::get('user')->id)
        ->get();

        return view('rekrut.rm',[
            'rekruts' => $rekruts,
        ]);
    }
    public function rekrutCheck(Request $request,$id)
    {

       $rekrut = Rekrut::find($id);
       $rekrut->status = $request->status;
       $rekrut->comment = $request->comment;
       $rekrut->save();

       return redirect()->back();
    }

    public function rekrutHisobot()
    {
        $regions = Region::all();

        $reg = [];

        foreach ($regions as $key => $value) {
            $rekruts= DB::table('rekruts')
                ->select('tg_user.first_name as f','tg_user.last_name as l','tg_region.name as r',
                        'tg_region.name as r','tg_district.name as d',
                        'rekruts.full_name as fname','rekruts.phone','rekruts.status','rekruts.comment','rekruts.id','tg_region.id as tid'
                        )
                ->join('tg_user','tg_user.id','rekruts.rm_id')
                ->join('tg_region','tg_region.id','rekruts.region_id')
                ->join('tg_district','tg_district.id','rekruts.district_id')
                ->where('tg_region.id',$value->id)
                ->get();
            if(count($rekruts) > 0)
            {
                $reg[] = array('region' => $value->name,'data' => $rekruts);
            }

        }


        return view('rekrut.hisobot',[
            'reg' => $reg,
        ]);
    }

    public function change($id)
    {
        $rekrut = Rekrut::find($id);
        $status = $rekrut->status;
        if($status == 1)
        {
            $rekrut->status = 2;
        }
        if($status == 2)
        {
            $rekrut->status = 1;
        }
        $rekrut->save();

        return redirect()->back();
    }

    public function delete($id)
    {
        $rekrut = Rekrut::destroy($id);

        return redirect()->back();
    }
}
