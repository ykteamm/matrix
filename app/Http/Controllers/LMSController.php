<?php

namespace App\Http\Controllers;

use App\Models\DailyWork;
use App\Models\Pharmacy;
use App\Models\PharmacyUser;
use App\Models\Teacher;
use App\Models\TeacherUser;
use App\Models\TestRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class LMSController extends Controller
{
    public function index()
    {
        $course = DB::table('lms_courses')->where('status',0)->first();
        $module = DB::table('lms_module')->where('course_id',$course ? $course->id : null)->first();
        $lesson = DB::table('lms_lesson')->where('module_id',$module ? $module->id : null)->first();
        $group_test = DB::table('lms_group_tests')->where('lesson_id',$lesson ? $lesson->id : null)->first();

        $answer_check = DB::table('lms_answer_check')
            ->where([
                'course_id'=>$course ? $course->id: null,
                'module_id'=>$module ? $module->id: null,
                'lesson_id'=>$lesson ? $lesson->id : null,
            ])
            ->where('foiz', '>=', $group_test ? $group_test->ball : null)
            ->get();
//        return $answer_check;

        $answer_user_id = [];
        $test = [];
        foreach ($answer_check as $ids){
            $answer_user_id[] = $ids->user_id;
            $data = [
                'user_id' => $ids->user_id,
                'foiz' => $ids->foiz,
            ];
            $test[] = $data;
        }

//        return $test;
//        return $answer_user_id;
        $users_passed = DB::table('lms_passed')
            ->where([
                'course_id'=> $course->id,
                'module_id'=>$module->id,
                'lesson_id'=>$lesson->id,
                'pass_status'=>1,
            ])
            ->whereIn('user_id',$answer_user_id)
            ->get();

        $passed_user_id = [];
        foreach ($users_passed as $user)
        {
            $passed_user_id[] = $user->user_id;
        }

        $user_check = DB::table('lms_users_check')->pluck('user_id')->toArray();

//        return $user_check;

        $users = DB::table('lms_users')
            ->select(
                'lms_users.id', 'lms_users.id', 'lms_users.first_name', 'lms_users.last_name', 'lms_users.birthday', 'lms_users.region_id', 'lms_users.district_id',
                'lms_users.phone', 'lms_users.image', 'lms_users.passport_image', 'lms_users.status', 'lms_users.rol_id',
                'lms_users.username','lms_users.date_joined','lms_users.date_register','lms_users.tg_user_id','tg_region.name as region_name','tg_district.name as district_name'
            )
            ->join('tg_region', 'tg_region.id', '=', 'lms_users.region_id')
            ->join('tg_district','tg_district.id','=','lms_users.district_id')
            ->whereIn('lms_users.id',$passed_user_id)
            ->whereNotIn('lms_users.id',$user_check)
            ->get();

        $teachers = Teacher::select('teachers.*', 'tg_user.first_name as user_first_name', 'tg_user.last_name as user_last_name')
            ->join('tg_user', 'tg_user.id', 'teachers.user_id')
            ->get();

//       return $teachers;

        return view('lms.index',compact('users','answer_check','test','teachers'));
    }

    public function UserCheck(Request $request)
    {

        $data = $request->all();
        $user_check = DB::table('lms_users_check')
            ->insert([
                'user_id'=>$data['user_id'],
                'video'=>$data['video'],
                'one_day_apteka'=>$data['one_day_apteka'],
                'test'=>$data['test'],
                'created_at'=> now(),
            ]);
        DB::table('lms_users')->where('id',$data['user_id'])
            ->update([
                'status'=>1,
                'date_joined'=>now(),
                'date_register'=>now(),
            ]);
        $lms_user = DB::table('lms_users')->where('id',$data['user_id'])->first();

        $username = $lms_user->username;
        $password = preg_replace("/[^0-9]/", "", $username);

        $new = DB::table('tg_user')->insertGetId([
            'password' => Hash::make($password),
            'last_login' => NULL,
            'is_superuser' => FALSE,
            'username' => $lms_user->username,
            'first_name' => $lms_user->first_name,
            'last_name' => $lms_user->last_name,
            'phone_number' => $lms_user->phone,
            'is_staff' => FALSE,
            'is_active' => TRUE,
            'is_verified' => TRUE,
            'date_joined' => date_now(),
            'district_id' => $lms_user->district_id,
            'region_id' => $lms_user->region_id,
            'specialty_id' => 1,
            'email' => NULL,
            'tg_id' => 990821015,
            'birthday' => $lms_user->birthday,
            'admin' => FALSE,
            'write_time' => date_now(),
            'salary' => 1500000,
            'pr' => $password,
            'tg_file_id' => NULL,
            'rol_id' => 27,
            'last_seen' => NULL,
            'teacher' => FALSE,
            'image_change' => TRUE,
            'pharmacy_id' => NULL,
            'image_url' => 'https://academy.novatio.uz/storage/'.$lms_user->image,
            'status' => 0,
            'level' => 0,
            'rm' => 0,
            'first_enter' => 0,
            'img_photo' => $lms_user->image,
            'img_passport' => $lms_user->passport_image,
        ]);

        if ($new) {
            $response = Http::post('notify.eskiz.uz/api/auth/login', [
                'email' => 'mubashirov2002@gmail.com',
                'password' => 'PM4g0AWXQxRg0cQ2h4Rmn7Ysoi7IuzyMyJ76GuJa'
            ]);
            $token = $response['data']['token'];

            $sms = Http::withToken($token)->post('notify.eskiz.uz/api/message/sms/send', [
                'mobile_phone' => $lms_user->phone,
//                Siz tasdiqlangdingiz
                'message' => 'Siz tasdiqlandingiz. Endi jang.novatio.uz saytiga ushbu login va parol orqali kirasiz.' . ' ' . ' ' . 'Login: ' . $username . ' ' . ' ' . 'Parol: ' . $password . '. Ishlaringizga omad!',
                'from' => '4546',
                'callback_url' => 'http://0000.uz/test.php'
            ]);

            DailyWork::create([
                'user_id' => $new,
                'start_work' => $data['start_work'],
                'finish_work' => $data['end_work'],
                'start' => '2023-03-15'
            ]);
            PharmacyUser::create([
                'user_id' => $new,
                'pharma_id' => $data['pharma_id'],
            ]);

            TeacherUser::create([
                'teacher_id' => $data['teacher_id'],
                'user_id' => $new,
                'week_date'=> now()->format('Y-m-d'),
            ]);

            DB::table('lms_users')->where('id',$data['user_id'])->update([
                'tg_user_id'=>$new
            ]);
        }

        return redirect(route('lms-index'));
    }

}
