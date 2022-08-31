<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Province;
use App\Models\Ekg;
use App\Models\Exo;
// use Session;
// use Config;
class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct()
    {
        // $this->middleware('logis'); 
    }
    public function index()
    {
        

        $max = Patient::max('patient_back');
        $patient = [];
        for ($i=0; $i < $max; $i++) { 
            $patient[$i] = $patients = DB::table('patients')->select('patients.id','patients.pinfl','patients.first_name','patients.last_name','patients.phone','patients.age','patients.bmi','patients.case_date','patients.gender','provinces.province_name')
            ->join('provinces','patients.province_id','provinces.id')
            ->where('hospital_id',Session::get('hospital_id'))
            ->where('branch_id',Session::get('branch_id'))
            ->where('patient_back',$i+1)
            ->get();
        }
        // return count($patient);
        

        return view('patient.list',compact('patient'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        // $province = ['Ташкент','г. Ташкент','Каракалпакистан','Андижан','Бухара','Жиззах','Кашкадарья','Навои','Наманган','Самарканд','Сурхандарья','Сырдарья','Фергана','Хорезм'];
        // foreach ($province as $key => $value) {
        //     $new_pro = new Province([
        //         'province_name' => $value,
        //     ]);
        //     $new_pro->save();
        // }
        // $dist_array = [['Кибрай','Ташкент','Янгийул','Бекобод','Бустанлик','Бука','Чиноз','Кибрай','Охангарон','Оккурган','Паркент','Пискент','Чирчик','Зангиота'],['Бектемир','Мирзо Улугбек','Миробод','Олмазор','Сергели','Учтепа','Чилонзор','Шайхонтоҳур','Юнусобод','Яккасарой','Яшнобод', ],["г. Нукус","Амударья","Беруний ","Кегейли ","Канликул","Караузак","Кунград","Муйнак","Нукус ","Тахиатош ","Тахтакупир","Турткуль","Ходжайли","Чимбай","Шуманай","Элликкалъа "],["г. Андижан","Хонабод","Андижан ","Асака ","Баликчи ","Буз ","Булокбоши ","Жалакудук ","Избоскан ","Кургантепа ","Мархамат .","Олтинкул ","Пахтаобод ","Улугнор ","Хужаобод ","Шахрихон "],["г. Бухара","г. Когон","  Бухара","Вобкент ","Жондор ","Когон ","Олот ","Пешку ","Ромитан ","Шофиркон ","Коровулбозор ","Коракул ","Гиждувон "],["г. Жиззах","Арнасой ","Бахмал ","Дустлик ","Зарбдор ","Зафаробод ","Зомин ","Мирзачул ","Пахтакор ","Фориш ","Шароф Рашидов ","Галлаорол ","Янгиобод "],["г. Карши ","г. Шаҳрисабз ","Дехканабад ","Касби ","Китоб ","Косон ","Миришкор ","Муборак ","Нишон ","Чиракчи ","Шахрисабз ","Яккабог ","Камаши ","Карши ","Гузор "],["г. Навои ","г. Зарафшан ","Кармана ","Конимех ","Навбаҳор ","Нурота ","Томди ","Учкудук","Хатирчи ","Кизилтепа "],["г. Наманган","Косонсой ","Мингбулак","Наманган ","Нарын ","Поп ","Туракурган ","Уйчи ","Учкурган ","Чартак","Чуст ","Янгикурган"],["г. Самарканд","г. Каттакурган","Булунгур ","Жомбой ","Иштихон ","Каттакурган","Нарпай ","Нуробод ","Окдарё ","Паярик ","Пастдаргом ","Пахтачи ","Самарканд ","Тойлок","Ургут ","Кушработ "],["г. Термиз ","Ангор ","Бойсун ","Денов ","Жаркурган","Музробод ","Олтинсой ","Сариосиё ","Термиз ","Узун ","Шеробод ","Шурчи ","Кизирик ","Кумкурган "],["г. Гулистон ","г. Янгиер ","г. Ширин ","Боёвут ","Гулистон ","Мирзаобод ","Околтин ","Сардоба ","Сайхунобод ","Сирдарё ","Ховос "],["г. Нурафшон ","г. Ангрен ","г. Бекабад","г. Алмалык","г. Охангарон ","г. Чирчик ","г. Янгийул ","Бекобод ","Бука ","Бустонлик ","Зангиота ","Кибрай ","Куйичирчик","Аккурган ","Ахангаран ","Паркент ","Пискент ","Тошкент ","Уртачирчик","Чиноз ","Юкоричирчик ","Янгийул "],["г. Фергана","г. Маргилон","г. Кувасой ","г. Коканд","Бешарик ","Багдад ","Бувайда ","Дангара ","Ёзёвон ","Кува ","Куштепа ","Олтиарик ","Риштон ","Сух ","Тошлок","Узбекистан","Учкуприк ","Фергана","Фуркат"],["г. Урганч","Хива ","Богот ","Гурлан ","Урганч ","Хива ","Хонка ","Хазорасп ","Шовот ","Янгиарик","Янгибозор ","Кушкупир"]];
        
        // $districts = [0,1,2,3,4,5,6,7,8,9,10,11,12,13];
        // foreach ($districts as $key => $value) {
        //     foreach ($dist_array[$key] as $keys => $values) {
        //         // if ($keys + 1 == $key) {
        //             $new_dist = new District([
        //                 'district_name' => $values,
        //                 'province_id' => $key+1,
        //             ]);
        //             $new_dist->save();
        //         // }
            
        //     }
        // }
        $province = Province::all();
        $district = DB::table('districts')->select('districts.id','districts.district_name','districts.province_id')
        ->get();
        // $district = $district_n[0];
        $count = DB::table('patients')
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))
        ->get()->count();
        $case_number = $count + 1;

        $diagnos = DB::table('patients')->select('id','first_name','last_name','full_name','pinfl','patient_back')->where('diagnos',null)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))
        ->get(); 
        $count_diagnos = count($diagnos);
        // $diagnos = $diagnos[0];

        $exam = DB::table('patients')->select('id','first_name','last_name','full_name','pinfl','patient_back')->where('patient_exam',null)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))
        ->get();
        $count_exam = count($exam);
        // $exam = $exam[0];


        $ekg = DB::table('patients')->select('id','first_name','last_name','full_name','pinfl','patient_back')
        ->where('ekg_id',null)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))
        ->get();
        $count_ekg = count($ekg);
        // $ekg = $ekg[0];


        $exo = DB::table('patients')->select('id','first_name','last_name','full_name','pinfl','patient_back')
        ->where('exo_id',null)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))
        ->get();
        $count_exo = count($exo);
        // $exo = $exo[0];


        $treatment = DB::table('patients')->select('id','first_name','last_name','full_name','pinfl','patient_back')
        ->where('treatment',null)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))
        ->get();
        $count_treatment = count($treatment);
        // $treatment = $treatment[0];


        // Session::set('success') = 'patient_create';
        // Session::put('success', 'patient_create');

        // return view('patient.create', compact('province','district','case_number','diagnos','count_diagnos'));

        if(isset(Session::get('per')['p_create']))
        {
            return view('patient.create', compact('province','district','case_number','diagnos','count_diagnos','exam','count_exam','ekg','count_ekg','exo','count_exo','treatment','count_treatment'));
        }else{
            return redirect()->route('glavniy');

        }


        // return $diagnos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        
        // $case_date_year = date('Y',(strtotime ( $request->get('case_date') ) ));
        // $case_date_month = date('m',(strtotime ( $request->get('case_date') ) ));
        // $case_date_day = date('d',(strtotime ( $request->get('case_date') ) ));
        // $case_date_oclock = date('h',(strtotime ( $request->get('case_time') ) ));
        // $case_date_minut = date('i',(strtotime ( $request->get('case_time') ) ));

        // $d = mktime($case_date_oclock, $case_date_minut, 54, $case_date_month, $case_date_day, $case_date_year);
        // $case_date = date("Y-m-d h:i:sa", $d);
        if($request->get('birth_date') == NULL)
        {
            $birth_date = null;
            
        }else{
            $birth_date = date('Y-m-d',(strtotime ( $request->get('birth_date') ) ));
        }
        
        $case_date = date('Y-m-d H:i:s',(strtotime ( $request->get('case_date') ) ));
        $passport = strtoupper($request->get('passport'));
        $district = new Patient([
            'hospital_id' => Session::get('hospital_id'),
            'branch_id' => Session::get('branch_id'),
            'pinfl' => $request->get('pinfl'),
            'passport' => $passport,
            'last_name' => $request->get('last_name'),
            'first_name' => $request->get('first_name'),
            'full_name' => $request->get('full_name'),
            'phone' => $request->get('phone'),
            'age' => $request->get('age'),
            'temp' => $request->get('temp'),
            'birth_day' => $birth_date,
            'passport' => $request->get('passport'),
            'province_id' => $request->get('province_id'),
            'district_id' => $request->get('district_id'),
            'height' => $request->get('height'),
            'weight' => $request->get('weight'),
            'bmi' => $request->get('bmi'),
            'gender' => $request->get('gender'),
            'case_number' => $request->get('case_number'),
            'case_date' => $case_date,
            'admission' => $request->get('amb'),
            'patient_back' => $request->get('patient_back'),
        ]);
        $district->save();
        

        $patient = Patient::where('pinfl', $request->get('pinfl'))
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))
        ->get();
        return redirect()->back()->with('success', 'patient_saved')->with('patient',$patient[0]);  
        // return $case_date;

        // return redirect()->back()->with('success', 'patient_saved');  
        // return [
        //     'req' => $request,
        // ];
        // Session::forget('success');
        // $id = Patient::findOrFail($id);
        // return $patient[0];
    }
    public function store_diagnos(Request $request)
    {
        // $validated = $request->validate([
        //     'radio' => 'required',
        // ]);
        

        $new_array = [];

        $diagnos = $request->diagnos;
        $time = $request->time;
        $id = intval($request->patient_id);
        $new_array = array('diagnos' => $diagnos,'time' => $time);
        $json_diagnos = json_encode($new_array);
        $json_illness = json_encode($request->all());

        $diagnos_patient = Patient::where('id', $id)
       ->update([
           'diagnos' => $json_diagnos,
           'illness' => $json_illness
        ]);
        $exam = DB::table('patients')->where('id', $id)->where('patient_exam',null)->get();
        $count_exam = count($exam);

        if($count_exam == 0)
        {
            return redirect()->back();
        }
        if ($count_exam == 1) {
            $patient = Patient::where('id', $id)->get();
            return redirect()->back()->with('success', 'diagnos_updated')->with('patient',$patient[0]);
        }
        

        // return redirect()->back()->with('success', 'diagnos_updated');
        // return $request;

    }

    public function store_exam(Request $request)
    {
        // $diagnos = $request->radio;
        

        $id = intval($request->patient_id);
        $json_exam = json_encode($request->all());

        $exam_patient = Patient::where('id', $id)
       ->update([
           'patient_exam' => $json_exam,
        ]); 

        $ekg = DB::table('patients')->where('id', $id)->where('ekg_id',null)->get();
        $count_ekg = count($ekg);

        if($count_ekg == 0)
        {
            return redirect()->back();
        }
        if ($count_ekg == 1) {
            $patient = Patient::where('id', $id)->get();
            return redirect()->back()->with('success', 'exam_updated')->with('patient',$patient[0]);
        }
        // $patient = Patient::where('id', $id)->get();
        // return redirect()->back()->with('success', 'exam_updated')->with('patient',$patient[0]);

    }

    public function store_treatment(Request $request)
    {
        

        $id = intval($request->patient_id);
        $json_treatment = json_encode($request->all());

        $treatment_patient = Patient::where('id', $id)
       ->update([
           'treatment' => $json_treatment,
           'treatment_tip' => $request->lech,
        ]);
        $patient = Patient::where('patients.id',$id)
        ->join('provinces','patients.province_id','provinces.id')
        ->join('districts','patients.district_id','districts.id')
        ->get();
        $patient = $patient[0];
        $illness = $patient->illness;
        $diagnos = $patient->diagnos;
        $patient_exam = $patient->patient_exam;
        $treatment = $patient->treatment;

        $ekg = Ekg::where('patient_id',$id)->orderBy('created_at', 'ASC')
        ->get();

        $exo = Exo::where('patient_id',$id)->orderBy('created_at', 'ASC')
        ->get();

        // $gender = ['true','false'];
        // $age = ['1' => 29,'30' => 45,'46' => 55,'56' => 65,'66' => 75,'76' => 300];
        $male_age = [];
        $female_age = [];
        // foreach ($gender as $key => $value) {
        //     foreach ($age as $keys => $values) {
        //          $count = DB::table('patients')->where('age','>=',$keys)->where('age','<=',$values)->where('gender',$value)->count();
        //             if ($value == 'true') {
        //                 $male_age[] = $count;
        //             }
        //             if ($value == 'false') {
        //                 $female_age[] = $count;
        //             }
        //     }
        // }

        return view('patient.profile', compact('patient','illness','treatment','diagnos','patient_exam','ekg','exo','male_age','female_age'));

        // return $request;


    }

    public function store_exit(Request $request)
    {
        

        $id = intval($request->patient_id);
        $dead = $request->isxod;

        $treatment_patient = Patient::where('id', $id)
       ->update([
           'death' => $dead,
        ]);
        return redirect()->back();
    }


    public function pinfl(Request $request)
    {
        // if(Session::get('hospital_id') == NULL)
        // {
        //     $case = Session::get('branch_id');
        // }
        // if(Session::get('branch_id') == NULL)
        // {
        //     $case = Session::get('hospital_id');
        // }

        $pinfl = $request->name;
        $patient = Patient::where('pinfl',$pinfl)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))
        ->join('provinces','patients.province_id','provinces.id')
        ->join('districts','patients.district_id','districts.id')
        ->get();

        if(count($patient) >= 1)
        {
            return [
                'count' => count($patient),
                'patient' => $patient,
                'patient_back' => count($patient)+1,
            ];
        }else{
            $patient_an = Patient::where('pinfl',$pinfl)
            ->join('provinces','patients.province_id','provinces.id')
            ->join('districts','patients.district_id','districts.id')
            ->get();
            return [
                
                'count' => count($patient),
                'patient' => $patient,
                'patient_back' => 1,
                'another' => $patient_an
            ];
        }

        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        

        $patient = Patient::where('patients.id',$id)
        ->join('provinces','patients.province_id','provinces.id')
        ->join('districts','patients.district_id','districts.id')
        ->get();
        $patient = $patient[0];
        $illness = $patient->illness;
        $diagnos = $patient->diagnos;
        $patient_exam = $patient->patient_exam;
        $treatment = $patient->treatment;

        $ekg = Ekg::where('patient_id',$id)->orderBy('created_at', 'ASC')
        // ->join('patients','ekgs.province_id','patients.id')
        ->get();

        $exo = Exo::where('patient_id',$id)->orderBy('created_at', 'ASC')
        // ->join('patients','ekgs.province_id','patients.id')
        ->get();

        // $illness = json_decode($patient[0]->illness); 
        return view('patient.profile', compact('patient','illness','treatment','diagnos','patient_exam','ekg','exo'));
        // return $patient->illness;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $p_id = Patient::find($id);
        // $d_id = Patient::where('district_id',$id);
        $getp = Province::find($p_id->province_id);
        $getd = District::find($p_id->district_id);
         $patient = Patient::where('patients.id',$id)
        ->join('provinces','patients.province_id','provinces.id')
        ->join('districts','patients.district_id','districts.id')
        ->get();
        $patient = $patient[0];
        $province = Province::all();
        $district = District::where('province_id',$getp->id)->get();
        $id = $p_id->id;


        return view('patient.patient_edit', compact('patient','province','district','getp','getd','id'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        // $case_date_year = date('Y',(strtotime ( $request->get('case_date') ) ));
        // $case_date_month = date('m',(strtotime ( $request->get('case_date') ) ));
        // $case_date_day = date('d',(strtotime ( $request->get('case_date') ) ));
        // $case_date_oclock = date('h',(strtotime ( $request->get('case_time') ) ));
        // $case_date_minut = date('i',(strtotime ( $request->get('case_time') ) ));

        // $d = mktime($case_date_oclock, $case_date_minut, 54, $case_date_month, $case_date_day, $case_date_year);
        // $case_date = date("Y-m-d h:i:sa", $d);
        if($request->get('birth_date') == NULL)
        {
            $birth_date = NULL;
        }else{
            $birth_date = date('Y-m-d',(strtotime ( $request->get('birth_date') ) ));
        }
        
        $case_date = date('Y-m-d H:i:s',(strtotime ( $request->get('case_date') ) ));
        $passport = strtoupper($request->get('passport'));
        $district = Patient::where('id',$id)
            ->update([
                'pinfl' => $request->get('pinfl'),
                'passport' => $passport,
                'last_name' => $request->get('last_name'),
                'first_name' => $request->get('first_name'),
                'full_name' => $request->get('full_name'),
                'phone' => $request->get('phone'),
                'age' => $request->get('age'),
                'temp' => $request->get('temp'),
                'birth_day' => $birth_date,
                'passport' => $request->get('passport'),
                'province_id' => $request->get('province_id'),
                'district_id' => $request->get('district_id'),
                'height' => $request->get('height'),
                'weight' => $request->get('weight'),
                'bmi' => $request->get('bmi'),
                'gender' => $request->get('gender'),
                'case_number' => $request->get('case_number'),
                'case_date' => $case_date,
                'admission' => $request->get('amb'),
                'patient_back' => 1,
            ]);
        return redirect()->route('patient.index');  
        // return $case_date;

        // return redirect()->back()->with('success', 'patient_saved');  
        // return [
        //     'req' => $request,
        // ];
        // Session::forget('success');
        // $id = Patient::findOrFail($id);
        // return $patient[0];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        

        $patient = Patient::find($id);
    // if(!$patient){
    //     return redirect()->route('invoice.index')->with(['fail' => 'Page not found !']);
    // }
    $patient->delete();
    return redirect()->back();
    }

    public function ageChart(Request $request)
    {
        $db_array = [10,11,12];
        $gender = ['true','false'];
        $age = ['1' => 29,'30' => 45,'46' => 55,'56' => 65,'66' => 75,'76' => 300];
        $male_age = [];
        $female_age = [];
        $all_count = 0;
        if ($request->data == 'a_today') {
            $date_begin = today();
            $date_end = today();
        }
        if ($request->data == 'a_week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( today()) ) ));
            $date_end = today()->format('Y-m-d');
        }
        if ($request->data == 'a_month') {
            $date_begin = today()->format('Y-m-01');
            $date_end = today()->format('Y-m-d');
        }
        if ($request->data == 'a_year') {
            $date_begin = today()->format('Y-01-01');
            $date_end = today()->format('Y-m-d');
        }
        if ($request->data == 'a_all') {
            $date_begin = today()->format('1790-01-01');
            $date_end = today()->format('Y-m-d');
        }

        foreach ($gender as $key => $value) {
            foreach ($age as $keys => $values) {
                if($request->db == 'all')
                {
                    foreach ($db_array as $keyd => $valued) {
                        $count = DB::table('patients')->where('age','>=',$keys)->where('age','<=',$values)->where('gender',$value)->whereDate('case_date','>=',$date_begin)
                        ->whereDate('case_date','<=',$date_end)
                        ->where('hospital_id',$valued)
                        ->count();
                        $all_count += $count;
                    }
                    if ($value == 'true') {
                        $male_age[] = $all_count;
                    }
                    if ($value == 'false') {
                        $female_age[] = $all_count;
                    }
                    $all_count = 0;
                }else{
                    $count = DB::table('patients')->where('age','>=',$keys)->where('age','<=',$values)->where('gender',$value)->whereDate('case_date','>=',$date_begin)->whereDate('case_date','<=',$date_end)
                    ->where('hospital_id',$request->db)
                    ->count();
                    if ($value == 'true') {
                        $male_age[] = $count;
                    }
                    if ($value == 'false') {
                        $female_age[] = $count;
                    }
                }
                 
            }
        }

        return [
            'male' => $male_age,
            'female' => $female_age,
        ];
    }
    public function mainAgeChart(Request $request)
    {

        
        $db_array = ['10','11','12'];
        $gender = ['true','false'];
        $age = ['1' => 29,'30' => 45,'46' => 55,'56' => 65,'66' => 75,'76' => 300];
        $male_age = [];
        $female_age = [];
        $all_count = 0;
        
        foreach ($gender as $key => $value) {
            foreach ($age as $keys => $values) {
                if($request->db == 'all')
                    {
                        foreach ($db_array as $keyd => $valued) {
                            $count = DB::table('patients')->where('age','>=',$keys)->where('age','<=',$values)
                            ->where('gender',$value)
                            ->where('hospital_id',$valued)
                            ->count();
                            $all_count += $count;
                           }
           
                            if ($value == 'true') {
                                   $male_age[] = $all_count;
                               }
                               if ($value == 'false') {
                                   $female_age[] = $all_count;
                               }
                           $all_count = 0;
                    }else{
                        $count = DB::table('patients')->where('age','>=',$keys)->where('age','<=',$values)->where('gender',$value)
                        ->where('hospital_id',$request->db)
                        ->count();
                        if ($value == 'true') {
                            $male_age[] = $count;
                        }
                        if ($value == 'false') {
                            $female_age[] = $count;
                        }
                    }
            }
        }
        return [
            'male' => $male_age,
            'female' => $female_age,
        ];
    }
    public function allChart(Request $request)
    {

        $db_array = ['10','11','12'];
        $gender = ['true','false'];
        
        $pie_gender = [];
        $pie_death = [];
    
        $all_count = 0;
        $all_death = 0;

        
        foreach ($gender as $key => $value) {

            if($request->db == 'all'){
                foreach ($db_array as $keyd => $valued) {
                    $count = DB::table('patients')->where('gender',$value)
                    ->where('hospital_id',$valued)
                    ->count();
                    $death_count = DB::table('patients')->where('death',$value)
                    ->where('hospital_id',$valued)
                    ->count();
                    $all_count += $count;
                    $all_death += $death_count;
                }
                $pie_gender[] = $all_count;
                $pie_death[] = $all_death;
                $all_count = 0;
                $all_death = 0;
            }else{
                $count = DB::table('patients')->where('gender',$value)
                ->where('hospital_id',$request->db)
                ->count();
                $death_count = DB::table('patients')->where('death',$value)
                ->where('hospital_id',$request->db)
                ->count();
                $pie_gender[] = $count;
                $pie_death[] = $death_count;
            }
        }
        $month_array = ['01'=>'31','02'=>'28','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31'];
        $chkb_array = [];
        $tlt_array = [];
        $chkb_no_dead_array = [];
        $tlt_no_dead_array = [];
        $chkb_dead_array = [];
        $tlt_dead_array = [];

        $all_p_chkb_count = 0;
        $all_p_tlt_count = 0;
        $all_p_chkb_no_dead_count = 0;
        $all_p_tlt_no_dead_count = 0;
        $all_p_chkb_dead_count = 0;
        $all_p_tlt_dead_count = 0;

            foreach ($month_array as $key => $value) {
                if($request->db == 'all'){
                    foreach ($db_array as $keyd => $valued) {
                        $all_p_chkb_c = DB::table('patients')->whereDate('case_date','>=',date("Y").'-'.$key.'-01')->whereDate('case_date','<=',date("Y").'-'.$key.'-'.$value)->where('treatment_tip','app.chkb')->where('hospital_id',$valued)->count();
                        $all_p_tlt_c = DB::table('patients')->whereDate('case_date','>=',date("Y").'-'.$key.'-01')->whereDate('case_date','<=',date("Y").'-'.$key.'-'.$value)->where('treatment_tip','app.tlt')->where('hospital_id',$valued)->count();
                        $all_p_chkb_count += $all_p_chkb_c;
                        $all_p_tlt_count += $all_p_tlt_c;
                        $all_p_chkb_no_dead_c = DB::table('patients')->whereDate('case_date','>=',date("Y").'-'.$key.'-01')->whereDate('case_date','<=',date("Y").'-'.$key.'-'.$value)->where('treatment_tip','app.chkb')->where('death',true)->where('hospital_id',$valued)->count();
                        $all_p_tlt_no_dead_c = DB::table('patients')->whereDate('case_date','>=',date("Y").'-'.$key.'-01')->whereDate('case_date','<=',date("Y").'-'.$key.'-'.$value)->where('treatment_tip','app.tlt')->where('death',true)->where('hospital_id',$valued)->count();
                        $all_p_chkb_no_dead_count += $all_p_chkb_no_dead_c;
                        $all_p_tlt_no_dead_count += $all_p_tlt_no_dead_c;
                        $all_p_chkb_dead_c = DB::table('patients')->whereDate('case_date','>=',date("Y").'-'.$key.'-01')->whereDate('case_date','<=',date("Y").'-'.$key.'-'.$value)->where('treatment_tip','app.chkb')->where('death',false)->where('hospital_id',$valued)->count();
                        $all_p_tlt_dead_c = DB::table('patients')->whereDate('case_date','>=',date("Y").'-'.$key.'-01')->whereDate('case_date','<=',date("Y").'-'.$key.'-'.$value)->where('treatment_tip','app.tlt')->where('death',false)->where('hospital_id',$valued)->count();
                        $all_p_chkb_dead_count += $all_p_chkb_dead_c;
                        $all_p_tlt_dead_count += $all_p_tlt_dead_c;
                    }
                    $chkb_array[] = $all_p_chkb_count;
                    $tlt_array[] = $all_p_tlt_count;
                    $all_p_chkb_count = 0;
                    $all_p_tlt_count = 0;
                    $chkb_no_dead_array[] = $all_p_chkb_no_dead_count;
                    $tlt_no_dead_array[] = $all_p_tlt_no_dead_count;
                    $all_p_chkb_no_dead_count = 0;
                    $all_p_tlt_no_dead_count = 0;
                    $chkb_dead_array[] = $all_p_chkb_dead_count;
                    $tlt_dead_array[] = $all_p_tlt_dead_count;
                    $all_p_chkb_dead_count = 0;
                    $all_p_tlt_dead_count = 0;
                }else{
                        $all_p_chkb_c = DB::table('patients')->whereDate('case_date','>=',date("Y").'-'.$key.'-01')->whereDate('case_date','<=',date("Y").'-'.$key.'-'.$value)->where('treatment_tip','app.chkb')->where('hospital_id',$request->db)->count();
                        $all_p_tlt_c = DB::table('patients')->whereDate('case_date','>=',date("Y").'-'.$key.'-01')->whereDate('case_date','<=',date("Y").'-'.$key.'-'.$value)->where('treatment_tip','app.tlt')->where('hospital_id',$request->db)->count();
                        $chkb_array[] = $all_p_chkb_c;
                        $tlt_array[] = $all_p_tlt_c;
                        $all_p_chkb_no_dead_c = DB::table('patients')->whereDate('case_date','>=',date("Y").'-'.$key.'-01')->whereDate('case_date','<=',date("Y").'-'.$key.'-'.$value)->where('treatment_tip','app.chkb')->where('death',true)->where('hospital_id',$request->db)->count();
                        $all_p_tlt_no_dead_c = DB::table('patients')->whereDate('case_date','>=',date("Y").'-'.$key.'-01')->whereDate('case_date','<=',date("Y").'-'.$key.'-'.$value)->where('treatment_tip','app.tlt')->where('death',true)->where('hospital_id',$request->db)->count();
                        $chkb_no_dead_array[] = $all_p_chkb_no_dead_c;
                        $tlt_no_dead_array[] = $all_p_tlt_no_dead_c;
                        $all_p_chkb_dead_c = DB::table('patients')->whereDate('case_date','>=',date("Y").'-'.$key.'-01')->whereDate('case_date','<=',date("Y").'-'.$key.'-'.$value)->where('treatment_tip','app.chkb')->where('death',false)->where('hospital_id',$request->db)->count();
                        $all_p_tlt_dead_c = DB::table('patients')->whereDate('case_date','>=',date("Y").'-'.$key.'-01')->whereDate('case_date','<=',date("Y").'-'.$key.'-'.$value)->where('treatment_tip','app.tlt')->where('death',false)->where('hospital_id',$request->db)->count();
                        $chkb_dead_array[] = $all_p_chkb_dead_c;
                        $tlt_dead_array[] = $all_p_tlt_dead_c;
                    }
            }
        return [
            'all_p_chkb' => $chkb_array,
            'all_p_tlt' => $tlt_array,
            'chkb_no_dead_array' => $chkb_no_dead_array,
            'tlt_no_dead_array' => $tlt_no_dead_array,
            'chkb_dead_array' => $chkb_dead_array,
            'tlt_dead_array' => $tlt_dead_array,
            'pie' => $pie_gender,
            'pie_death' => $pie_death,
        ];
    }

    public function patientData(Request $request)
    {
        $db_array = ['10','11','12'];
        $all_patient = 0;
        $all_chkb = 0;
        $all_true = 0;
        $chkb_true = 0;
        $all_false = 0;
        $chkb_false = 0;
        if($request->db == 'all')
        {
            foreach ($db_array as $keyd => $valued) {
                $all_patient += DB::table('patients')->where('hospital_id',$valued)->count();
                $all_chkb += DB::table('patients')->where('treatment_tip','app.chkb')->where('hospital_id',$valued)->count();
                $all_true += DB::table('patients')->where('death',true)->where('hospital_id',$valued)->count();
                $chkb_true += DB::table('patients')->where('death',true)->where('treatment_tip','app.chkb')->where('hospital_id',$valued)->count();
                $all_false += DB::table('patients')->where('death',false)->where('hospital_id',$valued)->count();
                $chkb_false += DB::table('patients')->where('death',false)->where('treatment_tip','app.chkb')->where('hospital_id',$valued)->count();
            }
        }else{
            $all_patient = DB::table('patients')->where('hospital_id',$request->db)->count();
            $all_chkb = DB::table('patients')->where('treatment_tip','app.chkb')->where('hospital_id',$request->db)->count();
            $all_true = DB::table('patients')->where('death',true)->where('hospital_id',$request->db)->count();
            $chkb_true = DB::table('patients')->where('death',true)->where('treatment_tip','app.chkb')->where('hospital_id',$request->db)->count();
            $all_false = DB::table('patients')->where('death',false)->where('hospital_id',$request->db)->count();
            $chkb_false = DB::table('patients')->where('death',false)->where('treatment_tip','app.chkb')->where('hospital_id',$request->db)->count();
        }
        
        return [
            'all_patient' => $all_patient,
            'all_chkb' => $all_chkb,
            'all_true' => $all_true,
            'chkb_true' => $chkb_true,
            'all_false' => $all_false,
            'chkb_false' => $chkb_false,
        ];
    }

    
}
