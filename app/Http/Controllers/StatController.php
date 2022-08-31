<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\Patient;
use App\Models\Province;
use App\Models\Ekg;
use App\Models\Exo;
class StatController extends Controller
{
    public function dateChart(Request $request)
    {
        setSchema('@h1%');
        if ($request->date == 'a_today') {
            $date_begin = today();
            $date_end = today();
        }
        if ($request->date == 'a_week') {
            if(date('N', time()) == 1) 
        { $date_begin = date('Y-m-d'); }
        else {$date_begin = date('Y-m-d', strtotime('last Monday'));}
            $date_end = today()->format('Y-m-d');

        }
        if ($request->date == 'a_month') {
            $date_begin = today()->format('Y-m-01');
            $date_end = today()->format('Y-m-d');

        }
        if ($request->date == 'a_year') {
            $date_begin = today()->format('Y-01-01');
            $date_end = today()->format('Y-m-d');

        }
        if ($request->date == 'a_all') {
            $date_end = DB::table('patients')->max('case_date');
            $date_begin = DB::table('patients')->min('case_date');
        }
            $date1=date_create($date_end);

            $date2=date_create($date_begin);
            $diff=date_diff($date1,$date2);

        $kun = $diff->days+1;
        $oy = $diff->m+1;
        $yil = $diff->y+1;
        if ($request->check) {
            $check_array = explode(",",$request->check);
        }
            if($diff->m == 0 && $diff->y == 0)
            {
                $date_begin = date('Y-m-d',(strtotime ( '- 1 day' , strtotime ( $date_begin ) ) ));

                $date_array = [];
                for($i = 1; $i <= $kun ; $i++)
                {
                    $plus = '+ 1 day'; 
                    $date_begin = date('Y-m-d',(strtotime ( $plus , strtotime ( $date_begin ) ) ));
                    $date_array[] = date('Y-m-d', strtotime($date_begin));
                }

                
                if ($request->tab == 'all_count'){
                    $all_count = [];
                    $date_e = [];
                foreach ($date_array as $key => $value) {
                    $all_query = DB::table('patients')->whereDate('case_date','=',$value);
                    foreach ($check_array as $keys => $values) {
                        if ($values == 'male') {
                            $all_query->where('gender',true);
                        }
                        if ($values == 'female') {
                            $all_query->where('gender',false);
                        }
                        if ($values == '29') {
                            $all_query->where('age','<=',29);
                        }
                        if ($values == '3045') {
                            $all_query->where('age','>=',30);
                            $all_query->where('age','<=',45);
                        }
                        if ($values == '4655') {
                            $all_query->where('age','>=',46);
                            $all_query->where('age','<=',55);
                        }
                        if ($values == '5665') {
                            $all_query->where('age','>=',56);
                            $all_query->where('age','<=',65);
                        }
                        if ($values == '6675') {
                            $all_query->where('age','>=',66);
                            $all_query->where('age','<=',75);
                        }
                        if ($values == '75') {
                            $all_query->where('age','>=',75);
                        }
                        if ($values == 'skori') {
                            $all_query->where('admission',false);
                        }
                        if ($values == 'samotek') {
                            $all_query->where('admission',true);
                        }
                        if ($values == 'ag') {
                            $all_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                        }
                        if ($values == 'sdtip') {
                            $all_query->where('illness', 'LIKE', '%"tip":"app.tip"%');
                        }
                        if ($values == 'ojireniya') {
                            $all_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                        }
                        if ($values == 'giper') {
                            $all_query->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                        }
                        if ($values == 'chkb') {
                            $all_query->where('treatment_tip','app.chkb');
                        }
                        if ($values == 'tlt') {
                            $all_query->where('treatment_tip','app.tlt');
                        }
                        if ($values == 'live') {
                            $all_query->where('death',true);
                        }
                        if ($values == 'dead') {
                            $all_query->where('death',false);
                        }
                    }
                    $all_count[] = $all_query->count();
                    $date_e[] = date('d.m.Y', strtotime($value));

                }
                    return [
                        'all_count' => $all_count,
                        'date_array' => $date_e,
                    ];

                }
                if ($request->tab == 'pol_count'){
                    $male_count = [];
                    $female_count = [];
                    $check_count = [];
                    $date_e = [];
                    foreach ($date_array as $key => $value) {
                        $male_query = DB::table('patients')->whereDate('case_date','=',$value);
                        $female_query = DB::table('patients')->whereDate('case_date','=',$value);
                        $check_query = DB::table('patients')->whereDate('case_date','=',$value);
                        if (!in_array('male',$check_array) && !in_array('female',$check_array)) {
                            $male_query->where('gender',true);
                            $female_query->where('gender',false);
                            foreach ($check_array as $keys => $values) {
                                if ($values == '29') {
                                    $male_query->where('age','<=',29);
                                    $female_query->where('age','<=',29);
                                }
                                if ($values == '3045') {
                                    $male_query->where('age','>=',30)->where('age','<=',45);
                                    $female_query->where('age','>=',30)->where('age','<=',45);
                                }
                                if ($values == '4655') {
                                    $male_query->where('age','>=',46)->where('age','<=',55);
                                    $female_query->where('age','>=',46)->where('age','<=',55);
                                }
                                if ($values == '5665') {
                                    $male_query->where('age','>=',56)->where('age','<=',65);
                                    $female_query->where('age','>=',56)->where('age','<=',65);
                                }
                                if ($values == '6675') {
                                    $male_query->where('age','>=',66)->where('age','<=',75);
                                    $female_query->where('age','>=',66)->where('age','<=',75);
                                }
                                if ($values == '75') {
                                    $male_query->where('age','>=',75);
                                    $female_query->where('age','>=',75);
                                }
                                if ($values == 'skori') {
                                    $male_query->where('admission',false);
                                    $female_query->where('admission',false);
                                }
                                if ($values == 'samotek') {
                                    $male_query->where('admission',true);
                                    $female_query->where('admission',true);
                                }
                                if ($values == 'chkb') {
                                    $male_query->where('treatment_tip','app.chkb');
                                    $female_query->where('treatment_tip','app.chkb');
                                }
                                if ($values == 'tlt') {
                                    $male_query->where('treatment_tip','app.tlt');
                                    $female_query->where('treatment_tip','app.tlt');
                                }
                                if ($values == 'ag') {
                                    $male_query->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                    $female_query->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                }
                                if ($values == 'sdtip') {
                                    $male_query->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                    $female_query->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                }
                                if ($values == 'ojireniya') {
                                    $male_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $female_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                }
                                if ($values == 'giper') {
                                    $male_query->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                    $female_query->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                }
                                if ($values == 'live') {
                                    $male_query->where('death',true);
                                    $female_query->where('death',true);
                                }
                                if ($values == 'dead') {
                                    $male_query->where('death',false);
                                    $female_query->where('death',false);
                                }
                            }
                        }else{
                            foreach ($check_array as $keys => $values) {
                                if ($values == 'male') {
                                    $check_query->where('gender',true);
                                }
                                if ($values == 'female') {
                                    $check_query->where('gender',false);
                                }
                                if ($values == '29') {
                                    $check_query->where('age','<=',29);
                                }
                                if ($values == '3045') {
                                    $check_query->where('age','>=',30);
                                    $check_query->where('age','<=',45);
                                }
                                if ($values == '4655') {
                                    $check_query->where('age','>=',46);
                                    $check_query->where('age','<=',55);
                                }
                                if ($values == '5665') {
                                    $check_query->where('age','>=',56);
                                    $check_query->where('age','<=',65);
                                }
                                if ($values == '6675') {
                                    $check_query->where('age','>=',66);
                                    $check_query->where('age','<=',75);
                                }
                                if ($values == '75') {
                                    $check_query->where('age','>=',75);
                                }
                                if ($values == 'skori') {
                                    $check_query->where('admission',false);
                                }
                                if ($values == 'samotek') {
                                    $check_query->where('admission',true);
                                }
                                if ($values == 'ag') {
                                    $check_query->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                }
                                if ($values == 'sdtip') {
                                    $check_query->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                }
                                if ($values == 'ojireniya') {
                                    $check_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                }
                                if ($values == 'giper') {
                                    $check_query->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                }
                                if ($values == 'chkb') {
                                    $check_query->where('treatment_tip','app.chkb');
                                }
                                if ($values == 'tlt') {
                                    $check_query->where('treatment_tip','app.tlt');
                                }
                                if ($values == 'live') {
                                    $check_query->where('death',true);
                                }
                                if ($values == 'dead') {
                                    $check_query->where('death',false);
                                }
                            }
                        }
                            $male_count[] = $male_query->count();
                            $female_count[] = $female_query->count();
                            $check_count[] = $check_query->count();
                        $date_e[] = date('d.m.Y', strtotime($value));
                        }
                        if (!in_array('male',$check_array) && !in_array('female',$check_array)) {
                            return [
                                'male_count' => $male_count,
                                'female_count' => $female_count,
                                'date_array' => $date_e,
                            ];
                        }else{
                            $lebel = '';
                            foreach ($check_array as $keyr => $valuer) {
                                if ($valuer == 'male') {
                                    $lebel = 'male';
                                }
                                if ($valuer == 'female') {
                                    $lebel = 'female';

                                }
                            }
                            return [
                                // 'male_count' => $male_count,
                                'lebel' => $lebel,
                                'check' => $check_count,
                                'date_array' => $date_e,
                            ];
                        }
                        
                }
                if ($request->tab == 'age_count'){
                    $age_29 = [];
                    $age_30 = [];
                    $age_46 = [];
                    $age_56 = [];
                    $age_66 = [];
                    $age_76 = [];
                    $check_count = [];
                    $date_e = [];

                    foreach ($date_array as $key => $value) {
                        $age_29s = DB::table('patients')->whereDate('case_date','=',$value)->where('age','<=',29);
                            $age_30s = DB::table('patients')->whereDate('case_date','=',$value)->where('age','>=',30)->where('age','<=',45);
                            $age_46s = DB::table('patients')->whereDate('case_date','=',$value)->where('age','>=',46)->where('age','<=',55);
                            $age_56s = DB::table('patients')->whereDate('case_date','=',$value)->where('age','>=',56)->where('age','<=',65);
                            $age_66s = DB::table('patients')->whereDate('case_date','=',$value)->where('age','>=',66)->where('age','<=',75);
                            $age_76s = DB::table('patients')->whereDate('case_date','=',$value)->where('age','>=',76);
                            $check_query = DB::table('patients')->whereDate('case_date','=',$value);

                    
                        if (!in_array('29',$check_array) && !in_array('3045',$check_array) && !in_array('4655',$check_array) && !in_array('5665',$check_array) && !in_array('6675',$check_array) && !in_array('75',$check_array)) {
                            foreach ($check_array as $keys => $values) {
                                if ($values == 'male') {
                                    $age_29s->where('gender',true);
                                    $age_30s->where('gender',true);
                                    $age_46s->where('gender',true);
                                    $age_56s->where('gender',true);
                                    $age_66s->where('gender',true);
                                    $age_76s->where('gender',true);
                                }
                                if ($values == 'female') {
                                    $age_29s->where('gender',false);
                                    $age_30s->where('gender',false);
                                    $age_46s->where('gender',false);
                                    $age_56s->where('gender',false);
                                    $age_66s->where('gender',false);
                                    $age_76s->where('gender',false);
                                }
                                if ($values == 'skori') {
                                    $age_29s->where('admission',false);
                                    $age_30s->where('admission',false);
                                    $age_46s->where('admission',false);
                                    $age_56s->where('admission',false);
                                    $age_66s->where('admission',false);
                                    $age_76s->where('admission',false);
                                }
                                if ($values == 'samotek') {
                                    $age_29s->where('admission',true);
                                    $age_30s->where('admission',true);
                                    $age_46s->where('admission',true);
                                    $age_56s->where('admission',true);
                                    $age_66s->where('admission',true);
                                    $age_76s->where('admission',true);
                                }
                                if ($values == 'chkb') {
                                    $age_29s->where('treatment_tip','app.chkb');
                                    $age_30s->where('treatment_tip','app.chkb');
                                    $age_46s->where('treatment_tip','app.chkb');
                                    $age_56s->where('treatment_tip','app.chkb');
                                    $age_66s->where('treatment_tip','app.chkb');
                                    $age_76s->where('treatment_tip','app.chkb');
                                }
                                if ($values == 'tlt') {
                                    $age_29s->where('treatment_tip','app.tlt');
                                    $age_30s->where('treatment_tip','app.tlt');
                                    $age_46s->where('treatment_tip','app.tlt');
                                    $age_56s->where('treatment_tip','app.tlt');
                                    $age_66s->where('treatment_tip','app.tlt');
                                    $age_76s->where('treatment_tip','app.tlt');
                                }
                                if ($values == 'ag') {
                                    $age_29s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $age_30s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $age_46s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $age_56s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $age_66s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $age_76s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                }
                                if ($values == 'sdtip') {
                                    $age_29s->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                    $age_30s->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                    $age_46s->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                    $age_56s->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                    $age_66s->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                    $age_76s->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                }
                                if ($values == 'ojireniya') {
                                    $age_29s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $age_30s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $age_46s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $age_56s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $age_66s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $age_76s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                }
                                if ($values == 'giper') {
                                    $age_29s->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                    $age_30s->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                    $age_46s->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                    $age_56s->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                    $age_66s->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                    $age_76s->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                }
                                if ($values == 'live') {
                                    $age_29s->where('death',true);
                                    $age_30s->where('death',true);
                                    $age_46s->where('death',true);
                                    $age_56s->where('death',true);
                                    $age_66s->where('death',true);
                                    $age_76s->where('death',true);
                                }
                                if ($values == 'dead') {
                                    $age_29s->where('death',false);
                                    $age_30s->where('death',false);
                                    $age_46s->where('death',false);
                                    $age_56s->where('death',false);
                                    $age_66s->where('death',false);
                                    $age_76s->where('death',false);
                                }
                            }
                            $age_29[] = $age_29s->count();
                            $age_30[] = $age_30s->count();
                            $age_46[] = $age_46s->count();
                            $age_56[] = $age_56s->count();
                            $age_66[] = $age_66s->count();
                            $age_76[] = $age_76s->count();
                            $date_e[] = date('d.m.Y', strtotime($value));

                        
                        
                         }else{

                            foreach ($check_array as $keys => $values) {
                                if ($values == 'male') {
                                    $check_query->where('age',true);
                                }
                                if ($values == 'female') {
                                    $check_query->where('age',false);
                                }
                                if ($values == '29') {
                                    $check_query->where('age','<=',29);
                                }
                                if ($values == '3045') {
                                    $check_query->where('age','>=',30)->where('age','<=',45);
                                }
                                if ($values == '4655') {
                                    $check_query->where('age','>=',46)->where('age','<=',55);
                                }
                                if ($values == '5665') {
                                    $check_query->where('age','>=',56)->where('age','<=',65);
                                }
                                if ($values == '6675') {
                                    $check_query->where('age','>=',66)->where('age','<=',75);
                                }
                                if ($values == '75') {
                                    $check_query->where('age','>=',75);
                                }
                                if ($values == 'skori') {
                                    $check_query->where('admission',false);
                                }
                                if ($values == 'samotek') {
                                    $check_query->where('admission',true);
                                }
                                if ($values == 'chkb') {
                                    $check_query->where('treatment_tip','app.chkb');
                                }
                                if ($values == 'tlt') {
                                    $check_query->where('treatment_tip','app.tlt');
                                }
                                if ($values == 'ag') {
                                    $check_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                }
                                if ($values == 'sdtip') {
                                    $check_query->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                }
                                if ($values == 'ojireniya') {
                                    $check_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                }
                                if ($values == 'giper') {
                                    $check_query->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                }
                                if ($values == 'live') {
                                    $check_query->where('death',true);
                                }
                                if ($values == 'dead') {
                                    $check_query->where('death',false);
                                }
                            }
                            $check_count[] = $check_query->count();
                            $date_e[] = date('d.m.Y', strtotime($value));
                            }
                    
                            
                        }
                        $lebel = '';
                        if (!in_array('29',$check_array) && !in_array('3045',$check_array) && !in_array('4655',$check_array) && !in_array('5665',$check_array) && !in_array('6675',$check_array) && !in_array('75',$check_array)) {
                            return [
                                'age_29' => $age_29,
                                'age_30' => $age_30,
                                'age_46' => $age_46,
                                'age_56' => $age_56,
                                'age_66' => $age_66,
                                'age_76' => $age_76,
                                'date_array' => $date_e,
                            ];
                            }else{
                                
                                foreach ($check_array as $keys => $values) {
                                    if ($values == '29') {
                                        $lebel = '-29';
                                    }
                                    if ($values == '3045') {
                                        $lebel = '30-45';
                                    }
                                    if ($values == '4655') {
                                        $lebel = '46-55';
                                    }
                                    if ($values == '5665') {
                                        $lebel = '56-65';
                                    }
                                    if ($values == '6675') {
                                        $lebel = '66-75';
                                    }
                                    if ($values == '75') {
                                        $lebel = '75-';
                                    }
                                }
                                return [
                                    'lebel' => $lebel,
                                    'check_count' => $check_count,
                                    'date_array' => $date_e,
                                ];
                            }
                    
                        
                }
                if ($request->tab == 'come_count'){
                    $skori_count = [];
                    $net_skori_count = [];
                    $check_count = [];
                    $date_e = [];
                    foreach ($date_array as $key => $value) {
                        $skori_counts = DB::table('patients')->whereDate('case_date','=',$value)->where('admission',true);
                        $net_skori_counts = DB::table('patients')->whereDate('case_date','=',$value)->where('admission',false);
                        $check_counts = DB::table('patients')->whereDate('case_date','=',$value);
                        if (!in_array('skori',$check_array) && !in_array('samotek',$check_array)) {
                            foreach ($check_array as $keys => $values) {
                                if ($values == 'male') {
                                    $skori_counts->where('gender',true);
                                    $net_skori_counts->where('gender',true);
                                }
                                if ($values == 'female') {
                                    $skori_counts->where('gender',false);
                                    $net_skori_counts->where('gender',false);
                                }
                                if ($values == '29') {
                                    $skori_counts->where('age','<=',29);
                                    $net_skori_counts->where('age','<=',29);
                                }
                                if ($values == '3045') {
                                    $skori_counts->where('age','>=',30)->where('age','<=',45);
                                    $net_skori_counts->where('age','>=',30)->where('age','<=',45);
                                }
                                if ($values == '4655') {
                                    $skori_counts->where('age','>=',46)->where('age','<=',55);
                                    $net_skori_counts->where('age','>=',46)->where('age','<=',55);
                                }
                                if ($values == '5665') {
                                    $skori_counts->where('age','>=',56)->where('age','<=',65);
                                    $net_skori_counts->where('age','>=',56)->where('age','<=',65);
                                }
                                if ($values == '6675') {
                                    $skori_counts->where('age','>=',66)->where('age','<=',75);
                                    $net_skori_counts->where('age','>=',66)->where('age','<=',75);
                                }
                                if ($values == '75') {
                                    $skori_counts->where('age','>=',75);
                                    $net_skori_counts->where('age','>=',75);
                                }
                                if ($values == 'chkb') {
                                    $skori_counts->where('treatment_tip','app.chkb');
                                    $net_skori_counts->where('treatment_tip','app.chkb');
                                }
                                if ($values == 'tlt') {
                                    $skori_counts->where('treatment_tip','app.tlt');
                                    $net_skori_counts->where('treatment_tip','app.tlt');
                                }
                                if ($values == 'ag') {
                                    $skori_counts->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                    $net_skori_counts->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                }
                                if ($values == 'sdtip') {
                                    $skori_counts->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                    $net_skori_counts->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                }
                                if ($values == 'ojireniya') {
                                    $skori_counts->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $net_skori_counts->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                }
                                if ($values == 'giper') {
                                    $skori_counts->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                    $net_skori_counts->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                }
                                if ($values == 'live') {
                                    $skori_counts->where('death',true);
                                    $net_skori_counts->where('death',true);
                                }
                                if ($values == 'dead') {
                                    $skori_counts->where('death',false);
                                    $net_skori_counts->where('death',false);
                                }
                            }
                        } else {
                            foreach ($check_array as $keys => $values) {
                                if ($values == 'male') {
                                    $check_counts->where('gender',true);
                                }
                                if ($values == 'female') {
                                    $check_counts->where('gender',false);
                                }
                                if ($values == '29') {
                                    $check_counts->where('age','<=',29);
                                }
                                if ($values == '3045') {
                                    $check_counts->where('age','>=',30)->where('age','<=',45);
                                }
                                if ($values == '4655') {
                                    $check_counts->where('age','>=',46)->where('age','<=',55);
                                }
                                if ($values == '5665') {
                                    $check_counts->where('age','>=',56)->where('age','<=',65);
                                }
                                if ($values == '6675') {
                                    $check_counts->where('age','>=',66)->where('age','<=',75);
                                }
                                if ($values == '75') {
                                    $check_counts->where('age','>=',75);
                                }
                                if ($values == 'skori') {
                                    $check_counts->where('admission',false);
                                }
                                if ($values == 'samotek') {
                                    $check_counts->where('admission',true);
                                }
                                if ($values == 'chkb') {
                                    $check_counts->where('treatment_tip','app.chkb');
                                }
                                if ($values == 'tlt') {
                                    $check_counts->where('treatment_tip','app.tlt');
                                }
                                if ($values == 'ag') {
                                    $check_counts->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                }
                                if ($values == 'sdtip') {
                                    $check_counts->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                }
                                if ($values == 'ojireniya') {
                                    $check_counts->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                }
                                if ($values == 'giper') {
                                    $check_counts->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                }
                                if ($values == 'live') {
                                    $check_counts->where('death',true);
                                }
                                if ($values == 'dead') {
                                    $check_counts->where('death',false);
                                }
                            }
                        }
                            $skori_count[] = $skori_counts->count();
                            $net_skori_count[] = $net_skori_counts->count();
                            $check_count[] = $check_counts->count();
                            $date_e[] = date('d.m.Y', strtotime($value));

                        }
                        $lebel = '';
                        if (!in_array('skori',$check_array) && !in_array('samotek',$check_array)) {
                            return [
                                'skori_count' => $skori_count,
                                'net_skori_count' => $net_skori_count,
                                'date_array' => $date_e,
                            ];
                        }else{
                            foreach ($check_array as $keys => $values) {
                                if ($values == 'skori') {
                                    $lebel = 'skori';
                                }
                                if ($values == 'samotek') {
                                    $lebel = 'samotek';
                                }
                            }
                            return [
                                'skori_count' => $check_count,
                                'lebel' => $lebel,
                                'date_array' => $date_e,
                            ];
                        }
                }
                if ($request->tab == 'dia_count'){
                    $ag_count = [];
                    $tip_count = [];
                    $oji_count = [];
                    $check_count = [];
                    $date_e = [];
                        foreach ($date_array as $key => $value) {
                            $ag_counts = DB::table('patients')->whereDate('case_date','=',$value)->where('illness', 'LIKE', '%"ag":"app.ag"%');
                            $tip_counts = DB::table('patients')->whereDate('case_date','=',$value)->where('illness', 'LIKE', '%"tip":"app.tip"%');
                            $oji_counts = DB::table('patients')->whereDate('case_date','=',$value)->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                            $giper_counts = DB::table('patients')->whereDate('case_date','=',$value)->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                            $check_counts = DB::table('patients')->whereDate('case_date','=',$value);
                            if (!in_array('ag',$check_array) && !in_array('sdtip',$check_array) && !in_array('ojireniya',$check_array) && !in_array('giper',$check_array)) {
                                foreach ($check_array as $keys => $values) {
                                    if ($values == 'male') {
                                        $ag_counts->where('gender',true);
                                        $tip_counts->where('gender',true);
                                        $oji_counts->where('gender',true);
                                        $giper_counts->where('gender',true);
                                    }
                                    if ($values == 'female') {
                                        $ag_counts->where('gender',false);
                                        $tip_counts->where('gender',false);
                                        $oji_counts->where('gender',false);
                                        $giper_counts->where('gender',false);
                                    }
                                    if ($values == '29') {
                                        $ag_counts->where('age','<=',29);
                                        $tip_counts->where('age','<=',29);
                                        $oji_counts->where('age','<=',29);
                                        $giper_counts->where('age','<=',29);
                                    }
                                    if ($values == '3045') {
                                        $ag_counts->where('age','>=',30)->where('age','<=',45);
                                        $tip_counts->where('age','>=',30)->where('age','<=',45);
                                        $oji_counts->where('age','>=',30)->where('age','<=',45);
                                        $giper_counts->where('age','>=',30)->where('age','<=',45);
                                    }
                                    if ($values == '4655') {
                                        $ag_counts->where('age','>=',46)->where('age','<=',55);
                                        $tip_counts->where('age','>=',46)->where('age','<=',55);
                                        $oji_counts->where('age','>=',46)->where('age','<=',55);
                                        $giper_counts->where('age','>=',46)->where('age','<=',55);
                                    }
                                    if ($values == '5665') {
                                        $ag_counts->where('age','>=',56)->where('age','<=',65);
                                        $tip_counts->where('age','>=',56)->where('age','<=',65);
                                        $oji_counts->where('age','>=',56)->where('age','<=',65);
                                        $giper_counts->where('age','>=',56)->where('age','<=',65);
                                    }
                                    if ($values == '6675') {
                                        $ag_counts->where('age','>=',66)->where('age','<=',75);
                                        $tip_counts->where('age','>=',66)->where('age','<=',75);
                                        $oji_counts->where('age','>=',66)->where('age','<=',75);
                                        $giper_counts->where('age','>=',66)->where('age','<=',75);
                                    }
                                    if ($values == '75') {
                                        $ag_counts->where('age','>=',75);
                                        $tip_counts->where('age','>=',75);
                                        $oji_counts->where('age','>=',75);
                                        $giper_counts->where('age','>=',75);
                                    }
                                    if ($values == 'chkb') {
                                        $ag_counts->where('treatment_tip','app.chkb');
                                        $tip_counts->where('treatment_tip','app.chkb');
                                        $oji_counts->where('treatment_tip','app.chkb');
                                        $giper_counts->where('treatment_tip','app.chkb');
                                    }
                                    if ($values == 'tlt') {
                                        $ag_counts->where('treatment_tip','app.tlt');
                                        $tip_counts->where('treatment_tip','app.tlt');
                                        $oji_counts->where('treatment_tip','app.tlt');
                                        $giper_counts->where('treatment_tip','app.tlt');
                                    }
                                    if ($values == 'live') {
                                        $ag_counts->where('death',true);
                                        $tip_counts->where('death',true);
                                        $oji_counts->where('death',true);
                                        $giper_counts->where('death',true);
                                    }
                                    if ($values == 'dead') {
                                        $ag_counts->where('death',false);
                                        $tip_counts->where('death',false);
                                        $oji_counts->where('death',false);
                                        $giper_counts->where('death',false);
                                    }
                                }
                            } else {
                                foreach ($check_array as $keys => $values) {
                                    if ($values == 'male') {
                                        $check_counts->where('gender',true);
                                    }
                                    if ($values == 'female') {
                                        $check_counts->where('gender',false);
                                    }
                                    if ($values == '29') {
                                        $check_counts->where('age','<=',29);
                                    }
                                    if ($values == '3045') {
                                        $check_counts->where('age','>=',30)->where('age','<=',45);
                                    }
                                    if ($values == '4655') {
                                        $check_counts->where('age','>=',46)->where('age','<=',55);
                                    }
                                    if ($values == '5665') {
                                        $check_counts->where('age','>=',56)->where('age','<=',65);
                                    }
                                    if ($values == '6675') {
                                        $check_counts->where('age','>=',66)->where('age','<=',75);
                                    }
                                    if ($values == '75') {
                                        $check_counts->where('age','>=',75);
                                    }
                                    if ($values == 'skori') {
                                        $check_counts->where('admission',false);
                                    }
                                    if ($values == 'samotek') {
                                        $check_counts->where('admission',true);
                                    }
                                    if ($values == 'chkb') {
                                        $check_counts->where('treatment_tip','app.chkb');
                                    }
                                    if ($values == 'tlt') {
                                        $check_counts->where('treatment_tip','app.tlt');
                                    }
                                    if ($values == 'ag') {
                                        $check_counts->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                    }
                                    if ($values == 'sdtip') {
                                        $check_counts->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                    }
                                    if ($values == 'ojireniya') {
                                        $check_counts->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    }
                                    if ($values == 'giper') {
                                        $check_counts->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                    }
                                    if ($values == 'live') {
                                        $check_counts->where('death',true);
                                    }
                                    if ($values == 'dead') {
                                        $check_counts->where('death',false);
                                    }
                                }
                            }
                                $ag_count[] = $ag_counts->count();
                                $tip_count[] = $tip_counts->count();
                                $oji_count[] = $oji_counts->count();
                                $giper_count[] = $giper_counts->count();
                                $check_count[] = $check_counts->count();
                                $date_e[] = date('d.m.Y', strtotime($value));
    
                            }
                            if (!in_array('ag',$check_array) && !in_array('sdtip',$check_array) && !in_array('ojireniya',$check_array) && !in_array('giper',$check_array)) {
                                return [
                                    'ag_count' => $ag_count,
                                    'tip_count' => $tip_count,
                                    'oji_count' => $oji_count,
                                    'giper_count' => $giper_count,
                                    'date_array' => $date_e,
                                ];
                            }else{
                                return [
                                    'check_count' => $check_count,
                                    'date_array' => $date_e,
                                ];
                            }
                        
                }
                if ($request->tab == 'ill_count'){
                    $death_count = [];
                    $live_count = [];
                    $check_count = [];
                    $date_e = [];
                    foreach ($date_array as $key => $value) {
                        $death_query = DB::table('patients')->whereDate('case_date','=',$value);
                        $live_query = DB::table('patients')->whereDate('case_date','=',$value);
                        $check_query = DB::table('patients')->whereDate('case_date','=',$value);
                        if (!in_array('death',$check_array) && !in_array('live',$check_array)) {
                            $death_query->where('death',false);
                            $live_query->where('death',true);
                            foreach ($check_array as $keys => $values) {
                                if ($values == 'male') {
                                    $death_query->where('gender',true);
                                    $live_query->where('gender',true);
                                }
                                if ($values == 'female') {
                                    $death_query->where('gender',false);
                                    $live_query->where('gender',false);
                                }
                                if ($values == '29') {
                                    $death_query->where('age','<=',29);
                                    $live_query->where('age','<=',29);
                                }
                                if ($values == '3045') {
                                    $death_query->where('age','>=',30)->where('age','<=',45);
                                    $live_query->where('age','>=',30)->where('age','<=',45);
                                }
                                if ($values == '4655') {
                                    $death_query->where('age','>=',46)->where('age','<=',55);
                                    $live_query->where('age','>=',46)->where('age','<=',55);
                                }
                                if ($values == '5665') {
                                    $death_query->where('age','>=',56)->where('age','<=',65);
                                    $live_query->where('age','>=',56)->where('age','<=',65);
                                }
                                if ($values == '6675') {
                                    $death_query->where('age','>=',66)->where('age','<=',75);
                                    $live_query->where('age','>=',66)->where('age','<=',75);
                                }
                                if ($values == '75') {
                                    $death_query->where('age','>=',75);
                                    $live_query->where('age','>=',75);
                                }
                                if ($values == 'skori') {
                                    $death_query->where('admission',false);
                                    $live_query->where('admission',false);
                                }
                                if ($values == 'samotek') {
                                    $death_query->where('admission',true);
                                    $live_query->where('admission',true);
                                }
                                if ($values == 'chkb') {
                                    $death_query->where('treatment_tip','app.chkb');
                                    $live_query->where('treatment_tip','app.chkb');
                                }
                                if ($values == 'tlt') {
                                    $death_query->where('treatment_tip','app.tlt');
                                    $live_query->where('treatment_tip','app.tlt');
                                }
                                if ($values == 'ag') {
                                    $death_query->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                    $live_query->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                }
                                if ($values == 'sdtip') {
                                    $death_query->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                    $live_query->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                }
                                if ($values == 'ojireniya') {
                                    $death_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                    $live_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                }
                                if ($values == 'giper') {
                                    $death_query->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                    $live_query->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                }
                            }
                        }else{
                            foreach ($check_array as $keys => $values) {
                                if ($values == 'male') {
                                    $check_query->where('gender',true);
                                }
                                if ($values == 'female') {
                                    $check_query->where('gender',false);
                                }
                                if ($values == '29') {
                                    $check_query->where('age','<=',29);
                                }
                                if ($values == '3045') {
                                    $check_query->where('age','>=',30);
                                    $check_query->where('age','<=',45);
                                }
                                if ($values == '4655') {
                                    $check_query->where('age','>=',46);
                                    $check_query->where('age','<=',55);
                                }
                                if ($values == '5665') {
                                    $check_query->where('age','>=',56);
                                    $check_query->where('age','<=',65);
                                }
                                if ($values == '6675') {
                                    $check_query->where('age','>=',66);
                                    $check_query->where('age','<=',75);
                                }
                                if ($values == '75') {
                                    $check_query->where('age','>=',75);
                                }
                                if ($values == 'skori') {
                                    $check_query->where('admission',false);
                                }
                                if ($values == 'samotek') {
                                    $check_query->where('admission',true);
                                }
                                if ($values == 'ag') {
                                    $check_query->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                }
                                if ($values == 'sdtip') {
                                    $check_query->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                }
                                if ($values == 'ojireniya') {
                                    $check_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                }
                                if ($values == 'giper') {
                                    $check_query->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                }
                                if ($values == 'chkb') {
                                    $check_query->where('treatment_tip','app.chkb');
                                }
                                if ($values == 'tlt') {
                                    $check_query->where('treatment_tip','app.tlt');
                                }
                                if ($values == 'live') {
                                    $check_query->where('death',true);
                                }
                                if ($values == 'dead') {
                                    $check_query->where('death',false);
                                }
                            }
                        }
                            $death_count[] = $death_query->count();
                            $live_count[] = $live_query->count();
                            $check_count[] = $check_query->count();
                            $date_e[] = date('d.m.Y', strtotime($value));
                        }
                        if (!in_array('death',$check_array) && !in_array('live',$check_array)) {
                            return [
                                'death_count' => $death_count,
                                'live_count' => $live_count,
                                'date_array' => $date_e,
                            ];
                        }else{
                            $lebel = '';
                            foreach ($check_array as $keyr => $valuer) {
                                if ($valuer == 'male') {
                                    $lebel = 'male';
                                }
                                if ($valuer == 'female') {
                                    $lebel = 'female';

                                }
                            }
                            return [
                                'check_count' => $check_count,
                                'date_array' => $date_e,
                            ];
                        }
                        
                }

            }
            if($diff->m !== 0 && $diff->y == 0)
            {
                $date_array = [];
                $get_month = date('Y-m', strtotime($date_begin));
                $case_month = $get_month.'-01';
                for($i = 0; $i < $oy ; $i++)
                {
                    $plus = '+'.$i.' '.'month';
                    $date_begin = date('Y-m',(strtotime ( $plus , strtotime ( $case_month ) ) ));
                    $date_array[$date_begin.'-01'] = date("Y-m-t", strtotime($date_begin));
                }

                
                if ($request->tab == 'all_count'){
                    $all_count = [];
                    $date_e = [];
                foreach ($date_array as $key => $value) {
                    $all_query = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value);
                    foreach ($check_array as $keys => $values) {
                        if ($values == 'male') {
                            $all_query->where('gender',true);
                        }
                        if ($values == 'female') {
                            $all_query->where('gender',false);
                        }
                        if ($values == '29') {
                            $all_query->where('age','<=',29);
                        }
                        if ($values == '3045') {
                            $all_query->where('age','>=',30);
                            $all_query->where('age','<=',45);
                        }
                        if ($values == '4655') {
                            $all_query->where('age','>=',46);
                            $all_query->where('age','<=',55);
                        }
                        if ($values == '5665') {
                            $all_query->where('age','>=',56);
                            $all_query->where('age','<=',65);
                        }
                        if ($values == '6675') {
                            $all_query->where('age','>=',66);
                            $all_query->where('age','<=',75);
                        }
                        if ($values == '75') {
                            $all_query->where('age','>=',75);
                        }
                        if ($values == 'skori') {
                            $all_query->where('admission',false);
                        }
                        if ($values == 'samotek') {
                            $all_query->where('admission',true);
                        }
                        if ($values == 'chkb') {
                            $all_query->where('treatment_tip','app.chkb');
                        }
                        if ($values == 'tlt') {
                            $all_query->where('treatment_tip','app.tlt');
                        }
                    }
                    $all_count[] = $all_query->count();
                    $date_e[] = date('d.m.Y', strtotime($value));

                    }
                    return [
                        'all_count' => $all_count,
                        'date_array' => $date_e,
                    ];

                }
            if ($request->tab == 'pol_count'){
                $male_count = [];
                $female_count = [];
                $check_count = [];
                $date_e = [];
                foreach ($date_array as $key => $value) {
                    $male_query = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value);
                    $female_query = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value);
                    $check_query = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value);
                    if (!in_array('male',$check_array) && !in_array('female',$check_array)) {
                        $male_query->where('gender',true);
                        $female_query->where('gender',false);
                        foreach ($check_array as $keys => $values) {
                            if ($values == '29') {
                                $male_query->where('age','<=',29);
                                $female_query->where('age','<=',29);
                            }
                            if ($values == '3045') {
                                $male_query->where('age','>=',30);
                                $male_query->where('age','<=',45);
                                $female_query->where('age','>=',30);
                                $female_query->where('age','<=',45);
                            }
                            if ($values == '4655') {
                                $male_query->where('age','>=',46);
                                $male_query->where('age','<=',55);
                                $female_query->where('age','>=',46);
                                $female_query->where('age','<=',55);
                            }
                            if ($values == '5665') {
                                $male_query->where('age','>=',56);
                                $male_query->where('age','<=',65);
                                $female_query->where('age','>=',56);
                                $female_query->where('age','<=',65);
                            }
                            if ($values == '6675') {
                                $male_query->where('age','>=',66);
                                $male_query->where('age','<=',75);
                                $female_query->where('age','>=',66);
                                $female_query->where('age','<=',75);
                            }
                            if ($values == '75') {
                                $male_query->where('age','>=',75);
                                $female_query->where('age','>=',75);
                            }
                            if ($values == 'skori') {
                                $male_query->where('admission',false);
                                $female_query->where('admission',false);
                            }
                            if ($values == 'samotek') {
                                $male_query->where('admission',true);
                                $female_query->where('admission',true);
                            }
                            if ($values == 'chkb') {
                                $male_query->where('treatment_tip','app.chkb');
                                $female_query->where('treatment_tip','app.chkb');
                            }
                            if ($values == 'tlt') {
                                $male_query->where('treatment_tip','app.tlt');
                                $female_query->where('treatment_tip','app.tlt');
                            }
                        }
                    }else{
                        foreach ($check_array as $keys => $values) {
                            if ($values == 'male') {
                                $check_query->where('gender',true);
                            }
                            if ($values == 'female') {
                                $check_query->where('gender',false);
                            }
                            if ($values == '29') {
                                $check_query->where('age','<=',29);
                            }
                            if ($values == '3045') {
                                $check_query->where('age','>=',30);
                                $check_query->where('age','<=',45);
                            }
                            if ($values == '4655') {
                                $check_query->where('age','>=',46);
                                $check_query->where('age','<=',55);
                            }
                            if ($values == '5665') {
                                $check_query->where('age','>=',56);
                                $check_query->where('age','<=',65);
                            }
                            if ($values == '6675') {
                                $check_query->where('age','>=',66);
                                $check_query->where('age','<=',75);
                            }
                            if ($values == '75') {
                                $check_query->where('age','>=',75);
                            }
                            if ($values == 'skori') {
                                $check_query->where('admission',false);
                            }
                            if ($values == 'samotek') {
                                $check_query->where('admission',true);
                            }
                            if ($values == 'chkb') {
                                $check_query->where('treatment_tip','app.chkb');
                            }
                            if ($values == 'tlt') {
                                $check_query->where('treatment_tip','app.tlt');
                            }
                        }
                    }
                        $male_count[] = $male_query->count();
                        $female_count[] = $female_query->count();
                        $check_count[] = $check_query->count();
                    $date_e[] = date('d.m.Y', strtotime($value));
                    }
                    if (!in_array('male',$check_array) && !in_array('female',$check_array)) {
                        return [
                            'male_count' => $male_count,
                            'female_count' => $female_count,
                            'date_array' => $date_e,
                        ];
                    }else{
                        $lebel = '';
                        foreach ($check_array as $keys => $values) {
                            if ($values == 'male') {
                                $lebel = 'male';
                            }
                            if ($values == 'female') {
                                $lebel = 'female';

                            }
                        }
                        return [
                            // 'male_count' => $male_count,
                            'lebel' => $lebel,
                            'check' => $check_count,
                            'date_array' => $date_e,
                        ];
                    }
                    
            }
            if ($request->tab == 'age_count'){
                $age_29 = [];
                $age_30 = [];
                $age_46 = [];
                $age_56 = [];
                $age_66 = [];
                $age_76 = [];
                $check_count = [];
                $date_e = [];

                foreach ($date_array as $key => $value) {
                    $age_29s = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value)->where('age','<=',29);
                        $age_30s = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value)->where('age','>=',30)->where('age','<=',45);
                        $age_46s = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value)->where('age','>=',46)->where('age','<=',55);
                        $age_56s = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value)->where('age','>=',56)->where('age','<=',65);
                        $age_66s = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value)->where('age','>=',66)->where('age','<=',75);
                        $age_76s = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value)->where('age','>=',76);
                        $check_query = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value);

                
                    if (!in_array('29',$check_array) && !in_array('3045',$check_array) && !in_array('4655',$check_array) && !in_array('5665',$check_array) && !in_array('6675',$check_array) && !in_array('75',$check_array)) {
                        foreach ($check_array as $keys => $values) {
                            if ($values == 'male') {
                                $age_29s->where('gender',true);
                                $age_30s->where('gender',true);
                                $age_46s->where('gender',true);
                                $age_56s->where('gender',true);
                                $age_66s->where('gender',true);
                                $age_76s->where('gender',true);
                            }
                            if ($values == 'female') {
                                $age_29s->where('gender',false);
                                $age_30s->where('gender',false);
                                $age_46s->where('gender',false);
                                $age_56s->where('gender',false);
                                $age_66s->where('gender',false);
                                $age_76s->where('gender',false);
                            }
                            if ($values == 'skori') {
                                $age_29s->where('admission',false);
                                $age_30s->where('admission',false);
                                $age_46s->where('admission',false);
                                $age_56s->where('admission',false);
                                $age_66s->where('admission',false);
                                $age_76s->where('admission',false);
                            }
                            if ($values == 'samotek') {
                                $age_29s->where('admission',true);
                                $age_30s->where('admission',true);
                                $age_46s->where('admission',true);
                                $age_56s->where('admission',true);
                                $age_66s->where('admission',true);
                                $age_76s->where('admission',true);
                            }
                            if ($values == 'chkb') {
                                $age_29s->where('treatment_tip','app.chkb');
                                $age_30s->where('treatment_tip','app.chkb');
                                $age_46s->where('treatment_tip','app.chkb');
                                $age_56s->where('treatment_tip','app.chkb');
                                $age_66s->where('treatment_tip','app.chkb');
                                $age_76s->where('treatment_tip','app.chkb');
                            }
                            if ($values == 'tlt') {
                                $age_29s->where('treatment_tip','app.tlt');
                                $age_30s->where('treatment_tip','app.tlt');
                                $age_46s->where('treatment_tip','app.tlt');
                                $age_56s->where('treatment_tip','app.tlt');
                                $age_66s->where('treatment_tip','app.tlt');
                                $age_76s->where('treatment_tip','app.tlt');
                            }
                            if ($values == 'ag') {
                                $age_29s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                $age_30s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                $age_46s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                $age_56s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                $age_66s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                $age_76s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                            }
                            if ($values == 'sdtip') {
                                $age_29s->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                $age_30s->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                $age_46s->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                $age_56s->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                $age_66s->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                $age_76s->where('illness', 'LIKE', '%"tip":"app.tip"%');
                            }
                            if ($values == 'ojireniya') {
                                $age_29s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                $age_30s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                $age_46s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                $age_56s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                $age_66s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                $age_76s->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                            }
                            if ($values == 'giper') {
                                $age_29s->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                $age_30s->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                $age_46s->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                $age_56s->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                $age_66s->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                $age_76s->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                            }
                            if ($values == 'live') {
                                $age_29s->where('death',true);
                                $age_30s->where('death',true);
                                $age_46s->where('death',true);
                                $age_56s->where('death',true);
                                $age_66s->where('death',true);
                                $age_76s->where('death',true);
                            }
                            if ($values == 'dead') {
                                $age_29s->where('death',false);
                                $age_30s->where('death',false);
                                $age_46s->where('death',false);
                                $age_56s->where('death',false);
                                $age_66s->where('death',false);
                                $age_76s->where('death',false);
                            }
                        }
                        $age_29[] = $age_29s->count();
                        $age_30[] = $age_30s->count();
                        $age_46[] = $age_46s->count();
                        $age_56[] = $age_56s->count();
                        $age_66[] = $age_66s->count();
                        $age_76[] = $age_76s->count();
                        $date_e[] = date('d.m.Y', strtotime($value));

                    
                    
                     }else{

                        foreach ($check_array as $keys => $values) {
                            if ($values == 'male') {
                                $check_query->where('age',true);
                            }
                            if ($values == 'female') {
                                $check_query->where('age',false);
                            }
                            if ($values == '29') {
                                $check_query->where('age','<=',29);
                            }
                            if ($values == '3045') {
                                $check_query->where('age','>=',30)->where('age','<=',45);
                            }
                            if ($values == '4655') {
                                $check_query->where('age','>=',46)->where('age','<=',55);
                            }
                            if ($values == '5665') {
                                $check_query->where('age','>=',56)->where('age','<=',65);
                            }
                            if ($values == '6675') {
                                $check_query->where('age','>=',66)->where('age','<=',75);
                            }
                            if ($values == '75') {
                                $check_query->where('age','>=',75);
                            }
                            if ($values == 'skori') {
                                $check_query->where('admission',false);
                            }
                            if ($values == 'samotek') {
                                $check_query->where('admission',true);
                            }
                            if ($values == 'chkb') {
                                $check_query->where('treatment_tip','app.chkb');
                            }
                            if ($values == 'tlt') {
                                $check_query->where('treatment_tip','app.tlt');
                            }
                            if ($values == 'ag') {
                                $check_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                            }
                            if ($values == 'sdtip') {
                                $check_query->where('illness', 'LIKE', '%"tip":"app.tip"%');
                            }
                            if ($values == 'ojireniya') {
                                $check_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                            }
                            if ($values == 'giper') {
                                $check_query->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                            }
                            if ($values == 'live') {
                                $check_query->where('death',true);
                            }
                            if ($values == 'dead') {
                                $check_query->where('death',false);
                            }
                        }
                        $check_count[] = $check_query->count();
                        $date_e[] = date('d.m.Y', strtotime($value));
                        }
                
                        
                    }
                    $lebel = '';
                    if (!in_array('29',$check_array) && !in_array('3045',$check_array) && !in_array('4655',$check_array) && !in_array('5665',$check_array) && !in_array('6675',$check_array) && !in_array('75',$check_array)) {
                        return [
                            'age_29' => $age_29,
                            'age_30' => $age_30,
                            'age_46' => $age_46,
                            'age_56' => $age_56,
                            'age_66' => $age_66,
                            'age_76' => $age_76,
                            'date_array' => $date_e,
                        ];
                        }else{
                            
                            foreach ($check_array as $keys => $values) {
                                if ($values == '29') {
                                    $lebel = '-29';
                                }
                                if ($values == '3045') {
                                    $lebel = '30-45';
                                }
                                if ($values == '4655') {
                                    $lebel = '46-55';
                                }
                                if ($values == '5665') {
                                    $lebel = '56-65';
                                }
                                if ($values == '6675') {
                                    $lebel = '66-75';
                                }
                                if ($values == '75') {
                                    $lebel = '75-';
                                }
                            }
                            return [
                                'lebel' => $lebel,
                                'check_count' => $check_count,
                                'date_array' => $date_e,
                            ];
                        }
                
                    
            }
            if ($request->tab == 'come_count'){
                $skori_count = [];
                $net_skori_count = [];
                $check_count = [];
                $date_e = [];
                foreach ($date_array as $key => $value) {
                    $skori_counts = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value)->where('admission',true);
                    $net_skori_counts = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value)->where('admission',false);
                    $check_counts = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value);
                    if (!in_array('skori',$check_array) && !in_array('samotek',$check_array)) {
                        foreach ($check_array as $keys => $values) {
                            if ($values == 'male') {
                                $skori_counts->where('gender',true);
                                $net_skori_counts->where('gender',true);
                            }
                            if ($values == 'female') {
                                $skori_counts->where('gender',false);
                                $net_skori_counts->where('gender',false);
                            }
                            if ($values == '29') {
                                $skori_counts->where('age','<=',29);
                                $net_skori_counts->where('age','<=',29);
                            }
                            if ($values == '3045') {
                                $skori_counts->where('age','>=',30)->where('age','<=',45);
                                $net_skori_counts->where('age','>=',30)->where('age','<=',45);
                            }
                            if ($values == '4655') {
                                $skori_counts->where('age','>=',46)->where('age','<=',55);
                                $net_skori_counts->where('age','>=',46)->where('age','<=',55);
                            }
                            if ($values == '5665') {
                                $skori_counts->where('age','>=',56)->where('age','<=',65);
                                $net_skori_counts->where('age','>=',56)->where('age','<=',65);
                            }
                            if ($values == '6675') {
                                $skori_counts->where('age','>=',66)->where('age','<=',75);
                                $net_skori_counts->where('age','>=',66)->where('age','<=',75);
                            }
                            if ($values == '75') {
                                $skori_counts->where('age','>=',75);
                                $net_skori_counts->where('age','>=',75);
                            }
                            if ($values == 'chkb') {
                                $skori_counts->where('treatment_tip','app.chkb');
                                $net_skori_counts->where('treatment_tip','app.chkb');
                            }
                            if ($values == 'tlt') {
                                $skori_counts->where('treatment_tip','app.tlt');
                                $net_skori_counts->where('treatment_tip','app.tlt');
                            }
                            if ($values == 'ag') {
                                $skori_counts->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                $net_skori_counts->where('illness', 'LIKE', '%"ag":"app.ag"%');
                            }
                            if ($values == 'sdtip') {
                                $skori_counts->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                $net_skori_counts->where('illness', 'LIKE', '%"tip":"app.tip"%');
                            }
                            if ($values == 'ojireniya') {
                                $skori_counts->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                $net_skori_counts->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                            }
                            if ($values == 'giper') {
                                $skori_counts->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                $net_skori_counts->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                            }
                            if ($values == 'live') {
                                $skori_counts->where('death',true);
                                $net_skori_counts->where('death',true);
                            }
                            if ($values == 'dead') {
                                $skori_counts->where('death',false);
                                $net_skori_counts->where('death',false);
                            }
                        }
                    } else {
                        foreach ($check_array as $keys => $values) {
                            if ($values == 'male') {
                                $check_counts->where('gender',true);
                            }
                            if ($values == 'female') {
                                $check_counts->where('gender',false);
                            }
                            if ($values == '29') {
                                $check_counts->where('age','<=',29);
                            }
                            if ($values == '3045') {
                                $check_counts->where('age','>=',30)->where('age','<=',45);
                            }
                            if ($values == '4655') {
                                $check_counts->where('age','>=',46)->where('age','<=',55);
                            }
                            if ($values == '5665') {
                                $check_counts->where('age','>=',56)->where('age','<=',65);
                            }
                            if ($values == '6675') {
                                $check_counts->where('age','>=',66)->where('age','<=',75);
                            }
                            if ($values == '75') {
                                $check_counts->where('age','>=',75);
                            }
                            if ($values == 'skori') {
                                $check_counts->where('admission',false);
                            }
                            if ($values == 'samotek') {
                                $check_counts->where('admission',true);
                            }
                            if ($values == 'chkb') {
                                $check_counts->where('treatment_tip','app.chkb');
                            }
                            if ($values == 'tlt') {
                                $check_counts->where('treatment_tip','app.tlt');
                            }
                            if ($values == 'ag') {
                                $check_counts->where('illness', 'LIKE', '%"ag":"app.ag"%');
                            }
                            if ($values == 'sdtip') {
                                $check_counts->where('illness', 'LIKE', '%"tip":"app.tip"%');
                            }
                            if ($values == 'ojireniya') {
                                $check_counts->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                            }
                            if ($values == 'giper') {
                                $check_counts->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                            }
                            if ($values == 'live') {
                                $check_counts->where('death',true);
                            }
                            if ($values == 'dead') {
                                $check_counts->where('death',false);
                            }
                        }
                    }
                        $skori_count[] = $skori_counts->count();
                        $net_skori_count[] = $net_skori_counts->count();
                        $check_count[] = $check_counts->count();
                        $date_e[] = date('d.m.Y', strtotime($value));

                    }
                    $lebel = '';
                    if (!in_array('skori',$check_array) && !in_array('samotek',$check_array)) {
                        return [
                            'skori_count' => $skori_count,
                            'net_skori_count' => $net_skori_count,
                            'date_array' => $date_e,
                        ];
                    }else{
                        foreach ($check_array as $keys => $values) {
                            if ($values == 'skori') {
                                $lebel = 'skori';
                            }
                            if ($values == 'samotek') {
                                $lebel = 'samotek';
                            }
                        }
                        return [
                            'skori_count' => $check_count,
                            'lebel' => $lebel,
                            'date_array' => $date_e,
                        ];
                    }
            }
            if ($request->tab == 'dia_count'){
                $ag_count = [];
                $tip_count = [];
                $oji_count = [];
                $check_count = [];
                $date_e = [];
                    foreach ($date_array as $key => $value) {
                        $ag_counts = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value)->where('illness', 'LIKE', '%"ag":"app.ag"%');
                        $tip_counts = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value)->where('illness', 'LIKE', '%"tip":"app.tip"%');
                        $oji_counts = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value)->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                        $giper_counts = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value)->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                        $check_counts = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value);
                        if (!in_array('ag',$check_array) && !in_array('sdtip',$check_array) && !in_array('ojireniya',$check_array) && !in_array('giper',$check_array)) {
                            foreach ($check_array as $keys => $values) {
                                if ($values == 'male') {
                                    $ag_counts->where('gender',true);
                                    $tip_counts->where('gender',true);
                                    $oji_counts->where('gender',true);
                                    $giper_counts->where('gender',true);
                                }
                                if ($values == 'female') {
                                    $ag_counts->where('gender',false);
                                    $tip_counts->where('gender',false);
                                    $oji_counts->where('gender',false);
                                    $giper_counts->where('gender',false);
                                }
                                if ($values == '29') {
                                    $ag_counts->where('age','<=',29);
                                    $tip_counts->where('age','<=',29);
                                    $oji_counts->where('age','<=',29);
                                    $giper_counts->where('age','<=',29);
                                }
                                if ($values == '3045') {
                                    $ag_counts->where('age','>=',30)->where('age','<=',45);
                                    $tip_counts->where('age','>=',30)->where('age','<=',45);
                                    $oji_counts->where('age','>=',30)->where('age','<=',45);
                                    $giper_counts->where('age','>=',30)->where('age','<=',45);
                                }
                                if ($values == '4655') {
                                    $ag_counts->where('age','>=',46)->where('age','<=',55);
                                    $tip_counts->where('age','>=',46)->where('age','<=',55);
                                    $oji_counts->where('age','>=',46)->where('age','<=',55);
                                    $giper_counts->where('age','>=',46)->where('age','<=',55);
                                }
                                if ($values == '5665') {
                                    $ag_counts->where('age','>=',56)->where('age','<=',65);
                                    $tip_counts->where('age','>=',56)->where('age','<=',65);
                                    $oji_counts->where('age','>=',56)->where('age','<=',65);
                                    $giper_counts->where('age','>=',56)->where('age','<=',65);
                                }
                                if ($values == '6675') {
                                    $ag_counts->where('age','>=',66)->where('age','<=',75);
                                    $tip_counts->where('age','>=',66)->where('age','<=',75);
                                    $oji_counts->where('age','>=',66)->where('age','<=',75);
                                    $giper_counts->where('age','>=',66)->where('age','<=',75);
                                }
                                if ($values == '75') {
                                    $ag_counts->where('age','>=',75);
                                    $tip_counts->where('age','>=',75);
                                    $oji_counts->where('age','>=',75);
                                    $giper_counts->where('age','>=',75);
                                }
                                if ($values == 'chkb') {
                                    $ag_counts->where('treatment_tip','app.chkb');
                                    $tip_counts->where('treatment_tip','app.chkb');
                                    $oji_counts->where('treatment_tip','app.chkb');
                                    $giper_counts->where('treatment_tip','app.chkb');
                                }
                                if ($values == 'tlt') {
                                    $ag_counts->where('treatment_tip','app.tlt');
                                    $tip_counts->where('treatment_tip','app.tlt');
                                    $oji_counts->where('treatment_tip','app.tlt');
                                    $giper_counts->where('treatment_tip','app.tlt');
                                }
                                if ($values == 'live') {
                                    $ag_counts->where('death',true);
                                    $tip_counts->where('death',true);
                                    $oji_counts->where('death',true);
                                    $giper_counts->where('death',true);
                                }
                                if ($values == 'dead') {
                                    $ag_counts->where('death',false);
                                    $tip_counts->where('death',false);
                                    $oji_counts->where('death',false);
                                    $giper_counts->where('death',false);
                                }
                            }
                        } else {
                            foreach ($check_array as $keys => $values) {
                                if ($values == 'male') {
                                    $check_counts->where('gender',true);
                                }
                                if ($values == 'female') {
                                    $check_counts->where('gender',false);
                                }
                                if ($values == '29') {
                                    $check_counts->where('age','<=',29);
                                }
                                if ($values == '3045') {
                                    $check_counts->where('age','>=',30)->where('age','<=',45);
                                }
                                if ($values == '4655') {
                                    $check_counts->where('age','>=',46)->where('age','<=',55);
                                }
                                if ($values == '5665') {
                                    $check_counts->where('age','>=',56)->where('age','<=',65);
                                }
                                if ($values == '6675') {
                                    $check_counts->where('age','>=',66)->where('age','<=',75);
                                }
                                if ($values == '75') {
                                    $check_counts->where('age','>=',75);
                                }
                                if ($values == 'skori') {
                                    $check_counts->where('admission',false);
                                }
                                if ($values == 'samotek') {
                                    $check_counts->where('admission',true);
                                }
                                if ($values == 'chkb') {
                                    $check_counts->where('treatment_tip','app.chkb');
                                }
                                if ($values == 'tlt') {
                                    $check_counts->where('treatment_tip','app.tlt');
                                }
                                if ($values == 'ag') {
                                    $check_counts->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                }
                                if ($values == 'sdtip') {
                                    $check_counts->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                }
                                if ($values == 'ojireniya') {
                                    $check_counts->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                }
                                if ($values == 'giper') {
                                    $check_counts->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                }
                                if ($values == 'live') {
                                    $check_counts->where('death',true);
                                }
                                if ($values == 'dead') {
                                    $check_counts->where('death',false);
                                }
                            }
                        }
                            $ag_count[] = $ag_counts->count();
                            $tip_count[] = $tip_counts->count();
                            $oji_count[] = $oji_counts->count();
                            $giper_count[] = $giper_counts->count();
                            $check_count[] = $check_counts->count();
                            $date_e[] = date('d.m.Y', strtotime($value));

                        }
                        if (!in_array('ag',$check_array) && !in_array('sdtip',$check_array) && !in_array('ojireniya',$check_array) && !in_array('giper',$check_array)) {
                            return [
                                'ag_count' => $ag_count,
                                'tip_count' => $tip_count,
                                'oji_count' => $oji_count,
                                'giper_count' => $giper_count,
                                'date_array' => $date_e,
                            ];
                        }else{
                            return [
                                'check_count' => $check_count,
                                'date_array' => $date_e,
                            ];
                        }
                    
            }
            if ($request->tab == 'ill_count'){
                $death_count = [];
                $live_count = [];
                $check_count = [];
                $date_e = [];
                foreach ($date_array as $key => $value) {
                    $death_query = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value);
                    $live_query = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value);
                    $check_query = DB::table('patients')->whereDate('case_date','>=',$key)->whereDate('case_date','<=',$value);
                    if (!in_array('death',$check_array) && !in_array('live',$check_array)) {
                        $death_query->where('death',false);
                        $live_query->where('death',true);
                        foreach ($check_array as $keys => $values) {
                            if ($values == 'male') {
                                $death_query->where('gender',true);
                                $live_query->where('gender',true);
                            }
                            if ($values == 'female') {
                                $death_query->where('gender',false);
                                $live_query->where('gender',false);
                            }
                            if ($values == '29') {
                                $death_query->where('age','<=',29);
                                $live_query->where('age','<=',29);
                            }
                            if ($values == '3045') {
                                $death_query->where('age','>=',30)->where('age','<=',45);
                                $live_query->where('age','>=',30)->where('age','<=',45);
                            }
                            if ($values == '4655') {
                                $death_query->where('age','>=',46)->where('age','<=',55);
                                $live_query->where('age','>=',46)->where('age','<=',55);
                            }
                            if ($values == '5665') {
                                $death_query->where('age','>=',56)->where('age','<=',65);
                                $live_query->where('age','>=',56)->where('age','<=',65);
                            }
                            if ($values == '6675') {
                                $death_query->where('age','>=',66)->where('age','<=',75);
                                $live_query->where('age','>=',66)->where('age','<=',75);
                            }
                            if ($values == '75') {
                                $death_query->where('age','>=',75);
                                $live_query->where('age','>=',75);
                            }
                            if ($values == 'skori') {
                                $death_query->where('admission',false);
                                $live_query->where('admission',false);
                            }
                            if ($values == 'samotek') {
                                $death_query->where('admission',true);
                                $live_query->where('admission',true);
                            }
                            if ($values == 'chkb') {
                                $death_query->where('treatment_tip','app.chkb');
                                $live_query->where('treatment_tip','app.chkb');
                            }
                            if ($values == 'tlt') {
                                $death_query->where('treatment_tip','app.tlt');
                                $live_query->where('treatment_tip','app.tlt');
                            }
                            if ($values == 'ag') {
                                $death_query->where('illness', 'LIKE', '%"ag":"app.ag"%');
                                $live_query->where('illness', 'LIKE', '%"ag":"app.ag"%');
                            }
                            if ($values == 'sdtip') {
                                $death_query->where('illness', 'LIKE', '%"tip":"app.tip"%');
                                $live_query->where('illness', 'LIKE', '%"tip":"app.tip"%');
                            }
                            if ($values == 'ojireniya') {
                                $death_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                                $live_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                            }
                            if ($values == 'giper') {
                                $death_query->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                                $live_query->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                            }
                        }
                    }else{
                        foreach ($check_array as $keys => $values) {
                            if ($values == 'male') {
                                $check_query->where('gender',true);
                            }
                            if ($values == 'female') {
                                $check_query->where('gender',false);
                            }
                            if ($values == '29') {
                                $check_query->where('age','<=',29);
                            }
                            if ($values == '3045') {
                                $check_query->where('age','>=',30);
                                $check_query->where('age','<=',45);
                            }
                            if ($values == '4655') {
                                $check_query->where('age','>=',46);
                                $check_query->where('age','<=',55);
                            }
                            if ($values == '5665') {
                                $check_query->where('age','>=',56);
                                $check_query->where('age','<=',65);
                            }
                            if ($values == '6675') {
                                $check_query->where('age','>=',66);
                                $check_query->where('age','<=',75);
                            }
                            if ($values == '75') {
                                $check_query->where('age','>=',75);
                            }
                            if ($values == 'skori') {
                                $check_query->where('admission',false);
                            }
                            if ($values == 'samotek') {
                                $check_query->where('admission',true);
                            }
                            if ($values == 'ag') {
                                $check_query->where('illness', 'LIKE', '%"ag":"app.ag"%');
                            }
                            if ($values == 'sdtip') {
                                $check_query->where('illness', 'LIKE', '%"tip":"app.tip"%');
                            }
                            if ($values == 'ojireniya') {
                                $check_query->where('illness', 'LIKE', '%"ojireniya":"app.ojireniya"%');
                            }
                            if ($values == 'giper') {
                                $check_query->where('illness', 'LIKE', '%"giperlipedimya":"app.giperlipedimya"%');
                            }
                            if ($values == 'chkb') {
                                $check_query->where('treatment_tip','app.chkb');
                            }
                            if ($values == 'tlt') {
                                $check_query->where('treatment_tip','app.tlt');
                            }
                            if ($values == 'live') {
                                $check_query->where('death',true);
                            }
                            if ($values == 'dead') {
                                $check_query->where('death',false);
                            }
                        }
                    }
                        $death_count[] = $death_query->count();
                        $live_count[] = $live_query->count();
                        $check_count[] = $check_query->count();
                        $date_e[] = date('d.m.Y', strtotime($value));
                    }
                    if (!in_array('death',$check_array) && !in_array('live',$check_array)) {
                        return [
                            'death_count' => $death_count,
                            'live_count' => $live_count,
                            'date_array' => $date_e,
                        ];
                    }else{
                        $lebel = '';
                        foreach ($check_array as $keyr => $valuer) {
                            if ($valuer == 'male') {
                                $lebel = 'male';
                            }
                            if ($valuer == 'female') {
                                $lebel = 'female';

                            }
                        }
                        return [
                            'check_count' => $check_count,
                            'date_array' => $date_e,
                        ];
                    }
                    
            }

            }
            
        
    }
    public function statusChart(Request $request)
    {
        setSchema('@h1%');

        if ($request->date && strlen($request->date) == 10) {
            $one_date = date('Y-m-d', strtotime($request->date));
            $pol_count = [];
            $pol_array = [true,false];
            foreach ($pol_array as $key => $value) {
                $pol_count[] = DB::table('patients')->whereDate('case_date','=',$one_date)->where('gender',$value)->count();
            }
            $age_cat = [['-29'],['30-45'],['46-55'],['56-65'],['66-75'],['76-']];
            $age_array = [['1','29'],['30','45'],['46','55'],['56','65'],['66','75'],['76','300']];
            $age_count = [];

            foreach ($age_array as $keys => $values) {
                $age_count[] = DB::table('patients')->whereDate('case_date','=',$one_date)->where('age','>=',$values[0])->where('age','<=',$values[1])->count();
            }

            $ill_count = [];
            $ill_array = ['ag','tip','ojireniya','giperlipedimya'];

            foreach ($ill_array as $keys => $values) {
                $query_text = '%"'.$values.'":"app.'.$values.'"%';
                $ill_count[] = DB::table('patients')->whereDate('case_date','=',$one_date)->where('illness','LIKE',$query_text)->count();
            }

            $skori_count = [];
            $skori_array = [true,false];
            foreach ($skori_array as $key => $value) {
                $skori_count[] = DB::table('patients')->whereDate('case_date','=',$one_date)->where('admission',$value)->count();
            }

            $death_count = [];
            $death_array = [true,false];
            foreach ($death_count as $key => $value) {
                $death_count[] = DB::table('patients')->whereDate('case_date','=',$one_date)->where('death',$value)->count();
            }


            return [
                'pol_count' => $pol_count,
                'age_cat' => $age_cat,
                'age_count' => $age_count,
                'ill_count' => $ill_count,
                'skori_count' => $skori_count,
                'death_count' => $death_count,
            ];
        }
        

    }


}
