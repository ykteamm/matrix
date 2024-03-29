<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use App\Models\Knowledge;
use App\Models\Pharmacy;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;

if(!function_exists('myPrognoz')){
    function myPrognoz($id) {
        $start = Carbon::now()->startOfMonth()->format("Y-m-d");
        $end = Carbon::now()->endOfMonth()->format("d");
        $now = Carbon::now()->format("Y-m-d");
        $fakt = DB::select(
            "SELECT
            COALESCE(SUM(CASE WHEN DATE(p.created_at) BETWEEN ? AND ? THEN p.number * p.price_product ELSE 0 END), 0) AS allprice
            FROM tg_productssold AS p
            WHERE p.user_id = ?",
            [$start, $now, $id]
        );
        $koef = 0;
        if(count($fakt) > 0) {
            $koef = round($fakt[0]->allprice / (int)date("d"));
        }
        $prognoz = $koef * $end;
        return $prognoz;
    }
}

if(!function_exists('getMonthName')){
    function getMonthName($text) {
        return [
            'January' => 'Yanvar',
            'February' => 'Fevral',
            'March' => 'Mart',
            'April' => 'Aprel',
            'May' => 'May',
            'June' => 'Iyun',
            'July' => 'Iyul',
            'August' => 'August',
            'September' => 'Sentabr',
            'October' => 'Oktabr',
            'November' => 'Noyabr',
            'December' => 'Dekabr'
        ][$text];
    }
}

if(!function_exists('maosh')){
    function maosh($sum) {
        if($sum < 25000000)
        {
            $koef = 2000000/15000000;
            $oylik = $sum*$koef;
        }elseif ($sum >= 25000000 && $sum < 35000000) {
            $koef = 3500000/25000000;
            $oylik = $sum*$koef;
        }else{
            $koef = 5000000/35000000;
            $oylik = $sum*$koef;
        }

        return $oylik;
    }
}

if (!function_exists('toLatin')) {
    function toLatin($krill)
    {
        $CYRILLIC_TO_LATIN = [
            'а' => 'a', 'А' => 'A',
            'б' => 'b', 'Б' => 'B',
            'в' => 'v', 'В' => 'V',
            'г' => 'g', 'Г' => 'G',
            'д' => 'd', 'Д' => 'D',
            'е' => 'e', 'Е' => 'E',
            'ё' => 'yo', 'Ё' => 'Yo',
            'ж' => 'j', 'Ж' => 'J',
            'з' => 'z', 'З' => 'Z',
            'и' => 'i', 'И' => 'I',
            'й' => 'y', 'Й' => 'Y',
            'к' => 'k', 'К' => 'K',
            'л' => 'l', 'Л' => 'L',
            'м' => 'm', 'М' => 'M',
            'н' => 'n', 'Н' => 'N',
            'о' => 'o', 'О' => 'O',
            'п' => 'p', 'П' => 'P',
            'р' => 'r', 'Р' => 'R',
            'с' => 's', 'С' => 'S',
            'т' => 't', 'Т' => 'T',
            'у' => 'u', 'У' => 'U',
            'ф' => 'f', 'Ф' => 'F',
            'х' => 'x', 'Х' => 'X',
            'ц' => 's', 'Ц' => 'S',
            'ч' => 'ch', 'Ч' => 'Ch',
            'ш' => 'sh', 'Ш' => 'Sh',
            'ъ' => 'ʼ', 'Ъ' => 'ʼ',
            'ь' => '', 'Ь' => '',
            'э' => 'e', 'Э' => 'E',
            'ю' => 'yu', 'Ю' => 'Yu',
            'я' => 'ya', 'Я' => 'Ya',
            'ў' => 'oʻ', 'Ў' => 'Oʻ',
            'қ' => 'q', 'Қ' => 'Q',
            'ғ' => 'gʻ', 'Ғ' => 'Gʻ',
            'ҳ' => 'h', 'Ҳ' => 'H',
        ];
        $lat = '';
        $words = explode(" ", $krill);
        foreach ($words as $word) {
            $ascii = '';
            if (strpos($word, '.')) {
                $ascii = '.';
                $word = substr($word, 0, strlen($word) - 1);
            }
            $arr = str_split($word);
            $len = count($arr) / 2;
            $w = '';
            for ($i = 0; $i < $len; $i++) {
                $letter = $arr[$i * 2] . $arr[($i * 2) + 1];
                $w .= $CYRILLIC_TO_LATIN[$letter];
            }
            $lat .= " " . $w . $ascii;
        }
        return $lat;
    }
}


