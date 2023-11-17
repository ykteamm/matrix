<?php

namespace App\Http\Controllers;

use App\Models\ProductSold;
use App\Models\Region;
use App\Models\Rekrut;
use App\Models\RekrutGroup;
use App\Models\Teacher;
use App\Models\TeacherUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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
                 'rekruts.age','rekruts.xolat','rekrut_groups.title','rekruts.sms'
                 )
        ->join('tg_user','tg_user.id','rekruts.rm_id')
        ->join('tg_region','tg_region.id','rekruts.region_id')
        ->join('tg_district','tg_district.id','rekruts.district_id')
        ->join('rekrut_groups','rekrut_groups.id','rekruts.group_id')
        ->whereDate('rekruts.created_at','>=','2023-09-01')
        ->orderBy('rid','DESC')
        ->get();


        $sms = DB::table('rekruts')->where('sms','>',0)->pluck('id')->toArray();

        $smar = [];

        foreach ($sms as $key => $value) {

            $bir = DB::table('academy_answer')->where('user_id',$value)->where('check',1)->count();
            $nol = DB::table('academy_answer')->where('user_id',$value)->where('check',0)->count();
           
            if(($bir+$nol) > 0)
            {
                $pr = ($bir*100)/($bir+$nol);

                $smar[$value] = $pr;
            }else{

                $smar[$value] = 0;
            }
           

        }

        // return $sms;

        $groups = RekrutGroup::all();

        return view('rekrut.add',[
            'regions' => $regions,
            'districts' => $districts,
            'rms' => $rms,
            'rekruts' => $rekruts,
            'teachers' => $teachers,
            'groups' => $groups,
            'smar' => $smar,
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
// fsdfsdf
        $igs = RekrutGroup::orderBy('id','DESC')->first();


        $date=date_create(date('Y-m-d'));
        date_modify($date,"-1 days");
        $ddd = date_format($date,"Y-m-d");
// gfgf
        // $rekrut = Rekrut::with('region')->where('region_id',$id)->where('group_id',$igs->id)
        $rekrut = Rekrut::with('region')->where('region_id',$id)
        // ->whereIn('xolat',[1,2,3,4])
        ->whereDate('created_at','>=','2023-11-17')
        ->whereDate('created_at','<=','2023-11-17')
        ->orderBy('district_id','ASC')
        ->get();

        $district = DB::table('tg_district')->pluck('name','id')->toArray();

        return view('rekrut.ustoz',[
            'rekruts' => $rekrut,
            'district' => $district,
        ]);
    }

    public function ustoz50()
    {
        $sold[5] = [5,437,488,477,490];
        $shogird[5] = 3;

        $sold[33] = [33,483,447,443,396];
        $shogird[33] = 2;

        $sold[177] = [177,441,467,453];
        $shogird[177] = 2;

        $sold[232] = [232,486,476,469,466,459];
        $shogird[232] = 4;

        $sold[79] = [79,473,439,479,480];
        $shogird[79] = 1;

        $sold[160] = [160,470,472,491];
        $shogird[160] = 3;

        $art = [];

        foreach ($sold as $key => $value) {
            $rekrut = ProductSold::whereIn('user_id',$value)
                    ->whereDate('created_at','>=','2023-10-01')
                    ->whereDate('created_at','<=','2023-10-31')
                    ->sum(DB::raw('price_product*number'));

            $ustoz = User::find($key);

            $art[] = ['fakt' => $rekrut,'ustoz'=> $ustoz->first_name.'-'.$ustoz->last_name,'shogird' => $shogird[$key]];


        }

        $price = array_column($art, 'fakt');
        array_multisort($price, SORT_DESC, $art);

        return $art;

    }

    public function ustoz70()
    {
        $sold[5] = [5,437,498,488,490,504,511];
        $shogird[5] = 6;

        $sold[33] = [33,483,447,443,495];
        $shogird[33] = 4;

        $sold[177] = [177,467,512];
        $shogird[177] = 2;

        $sold[232] = [232,486,469,466,459,503];
        $shogird[232] = 5;

        $sold[79] = [79,500,501,502];
        $shogird[79] = 3;

        $sold[160] = [160,470,472,491];
        $shogird[160] = 3;

        $art = [];

        foreach ($sold as $key => $value) {
            $rekrut = ProductSold::whereIn('user_id',$value)
                    ->whereDate('created_at','>=','2023-11-01')
                    ->whereDate('created_at','<=','2023-11-30')
                    ->sum(DB::raw('price_product*number'));

            $ustoz = User::find($key);

            $art[] = ['fakt' => $rekrut,'ustoz'=> $ustoz->first_name.'-'.$ustoz->last_name,'shogird' => $shogird[$key]];


        }

        $price = array_column($art, 'fakt');
        array_multisort($price, SORT_DESC, $art);

        return $art;

    }

    public function rekrutSMS($id)
    {   
        $rekrut = Rekrut::find($id);


        $response = Http::post('notify.eskiz.uz/api/auth/login', [
            'email' => 'mubashirov2002@gmail.com',
            'password' => 'PM4g0AWXQxRg0cQ2h4Rmn7Ysoi7IuzyMyJ76GuJa'
        ]);
        $token = $response['data']['token'];

        $sms = Http::withToken($token)->post('notify.eskiz.uz/api/message/sms/send', [
            'mobile_phone' => substr($rekrut->phone,1),
            'message' => 'Saytga kiring kompaniya haqidagi videoni ko\'ring va testlarga javob bering. 5 millonlik ishni qo\'lga kiriting.' . ' Videoni ko\'rish uchun ustiga bosing ' . ' academy.novatio.uz/'.substr($rekrut->phone,1),
            'from' => '4546',
            'callback_url' => 'http://0000.uz/test.php'
        ]);

        $rekrut = Rekrut::find($id);
        $rekrut->sms = $rekrut->sms + 1;
        $rekrut->save();

        return redirect()->back();
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
