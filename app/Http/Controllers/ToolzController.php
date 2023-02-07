<?php

namespace App\Http\Controllers;

use App\Models\KingSold;
use App\Models\Shift;
use App\Models\UserBattle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ToolzController extends Controller
{
    public function selfi()
    {
        $shifts = Shift::with('user','pharmacy','user.region')
        ->whereDate('created_at','>=','2023-01-30')
        ->orderBy('id','DESC')->get();
        $host = substr(request()->getHttpHost(),0,3);
        return view('toolz.selfi',compact('shifts','host'));
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
        ->orderBy('id','DESC')->get();
        $host = substr(request()->getHttpHost(),0,3);
        return view('toolz.king-sold',compact('solds','host'));

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

        // $u1id = UserBattle::where('ends',0)->pluck('u1id')->toArray();
        // $u2id = UserBattle::where('ends',0)->pluck('u2id')->toArray();
        // $alluid = array_unique(array_merge($u1id,$u2id));
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
        $response = Http::post('notify.eskiz.uz/api/auth/login', [
            'email' => 'mubashirov2002@gmail.com',
            'password' => 'PM4g0AWXQxRg0cQ2h4Rmn7Ysoi7IuzyMyJ76GuJa'
        ]);
        $token = $response['data']['token'];
        foreach ($king_sold as $key => $value) {
            $sms = Http::withToken($token)->post('notify.eskiz.uz/api/message/sms/send', [
                'mobile_phone' => substr($value,1),
                'message' => 'Jangchi !!! '.' '.$user->last_name.' '.$user->first_name.' '.'hozirgina shox yurish qildi.'.' '.'Yutganga 200.000 som premiya beriladi!!! https://jang.novatio.uz',
                'from' => '4546',
                'callback_url' => 'http://0000.uz/test.php'
            ]);

        }

        return [
            'response' => 200,
        ];
    }
}
