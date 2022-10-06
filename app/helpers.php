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
    if(!function_exists('setSchemaInConnection')){
            function setSchemaInConnection()
        {
            Config::set("database.connections.pgsql.schema", Session::get('db'));
            $query = 'SET search_path TO ' . '"'.Session::get('db').'"';
            DB::statement($query);
            
        }
    }
    
    if(!function_exists('setArt')){
        function setArt($db)
    {
        Config::set("database.connections.pgsql.schema", $db);
        $query = 'SET search_path TO ' . '"'.$db.'"';
        DB::statement($query);
        Artisan::call('migrate:refresh', [
            '--force' => true,
        ]);
        
    }
}
    if(!function_exists('setPublic')){
        function setPublic($db)
    {
        Config::set("database.connections.pgsql.schema", $db);
        $query = 'SET search_path TO ' . '"'.$db.'"';
        DB::statement($query);
        
    }
}

    if(!function_exists('setSchema')){
            function setSchema($db)
        {
            Config::set("database.connections.pgsql.schema", $db);
            $query = 'SET search_path TO ' . '"'.$db.'"';
            DB::statement($query);
            
        }
    }
    if(!function_exists('positions')){
            function positions()
        {
            $positions = [
                'hospital' => 'Больница',
                'branch' => 'Филиал',
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
            return $positions;
            
        }
    }

    if(!function_exists('h_positions')){
        function h_positions()
    {
        $h_positions = [
            'dash' => 'Dashboard',
            'filter' => 'Filter',
            'elchi' => 'Elchi',
            'pro' => 'Mahsulotlar',
            'grade' => 'Baholash',
            'ques' => 'Savollar',
            'setting' => 'Sozlamalar',
            'User' => 'User',
            'rol' => 'Rol',
            'region' => 'Barcha viloyat',
        ];
        $knowledge = Knowledge::first();
        $h_positions['bilim'.$knowledge->id] = $knowledge->name;
        $department = DB::table('tg_department')->where('status',1)->get();
        foreach ($department as $key => $value) {
            $h_positions['d'.$value->id] = $value->name;
        }
        
        $region = DB::table('tg_region')->get();
        foreach ($region as $key => $value) {
            $h_positions[$value->id] = $value->name;
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