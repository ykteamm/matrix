<?php 
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

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
            'User' => 'User',
            'rol' => 'Rol',
            'region' => 'Barcha viloyat',
        ];
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
    



?>