<?php

namespace App\Http\Controllers;

use App\Interfaces\Repositories\SMSRepository;
use App\Interfaces\Repositories\ShiftRepository;
use App\Models\KingSold;
use App\Models\LigaKingSold;
use App\Models\LigaKingUser;
use App\Models\Order;
use App\Models\ProductSold;
use App\Models\Shift;
use App\Models\User;
use App\Models\UserBattle;
use App\Services\KingSoldSearchService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ToolzController extends Controller
{
    private SMSRepository $smsRepository;
    private ShiftRepository $shiftRepository;
    public function __construct(
        SMSRepository $sms,
        ShiftRepository $shift
    ) {
        $this->smsRepository = $sms;
        $this->shiftRepository = $shift;
    }
    private const ERRORS = [
        'kun_soni' => 'Kun soni yo\'q',
        'beyjik_yoq' => 'Bejyik yo\'q',
        'xalat_yoq' => 'Xalat yo\'q',
        'lokatsiya_notogri' => 'Lokatsiya noto\'g\'ri'
    ];
    private const MIN_FINE = 10000;

    public function openSmena(Request $request)
    {
        $date = $request->input('smena_date');
        $paginated = true;
        $host = substr(request()->getHttpHost(), 0, 3);
        $uncheckedshifts = $this->shiftRepository->unchecked();
        $checkedshifts = $this->shiftRepository->checked($date, $paginated);
        return view('toolz.open-smena', compact('checkedshifts', 'host', 'uncheckedshifts', 'date', 'paginated'));
    }

    public function closeSmena(Request $request)
    {
        $date = $request->input('smena_date');
        $paginated = true;
        $host = substr(request()->getHttpHost(), 0, 3);
        $uncheckedshifts = $this->shiftRepository->unchecked('admin_check_close', 2);
        $checkedshifts = $this->shiftRepository->checked($date, $paginated, 'admin_check_close', 2);
        return view('toolz.close-smena', compact('checkedshifts', 'host', 'uncheckedshifts', 'date', 'paginated'));
    }

    public function adminCheckOpenSmena(Request $request)
    {
        $fine = 0;
        $msg = '';
        $inputs = $request->all();
        $phone = DB::table('tg_user')->where('id', $request->input('user_id'))->get()->phone_number;
        unset($inputs['_token'], $inputs['shift_id'], $inputs['user_id'], $inputs['izoh']);
        foreach ($inputs as $key => $value) {
            if ($key === 'kun_soni' || $key === 'lokatsiya_notogri') {
                $this->shiftRepository->delete($request->input('shift_id'));
                $this->smsRepository->sendSMS($phone, "Sizning hisobotingiz qabul qilinmadi. Qaytadan smena oching");
                return back();
            } else {
                $fine += static::MIN_FINE;
                $msg .= static::ERRORS[$key] . '. ';
            }
        }
        if ($fine !== 0 && $msg !== '') {
            $this->shiftRepository->setDetail($fine, $request->input('izoh'), $request->input('user_id'), $msg);
            $this->smsRepository->sendSMS($phone, $request->input('izoh') . $msg . "Jarima: " . $fine . " so'm");
        }
        $this->shiftRepository->update($request->input('shift_id'), $msg);
        return back();
    }
    public function adminCheckCloseSmena(Request $request)
    {
        $fine = 0;
        $msg = '';
        $inputs = $request->all();
        $phone = DB::table('tg_user')->where('id', $request->input('user_id'))->first()->phone_number;
        unset($inputs['_token'], $inputs['shift_id'], $inputs['user_id'], $inputs['izoh']);
        foreach ($inputs as $key => $value) {
            $fine += static::MIN_FINE;
            $msg .= static::ERRORS[$key] . '. ';
        }
        if ($fine !== 0 && $msg !== '') {
            $this->shiftRepository->setDetail($fine, $request->input('izoh'), $request->input('user_id'), $msg);
            $this->smsRepository->sendSMS($phone, $request->input('izoh') . $msg . "Jarima: " . $fine . " so'm");
        }
        $this->shiftRepository->update($request->input('shift_id'), $msg);
        return back();
    }


    public function kingSold()
    {
        $solds = KingSold::with('order', 'order.sold', 'order.sold.medicine', 'order.user')
            ->whereDate('created_at', '>=', '2023-01-30')
            ->where('image', '!=', 'add')
            ->where('admin_check', 0)
            ->orderBy('id', 'DESC')->get();
        $host = substr(request()->getHttpHost(), 0, 3);
        return view('toolz.king-sold', compact('solds', 'host'));
    }
    public function kingSoldHistory(Request $request, $date)
    {
        $date = $request->input('smena_date');
        // dd($date);
        $paginated = true;
        $solds = KingSold::with('order', 'order.sold', 'order.sold.medicine', 'order.user')
            ->whereDate('created_at', '>=', '2023-01-30')
            ->where('image', '!=', 'add');

        $host = substr(request()->getHttpHost(), 0, 3);

        if ($date !== NULL) {
            $paginated = false;
            $solds = $solds->whereDate('created_at', $date)->orderBy('id', 'DESC')->get();
        } else {
            $solds = $solds->orderBy('id', 'DESC')->paginate(10);
        }
        return view('toolz.king-sold-history', compact('solds', 'host', 'date', 'paginated'));
    }
    
    public function kingSoldAnsver(Request $request)
    {
        $order_id = KingSold::find($request->id)->order_id;
        $summa = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
            ->where('tg_productssold.order_id', $order_id)->get();
        if ($request->ansver == 2) {
            if ($summa[0]->allprice >= 200000) {
                $new = KingSold::where('id', $request->id)->update([
                    'admin_check' => $request->ansver,
                    'status' => 1
                ]);
            } else {
                $new = KingSold::where('id', $request->id)->update([
                    'admin_check' => $request->ansver,
                    'status' => 2
                ]);
            }
        } else {

            if ($summa[0]->allprice >= 200000) {
                $add = floor($summa[0]->allprice / 200000) - 1;

                if ($add != 0) {
                    for ($i = 1; $i <= $add; $i++) {
                        $new = new KingSold([
                            'order_id' => $order_id,
                            'image' => 'add',
                            'admin_check' => 1
                        ]);
                        $new->save();
                    }
                }
                $new = KingSold::where('id', $request->id)->update([
                    'admin_check' => $request->ansver,
                    'status' => 1
                ]);
            } else {
                $new = KingSold::where('id', $request->id)->update([
                    'admin_check' => $request->ansver,
                    'status' => 2
                ]);
            }

            $user_id = Order::find($order_id)->user_id;

            $exists_user_id = DB::table('liga_king_users')->where('user_id', $user_id)->get();
            if (count($exists_user_id) == 0) {
                DB::table('liga_king_users')->insert([
                    'liga_id' => 2,
                    'user_id' => $user_id
                ]);
            }

            $weekStartDate = Carbon::now()->startOfWeek()->format('Y-m-d');
            $weekEndDate = Carbon::now()->endOfWeek()->format('Y-m-d');
            $king_sold = DB::table('tg_king_sold')
                ->selectRaw('tg_order.user_id,tg_user.phone_number')
                ->where('tg_king_sold.admin_check', 1)
                ->whereDate('tg_king_sold.created_at', '>=', $weekStartDate)
                ->whereDate('tg_king_sold.created_at', '<=', $weekEndDate)
                ->join('tg_order', 'tg_order.id', 'tg_king_sold.order_id')
                ->join('tg_user', 'tg_user.id', 'tg_order.user_id')
                ->groupBy('tg_order.user_id', 'tg_user.phone_number')
                ->pluck('phone_number')->toArray();
            $user_id = DB::table('tg_order')->where('id', $order_id)->value('user_id');
            $user = DB::table('tg_user')->find($user_id);
            $king_sold[] = '+998990821015';
            $king_sold[] = '+998977332305';
            $king_sold[] = '+998931810408';
            $king_sold[] = '+998930000047';
            $king_sold[] = '+998935050498';
            $king_sold[] = '+998946890010';

            $king_sold[] = '+998990316244';
            $king_sold[] = '+998995511944';
            $response = Http::post('notify.eskiz.uz/api/auth/login', [
                'email' => 'mubashirov2002@gmail.com',
                'password' => 'PM4g0AWXQxRg0cQ2h4Rmn7Ysoi7IuzyMyJ76GuJa'
            ]);
            $token = $response['data']['token'];
            foreach ($king_sold as $key => $value) {
                $sms = Http::withToken($token)->post('notify.eskiz.uz/api/message/sms/send', [
                    'mobile_phone' => substr($value, 1),
                    'message' => 'Jangchi !!! ' . ' ' . $user->last_name . ' ' . $user->first_name . ' ' . 'hozirgina shox yurish qildi.' . ' ' . 'Yutganga 200.000 som premiya beriladi!!! https://jang.novatio.uz',
                    'from' => '4546',
                    'callback_url' => 'http://0000.uz/test.php'
                ]);
            }
        }

        return [
            'response' => 200,
        ];
    }

    // public function kingSoldAnsver(Request $request)
    // {
    //     $order_id = KingSold::find($request->id)->order_id;
    //     $summa = DB::table('tg_productssold')
    //         ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
    //         ->where('tg_productssold.order_id', $order_id)->get();


    //     if ($summa[0]->allprice >= 200000) {
    //         $add = floor($summa[0]->allprice / 200000) - 1;

    //         if ($add != 0) {
    //             for ($i = 1; $i <= $add; $i++) {
    //                 $new = new KingSold([
    //                     'order_id' => $order_id,
    //                     'image' => 'add',
    //                     'admin_check' => 1
    //                 ]);
    //                 $new->save();
    //             }
    //         }
    //         $new = KingSold::where('id', $request->id)->update([
    //             'admin_check' => $request->ansver,
    //             'status' => 1
    //         ]);
    //     } else {
    //         $new = KingSold::where('id', $request->id)->update([
    //             'admin_check' => $request->ansver,
    //             'status' => 2
    //         ]);
    //     }


    //     $weekStartDate = Carbon::now()->startOfWeek()->format('Y-m-d');
    //     $weekEndDate = Carbon::now()->endOfWeek()->format('Y-m-d');
    //     $king_sold = DB::table('tg_king_sold')
    //         ->selectRaw('tg_order.user_id,tg_user.phone_number')
    //         ->where('tg_king_sold.admin_check', 1)
    //         ->whereDate('tg_king_sold.created_at', '>=', $weekStartDate)
    //         ->whereDate('tg_king_sold.created_at', '<=', $weekEndDate)
    //         ->join('tg_order', 'tg_order.id', 'tg_king_sold.order_id')
    //         ->join('tg_user', 'tg_user.id', 'tg_order.user_id')
    //         ->groupBy('tg_order.user_id', 'tg_user.phone_number')
    //         ->pluck('phone_number')->toArray();
    //     $user_id = DB::table('tg_order')->where('id', $order_id)->value('user_id');
    //     $user = DB::table('tg_user')->find($user_id);
    //     $king_sold[] = '+998990821015';
    //     $king_sold[] = '+998977332305';
    //     $king_sold[] = '+998931810408';
    //     $king_sold[] = '+998930000047';
    //     $king_sold[] = '+998935050498';
    //     $king_sold[] = '+998946890010';
    //     $response = Http::post('notify.eskiz.uz/api/auth/login', [
    //         'email' => 'mubashirov2002@gmail.com',
    //         'password' => 'PM4g0AWXQxRg0cQ2h4Rmn7Ysoi7IuzyMyJ76GuJa'
    //     ]);
    //     $token = $response['data']['token'];
    //     if ($request->ansver != 2) {
    //         foreach ($king_sold as $key => $value) {
    //             $sms = Http::withToken($token)->post('notify.eskiz.uz/api/message/sms/send', [
    //                 'mobile_phone' => substr($value, 1),
    //                 'message' => 'Jangchi !!! ' . ' ' . $user->last_name . ' ' . $user->first_name . ' ' . 'hozirgina shox yurish qildi.' . ' ' . 'Yutganga 200.000 som premiya beriladi!!! https://jang.novatio.uz',
    //                 'from' => '4546',
    //                 'callback_url' => 'http://0000.uz/test.php'
    //             ]);
    //         }
    //     }

    //     return [
    //         'response' => 200,
    //     ];
    // }
    public function kingSoldLiga()
    {
        $ligas = LigaKingSold::with('liga_user', 'liga_user.user')->get();

        $no_user = LigaKingUser::pluck('user_id')->toArray();
        // return $no_user;
        $endday = date('Y-m-d', (strtotime('-1 day', strtotime(Carbon::now()))));
        $startday = date('Y-m-d', (strtotime('-14 day', strtotime(Carbon::now()))));
        $transactions = ProductSold::whereBetween('created_at', [$startday, $endday])
            ->distinct()
            ->pluck('user_id')->toArray();
        $user_in = [];
        foreach ($transactions as $key => $value) {
            if (!in_array($value, $no_user)) {
                $user_in[] = $value;
            }
        }
        // return $user_in;
        $users = User::whereIn('id', $user_in)->get();
        // return $users;
        return view('toolz.king-liga', compact('users', 'ligas'));
    }
    public function kingSoldLigaStore(Request $request)
    {
        $inputs = $request->all();
        unset($inputs['_token']);
        $new = new LigaKingUser($inputs);
        $new->save();
        return redirect()->back();
    }
    public function kingSoldLigaDelete(Request $request)
    {
        $inputs = $request->all();
        $new = LigaKingUser::where('user_id', $inputs['user_id'])->where('liga_id', $inputs['team_id'])->delete();
        return redirect()->back();
    }
    public function kingSoldSearch($user_id, $region_id, $date)
    {
        $new = new KingSoldSearchService;
        $king_solds = $new->kingSoldSearch($user_id, $region_id, $date);

        $regions = DB::table('tg_region')
            ->whereIn('id', $new->getMyRegion())
            ->get();

        $users = DB::table('tg_user')->select('first_name', 'last_name', 'id', 'region_id')
            ->whereIn('id', $new->getUserId('all'))
            ->get();

        $dates = $new->day($date);
        $dateTexte = $dates->dateTexte;
        $dateText = $dates->dateText;


        if ($user_id == 'all') {
            $pText = 'Hammasi';
            $pkey = 'all';
        } else {
            $pText = DB::table('tg_user')->where('id', $user_id)->value('last_name') . ' ' . DB::table('tg_user')->where('id', $user_id)->value('first_name');
            $pkey = $user_id;
        }

        if ($region_id == 'all') {
            $regText = 'Hammasi';
            $regkey = "all";
        } else {
            $regText = DB::table('tg_region')->where('id', $region_id)->value('name');
            $regkey = $region_id;
        }
        // return $users;
        return view('toolz.king-sold-report', compact('pText', 'pkey', 'king_solds', 'regions', 'users', 'regkey', 'regText', 'dateText', 'dateTexte'));
    }
}
