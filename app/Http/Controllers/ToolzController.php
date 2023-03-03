<?php

namespace App\Http\Controllers;

use App\Models\KingSold;
use App\Models\LigaKingSold;
use App\Models\LigaKingUser;
use App\Models\ProductSold;
use App\Models\Shift;
use App\Models\User;
use App\Models\UserBattle;
use App\Services\KingSoldSearchService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ToolzController extends Controller
{
    public function openSmena()
    {
        $uncheckedshifts = Shift::with('user','pharmacy','user.region')
        ->whereDate('created_at','>=','2023-01-30')
        ->where('admin_check', NULL)
        ->orderBy('id','DESC')->get();

        $checkedshifts = Shift::with('user','pharmacy','user.region')
        ->whereDate('created_at','>=','2023-01-30')
        ->where('admin_check','!=', NULL)
        ->orderBy('id','DESC')->paginate(10);
        
        $host = substr(request()->getHttpHost(),0,3);
        return view('toolz.open-smena',compact('checkedshifts','host', 'uncheckedshifts'));
    }

    public function closeSmena()
    {
        $uncheckedshifts = Shift::with('user','pharmacy','user.region')
        ->whereDate('created_at','>=','2023-01-30')
        ->where('admin_check', NULL)
        ->orderBy('id','DESC')->get();

        $checkedshifts = Shift::with('user','pharmacy','user.region')
        ->whereDate('created_at','>=','2023-01-30')
        ->where('admin_check','!=', NULL)
        ->orderBy('id','DESC')->paginate(10);
        
        $host = substr(request()->getHttpHost(),0,3);
        return view('toolz.close-smena',compact('checkedshifts','host', 'uncheckedshifts'));
    }

    public function shiftAnsver(Request $request)
    {
        $new = Shift::where('id',$request->id)->update([
            'admin_check' => array('check' => $request->ansver)
        ]);

        return [
            'response' => 200,
        ];
    }
    public function kingSold()
    {  
        $solds = KingSold::with('order','order.sold','order.sold.medicine','order.user')
        ->whereDate('created_at','>=','2023-01-30')
        ->where('image','!=','add')
        ->where('admin_check',0)
        ->orderBy('id','DESC')->get();
        $host = substr(request()->getHttpHost(),0,3);
        return view('toolz.king-sold',compact('solds','host'));

    }
    public function kingSoldHistory($date)
    {  
        $solds = KingSold::with('order','order.sold','order.sold.medicine','order.user')
        ->whereDate('created_at','>=','2023-01-30')
        ->where('image','!=','add')
        // ->where('admin_check',0)
        ->orderBy('id','DESC')->limit(10)->paginate(10);
        $host = substr(request()->getHttpHost(),0,3);
        // dd($solds);
        return view('toolz.king-sold-history',compact('solds','host'));

    }
    public function kingSoldAnsver(Request $request)
    {
        $order_id = KingSold::find($request->id)->order_id;
        $summa = DB::table('tg_productssold')
            ->selectRaw('SUM(tg_productssold.number * tg_productssold.price_product) as allprice')
            ->where('tg_productssold.order_id',$order_id)->get();
        $add = floor($summa[0]->allprice/200000)-1;
        if($add != 0)
        {
            for ($i=1; $i <= $add; $i++) { 
                $new = new KingSold([
                    'order_id' => $order_id,
                    'image' => 'add',
                    'admin_check' => 1
                ]);
                $new->save();
            }
        }
        $new = KingSold::where('id',$request->id)->update([
            'admin_check' => $request->ansver
        ]);

        $weekStartDate = Carbon::now()->startOfWeek()->format('Y-m-d');
        $weekEndDate = Carbon::now()->endOfWeek()->format('Y-m-d');
        $king_sold = DB::table('tg_king_sold')
                    ->selectRaw('tg_order.user_id,tg_user.phone_number')
                    ->where('tg_king_sold.admin_check',1)
                    ->whereDate('tg_king_sold.created_at','>=',$weekStartDate)
                    ->whereDate('tg_king_sold.created_at','<=',$weekEndDate)
                    ->join('tg_order','tg_order.id','tg_king_sold.order_id')
                    ->join('tg_user','tg_user.id','tg_order.user_id')
                    ->groupBy('tg_order.user_id','tg_user.phone_number')
                    ->pluck('phone_number')->toArray();
        $user_id = DB::table('tg_order')->where('id',$order_id)->value('user_id');
        $user = DB::table('tg_user')->find($user_id);
        $king_sold[] = '+998990821015';
        $king_sold[] = '+998977332305';
        $king_sold[] = '+998931810408';
        $king_sold[] = '+998930000047';
        $king_sold[] = '+998935050498';
        $king_sold[] = '+998946890010';
        $response = Http::post('notify.eskiz.uz/api/auth/login', [
            'email' => 'mubashirov2002@gmail.com',
            'password' => 'PM4g0AWXQxRg0cQ2h4Rmn7Ysoi7IuzyMyJ76GuJa'
        ]);
        $token = $response['data']['token'];
        if($request->ansver != 2)
        {
            foreach ($king_sold as $key => $value) {
                $sms = Http::withToken($token)->post('notify.eskiz.uz/api/message/sms/send', [
                    'mobile_phone' => substr($value,1),
                    'message' => 'Jangchi !!! '.' '.$user->last_name.' '.$user->first_name.' '.'hozirgina shox yurish qildi.'.' '.'Yutganga 200.000 som premiya beriladi!!! https://jang.novatio.uz',
                    'from' => '4546',
                    'callback_url' => 'http://0000.uz/test.php'
                ]);
    
            }
        }
        
        return [
            'response' => 200,
        ];
    }
    public function kingSoldLiga()
    {
        $ligas = LigaKingSold::with('liga_user','liga_user.user')->get();

        $no_user = LigaKingUser::pluck('user_id')->toArray();
        // return $no_user;
        $endday = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( Carbon::now() ) ) ));
        $startday = date('Y-m-d',(strtotime ( '-14 day' , strtotime ( Carbon::now() ) ) ));
        $transactions= ProductSold::whereBetween('created_at', [$startday, $endday])
            ->distinct()
            ->pluck('user_id')->toArray();
        $user_in = [];
        foreach ($transactions as $key => $value) {
            if(!in_array($value,$no_user))
            {
                $user_in[] = $value;
            }
        }
        // return $user_in;
        $users = User::whereIn('id',$user_in)->get();
        // return $users;
        return view('toolz.king-liga',compact('users','ligas'));
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
        $new = LigaKingUser::where('user_id',$inputs['user_id'])->where('liga_id',$inputs['team_id'])->delete();
        return redirect()->back();
    }
    public function kingSoldSearch($user_id,$region_id,$date)
    {
        $new = new KingSoldSearchService;
        $king_solds = $new->kingSoldSearch($user_id,$region_id,$date);
        
        $regions = DB::table('tg_region')
        ->whereIn('id',$new->getMyRegion())
        ->get();
        
        $users = DB::table('tg_user')->select('first_name','last_name','id','region_id')
        ->whereIn('id',$new->getUserId('all'))
        ->get();

        $dates = $new->day($date);
        $dateTexte =$dates->dateTexte;
        $dateText =$dates->dateText;


        if($user_id == 'all')
        {
            $pText = 'Hammasi';
            $pkey = 'all';
        }else{
            $pText = DB::table('tg_user')->where('id',$user_id)->value('last_name').' '.DB::table('tg_user')->where('id',$user_id)->value('first_name');
            $pkey = $user_id;

        }

        if($region_id == 'all')
        {
            $regText = 'Hammasi';
            $regkey = "all";
        }else{
            $regText = DB::table('tg_region')->where('id',$region_id)->value('name');
            $regkey = $region_id;
        }
        // return $users;
        return view('toolz.king-sold-report',compact('pText','pkey','king_solds','regions','users','regkey','regText','dateText','dateTexte'));
    }
}