if (!function_exists('date_now')) {
    function date_now()
    {

        return Carbon::now();
    }
}

if (!function_exists('battleDay')) {
    function battleDay($day)
    {
        if ($day == 0) {
            return 'Monday';
        }
        if ($day == 1) {
            return 'Tuesday';
        }
        if ($day == 2) {
            return 'Wednesday';
        }
        if ($day == 3) {
            return 'Thursday';
        }
        if ($day == 4) {
            return 'Friday';
        }
        if ($day == 5) {
            return 'Saturday';
        }
        if ($day == 6) {
            return 'Sunday';
        }
    }
}

if (!function_exists('wordSimilarity')) {
    function wordSimilarity($s1, $s2)
    {

        $words1 = preg_split('/\s+/', $s1);
        $words2 = preg_split('/\s+/', $s2);
        $diffs1 = array_diff($words2, $words1);
        $diffs2 = array_diff($words1, $words2);

        $diffsLength = strlen(join("", $diffs1) . join("", $diffs2));
        $wordsLength = strlen(join("", $words1) . join("", $words2));
        if (!$wordsLength) return 0;

        $differenceRate = ($diffsLength / $wordsLength);
        $similarityRate = 1 - $differenceRate;
        return $similarityRate;
    }
}
if (!function_exists('month_name')) {
    function month_name()
    {
        $month_name = [];
        $month_name[1] = 'Yanvar';
        $month_name[2] = 'Fevral';
        $month_name[3] = 'Mart';
        $month_name[4] = 'Aprel';
        $month_name[5] = 'May';
        $month_name[6] = 'Iyun';
        $month_name[7] = 'Iyul';
        $month_name[8] = 'Avgust';
        $month_name[9] = 'Sentabr';
        $month_name[10] = 'Oktabr';
        $month_name[11] = 'Noyabr';
        $month_name[12] = 'Dekabr';
        return $month_name;
    }
}
if (!function_exists('dep_name')) {
    function dep_name()
    {
        $departments = DB::table('tg_department')->where('status', 1)->get();
        return $departments;
    }
}
if (!function_exists('getUserRegion')) {
    function getUserRegion()
    {
        $userarrayreg = [];
        if (isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true') {
            $users = DB::table('tg_user')
                ->where('tg_user.status', 1)
                ->select('tg_region.id as tid', 'tg_user.id', 'tg_user.last_name', 'tg_user.first_name')
                ->join('tg_region', 'tg_region.id', 'tg_user.region_id')
                ->get();
            foreach ($users as $key => $value) {
                $userarrayreg[] = $value->id;
            }
        } else {
            $r_id_array = [];
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)) {
                    $r_id_array[] = $key;
                }
            }
            $users = DB::table('tg_user')
                ->whereIn('tg_region.id', $r_id_array)
                ->where('tg_user.status', 1)
                ->select('tg_region.id as tid', 'tg_user.id', 'tg_user.last_name', 'tg_user.first_name')
                ->join('tg_region', 'tg_region.id', 'tg_user.region_id')
                ->get();
            foreach ($users as $key => $value) {
                $userarrayreg[] = $value->id;
            }
        }
        return $userarrayreg;
    }
}

if (!function_exists('getRegion')) {
    function getRegion()
    {
        if (isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true') {
            $regionId = DB::table('tg_region')->pluck('id');
        } else {
            $regionId = [];
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)) {
                    $regionId[] = $key;
                }
            }
        }
        return $regionId;
    }
}
if (!function_exists('rmDay')) {
    function rmDay()
    {
        if (intval(date('H', strtotime(date_now()))) >= 0 && intval(date('H', strtotime(date_now()))) < 13) {
            $day = 1;
        } else {
            $day = 0;
        }
        return $day;
    }
}

