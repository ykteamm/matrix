<?php

namespace App\Http\Controllers;

use App\Models\Jamoa;
use App\Models\ProductSold;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JamoalarController extends Controller
{
    public function index(){

        $teachers = Teacher::select('teachers.*', 'tg_user.first_name as user_first_name', 'tg_user.last_name as user_last_name')
            ->join('tg_user', 'tg_user.id', 'teachers.user_id')
            ->get();

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
                    ->whereDate('created_at', '=', '2023-06-27')
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
                    ->whereDate('created_at', '=', '2023-06-27')
                    ->orderBy('date', 'DESC')
                    ->groupBy('date','user_id'); // teacher relationship orqali id va name ustunlarini olish
//                    ->get();
            }])
            ->get()->toArray();

//return $teacherUsers;

// total

//        $from = '2023-11-10';
//        $to = '2023-11-13';
//        $total = ProductSold::
//        whereBetween('created_at', [$from, $to])
//            ->select(DB::raw('DATE(created_at) as date'),DB::raw('SUM(number * price_product) as totalSum'))
////            ->whereDate('created_at', '=', '2023-03-11')
//            ->where('user_id',323)
//            ->groupBy('date')
//            ->get();
//
//        return $total;
//end total

        $totals = ProductSold::
            select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(number * price_product) as totalSum')
                )
            ->whereDate('created_at', '=', '2023-11-13')
            ->orderBy('date', 'DESC')
            ->groupBy('date')
            ->get();

//        return $totals;

        return view('jamoalar.index',compact('teachers','members','jamoaUsers','teacherUsers'));
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

}
