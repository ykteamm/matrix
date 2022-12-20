<?php
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use App\Models\Knowledge;
if(!function_exists('date_now')){
    function date_now() {

        return Carbon::now();

    }
}

if(!function_exists('wordSimilarity')){
    function wordSimilarity($s1,$s2) {

        $words1 = preg_split('/\s+/',$s1);
        $words2 = preg_split('/\s+/',$s2);
        $diffs1 = array_diff($words2,$words1);
        $diffs2 = array_diff($words1,$words2);

        $diffsLength = strlen(join("",$diffs1).join("",$diffs2));
        $wordsLength = strlen(join("",$words1).join("",$words2));
        if(!$wordsLength) return 0;

        $differenceRate = ( $diffsLength / $wordsLength );
        $similarityRate = 1 - $differenceRate;
        return $similarityRate;

    }
}
    if(!function_exists('month_name')){
            function month_name()
        {
            $month_name = [];
            $month_name [1]= 'Yanvar';
            $month_name [2]= 'Fevral';
            $month_name [3]= 'Mart';
            $month_name [4]= 'Aprel';
            $month_name [5]= 'May';
            $month_name [6]= 'Iyun';
            $month_name [7]= 'Iyul';
            $month_name [8]= 'Avgust';
            $month_name [9]= 'Sentabr';
            $month_name [10]= 'Oktabr';
            $month_name [11]= 'Noyabr';
            $month_name [12]= 'Dekabr';
            return $month_name;
        }
    }
    if(!function_exists('dep_name')){
        function dep_name()
    {
        $departments = DB::table('tg_department')->where('status',1)->get();
        return $departments;
    }
}
    if(!function_exists('getUserRegion')){
        function getUserRegion()
    {
        $userarrayreg = [];
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
            {
                $users = DB::table('tg_user')
                    ->where('tg_user.status',1)
                    ->select('tg_region.id as tid','tg_user.id','tg_user.last_name','tg_user.first_name')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->get();
                    foreach ($users as $key => $value) {
                        $userarrayreg[] = $value->id;
                    }
            }
            else{
                $r_id_array = [];
                    foreach (Session::get('per') as $key => $value) {
                        if (is_numeric($key)){
                            $r_id_array[] = $key;
                        }
                    }
                    $users = DB::table('tg_user')
                    ->whereIn('tg_region.id',$r_id_array)
                    ->where('tg_user.status',1)
                    ->select('tg_region.id as tid','tg_user.id','tg_user.last_name','tg_user.first_name')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->get();
                    foreach ($users as $key => $value) {
                        $userarrayreg[] = $value->id;
                    }
            }
            return $userarrayreg;

    }
}

    if(!function_exists('getRegion')){
            function getRegion()
        {
            if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
            {
                $regionId = DB::table('tg_region')->pluck('id');
            }
            else{
                $regionId = [];
                    foreach (Session::get('per') as $key => $value) {
                        if (is_numeric($key)){
                            $regionId[] = $key;
                        }
                    }
            }
            return $regionId;
        }

    }
    if(!function_exists('rmDay')){
            function rmDay()
        {
            if(intval(date('h',strtotime(date_now()))) >= 0 && intval(date('h',strtotime(date_now()))) <= 13) 
            {
                $day = 1;
            }else{
                $day = 0;
            }
            return $day;

        }
    }

    if(!function_exists('h_positions')){
        function h_positions()
    {
        $h_positions = [
            'dash' => 'Dashboard',
            'filter' => 'Filter',
            'elchi' => 'Elchi',
            'elchi-day' => 'Elchi kunlik',
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
            'accept'=> 'Kirimlar',
            'stock'=>'Qoldiqlar',
            'user-pharm'=>'User Dorixona'
        ];
        // $knowledge = Knowledge::first();
        // $h_positions['pharmacy'] = 'Dorixona';
        $h_positions['user_pharmacy'] = 'Dorixona - user';
        $h_positions['farm_pm'] = 'Dorixona - plus - minus';
        $h_positions['team'] = 'Jamoa';
        $h_positions['narx'] = 'Narx';
        $h_positions['zavod'] = 'Zavod';
        $h_positions['control'] = 'User control';
        $h_positions['bilim'] = 'Bilim';
        $department = DB::table('tg_department')->where('status',1)->get();
        foreach ($department as $key => $value) {
            $h_positions['d'.$value->id] = $value->name;
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

if(!function_exists('b_positions')){
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

    if(!function_exists('h_actions')){
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
    if(!function_exists('b_actions')){
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
    if (! function_exists('get_visitor_IP'))
{
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
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)){
                    return $ip;
                }
            }
        }
        return $_SERVER['REMOTE_ADDR'];
    }
}




?>