if (!function_exists('h_positions')) {
    function h_positions()
    {
        $h_positions = [
            'dash' => 'Dashboard',
            'filter' => 'Filter',
            'elchi' => 'Elchi',
            'elchi-day' => 'Elchi kunlik',
            'king_sold' => 'Shox yurish',
            'pro' => 'Mahsulotlar',
            'trend' => 'Trend',
            'grade' => 'Baholash',
            'ques' => 'Savollar',
            'know_ques' => 'Bilim savollar',
            'edit_purchase' => 'Xaridlarni o\'zgartirish',
            'show_purchase' => 'Taxrirlash tarixi',
            'setting' => 'Sozlamalar',
            'User' => 'User',
            'rol' => 'Rol',
            'region' => 'Barcha viloyat',
            'accept' => 'Kirimlar',
            'stock' => 'Qoldiqlar',
            'user-pharm' => 'User Dorixona'
        ];
        // $knowledge = Knowledge::first();
        // $h_positions['pharmacy'] = 'Dorixona';
        $h_positions['user_pharmacy'] = 'Dorixona - user';
        $h_positions['farm_pm'] = 'Dorixona - plus - minus';
        $h_positions['team'] = 'Jamoa';
        $h_positions['order'] = 'Order';
        $h_positions['rek'] = 'Rek';
        $h_positions['turnir'] = 'Turnir';
        $h_positions['market'] = 'Market';
        $h_positions['firewall'] = 'Firewall';
        $h_positions['crystal'] = 'Crystal';
        $h_positions['rekrut'] = 'Rekrut';
        $h_positions['oylik'] = 'Oylik';
        $h_positions['rekrut-atchot'] = 'Rekrut Hisobot';
        $h_positions['provizor-atchot'] = 'Provizor Hisobot';

        $h_positions['toolz'] = 'Toolz Bot';
        $h_positions['teacher'] = 'Ustoz - shogird';
        $h_positions['narx'] = 'Narx';
        $h_positions['zavod'] = 'Zavod';
        $h_positions['control'] = 'User control';
        $h_positions['bilim'] = 'Bilim';
        $h_positions['all_user'] = 'Userlar';
        $department = DB::table('tg_department')->where('status', 1)->get();
        foreach ($department as $key => $value) {
            $h_positions['d' . $value->id] = $value->name;
        }

        $region = DB::table('tg_region')->get();
        foreach ($region as $key => $value) {
            $h_positions[$value->id] = $value->name;
        }

        $perm = DB::table('tg_perm')->get();
        foreach ($perm as $key => $value) {
            $h_positions[$value->key] = $value->name;
        }
        return $h_positions;
    }
}

if (!function_exists('admin_positions')) {
    function admin_positions()
    {
        $h_positions = [
            'order_zakaz' => 'Pul kelishi zakaz berish',
            'order_report' => 'Pul kelishi hisobot'
        ];


        return $h_positions;
    }
}
if (!function_exists('b_positions')) {
    function b_positions()
    {
        $b_positions = [
            'rol' => 'Должность',
            'user' => 'Пользователь',
            'p_registr' => 'Пациент регистрация',
            'p_diagnos' => 'Пациент диагноз ',
            'p_illnes' => 'Пациент осмотр больного ',
            'p_ekg' => 'Пациент ЭКГ',
            'p_exo' => 'Пациент ЭХО',
            'p_treatment' => 'Пациент лечение ',
            'exit' => 'Исход',
        ];
        return $b_positions;
    }
}

