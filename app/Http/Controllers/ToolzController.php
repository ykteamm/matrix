<?php

namespace App\Http\Controllers;

use App\Repositories\HelperRepository;
use App\Repositories\SMSRepository;
use App\Repositories\ShiftRepository;
use App\Models\KingLiga;
use App\Models\KingSold;
use App\Models\LigaKingSold;
use App\Models\LigaKingUser;
use App\Models\Order;
use App\Models\ProductSold;
use App\Models\User;
use App\Services\KingSoldSearchService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToolzController extends Controller
{
    private SMSRepository $smsRepository;
    private ShiftRepository $shiftRepository;
    private HelperRepository $helper;
    private KingSoldSearchService $kingSoldService;
    public function __construct(
        SMSRepository $sms,
        ShiftRepository $shift,
        HelperRepository $helper,
        KingSoldSearchService $kingSold
    ) {
        $this->smsRepository = $sms;
        $this->shiftRepository = $shift;
        $this->helper = $helper;
        $this->kingSoldService = $kingSold;
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
        $page = $request->input('page');
        $host = substr(request()->getHttpHost(), 0, 3);
        $uncheckedshifts = $this->shiftRepository->unchecked('admin_check', 1);
        $historyshifts = $this->shiftRepository->history($date, 'admin_check', 1);
        return view('toolz.open-smena', compact('page', 'historyshifts', 'host', 'uncheckedshifts', 'date'));
    }

    public function closeSmena(Request $request)
    {
        $date = $request->input('smena_date');
        $page = $request->input('page');
        $host = substr(request()->getHttpHost(), 0, 3);
        $uncheckedshifts = $this->shiftRepository->unchecked('admin_check_close', 2);
        $historyshifts = $this->shiftRepository->history($date, 'admin_check_close', 2);
        return view('toolz.close-smena', compact('page', 'historyshifts', 'host', 'uncheckedshifts', 'date'));
    }

    public function kingLigas()
    {
        $ligas = KingLiga::orderBy('id', 'ASC')->get();
        $users = DB::table('tg_user AS u')
        ->select('u.id', 'u.first_name AS f', 'u.last_name AS l', 'kl.id AS ligaid')
        ->join('user_king_liga AS ul', 'ul.user_id', 'u.id')
        ->join('king_ligas AS kl', 'kl.id', 'ul.king_liga_id')
        ->get();
        return view('toolz.king-ligas', compact('ligas','users'));
    }
    public function kingLigasUpdate(Request $request)
    {
        $inputs = $request->all();
        unset($inputs['_token']);
        foreach ($inputs as $userId => $ligaId) {
            $user_liga = DB::table('user_king_liga')->where('user_id', $userId)->where('king_liga_id', $ligaId)->first();
            if(!$user_liga) {
                DB::table('user_king_liga')->where('user_id', $userId)->update([
                    'king_liga_id' => $ligaId
                ]);
            }
        }
        return back();
    }

    public function adminCheckOpenSmena(Request $request)
    {
        $fine = 0;
        $error = '';
        $user_id = $request->input('user_id');
        $shift_id = $request->input('shift_id');
        $kun_soni = $request->input('kun_soni');
        $beyjik_yoq = $request->input('beyjik_yoq');
        $xalat_yoq = $request->input('xalat_yoq');
        $lokatsiya_notogri = $request->input('lokatsiya_notogri');
        $izoh = $request->input('izoh');
        $user = User::find($user_id);

        if ($kun_soni) {
            $this->shiftRepository->update($shift_id, 0, "Kun soni yo'q. Qaytadan smena oching !");
            $info = "Siz " . $user->first_name ." ". $user->last_name . " ning smena ochganligini kun soni yo'qligi tufayli yopdingiz ! Soat ". date("H:i"); 
            return back()->with('openSmena', $info);
        }
        if($beyjik_yoq) {
            $error .= static::ERRORS[$beyjik_yoq] . ". ";
            $fine += static::MIN_FINE;
        }
        if($xalat_yoq) {
            $error .= static::ERRORS[$xalat_yoq] . ". ";
            $fine += static::MIN_FINE;
        }
        if($lokatsiya_notogri) {
            $error .= static::ERRORS[$lokatsiya_notogri] . ". ";
            $fine += static::MIN_FINE;
        }
      
        if ($beyjik_yoq || $xalat_yoq || $lokatsiya_notogri) {
            $error = $izoh . " " . $error;
            $this->helper->setDetail($user_id, $fine, $error);
        }
        $this->shiftRepository->updateAdminCheck($shift_id, $error, 'admin_check');
        if($error == '') {
            $msg = "Siz " . $user->first_name ." ". $user->last_name . " ning smena ochganligini tasdiqladingiz !";
            return back()->with('openSmena', $msg);
        } else {
            $msg = "Siz " . $user->first_name ." ". $user->last_name . " ning smena ochganligini " . $error . " bilan tasdiqladingiz ! Jarima: " . number_format($fine, 0, '', " ");
            return back()->with('openSmena', $msg);
        }
    }
    public function adminCheckCloseSmena(Request $request)
    {
        $fine = 0;
        $error = '';
        $user_id = $request->input('user_id');
        $shift_id = $request->input('shift_id');
        $kun_soni = $request->input('kun_soni');
        $beyjik_yoq = $request->input('beyjik_yoq');
        $xalat_yoq = $request->input('xalat_yoq');
        $lokatsiya_notogri = $request->input('lokatsiya_notogri');
        $izoh = $request->input('izoh');
        $user = User::find($user_id);

        // if ($kun_soni) {
        //     $this->shiftRepository->update($shift_id, 0, "Kun soni yo'q. Qaytadan smena oching !");
        //     $info = "Siz " . $user->first_name ." ". $user->last_name . " ning smena yopganligini kun soni yo'qligi tufayli yopdingiz ! Soat ". date("H:i"); 
        //     return back()->with('openSmena', $info);
        // }
        if($kun_soni) {
            $error .= static::ERRORS[$kun_soni] . ". ";
            $fine += static::MIN_FINE;
        }
        if($beyjik_yoq) {
            $error .= static::ERRORS[$beyjik_yoq] . ". ";
            $fine += static::MIN_FINE;
        }
        if($xalat_yoq) {
            $error .= static::ERRORS[$xalat_yoq] . ". ";
            $fine += static::MIN_FINE;
        }
        if($lokatsiya_notogri) {
            $error .= static::ERRORS[$lokatsiya_notogri] . ". ";
            $fine += static::MIN_FINE;
        }
      
        if ($beyjik_yoq || $xalat_yoq || $lokatsiya_notogri || $kun_soni) {
            $error = $izoh . " " . $error;
            $this->helper->setDetail($user_id, $fine, $error);
        }
        $this->shiftRepository->updateAdminCheck($shift_id, $error, 'admin_check_close');
        if($error == '') {
            $msg = "Siz " . $user->first_name ." ". $user->last_name . " ning smena yopganligini tasdiqladingiz !";
            return back()->with('closeSmena', $msg);
        } else {
            $msg = "Siz " . $user->first_name ." ". $user->last_name . " ning smena yopganligini " . $error . " bilan tasdiqladingiz ! Jarima: " . number_format($fine, 0, '', " ");
            return back()->with('closeSmena', $msg);
        }
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
    public function kingSoldHistory(Request $request)
    {
        $host = substr(request()->getHttpHost(), 0, 3);
        $solds = KingSold::with('order', 'order.sold', 'order.sold.medicine', 'order.user')
            ->whereDate('created_at', '>=', '2023-01-30')
            ->where(function () use ($request) {
            })
            ->where('image', '!=', 'add')
            ->orderBy('id', 'DESC');

        if ($date = $request->input('_date')) {
            $solds = $solds->whereDate('created_at', $date)->get();
        } else {
            $solds = $solds->paginate(10);
        }
        return view('toolz.king-sold-history', compact('solds', 'host', 'date'));
    }

    public function kingSoldAnsver(Request $request)
    {
        if (isset($request->izoh)) {
            $comment = $request->izoh;
        } else {
            $comment = NULL;
        }

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
            if (isset($request->count)) {
                $count = $request->count;
                $floor = floor($count);
                $kasr = $count - $floor;

                if ($kasr == 0) {
                    if ($count == 1) {
                        $new = KingSold::where('id', $request->id)->update([
                            'admin_check' => $request->ansver,
                            'status' => 1,
                            'comment' => $comment
                        ]);
                    } else {
                        $new = KingSold::where('id', $request->id)->update([
                            'admin_check' => $request->ansver,
                            'status' => 1,
                            'comment' => $comment
                        ]);

                        for ($i = 1; $i <= $count - 1; $i++) {
                            $new = new KingSold([
                                'order_id' => $order_id,
                                'image' => 'add',
                                'admin_check' => 1
                            ]);
                            $new->save();
                        }
                    }
                } else {
                    if ($count == 1) {
                        $new = KingSold::where('id', $request->id)->update([
                            'admin_check' => $request->ansver,
                            'status' => 1,
                            'comment' => $comment
                        ]);
                    } else {
                        $new = KingSold::where('id', $request->id)->update([
                            'admin_check' => $request->ansver,
                            'status' => 1,
                            'comment' => $comment
                        ]);

                        for ($i = 1; $i <= $count - 1; $i++) {
                            $new = new KingSold([
                                'order_id' => $order_id,
                                'image' => 'add',
                                'admin_check' => 1
                            ]);
                            $new->save();
                        }
                    }
                    $new = new KingSold([
                        'order_id' => $order_id,
                        'image' => 'add',
                        'admin_check' => 1,
                        'status' => 2,
                    ]);
                    $new->save();
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
                        'status' => 1,
                        'comment' => $comment

                    ]);
                } else {
                    $new = KingSold::where('id', $request->id)->update([
                        'admin_check' => $request->ansver,
                        'status' => 2,
                        'comment' => $comment

                    ]);
                }
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
            // $response = Http::post('notify.eskiz.uz/api/auth/login', [
            //     'email' => 'mubashirov2002@gmail.com',
            //     'password' => 'PM4g0AWXQxRg0cQ2h4Rmn7Ysoi7IuzyMyJ76GuJa'
            // ]);
            // $token = $response['data']['token'];
            // foreach ($king_sold as $key => $value) {
            //     $sms = Http::withToken($token)->post('notify.eskiz.uz/api/message/sms/send', [
            //         'mobile_phone' => substr($value, 1),
            //         'message' => 'Jangchi !!! ' . ' ' . $user->last_name . ' ' . $user->first_name . ' ' . 'hozirgina shox yurish qildi.' . ' ' . 'Yutganga 200.000 som premiya beriladi!!! https://jang.novatio.uz',
            //         'from' => '4546',
            //         'callback_url' => 'http://0000.uz/test.php'
            //     ]);
            // }
        }

        return redirect()->back();
    }

    public function kingSoldLiga()
    {
        $ligas = LigaKingSold::with('liga_user', 'liga_user.user')->get();

        $no_user = LigaKingUser::pluck('user_id')->toArray();

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

        $king_solds = $this->kingSoldService->kingSoldSearch($user_id, $region_id, $date);

        $regions = DB::table('tg_region')
            ->whereIn('id', $this->kingSoldService->getMyRegion())
            ->get();

        $users = DB::table('tg_user')->select('first_name', 'last_name', 'id', 'region_id')
            ->whereIn('id', $this->kingSoldService->getUserId('all'))
            ->where('tg_user.rm', 0)
            ->whereIn('tg_user.status', [1, 0])
            ->get();

        $dates = $this->kingSoldService->day($date);
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

        $total = [];

        foreach ($king_solds as $king) {
            if ($user_id == 'all' && $region_id == 'all') {
                foreach ($regions as $reg) {
                    if ($reg->name == $king['r']) {
                        if (!isset($total[$reg->name])) {
                            $total[$reg->name] = [];
                        }
                        $total[$reg->name][] = $king;
                    }
                }
            } else if ($user_id == 'all' && $region_id != 'all') {
                if ($regText == $king['r']) {
                    $total[] = $king;
                }
            } else if ($user_id != 'all') {
                if ($user_id == $king['user_id']) {
                    $total[] = $king;
                }
            }
        }
        if ($user_id == 'all' && $region_id == 'all') {
            uasort($total, function ($a, $b) {
                $sum1 = 0;
                $sum2 = 0;
                foreach ($a as $i) {
                    $sum1 += $i['count'];
                }
                foreach ($b as $j) {
                    $sum2 += $j['count'];
                }
                if ($sum1 == $sum2) {
                    return 0;
                }
                return $sum1 > $sum2 ? -1 : 1;
            });
        }


        return view('toolz.king-sold-report', compact('user_id', 'region_id', 'total', 'pText', 'pkey', 'king_solds', 'regions', 'users', 'regkey', 'regText', 'dateText', 'dateTexte'));
    }

    public function provizor()
    {
        $users = User::where('specialty_id', 1)->get();

        $provizor = User::where('specialty_id', 9)->get();

        return view('toolz.provizor', compact('users', 'provizor'));
    }
    public function provizorAdd(Request $request)
    {
        $update = DB::table('tg_user')->where('id', $request->user_id)->update([
            'specialty_id' => 9,
        ]);
        return redirect()->back();
    }
    public function provizorLose(Request $request)
    {
        $update = DB::table('tg_user')->where('id', $request->user_id)->update([
            'specialty_id' => 1,
        ]);
        return redirect()->back();
    }
}
