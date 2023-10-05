<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Rekrut;
use App\Models\RekrutGroup;
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
                 'rekruts.full_name as fname','rekruts.last_name as lname','rekruts.phone','rekruts.status','rekruts.id as rid','rekruts.comment','rekruts.created_at as dat',
                 'rekruts.age','rekruts.xolat','rekrut_groups.title'
                 )
        ->join('tg_user','tg_user.id','rekruts.rm_id')
        ->join('tg_region','tg_region.id','rekruts.region_id')
        ->join('tg_district','tg_district.id','rekruts.district_id')
        ->join('rekrut_groups','rekrut_groups.id','rekruts.group_id')
        ->whereDate('rekruts.created_at','>=','2023-09-01')
        ->orderBy('rid','DESC')
        ->get();


        $groups = RekrutGroup::all();

        return view('rekrut.add',[
            'regions' => $regions,
            'districts' => $districts,
            'rms' => $rms,
            'rekruts' => $rekruts,
            'teachers' => $teachers,
            'groups' => $groups,
        ]);

    }

    public function changeXolat($id,$xolat)
    {
        $rekrut = Rekrut::find($id);

        $rekrut->xolat = $xolat;

        $rekrut->save();

        return redirect()->back();
    }

    public function changePotok($id,$potok)
    {
        $rekrut = Rekrut::find($id);

        $rekrut->group_id = $potok;

        $rekrut->save();

        return redirect()->back();
    }

    public function saveUser(Request $request)
    {
        // return $request->all();

        if($request->xolat == 4)
        {
            $new = Rekrut::create([
                'full_name' => $request->full_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'region_id' => $request->region_id,
                'district_id' => $request->district_id,
                'rm_id' => $request->rm_id,
                'xolat' => $request->xolat,
                'age' => $request->age,
                'grafik' => $request->grafik,
                'link' => $request->link,
                'group_id' => $request->group_id,
            ]);
        }else{
            $new = Rekrut::create([
                'full_name' => $request->full_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'region_id' => $request->region_id,
                'district_id' => $request->district_id,
                'xolat' => $request->xolat,
                'age' => $request->age,
                'grafik' => $request->grafik,
                'link' => $request->link,
                'group_id' => $request->group_id,
                // 'rm_id' => 178
                'rm_id' => $request->rm_id,


            ]);
        }
        

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
        ->whereDate('rekruts.created_at','>=','2023-09-01')
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

    public function rekrutUstozHisobot($id)
    {

        // $rekruts= DB::table('rekruts')
        // ->select('tg_user.first_name as f','tg_user.last_name as l','tg_region.name as r',
        //          'tg_region.name as r','tg_district.name as d',
        //          'rekruts.full_name as fname','rekruts.phone','rekruts.status','rekruts.comment','rekruts.id'
        //          )
        // ->join('tg_user','tg_user.id','rekruts.rm_id')
        // ->join('tg_region','tg_region.id','rekruts.region_id')
        // ->join('tg_district','tg_district.id','rekruts.district_id')
        // ->where('rekruts.rm_id',Session::get('user')->id)
        // ->whereDate('rekruts.created_at','>=','2023-09-01')
        // ->get();

        $rekrut = Rekrut::with('region')->where('region_id',$id)->where('group_id',2)->whereIn('xolat',[1,2,3])->get();

        return view('rekrut.ustoz',[
            'rekruts' => $rekrut,
        ]);
    }

    public function rekrutEdit($id)
    {

       $rekrut = Rekrut::with('user','region')->find($id);

       $regions = Region::all();

       $districts = DB::table('tg_district')->get();


       $rms = User::whereIn('rm',[1,2])->get();

       $teachers = Teacher::with('user')->get();

       $groups = RekrutGroup::all();

       $xolat[1] = 'O\'ylab koradi';
        $xolat[2] = 'Telefon ko\'tarmadi';
        $xolat[3] = 'O\'qishga keladi';
        $xolat[4] = 'Ustoz bilan gaplashadi';
        $xolat[5] = 'Uyi uzoq';
        $xolat[6] = 'O\'qishga kelolmaydi lekin ishlaydi';
        $xolat[7] = 'Ishlamaydi';

       return view('rekrut.edit',compact('rekrut','regions','districts','rms','teachers','groups','xolat'));
    }

    public function rekrutUpdate(Request $request,$id)
    {

        $rekrut = Rekrut::find($id);
        $rekrut->full_name = $request->full_name;
        $rekrut->last_name = $request->last_name;
        $rekrut->region_id = $request->region_id;
        $rekrut->district_id = $request->district_id;
        $rekrut->xolat = $request->xolat;
        $rekrut->phone = $request->phone;
        $rekrut->age = $request->age;
        $rekrut->grafik = $request->grafik;
        $rekrut->link = $request->link;
        $rekrut->rm_id = $request->rm_id;
        $rekrut->group_id = $request->group_id;

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
                ->whereDate('rekruts.created_at','>=','2023-09-01')
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
