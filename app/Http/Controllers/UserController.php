<?php

namespace App\Http\Controllers;

use App\Models\AllProduct;
use App\Models\District;
use App\Models\NewUsers;
use App\Models\User;
use App\Models\Member;
use App\Models\Ball;
use App\Models\BattleDay;
use App\Models\BattleHistory;
use App\Models\Blacklist;
use App\Models\Calendar;
use App\Models\DailyWork;
use App\Models\Detail;
use App\Models\ElchiBattleSetting;
use App\Models\Medicine;
use App\Models\Price;
use App\Models\Exercise;
use App\Models\ElchiExercise;
use App\Models\ElchiUserExercise;
use App\Models\NewElchi;
use App\Models\Pharmacy;
use App\Models\PharmacyUser;
use App\Models\ProductSold;
use App\Models\TestRegister;
use App\Models\Region;
use App\Models\Teacher;
use App\Models\TeacherUser;
use App\Models\UserBattle;
use App\Models\UserCrystall;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Services\ElchiService;
use App\Services\ElchiBattleService;
use App\Services\UserMoneyService;
use App\Services\WorkDayServices;

class UserController extends Controller
{
    public UserMoneyService $userMoney;
    public function __construct(UserMoneyService $um)
    {
        $this->userMoney = $um;
    }
    public function blackList()
    {
        $blackList = fn($active) => DB::select("SELECT
            u.id,
            u.first_name AS f,
            u.last_name AS l,
            b.active,
            COALESCE(SUM(CASE WHEN DATE(p.created_at) BETWEEN DATE(date_trunc('month', now()))  AND DATE(date_trunc('month', now()) + interval '1 month - 1 day') THEN p.number * p.price_product END), 0) AS nowmonth,
            COALESCE(SUM(CASE WHEN DATE(p.created_at) BETWEEN DATE(date_trunc('month', now()) - interval '1 month')  AND DATE(date_trunc('month', now()) - interval '1 day') THEN p.number * p.price_product END), 0) AS onemonthago,
            COALESCE(SUM(CASE WHEN DATE(p.created_at) BETWEEN DATE(date_trunc('month', now()) - interval '2 month')  AND DATE(date_trunc('month', now()) - interval '1 month 1 day') THEN p.number * p.price_product END), 0) AS twomonthago
            FROM blacklists AS b
            LEFT JOIN tg_user AS u ON u.id = b.user_id
            LEFT JOIN tg_productssold AS p ON p.user_id = u.id
            WHERE b.active = ?
            GROUP BY u.id, b.id
        ", [$active]);

        $blocked = $blackList(1);
        $other = $blackList(0);
        return view('userControl.blacklist', compact('blocked', 'other'));
    }
    public function blackListRemove(Request $request)
    {
        $inputs = $request->all();
        unset($inputs['_token']);
        foreach ($inputs as $id => $id) {
            Blacklist::where('user_id', $id)->update([
                'active' => 0
            ]);
        }
        return back();
    }
    public function userMoney($region_id,$month)
    {




        $data = [];

        // $month = $month->input('_month') ?? date('Y-m');

        $currentDate = date('Y-m-d');

        $last_date = Carbon::createFromFormat('Y-m-d', $month . '-01')
            ->lastOfMonth()
            ->format('Y-m-d');

        if (strtotime($currentDate) > strtotime($last_date)) {
            $active = 1;
        } else {
            $active = 0;
        }

        $data = [];
        $regions = Region::all();

        if($region_id == 'all')
        {
            $regText = 'Hammasi';
        }else{
            $regText = Region::find($region_id)->name;
        }

        if($region_id == 'all')
        {
            $regis = Region::pluck('id')->toArray();

            $regi = DB::table('tg_region')
            ->selectRaw('tg_region.*, COUNT(tg_region.id) AS count')
            ->whereIn('tg_region.id',$regis)
            ->leftJoin('tg_user', 'tg_user.region_id', 'tg_region.id')
            ->orderBy('count', 'DESC')
            ->groupBy('tg_region.id')
            ->get();
        }else{
            $regi = DB::table('tg_region')
            ->selectRaw('tg_region.*, COUNT(tg_region.id) AS count')
            ->where('tg_region.id',$region_id)
            ->leftJoin('tg_user', 'tg_user.region_id', 'tg_region.id')
            ->orderBy('count', 'DESC')
            ->groupBy('tg_region.id')
            ->get();
        }


        foreach ($regi as $region) {

            $reg = ['sum' => 0, 'users' => [], 'name' => $region->name, 'id' => $region->id];

            $users = ProductSold::select('tg_user.id')
                ->whereDate('tg_productssold.created_at','>=',$month.'-01')
                ->whereDate('tg_productssold.created_at','<=',$last_date)
                // ->where('tg_user.id', 108)
                ->whereIn('tg_user.status', [0,1,2])
                ->where('tg_region.id', $region->id)
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->distinct('id')
                ->pluck('id')
                ->toArray();


            foreach ($users as $id) {
                $id = 533;
                $month = '2024-01';
                $service = new WorkDayServices($id, $active);
                $userData = $service->getMonthMaosh($month);
                $reg['sum'] += ($userData['maosh'] - $userData['jarima']);
                $reg['users'][] = $userData;
            }
            $data[$region->name] = $reg;
        }


        $yearMonths = Calendar::whereDate('created_at', '>=', '2023-02-24')->pluck('year_month')->toArray();

        // dd($data);

        return view('userControl.user-money', compact('data', 'yearMonths', 'month','regions','regText','region_id'));
    }
    public function userMoneyProfil($id, $month)
    {
        $currentDate = date('Y-m-d');
        $last_date = Carbon::createFromFormat('Y-m-d', $month . '-01')
            ->lastOfMonth()
            ->format('Y-m-d');

        if (strtotime($currentDate) > strtotime($last_date)) {
            $active = 1;
        } else {
            $active = 0;
        }

        // $active = 1;

        $service = new WorkDayServices($id, $active);


        $userData = $service->getMonthMaoshKunlik($month);


        // $yearMonths = ['2023-03','2023-04'];

        $yearMonths = Calendar::whereDate('created_at', '>=', '2023-02-24')->pluck('year_month')->toArray();

        // dd($userData);

        return view('userControl.user-money-profil', compact('userData', 'yearMonths', 'month', 'id'));

        // return $userData;
    }
    public function index()
    {
        $users = User::where('status', 1)->where('rm', '!=', 1)
            ->where('level', '!=', 2)
            ->orderBy('id')->get();
        $unemployes = User::where('status', 2)->orderBy('id')->get();
        $newemployes = User::where('status', 0)->orderBy('id')->get();
        $testusers = User::where('status', 3)->orderBy('id')->get();
        $rms = User::where('rm', 1)->orderBy('id')->get();
        $caps = User::where('level', 2)->orderBy('id')->get();
        // $new_users = NewUsers::all();
        // return $users;
        // $arr = [];
        // foreach ($new_users as $user) {
        //     $d = json_decode($user->message);
        //     if (isset($d->data)) {
        //         $arr[] = array('id' => $user->id, 'tg_id' => $user->tg_id, 'data' => $d->data);
        //     }
        // }
        return view('userControl.index', compact('users', 'testusers', 'unemployes', 'newemployes', 'rms', 'caps'));
    }

    public function controlWorker(Request $request, $action)
    {

        $r = $request->all();
        unset($r['_token']);
        foreach ($r as $key => $item) {
            if ($item == 'id') {
                $id = substr($key, 3);
                DB::table('tg_user')
                    ->where('id', $id)
                    ->update([
                        'status' => $action ?? 2,
                        'work_end' => date("Y-m-d")
                    ]);
            }
            if ($item == 'test') {
                $test = substr($key, 5);

                DB::table('tg_user')
                    ->where('id', $test)
                    ->update(['status' => 3]);
            }
            if ($item == 'rm') {
                $test = substr($key, 3);
                $rm = DB::table('tg_user')
                    ->where('id', $test)->first();
                $json = [
                    "dash" => "true",
                    "bilim" => "true",
                    "elchi" => "true",
                    "grade" => "true",
                    "pharmacy" => "true",
                ];
                $new = DB::table('tg_positions')
                    ->insertGetId([
                        'position_json' => json_encode($json),
                        'rol_name' => 'RM-' . $rm->first_name,
                        'created_at' => date_now(),
                        'update_at' => date_now(),
                    ]);
                DB::table('tg_user')
                    ->where('id', $test)
                    ->update(['rm' => 1, 'rol_id' => $new]);
            }
            if ($item == 'cap') {
                $test = substr($key, 4);
                $rm = DB::table('tg_user')
                    ->where('id', $test)->first();
                if ($rm->rm != 1) {
                    $json = [
                        "dash" => "true",
                        "bilim" => "true",
                        "elchi" => "true",
                        "grade" => "true",
                        "pharmacy" => "true",
                    ];
                    $new = DB::table('tg_positions')
                        ->insertGetId([
                            'position_json' => json_encode($json),
                            'rol_name' => 'Capitan-' . $rm->first_name,
                            'created_at' => date_now(),
                            'update_at' => date_now(),
                        ]);
                    DB::table('tg_user')
                        ->where('id', $test)
                        ->update(['level' => 2, 'rol_id' => $new]);
                } else {
                    DB::table('tg_user')
                        ->where('id', $test)
                        ->update(['level' => 2]);
                }
            }
        }
        return redirect()->back();
    }

    public function userRm(Request $request)
    {
        $r = $request->all();
        unset($r['_token']);
        foreach ($r as $key => $item) {
            if ($item == 'rm') {
                $test = substr($key, 3);
                $cap = DB::table('tg_user')
                    ->where('id', $test)->first();
                if ($cap->level != 2) {
                    $rol_id = DB::table('tg_user')->where('id', $test)->first();
                    DB::table('tg_positions')->where('id', $rol_id->rol_id)->delete();
                }

                DB::table('tg_user')
                    ->where('id', $test)
                    ->update(['rm' => 0, 'rol_id' => NULL]);
            }
        }
        return redirect()->back();
    }
    public function userCap(Request $request)
    {
        $r = $request->all();
        unset($r['_token']);

        foreach ($r as $key => $item) {
            if ($item == 'cap') {
                $test = substr($key, 4);
                $rm = DB::table('tg_user')
                    ->where('id', $test)->first('rm');
                if ($rm->rm != 1) {
                    $rol_id = DB::table('tg_user')->where('id', $test)->first();
                    DB::table('tg_positions')->where('id', $rol_id->rol_id)->delete();
                    DB::table('tg_user')
                        ->where('id', $test)
                        ->update(['level' => 1, 'rol_id' => NULL]);
                } else {
                    DB::table('tg_user')
                        ->where('id', $test)
                        ->update(['level' => 1]);
                }
            }
        }
        return redirect()->back();
    }
    public function userTest(Request $request)
    {
        $r = $request->all();
        unset($r['_token']);

        foreach ($r as $key => $item) {
            if ($item == 'test') {
                $test = substr($key, 5);

                DB::table('tg_user')
                    ->where('id', $test)
                    ->update([
                        'status' => 1,
                        'work_start' => date("Y-m-d"),
                        'work_end' => NULL
                    ]);
            }
        }
        return redirect()->back();
    }
    public function userNew(Request $request)
    {
        $r = $request->all();
        unset($r['_token']);

        foreach ($r as $key => $item) {
            if ($item == 'new') {
                $id = substr($key, 4);
                DB::table('tg_user')
                    ->where('id', $id)
                    ->update([
                        'status' => 1,
                        'work_start' => date("Y-m-d"),
                        'work_end' => NULL
                    ]);
            }
        }
        return redirect()->back();
    }
    public function userExit(Request $request)
    {
        $r = $request->all();
        unset($r['_token']);
        foreach ($r as $key => $item) {
            if ($item == 'exit') {
                $test = substr($key, 5);
                DB::table('tg_user')
                    ->where('id', $test)->update([
                        'status' => 1,
                        'work_start' => date("Y-m-d"),
                        'work_end' => NULL
                    ]);
            }
        }
        return redirect()->back();
    }
    public function addUser(Request $request)
    {
        $r = $request->all();
        unset($r['_token']);
        foreach ($r as $key => $item) {
            $id[] = substr($key, 3);
        }
        foreach ($id as $item) {
            $response = Http::post('http://128.199.2.165:8100/api/v1/user/create/', [
                'tg_id' => $item,
            ]);
            return $response;
        }

        return redirect()->back();
    }
    public function adminList(Request $request)
    {
        $elchi = DB::table('tg_user')
            ->where('admin', TRUE)
            ->where('rm', 0)
            ->select('tg_user.last_seen', 'tg_positions.id as pid', 'tg_positions.rol_name', 'tg_user.id', 'tg_user.tg_id', 'tg_user.username', 'tg_user.birthday', 'tg_user.phone_number', 'tg_user.first_name', 'tg_user.last_name', 'tg_region.name as v_name')
            ->join('tg_region', 'tg_region.id', 'tg_user.region_id')
            ->leftjoin('tg_positions', 'tg_positions.id', 'tg_user.rol_id')
            ->orderBy('tg_user.last_seen', 'ASC')
            ->get();
        $posi = DB::table('tg_positions')->get();
        return view('rol-setting.user', compact('elchi', 'posi'));
    }
    public function rmList(Request $request)
    {

        $elchi = DB::table('tg_user')
            ->where('rm', 1)
            ->select('tg_user.last_seen', 'tg_positions.id as pid', 'tg_positions.rol_name', 'tg_user.id', 'tg_user.tg_id', 'tg_user.username', 'tg_user.birthday', 'tg_user.phone_number', 'tg_user.first_name', 'tg_user.last_name', 'tg_region.name as v_name')
            ->join('tg_region', 'tg_region.id', 'tg_user.region_id')
            ->leftjoin('tg_positions', 'tg_positions.id', 'tg_user.rol_id')
            ->orderBy('tg_user.last_seen', 'ASC')
            ->get();
        $posi = DB::table('tg_positions')->get();
        return view('rol-setting.user', compact('elchi', 'posi'));
    }
    public function capList(Request $request)
    {

        $elchi = DB::table('tg_user')
            ->where('level', 2)
            ->select('tg_user.last_seen', 'tg_positions.id as pid', 'tg_positions.rol_name', 'tg_user.id', 'tg_user.tg_id', 'tg_user.username', 'tg_user.birthday', 'tg_user.phone_number', 'tg_user.first_name', 'tg_user.last_name', 'tg_region.name as v_name')
            ->join('tg_region', 'tg_region.id', 'tg_user.region_id')
            ->leftjoin('tg_positions', 'tg_positions.id', 'tg_user.rol_id')
            ->orderBy('tg_user.last_seen', 'ASC')
            ->get();
        $posi = DB::table('tg_positions')->get();
        return view('rol-setting.user', compact('elchi', 'posi'));
    }
    public function userList(Request $request)
    {

        $elchi = DB::table('tg_user')
            ->whereIn('level', [0, 1])
            ->where('admin', FALSE)
            ->where('rm', 0)
            ->select('tg_user.last_seen', 'tg_positions.id as pid', 'tg_positions.rol_name', 'tg_user.id', 'tg_user.tg_id', 'tg_user.username', 'tg_user.birthday', 'tg_user.phone_number', 'tg_user.first_name', 'tg_user.last_name', 'tg_region.name as v_name')
            ->join('tg_region', 'tg_region.id', 'tg_user.region_id')
            ->leftjoin('tg_positions', 'tg_positions.id', 'tg_user.rol_id')
            ->orderBy('tg_user.last_seen', 'ASC')
            ->get();
        $posi = DB::table('tg_positions')->get();
        return view('rol-setting.user', compact('elchi', 'posi'));
    }


    public function elchiBattleSelect()
    {
        $endday = date('Y-m-d', (strtotime('-1 day', strtotime(Carbon::now()))));
        $startday = date('Y-m-d', (strtotime('-7 day', strtotime(Carbon::now()))));
        $all_user = User::pluck('id');
        $users = [];
        foreach ($all_user as $id) {
            $transactions = ProductSold::whereBetween('created_at', [$startday, $endday])
                ->select(DB::raw('DATE(created_at) as date'))
                ->where('user_id', $id)
                ->groupBy('date')
                ->get('date');
            $sizeof = sizeof($transactions);
            if ($sizeof >= 3) {
                $users[] = $id;
            }
        }
        $userid = User::with('battle_user1', 'battle_user2')->whereIn('id', $users)->get();
        // return $userid;
        // $battle_day = BattleDay::with('u1id','u2id')->where('u1id',27)->orWhere('u2id',27)->get();
        // return $battle_day;

        return view('elchilar.select', compact('userid'));
    }
    public function elchiBattleSelectStore(Request $request)
    {

        if ($request->user1 == $request->user2) {
            return redirect()->back();
        }
        $userIn[] = $request->user1;
        $userIn[] = $request->user2;

        $user1 = UserBattle::where('u1id', $request->user1)->orWhere('u2id', $request->user1)->where('ends', 0)->orderBy('id', 'DESC')->limit(1)->get();
        $user2 = UserBattle::where('u1id', $request->user2)->orWhere('u2id', $request->user2)->where('ends', 0)->orderBy('id', 'DESC')->limit(1)->get();
        // return $user2;

        if ($user1[0]->end_day >= $user2[0]->end_day) {
            $st_day = $user1[0]->end_day;
            $start_index_day = date('Y-m-d', (strtotime('+1 day', strtotime($st_day))));
            $end_index_day = date('Y-m-d', (strtotime('+' . $request->day . ' day', strtotime($st_day))));

            $arrayDate = array();
            $Variable1 = strtotime($start_index_day);
            $Variable2 = strtotime($end_index_day);
            $sum = 0;
            for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) {
                $Store = date('w', $currentDate);
                if ($Store == 0) {
                    $sum += 1;
                } else {
                    $arrayDate[] = date('Y-m-d', $currentDate);
                }
            }
            if ($sum > 0) {
                for ($i = 1; $i <= $sum; $i++) {
                    $ends = date('w', (strtotime('+1 day', strtotime(end($arrayDate)))));
                    if ($ends == 0) {
                        $endsw = date('Y-m-d', (strtotime('+2 day', strtotime(end($arrayDate)))));
                    } else {
                        $endsw = date('Y-m-d', (strtotime('+1 day', strtotime(end($arrayDate)))));
                    }
                    $arrayDate[] = $endsw;
                }
            }
            $start_day = $arrayDate[0];
            $end_day = end($arrayDate);
            $new_battle = new UserBattle([
                'u1id' => $request->user1,
                'u2id' => $request->user2,
                'price1' => 0,
                'price2' => 0,
                'days' => $request->day,
                'start_day' => $start_day,
                'end_day' => $end_day,
            ]);
            $new_battle->save();
        } else {
            $st_day = $user2[0]->end_day;
            $start_index_day = date('Y-m-d', (strtotime('+1 day', strtotime($st_day))));
            $end_index_day = date('Y-m-d', (strtotime('+' . $request->day . ' day', strtotime($st_day))));

            $arrayDate = array();
            $Variable1 = strtotime($start_index_day);
            $Variable2 = strtotime($end_index_day);
            $sum = 0;
            for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) {
                $Store = date('w', $currentDate);
                if ($Store == 0) {
                    $sum += 1;
                } else {
                    $arrayDate[] = date('Y-m-d', $currentDate);
                }
            }
            if ($sum > 0) {
                for ($i = 1; $i <= $sum; $i++) {
                    $ends = date('w', (strtotime('+1 day', strtotime(end($arrayDate)))));
                    if ($ends == 0) {
                        $endsw = date('Y-m-d', (strtotime('+2 day', strtotime(end($arrayDate)))));
                    } else {
                        $endsw = date('Y-m-d', (strtotime('+1 day', strtotime(end($arrayDate)))));
                    }
                    $arrayDate[] = $endsw;
                }
            }
            $start_day = $arrayDate[0];
            $end_day = end($arrayDate);
            $new_battle = new UserBattle([
                'u1id' => $request->user1,
                'u2id' => $request->user2,
                'price1' => 0,
                'price2' => 0,
                'days' => $request->day,
                'start_day' => $start_day,
                'end_day' => $end_day,
            ]);
            $new_battle->save();
        }


