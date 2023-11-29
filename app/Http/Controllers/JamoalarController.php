<?php

namespace App\Http\Controllers;

use App\Models\Jamoa;
use App\Models\JamoaPlan;
use App\Models\ProductSold;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JamoalarController extends Controller
{
    public function index(){

        $teachers = Teacher::select('teachers.*', 'tg_user.first_name as user_first_name', 'tg_user.last_name as user_last_name')
            ->join('tg_user', 'tg_user.id', 'teachers.user_id')
            ->get();
//        return $teachers;

        $members = User::select('tg_user.*', 'tg_user.first_name as user_first_name', 'tg_user.last_name as user_last_name')
            ->leftJoin('teachers', 'teachers.user_id', '=', 'tg_user.id')
            ->whereNull('teachers.user_id')
            ->whereNotIn('tg_user.id', function ($query) {
                $query->select('user_id')->from('tg_jamoalar');
            })
            ->get();
//return $members;

        $jamoaUsers = Jamoa::
            join('tg_user', 'tg_jamoalar.teacher_id', '=', 'tg_user.id')
            ->select('tg_jamoalar.teacher_id', 'tg_user.first_name', 'tg_user.last_name','tg_user.id')
            ->distinct()
            ->with(['teacher_id' => function ($teacher) {
                $teacher
                    ->select('user_id',
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(number * price_product) as totalSum')
                )
                    ->whereDate('created_at', '=', date('Y-m-d'))
                    ->orderBy('date', 'DESC')
                    ->groupBy('date','user_id'); // teacher relationship orqali id va name ustunlarini olish
//                    ->get();
            }])
            ->get()->toArray();

//        return $jamoaUsers;
        $teacherUsers = Jamoa::select('tg_user.first_name', 'tg_user.last_name','tg_user.id','teacher_id','user_id')
            ->join('tg_user', 'tg_jamoalar.user_id', '=', 'tg_user.id')
            ->with(['user_id' => function ($user) {
                $user
                    ->select('user_id',
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('SUM(number * price_product) as totalSum')
                    )
                    ->whereDate('created_at', '=', date('Y-m-d'))
                    ->orderBy('date', 'DESC')
                    ->groupBy('date','user_id'); // teacher relationship orqali id va name ustunlarini olish
//                    ->get();
            }])
            ->get()->toArray();

//        return date('Y-m-d');

//return $teacherUsers;

        $user_id = User::select('id','first_name','last_name')
            ->get();

        $plan_jamoa = JamoaPlan::select('id','user_id','plan_pul','start_day','end_day')->get();
//        return $plan_jamoa;

        return view('jamoalar.index',compact('teachers','members','jamoaUsers','teacherUsers','user_id','plan_jamoa'));
    }

    public function CreatePlan(Request $request){
        $request->validate([
            'user_id'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'plan_pul'=>'required',
        ]);
        $plan = new JamoaPlan();
        $plan->user_id = $request->user_id;
        $plan->plan_pul = $request->plan_pul;
        $plan->start_day = $request->start_date;
        $plan->end_day = $request->end_date;

        if (!$plan->save())
        {
            return redirect(route('jamoalar'))->with('error', 'Does not create plan!');
        }
        return redirect(route('jamoalar'))->with('success', 'User Plan successfull created!');
    }

    public  function UpdatePlan(Request $request,$id){

        $plan_data = JamoaPlan::find($id);
        $input = $request->all();
        $plan_data->update($input);
        $request->validate([
            'user_id'=>'required',
            'start_day'=>'required',
            'end_day'=>'required',
            'plan_pul'=>'required',
        ]);
        $plan_data->user_id = $request->user_id;
        $plan_data->start_day = $request->start_day;
        $plan_data->end_day = $request->end_day;
        $plan_data->plan_pul = $request->plan_pul;

        if ($plan_data->save()) {
            return redirect(route('jamoalar'))->with('success', 'User Plan successfully updated!');
        } else {
            return redirect(route('jamoalar'))->with('error', 'Failed to update plan!');
        }

    }

    public function SelectDate(Request $request) {
        $SelectTeacherUsers = Jamoa::select('tg_user.first_name', 'tg_user.last_name', 'tg_user.id', 'teacher_id', 'user_id')
            ->join('tg_user', 'tg_jamoalar.user_id', '=', 'tg_user.id')
            ->with(['user_id' => function ($user) use ($request) {
                $user
                    ->select('user_id',
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('SUM(number * price_product) as totalSum')
                    )
                    ->whereBetween('created_at', [$request->start_date, $request->end_date])
                    ->orderBy('date', 'DESC')
                    ->groupBy('date', 'user_id');
            }])
            ->get()
            ->toArray();
//        return $teacherUsers;
        $SelectJamoaUsers = Jamoa::
        join('tg_user', 'tg_jamoalar.teacher_id', '=', 'tg_user.id')
            ->select('tg_jamoalar.teacher_id', 'tg_user.first_name', 'tg_user.last_name','tg_user.id')
            ->distinct()
            ->with(['teacher_id' => function ($teacher) use ($request) {
                $teacher
                    ->select('user_id',
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('SUM(number * price_product) as totalSum')
                    )
//                    ->whereDate('created_at', '=', '2023-06-27')
                    ->whereBetween('created_at', [$request->start_date, $request->end_date])
                    ->orderBy('date', 'DESC')
                    ->groupBy('date','user_id'); // teacher relationship orqali id va name ustunlarini olish
//                    ->get();
            }])
            ->get()->toArray();


        $start_date = $request->start_date;
        $end_date = $request->end_date;
//        return $jamoaUsers;

        return view('jamoalar.select-date',compact('SelectTeacherUsers','SelectJamoaUsers','start_date','end_date'));
    }

    public function CreateJamoa(Request $request)
    {
        $request->validate([
            'teacher_id'=>'required',
            'member_id'=>'required',
        ]);

        $jamoa = new Jamoa();
        $jamoa->user_id = $request->member_id;
        $jamoa->teacher_id = $request->teacher_id;

        if (!$jamoa->save())
        {
            return redirect(route('jamoalar'))->with('error', 'Does not create jamoa!');
        }
        return redirect(route('jamoalar'))->with('success', 'Jamoa successfull created!');

    }

    public function DeleteJamoa($user_id)
    {
        $deleteJamoa = Jamoa::where('user_id', $user_id)->first();

        if ($deleteJamoa) {
            $deleteJamoa->delete();
            return redirect(route('jamoalar'))->with('success', $user_id . 'User ID successfull deleted!');
        } else {
            // Handle the case where the record is not found
            return redirect(route('jamoalar'))->with('error', 'Error');
        }
    }

    public function IsTeacherOrUser($id){

        $teachers = Teacher::select('user_id','tg_user.first_name as user_first_name', 'tg_user.last_name as user_last_name','teachers.user_id as sold_id')
            ->join('tg_user', 'tg_user.id', 'teachers.user_id')
            ->where('teachers.user_id',$id)
            ->with(['plan_id'=> function($user){
                $user->select('user_id','plan_pul','start_day','end_day');
            }])
//            ->with(['sold_id'=> function($sold){
//                $sold->select('user_id',
//                DB::raw('DATE(created_at) as date'),
//                DB::raw('SUM(number * price_product) as totalSum')
//                )
//                ->whereDate('created_at', '=', date('Y-m-d') )
//                ->orderBy('date', 'DESC')
//                ->groupBy('date','id');
//            }])
            ->with(['sold_id'=>function($user_id){
                $user_id->select('tg_productssold.user_id',
                    DB::raw('DATE(tg_productssold.created_at) as date'),
                    DB::raw("TO_CHAR(tg_productssold.created_at,'Day') as week_day"),
                    DB::raw('SUM(tg_productssold.number * tg_productssold.price_product) as totalSum'),
                    DB::raw('DATE(MAX(tg_jamoalar_plan.start_day)) as start_day'),
                    DB::raw('DATE(MAX(tg_jamoalar_plan.end_day)) as end_day'),
//                        DB::raw('tg_jamoalar_plan.start_day::timestamp as start'),
//                        DB::raw('tg_jamoalar_plan.end_day::timestamp as end')
                )
                    ->join('tg_jamoalar_plan', 'tg_jamoalar_plan.user_id', '=', 'tg_productssold.user_id')
                    ->whereBetween('tg_productssold.created_at',[
                        DB::raw('tg_jamoalar_plan.start_day::timestamp'),
                        DB::raw('tg_jamoalar_plan.end_day::timestamp')
                    ])
//                    ->whereBetween('tg_productssold.created_at',['2023-11-18', '2023-11-27'])
//                    ->whereDate('tg_productssold.created_at', '=', date('Y-m-d') )
                    ->groupBy('date','tg_productssold.user_id','week_day','start_day','end_day');
            }])
            ->with(['members'=>function($jamoa){
                $jamoa->select('teacher_id','user_id');
                $jamoa->with(['user_id'=>function($user_id){
                    $user_id->select('tg_productssold.user_id',
                    DB::raw('DATE(tg_productssold.created_at) as date'),
                    DB::raw("TO_CHAR(tg_productssold.created_at,'Day') as week_day"),
                    DB::raw('SUM(tg_productssold.number * tg_productssold.price_product) as totalSum'),
                    DB::raw('DATE(MAX(tg_jamoalar_plan.start_day)) as start_day'),
                    DB::raw('DATE(MAX(tg_jamoalar_plan.end_day)) as end_day'),
//                        DB::raw('tg_jamoalar_plan.start_day::timestamp as start'),
//                        DB::raw('tg_jamoalar_plan.end_day::timestamp as end')
                    )
                    ->join('tg_jamoalar_plan', 'tg_jamoalar_plan.user_id', '=', 'tg_productssold.user_id')
                        ->whereBetween('tg_productssold.created_at',[
                            DB::raw('tg_jamoalar_plan.start_day::timestamp'),
                            DB::raw('tg_jamoalar_plan.end_day::timestamp')
                        ])
//                    ->whereBetween('tg_productssold.created_at',['2023-11-18', '2023-11-27'])
//                    ->whereDate('tg_productssold.created_at', '=', date('Y-m-d') )
                    ->groupBy('date','tg_productssold.user_id','week_day','start_day','end_day');
                }])
                ->with(['plan_id'=>function($plan){
                    $plan->select('user_id','plan_pul','start_day','end_day');
                }]);
            }])
            ->first();

        return $teachers;

//        $members = User::select('tg_user.id as user_id','tg_user.first_name as user_first_name', 'tg_user.last_name as user_last_name','tg_user.id as sold_id')
//            ->leftJoin('teachers', 'teachers.user_id', '=', 'tg_user.id')
//            ->whereNull('teachers.user_id')
//            ->whereNotIn('tg_user.id', function ($query) {
//                $query->select('user_id')->from('tg_jamoalar');
//            })
//            ->with(['plan_id'=> function($user){
//                $user->select('user_id','plan_pul','start_day','end_day');
//            }])
//            ->with(['sold_id'=> function($sold){
//                $sold->select('user_id',
//                    DB::raw('DATE(created_at) as date'),
//                    DB::raw('SUM(number * price_product) as totalSum')
//                )
//                    ->whereDate('created_at', '=', date('Y-m-d') )
//                    ->orderBy('date', 'DESC')
//                    ->groupBy('date','id');
//            }])
//            ->where('tg_user.id',$id)
//            ->first();
//        return $members;

        if ($teachers){
            return $teachers;
        }
        elseif ($members){
            return $members;
        }else{
            return abort(404);
        }
//        return now();

    }
}