if (!function_exists('h_actions')) {
    function h_actions()
    {
        $actions = [
            'hospital_create',
            'hospital_read',
            'hospital_update',
            'hospital_delete',
        ];
        return $actions;
    }
}
if (!function_exists('b_actions')) {
    function b_actions()
    {
        $actions = [
            'hospital_create',
            'hospital_read',
            'hospital_update',
            'hospital_delete',
            'branch_create',
            'branch_read',
            'branch_update',
            'branch_delete',
        ];
        return $actions;
    }
}
if (!function_exists('get_visitor_IP')) {
    /**
     * Get the real IP address from visitors proxy. e.g. Cloudflare
     *
     * @return string IP
     */


    function get_visitor_IP()
    {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        // Sometimes the `HTTP_CLIENT_IP` can be used by proxy servers
        $ip = @$_SERVER['HTTP_CLIENT_IP'];
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }

        // Sometimes the `HTTP_X_FORWARDED_FOR` can contain more than IPs
        $forward_ips = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        if ($forward_ips) {
            $all_ips = explode(',', $forward_ips);
            foreach ($all_ips as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
        return $_SERVER['REMOTE_ADDR'];
    }
}

if (!function_exists('numb')) {
    function numb($number)
    {
        if ($number < 999999 && $number > 999) {
            // Anything less than a billion
            $format =  number_format($number / 1000) . 'K';
        } else if ($number < 999999999 && $number > 999999) {
            // Anything less than a billion
            $format =  number_format($number / 1000000,) . 'M';
        } else {
            $format = number_format($number, 0, '', '.');
        }
        return $format;
    }
}

if (!function_exists('bmk')) {
    function bmk($number)
    {
        if ($number < 1000000) {
            // Anything less than a million
            $format = number_format($number / 1000) . 'K';
        } else if ($number < 1000000000) {
            // Anything less than a billion
            $format = number_format($number / 1000000,0) . 'M';
        } else {
            // At least a billion
            $format = number_format($number / 1000000000, 3) . 'B';
        }
        return $format;
    }
}

if (!function_exists('mprice')) {
    function mprice($id)
    {
        $price = DB::table('tg_prices')->where('medicine_id',$id)->where('shablon_id',3)->first();
       
        return $price->price;
    }
}

if(!function_exists('getHostNameUrl')){
    function getHostNameUrl() {

        $host = substr(request()->getHttpHost(),0,3);

        return $host;

    }
}

if(!function_exists('getProvizorUrl')){
    function getProvizorUrl() {

        if(getHostNameUrl() == 127)
        {
            $url = 'http://127.0.0.1:8000';
        }else{
            $url = 'https://promo.novatio.uz';
        }

        return $url;

    }
}

if(!function_exists('getPharmacy')){
    function getPharmacy($id) {

        $p = Pharmacy::find($id)->name;

        return $p??'no';

    }
}
if(!function_exists('getRegionByid')){
    function getRegionByid($id) {

        $p = Region::find($id)->name;

        return $p??'no';

    }
}
if(!function_exists('getShtrafDefault')){
    function getShtrafDefault($date_begin,$date_end,$user_id) {

        $if_user = DB::table('teacher_users')->where('user_id',Auth::id())->first();

        if($if_user)
        {
            if(strtotime($if_user->week_date) > strtotime($date_end))
            {
                $exists = [];
                return $exists;
            }else{
                if(strtotime($if_user->week_date) < strtotime($date_begin))
                {
                    $exists = DB::table('tg_details')
                    ->select('price','message',DB::raw('DATE(created_at)'))
                    ->where('user_id',$user_id)
                    ->where('status',2)
                    ->whereDate('created_at','>=',$date_begin)
                    ->whereDate('created_at','<=',$date_end)
                    ->distinct('date')
                    ->get();
                    return $exists;

                }else{
                    $exists = DB::table('tg_details')
                    ->select('price','message',DB::raw('DATE(created_at)'))
                    ->where('user_id',$user_id)
                    ->where('status',2)
                    ->whereDate('created_at','>=',$if_user->week_date)
                    ->whereDate('created_at','<=',$date_end)
                    ->distinct('date')
                    ->get();

                    return $exists;
                }

            }


        }
        $exists = DB::table('tg_details')
        ->select('price','message',DB::raw('DATE(created_at)'))
        ->where('user_id',$user_id)
        ->where('status',2)
        ->whereDate('created_at','>=',$date_begin)
        ->whereDate('created_at','<=',$date_end)
        ->distinct('date')
        ->get();

        return $exists;


    }
}