        return redirect()->back();
    }

    public function elchiHis($id)
    {
        $getter = BattleHistory::where('win_user_id', $id)
            ->orWhere('lose_user_id', $id)->get();
        // return $getter;
        return view('elchilar.history', compact('getter', 'id'));
    }
    public function elchiBattleExercise()
    {
        $medicine = Medicine::orderBy('id', 'ASC')->get();
        $price = Price::where('shablon_id', 3)->get();
        return view('elchilar.exercise', compact('medicine', 'price'));
        // return $shablon;
    }
    public function elchiBattleExerciseStore(Request $request)
    {
        $inputs = $request->all();
        unset($inputs['_token']);
        $exercise = new Exercise($inputs);
        $exercise->save();
        if ($exercise->id) {
            return redirect()->back();
        }
    }
    public function elchiUserBattleExercise()
    {
        $medicine = Medicine::orderBy('id', 'ASC')->get();
        $price = Price::where('shablon_id', 3)->get();
        return view('elchilar.user-exercise', compact('medicine', 'price'));
        // return $shablon;
    }
    public function elchiUserBattleExerciseStore(Request $request)
    {
        // return $request;
        $inputs = $request->all();
        unset($inputs['_token']);
        $users = User::where('admin', 'false')->get();
        foreach ($users as $key => $value) {
            $inputs['user_id'] = $value->id;
            $exercise = new ElchiUserExercise($inputs);
            $exercise->save();
        }
        return redirect()->back();
    }

    public function userBindPharmacy(Request $request)
    {
        DB::table('tg_pharmacy_users')->insert([
            'user_id' => $request->input('user_id'),
            'pharma_id' => $request->input('pharma_id')
        ]);
        return back();
    }

    public function userWithoutPharmacy()
    {
        $idArr = DB::table('tg_pharmacy_users')->pluck('user_id')->toArray();
        $users = User::with('region', 'region.pharmacy')
            ->whereNotIn('id', $idArr)
            ->where('admin', FALSE)
            ->where('status', '!=', 3)
            ->get();
        return view('userControl.withoutpharm', compact('users'));
    }

    public function usersCrystall()
    {
        $users = User::select('tg_user.id','tg_user.username','tg_user.first_name', 'tg_user.last_name', 'uc.crystall')
            ->leftJoin('user_crystalls AS uc','uc.user_id', 'tg_user.id')
            // ->where('tg_user.status', 1)
            ->orderBy('tg_user.id', 'DESC')
            ->get();
        return view('userControl.users-crystall', compact('users'));
    }

    public function changeCrystall(Request $request)
    {
        $r = $request->all();
        unset($r['_token']);
        foreach ($r as $key => $value) {
            $user_id = substr($key, 9);
            $userCrystal = UserCrystall::where('user_id', $user_id)->first();
            if($userCrystal) {
                UserCrystall::where('id', $userCrystal->id)->update([
                    'crystall' =>  $value
                ]);
            } else {
                UserCrystall::create([
                    'user_id' => $user_id,
                    'crystall' => $value ?? 0
                ]);
            }
        }
        return back();
    }


    public function allUsers()
    {
        $users = User::select('tg_user.*', 'tg_region.name as region_name', 'daily_works.start_work', 'daily_works.finish_work')
            ->join('tg_region', 'tg_region.id', 'tg_user.region_id')
//            ->leftJoin('daily_works', 'daily_works.user_id', 'tg_user.id')
//                new active 1 all
            ->leftJoin('daily_works', function ($join) {
                $join->on('daily_works.user_id', 'tg_user.id')
                    ->where('daily_works.active', 1); // Add a condition to filter only active records
            })
//            end
            ->groupBy('tg_user.id', 'daily_works.id', 'region_name')
            // ->where('daily_works.active', 1)
            ->orderBy('tg_user.id', 'DESC')
            ->get();
        // dd($users[0]);
        return view('userControl.users', compact('users'));
    }

    public function ViewUsers($id)
    {
        $user = User::find($id);
        if (!$user){
            abort(404);
        }

        $users = User::select('tg_user.*', 'tg_region.name as region_name', 'daily_works.start_work', 'daily_works.finish_work')
            ->join('tg_region', 'tg_region.id', 'tg_user.region_id')
            ->leftJoin('daily_works', 'daily_works.user_id', 'tg_user.id')
            ->groupBy('tg_user.id', 'daily_works.id', 'region_name')
            ->where('tg_user.id',$id)
            // ->where('daily_works.active', 1)
            ->orderBy('tg_user.id', 'DESC')
            ->first();
        // dd($users[0]);

        $region = Region::get(['name','id']);

        $district = District::get(['name','id','region_id']);

        $pharmacyId = DB::table('tg_pharmacy_users')->where('user_id', $users->id)->pluck('pharma_id');

        $pharmacy_name = DB::table('tg_pharmacy')->get();

        $product_sold = ProductSold::
        select(
            'order_id',
            'user_id',
            DB::raw('SUM(number * price_product) as total'),
            DB::raw('SUM(number) as number'),
            DB::raw('tg_pharmacy.name as pharmacy_name'),
            DB::raw('MAX(tg_productssold.created_at) as created_at'),
        )

            ->leftJoin('tg_pharmacy', 'tg_pharmacy.id', 'tg_productssold.pharm_id')
            ->where('user_id',$users->id)
            ->groupBy('order_id','user_id','tg_pharmacy.name')
            ->orderByDesc('order_id')
            ->limit(10)
            ->get();

        $daily_works = DailyWork::where('user_id',$users->id)->get();


        return view('userControl.users-view', compact('users','id','region','district','pharmacyId','pharmacy_name','product_sold','daily_works'));
    }

    public function CreatePharm(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'pharma_id'=>'required',
        ]);

        $pharm_create = new PharmacyUser();
        $pharm_create->user_id = $request->user_id;
        $pharm_create->pharma_id = $request->pharma_id;

        if (!$pharm_create->save())
        {
            return redirect(route('users-view',['id'=>$request->user_id]))->with('error', 'Does not create pharm!');
        }
        return redirect(route('users-view',['id'=>$request->user_id]))->with('success', 'Pharm successfull created!');
    }

    public function DeletePharm(Request $request,$id)
    {

        $pharmacyUser = PharmacyUser::where('pharma_id', $id)->first();

        if ($pharmacyUser) {
            $pharmacyUser->delete();
            return redirect(route('users-view', ['id' => $request->user_id]))->with('success', 'Pharm successfull deleted!');
        } else {
            // Handle the case where the record is not found
            return redirect()->back()->with('error', 'Record not found.');
        }
    }

    public function DeleteOrder(Request $request,$id)
    {
        $pharmacyUsers = ProductSold::where('order_id', $id)->get();

        if ($pharmacyUsers->isNotEmpty()) {
            foreach ($pharmacyUsers as $pharmacyUser) {
                $pharmacyUser->delete();
            }

            return redirect(route('users-view', ['id' => $request->user_id]))->with('success', 'Successfully deleted!');
        } else {
            // Handle the case where no records were found
            return redirect()->back()->with('error', 'No records found for the given order ID.');
        }

    }

    public function changeRegion(Request $request)
    {
        $data = District::select('id','name')->where('region_id',$request->region_id)->get();
        return response()->json($data);
    }

    public function UpdateOrder(Request $request, $id)
    {
        $order = DB::table('tg_order')->where('id',$id)->update([
            'pharm_id'=>$request->pharm_id,
           'created_at'=>$request->created_at
        ]);

        $user_data = DB::table('tg_productssold')->where('order_id',$id)->update([
            'pharm_id'=>$request->pharm_id,
            'created_at'=>$request->created_at
        ]);
        if (!($user_data && $order)){
            return redirect(route('users-view'))->with('error', 'Order does not updated!');
        }
        return redirect(route('users-view',['id'=>$request->user_id]))->with('success', 'Order successfull updated!');
    }

    public function UpdateUsers(Request $request, $id)
    {
        $user_data = DB::table('tg_user')->where('id',$id)->update([
            'id'=>$request->id,
            'status'=>$request->status,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'region_id'=>$request->region_id,
            'district_id'=>$request->district_id,
        ]);

        if (!$user_data){
            return redirect(route('users-view'))->with('Error', 'User does not updated!');
        }
        return redirect(route('users-view',['id'=>$id]))->with('success', 'User successfull updated!');
    }

    public function UpdateStartWork(Request $request, $id)
    {
        if ($request->finish_date == null){
            $user_data = DailyWork::where(['id'=>$id,'user_id'=>$request->user_id])->update([
                'user_id'=>$request->user_id,
                'start_work'=>$request->start_work,
                'finish_work'=>$request->finish_work,
               // 'finish'=>date('Y-m-d', strtotime($request->finish_date)),
                'start'=>date('Y-m-d', strtotime($request->start_date)),
            ]);
            if (!$user_data){
                return redirect(route('users-view'))->with('Error', 'Work Time does not updated!');
            }
            return redirect(route('users-view',['id'=>$request->user_id]))->with('success', 'Work time successfull updated!');
        }else{
            $user_data = DailyWork::where(['id'=>$id,'user_id'=>$request->user_id])->update([
                'user_id'=>$request->user_id,
                'start_work'=>$request->start_work,
                'finish_work'=>$request->finish_work,
                'finish'=>date('Y-m-d', strtotime($request->finish_date)),
                'start'=>date('Y-m-d', strtotime($request->start_date)),
            ]);
            if (!$user_data){
                return redirect(route('users-view'))->with('Error', 'Work Time does not updated!');
            }
            return redirect(route('users-view',['id'=>$request->user_id]))->with('success', 'Work time successfull updated!');
        }


    }


    public function CreateStartWork(Request $request)
    {
//        $req = $request->all();

        if ($request->user_id && $request->start_date && $request->start_work && $request->finish_work) {
            $Daily = DailyWork::where('user_id', $request->user_id)->orderBy('id', 'DESC')->first();
            if ($Daily){
                $ends = date('Y-m-d', (strtotime('-1 day', strtotime($request->start_date))));
                DailyWork::where('id', $Daily->id)->update([
                    'finish' => $ends,
                    'active' => 0
                ]);
                DailyWork::create([
                    'user_id' => $request->user_id,
                    'start_work' => $request->start_work,
                    'finish_work' => $request->finish_work,
                    'start' =>  date('Y-m-d', strtotime($request->start_date))  // $request->start_date  //date("Y-m-d")
                ]);
                return redirect(route('users-view',['id'=>$request->user_id]))->with('success', 'User successfull Start Work!');
            } else {
                DailyWork::create([
                    'user_id' => $request->user_id,
                    'start_work' => $request->start_work,
                    'finish_work' => $request->finish_work,
                    'start' => date('Y-m-d', strtotime($request->start_date)) // $request->start_date // date("Y-m-d")
                ]);
                return redirect(route('users-view',['id'=>$request->user_id]))->with('success', 'User successfull Work!');
            }
        }
        return redirect(route('users-view',['id'=>$request->user_id]))->with('Error', 'User does not created start work!');

    }

    public function assignDailyWork(Request $request)
    {
        // return $request;
        $r = $request->all();
        unset($r['_token']);
        foreach ($r as $key => $value) {
            if ($value == 'change') {
                $user_id = substr($key, 7);


                if($r['endwork_' . $user_id] != null)
                {
                    DB::table('tg_user')->where('id', $user_id)->update([
                        'work_end' => $r['endwork_' . $user_id],
                    ]);
                }else{
                    $userDaily = DailyWork::where('user_id', $user_id)->orderBy('id', 'DESC')->first();
                    if ($userDaily) {
                    $ends = date('Y-m-d', (strtotime('-1 day', strtotime(date("Y-m-d")))));

                    DailyWork::where('id', $userDaily->id)->update([
                        'finish' => $ends,
                        'active' => 0
                    ]);
                    DailyWork::create([
                        'user_id' => $user_id,
                        'start_work' => $r['start_' . $user_id],
                        'finish_work' => $r['finish_' . $user_id],
                        'start' => date("Y-m-d")
                    ]);
                    } else {
                        DailyWork::create([
                            'user_id' => $user_id,
                            'start_work' => $r['start_' . $user_id],
                            'finish_work' => $r['finish_' . $user_id],
                            'start' => date("Y-m-d")
                        ]);
                    }
                }


            }
        }
        return back();
    }

    public function userRegister()
    {
        $registers = TestRegister::orderBy('id', 'ASC')->get();
        $region = Region::pluck('name', 'id');
        $district = DB::table('tg_district')->pluck('name', 'id');
        $host = substr(request()->getHttpHost(), 0, 3);


        $pharmacy = Pharmacy::all();
        $teacher = Teacher::all();

        // return $teacher;
        // return $registers;
        // $register = TestRegister::join('tg_region', function ($join) {
        //     $join->on(function ($on) {
        //         $on->whereJsonContains('tg_test_register.elchi->region', 'tg_region.id');
        //     });
        // })->get();

        return view('userControl.register', compact('registers', 'region', 'district', 'host', 'pharmacy', 'teacher'));
    }
    public function userCancel(Request $request)
    {
        $user = TestRegister::where('id', $request->id)->first('elchi');
        $user = json_decode($user->elchi);
        // return $user;
        $response = Http::post('notify.eskiz.uz/api/auth/login', [
            'email' => 'mubashirov2002@gmail.com',
            'password' => 'PM4g0AWXQxRg0cQ2h4Rmn7Ysoi7IuzyMyJ76GuJa'
        ]);
        $token = $response['data']['token'];

        $sms = Http::withToken($token)->post('notify.eskiz.uz/api/message/sms/send', [
            'mobile_phone' => '998' . $user->phone,
            'message' => 'jang.novatio.uz saytida qilgan registratsiyangiz bekor qilindi' . ' ' . $request->comment,
            'from' => '4546',
            'callback_url' => 'http://0000.uz/test.php'
        ]);
        if ($sms['status']) {
            $update = TestRegister::where('id', $request->id)->update([
                'status' => 0,
            ]);
        }
        return [
            'status' => 200,
        ];
    }
    public function userSuccess(Request $request, $id)
    {


        $user = TestRegister::where('id', $id)->first('elchi');
        $user = json_decode($user->elchi);
        // return $user;

        $last_user = User::orderBy('id', 'DESC')->first('username');
        $username = 'nvt' . (intval(substr($last_user->username, 3)) + 1);
        $password = rand(1000, 9999);

        if (intval($user->lavozim) == 1) {
            $spe_id = 1;
            $status = 0;
            if (!isset($request->teacher_id)) {
                return redirect()->back();
            }
        } else {
            $spe_id = 9;
            $status = 1;
        }

        $new = DB::table('tg_user')->insertGetId([
            'password' => Hash::make($password),
            'last_login' => NULL,
            'is_superuser' => FALSE,
            'username' => $username,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone_number' => '+998' . $user->phone,
            'is_staff' => FALSE,
            'is_active' => TRUE,
            'is_verified' => TRUE,
            'date_joined' => date_now(),
            'district_id' => $user->district,
            'region_id' => $user->region,
            'specialty_id' => $spe_id,
            'email' => NULL,
            'tg_id' => 990821015,
            'birthday' => $user->year . '-' . $user->month . '-' . $user->day,
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
            'image_url' => 'https://telegra.ph//file/04f99aa16eebd4af2a42c.jpg',
            'status' => $status,
            'level' => 0,
            'rm' => 0,
            'first_enter' => 0,
            'img_photo' => $user->photo,
            'img_passport' => $user->passport,

        ]);
        // $new_work_day = DB::table('daily_works')->insert([
        //     'user_id' => $new,
        //     'start_work' => '09:00:00',
        //     'finish_work' => '18:00:00',
        // ]);
        if ($new) {
            $response = Http::post('notify.eskiz.uz/api/auth/login', [
                'email' => 'mubashirov2002@gmail.com',
                'password' => 'PM4g0AWXQxRg0cQ2h4Rmn7Ysoi7IuzyMyJ76GuJa'
            ]);
            $token = $response['data']['token'];

            $sms = Http::withToken($token)->post('notify.eskiz.uz/api/message/sms/send', [
                'mobile_phone' => '998' . $user->phone,
                'message' => 'jang.novatio.uz saytida qilgan registratsiyangiz qabul qilindi.' . ' ' . ' ' . 'Login: ' . $username . ' ' . ' ' . 'Parol: ' . $password,
                'from' => '4546',
                'callback_url' => 'http://0000.uz/test.php'
            ]);
            if ($sms['status']) {
                $update = TestRegister::where('id', $request->id)->update([
                    'status' => 1,
                ]);
            }

            DailyWork::create([
                'user_id' => $new,
                'start_work' => $request->start_work,
                'finish_work' => $request->end_work,
                'start' => '2023-03-15'
            ]);

            PharmacyUser::create([
                'user_id' => $new,
                'pharma_id' => $request->pharma_id,
            ]);

            if (intval($user->lavozim) == 1) {
                TeacherUser::create([
                    'teacher_id' => $request->teacher_id,
                    'user_id' => $new,
                ]);
            }
        }

        return redirect()->back();
    }

    public function rePassword()
    {
        $users = User::all();

        return view('repas',compact('users'));
    }

    public function rePasswordPass()
    {

        $users = User::all();

        foreach ($users as $key => $value) {
            $update = DB::table('tg_user')->where('id',$value->id)->update([
                'password' => Hash::make($value->pr)
            ]);
        }
        return redirect()->back();
    }

    public function rePasswordPass423423()
    {
        $users = User::all();

        $nomer = [];

        foreach ($users as $key => $value) {
            $new = random_int(1000, 9999);

            $update = DB::table('tg_user')->where('id',$value->id)->update([
                'pr' => $new
            ]);
            $nomer = $value->phone_number;

            $response = Http::post('notify.eskiz.uz/api/auth/login', [
                'email' => 'mubashirov2002@gmail.com',
                'password' => 'PM4g0AWXQxRg0cQ2h4Rmn7Ysoi7IuzyMyJ76GuJa'
            ]);
            $token = $response['data']['token'];

                $sms = Http::withToken($token)->post('notify.eskiz.uz/api/message/sms/send', [
                    'mobile_phone' => substr($nomer,1),
                    'message' => 'Sizning yangi parolingiz' . ' ' . ' ' . 'Login: ' . $value->username . ' ' . ' ' . 'Parol: ' . $new,
                    'from' => '4546',
                    'callback_url' => 'http://0000.uz/test.php'
                ]);

        }


        return redirect()->back();

    }
}
