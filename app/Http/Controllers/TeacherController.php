<?php

namespace App\Http\Controllers;

use App\Models\ProductSold;
use App\Models\Region;
use App\Models\Teacher;
use App\Models\TeacherUser;
use App\Models\TeachGradeStar;
use App\Models\TestReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{

    public function index()
    {
        $teachers = User::where('status',1)->get();

        $teachers_user = Teacher::orderBy('active','DESC')->get();

        return view('teacher.index',[
            'teachers' => $teachers,
            'teachers_user' => $teachers_user,
        ]);
    }


    public function store(Request $request)
    {
        $teacher = new Teacher([
            'user_id' => $request->user_id
        ]);

        $teacher->save();

        return redirect()->back();
    }

    public function shogird()
    {
        $users = User::where('status',1)->get();

        $teachers = Teacher::with('user')->where('active',1)->get();

        $teachers_user = TeacherUser::with('user','teacher')->orderBy('id','DESC')->get();

//         return $teachers_user;

        return view('teacher.shogird',[
            'teachers' => $teachers,
            'users' => $users,
            'teachers_user' => $teachers_user,
        ]);

    }

    public function ustozAdd($id)
    {
        $teach = TeacherUser::find($id);

        $teach->ustoz = 1;
        $teach->save();

        return redirect()->back();
    }

    public function ustozStajerMinus($id)
    {
        $teach = TeacherUser::find($id);

        $teach->ustoz = 0;
        $teach->save();

        return redirect()->back();
    }

    public function stajerAdd($id)
    {
        $teach = TeacherUser::find($id);

        $teach->ustoz = 2;
        $teach->save();

        return redirect()->back();
    }

    public function ustozGame($id)
    {
        $teach = TeacherUser::find($id);

        if($teach->game == 1)
        {
            $ust = 0;
        }else{
            $ust = 1;
        }

        $teach->game = $ust;
        $teach->save();

        return redirect()->back();
    }

    public function shogirdUpdateTime(Request $request)
    {
        $inputs=$request->all();
        unset($inputs['_token']);
        foreach ($inputs as $id => $time) {
            TeacherUser::where('id', $id)->update([
                'week_date' => $time
            ]);
        }
        return redirect()->back();
    }

    public function shogirdStore(Request $request)
    {
        $teacher = new TeacherUser([
            'teacher_id' => $request->teacher_id,
            'user_id' => $request->user_id,
            'first_view' => 1,
            'day' => 0,
            'week_date' => date('Y-m-d',strtotime($request->week_date))
        ]);

        $teacher->save();

        return redirect()->back();
    }

    public function grade()
    {
        $baho = TeachGradeStar::with('tester','user')->where('star','!=',0)->orderBy('id','DESC')->get();




        $savol_baho = TestReview::with('tester','user','test')->orderBy('id','DESC')
        ->get();

        // return $savol_baho;

        return view('teacher.grade',[
            'grades' => $baho,
            'questions' => $savol_baho,
        ]);
    }


    public function yetakchi()
    {

        $date=[];
        $date[] = [
            '2023-01-01',
            '2023-01-31',
        ];
        //fev
                $date[] = [
                    '2023-02-01',
                    '2023-02-28',
                ];
        //mart
                $date[] = [
                    '2023-03-01',
                    '2023-03-31',
                ];
        //aprel
                $date[] = [
                    '2023-04-01',
                    '2023-04-30',
                ];
        //may
                $date[] = [
                    '2023-05-01',
                    '2023-05-31',
                ];
        //iyun
                $date[] = [
                    '2023-06-01',
                    '2023-06-30',
                ];
        // iyul
                $date[] = [
                    '2023-07-01',
                    '2023-07-31',
                ];
        //        avg
                $date[] = [
                    '2023-08-01',
                    '2023-08-31',
                ];
        //        sen
                $date[] = [
                    '2023-09-01',
                    '2023-09-30',
                ];
        //        okt
                $date[] = [
                    '2023-10-01',
                    '2023-10-31',
                ];
        //        noyabr
                $date[] = [
                    '2023-11-01',
                    '2023-11-30',
                ];
        //        dekabr
                $date[] = [
                    '2023-12-01',
                    '2023-12-31',
                ];

        $sort = DB::table('tg_productssold')
                ->selectRaw('SUM(tg_productssold.price_product * tg_productssold.number) as allprice, tg_region.id')
                ->join('tg_user', 'tg_user.id', 'tg_productssold.user_id')
                ->join('tg_region', 'tg_region.id', 'tg_user.region_id')
                ->whereDate('created_at','>=','2023-01-01')
                ->whereDate('created_at','<=','2023-12-31')
                ->groupBy('tg_region.id')
                ->orderBy('allprice', 'DESC')
                ->get();


        $regions = [2,3,5,7,12,13,14,11,8,17,10,15,1,6,9];

        $reg = [];
        $elchi = [];
        $name = [];

        foreach ($regions as $index => $region) {
            foreach ($date as $key => $value) {
                $sort = DB::table('tg_productssold')
                ->selectRaw('SUM(tg_productssold.price_product * tg_productssold.number) as allprice')
                ->join('tg_user', 'tg_user.id', 'tg_productssold.user_id')
                ->join('tg_region', 'tg_region.id', 'tg_user.region_id')
                ->whereDate('created_at','>=',$value[0])
                ->whereDate('created_at','<=',$value[1])
                ->where('tg_region.id','=',$region)
                ->orderBy('allprice', 'DESC')
                ->first()->allprice??0;

                $ss = DB::table('tg_productssold')
                ->selectRaw('SUM(tg_productssold.price_product * tg_productssold.number) as allprice')
                ->join('tg_user', 'tg_user.id', 'tg_productssold.user_id')
                ->join('tg_region', 'tg_region.id', 'tg_user.region_id')
                ->whereDate('created_at','>=',$value[0])
                ->whereDate('created_at','<=',$value[1])
                ->where('tg_region.id','=',$region)
                ->where('tg_user.specialty_id','=',1)
                ->orderBy('allprice', 'DESC')
                ->first()->allprice??0;

                $reg[$region][$key] = $sort;
                $elchi[$region][$key] = $ss;

                $name[$region] = Region::find($region)->name;

            }
        }


        return view('teacher.reg2024',[
            'reg' => $reg,
            'elchis' => $elchi,
            'name' => $name,
            'regions' => $regions,
        ]);

    }
}
