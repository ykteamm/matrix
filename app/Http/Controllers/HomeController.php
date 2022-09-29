<?php

namespace App\Http\Controllers;

use App\Helpers\UserSystemInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// use Illuminate\Http\Patient;
use App\Models\District;
use App\Models\Patient;
use App\Models\Position;
use App\Models\Region;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Jenssegers\Agent\Agent;
// use Session;
// use Config;
use Storage;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Http;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }
    public function smsfly(Request $request)
    {
        $data =  $request->all();
        $phone = $data['phone'];
        $message = $data['message'];
        // $responses = Http::post('https://api.smsfly.uz/send', [
        //     'key' => '2b45f42d-1d3d-11ed-a71e-0242ac120002',
        //     'phone' => $phone,
        //     'message' => $message,
        // ]);

        $response = Http::withHeaders([
            'Accept'        => 'application/json',
            'Content-Type' => 'application/json',
        ])
        ->withOptions([
          'verify' => true,
        ])
        ->post('https://api.smsfly.uz/send', [
            'key' => '2b45f42d-1d3d-11ed-a71e-0242ac120002',
            'phone' => $phone,
            'message' => $message,
        ]);
        return [
            'res' => $response['reason']
        ];

        // $post = [
        //     'key' => '2b45f42d-1d3d-11ed-a71e-0242ac120002',
        //     'phone' => $phone,
        //     'message' => $message,
        // ];
        
        // $ch = curl_init('https://api.smsfly.uz/send');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        // // execute!
        // $response = curl_exec($ch);
        
        // curl_close($ch);

        // return [
        //     'res' => $response
        // ];
    }
    public function imageGrade()
    {
        // $files = Storage::disk('public_grade')->allFiles();
        // return $files;
        $question = DB::table('tg_question')->whereIn('grade',[4,5])->get();
        return view('image.create',compact('question'));
    }
    public function imageGradeSave(Request $request)
    {
        if($request->file('filerangli')){
            $file= $request->file('filerangli');
            $filename= 'rangli'.$request->bolim.'.'.$file->getClientOriginalExtension();
            $file-> move(public_path('assets/grade'), $filename);
            // Storage::disk('public_grade')->put($filename, $file);
        }
        if($request->file('filerangsiz')){
            $file= $request->file('filerangsiz');
            $filename= 'rangsiz'.$request->bolim.'.'.$file->getClientOriginalExtension();
            $file-> move(public_path('assets/grade'), $filename);
            // Storage::disk('public_grade')->put($filename, $file);
        }
        return redirect()->back();

        // $files = Storage::disk('public_grade')->allFiles();
        // return $files;
        // $question = DB::table('tg_question')->whereIn('grade',[4,5])->get();
        // return view('image.create',compact('question'));
    }
    public function reg()
    {
        // $email = DB::table('tg_user')->where('id', '36')->value('pr');
        $user = DB::table('tg_productssold')
        ->selectRaw('SUM(tg_productssold.number * tg_medicine.price) as allprice,SUM(tg_productssold.number) as allnumber,tg_medicine.name,tg_medicine.price');
        $search = $user->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id');
               
        // $search = $user->addSelect(DB::raw('count(*) as last'));

        $search = $user->groupBy('tg_medicine.name','tg_medicine.price')->get();


        return $search;
    }
    public function index()
    {

        $deparid = DB::table('tg_productssold')->where('order_id',720)->update([
            'number' => 1
        ]);
        $deparid = DB::table('tg_productssold')->where('order_id',720)->get();
        return $deparid;
        // $sesid = [];
        // foreach(Session::get('per') as $key => $item)
        // {
        //     if(strlen($key) == 2)
        //     {
        //         $sesid[] = substr($key,0,1);
        //     }
        // }
        // return $sesid;
        // return Session::get('per');
        $regions = DB::table('tg_region')->get();

        $sum = DB::table('tg_productssold')
                ->select('tg_medicine.price as price','tg_productssold.number as m_number','tg_region.name as r_name','tg_region.id as r_id')
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                // ->orderBy('tg_order.id', 'ASC')
                ->get();
        $summa = 0;
        $array = [];
        foreach ($regions as $key => $value) {
            foreach ($sum as $keys => $values) {
                if($value->id == $values->r_id)
                {
                    $summa = $summa + ($values->m_number * $values->price);
                }

            }

            $array[] = array('summa' => $summa,'region' => $value->name);
            $summa = 0;

        }
        arsort( $array);
        return view('index',compact('array'));
    }

    public function filter()
    {
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $regions = DB::table('tg_region')->get();
        $users = DB::table('tg_user')
        ->select('tg_region.id as tid','tg_user.id','tg_user.first_name','tg_user.last_name')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->get();
        }else{
            $r_id_array = [];
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)){
               $r_id_array[] = $key;
                }
            }
            $regions = DB::table('tg_region')->whereIn('id',$r_id_array)->get();
            $users = DB::table('tg_user')
            ->whereIn('tg_region.id',$r_id_array)
            ->select('tg_region.id as tid','tg_user.id','tg_user.first_name','tg_user.last_name')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->get();
        }

        $medicine = DB::table('tg_medicine')->get();
        $category = DB::table('tg_category')->get();
        return view('filter',compact('regions','medicine','users','category'));
    }
    public function elchi($id,$time)
    {
        $getimg = DB::table('tg_user')->where('id',$id)->value('image');
        $img = DB::table('tg_user')->where('id',$id)->value('image_change');
        if($img)
        {
            \File::delete(public_path() . '/assets/img/'.$getimg);
            $response = Http::get('http://138.68.81.139:8100/api/v1/user/image/'.$id);
            $url = $response['image'];
            $contents = file_get_contents($url);
            $name = substr($url, strrpos($url, '/') + 1);
            Storage::disk('public_uploads')->put($name, $contents);
            $update = DB::table('tg_user')->where('id',$id)->update([
                'image_change' => FALSE
            ]);
        }
        // // return substr($getimg,6);
        // return $getimg;
        // $exists = Storage::disk('public_uploads')->exists(substr($getimg,6));
        // // return $exists;
        // if(!$exists) {
            
        // }
        

        if ($time == 'today') {
            $date_begin = today();
            $date_end = today();
            $dateText = 'Bugun';
        }
        elseif ($time == 'week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( today()) ) ));
            $date_end = today()->format('Y-m-d');
            $dateText = 'Hafta';
        }
        elseif ($time == 'month') {
            $date_begin = today()->format('Y-m-01');
            $date_end = today()->format('Y-m-d');
            $dateText = 'Oy';
        }
        elseif ($time == 'year') {
            $date_begin = today()->format('Y-01-01');
            $date_end = today()->format('Y-m-d');
            $dateText = 'Yil';
        }
        elseif ($time == 'all') {
            $date_begin = today()->format('1790-01-01');
            $date_end = today()->format('Y-m-d');
            $dateText = 'Hammasi';
        }
        else{
            $date_begin = substr($time,0,10);
            $date_end = substr($time,11);
            $dateText = date('d.m.Y',(strtotime ( $date_begin ) )).'-'.date('d.m.Y',(strtotime ( $date_end ) ));

        }  
        // return  substr("$time",0,10);
        $elchi = DB::table('tg_user')->where('tg_user.id',$id)
        ->select('tg_user.image','tg_specialty.name as lv','tg_user.id','tg_user.tg_id','tg_user.username','tg_user.birthday','tg_user.phone_number','tg_user.first_name','tg_user.last_name','tg_region.name as v_name','tg_district.name as d_name')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->join('tg_district','tg_district.id','tg_user.district_id')
        ->join('tg_specialty','tg_specialty.id','tg_user.specialty_id')
        ->first();
        // $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( today()) ) ));
            // $date_end = today()->format('Y-m-d');
            $category = DB::table('tg_category')->get();
            $medicine = DB::table('tg_medicine')->get();
            $oneuser = DB::table('tg_productssold')
            ->select('tg_category.id as c_id','tg_medicine.id as m_id','tg_medicine.name as m_name','tg_medicine.price as m_price','tg_productssold.number as m_number','tg_user.first_name as uf_name','tg_user.last_name as ul_name','tg_region.name as r_name','tg_productssold.created_at as m_data')
            ->whereDate('tg_productssold.created_at','>=',$date_begin)
            ->whereDate('tg_productssold.created_at','<=',$date_end)
            ->where('tg_user.id',$id)
            ->join('tg_user','tg_user.id','tg_productssold.user_id')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
            ->join('tg_category','tg_category.id','tg_medicine.category_id')
            ->get();
            $sum = 0;
            $catesum = 0;
            $medisum = 0;
            $number = 0;
            $cateory = [];
            $medic = [];

            foreach ($medicine as $mkey => $med) {
                foreach ($oneuser as $key => $one) {

                    if($med->id == $one->m_id)
                    {
                        $medisum = $medisum + ($one->m_price * $one->m_number);
                        $number = $number + $one->m_number;

                        $medic[$mkey] = array('price' => $medisum,'number' => $number, 'name' => $med->name,'cid'=>$one->c_id);
                    }
                }
                    $medisum = 0;
                    $number = 0;

            }
            foreach ($oneuser as $key => $one) {
                $sum = $sum + ($one->m_price * $one->m_number);

            }
            foreach ($category as $ckey => $cate) {
                foreach ($oneuser as $key => $one) {
                    if($cate->id == $one->c_id)
                    {
                        $catesum = $catesum + ($one->m_price * $one->m_number);
                        $cateory[$ckey] = array('price' => $catesum, 'name' => $cate->name,'id' => $cate->id );
                    }else{

                    }
                }
                    // $cateory[] = array('price' => 0, 'name' => $cate->name,'id' => $cate->id );

                    $catesum = 0;

            }
           
            if(count($cateory) == 0)
            {
                foreach ($category as $key => $value) {
                    $cateory[] = array('price' => 0, 'name' => $value->name,'id' => $value->id );

                }

            }
            $isar = [];
            foreach($cateory as $key => $value)
            {
                $isar[] = $value['name'];
            }
            foreach ($category as $key => $value) {
                if(!in_array($value->name,$isar))
                {
                    $cateory[] = array('price' => 0, 'name' => $value->name,'id' => $value->id );

                }
            }
            // return $cateory;
            // return [
            //     'data' => $user,
            //     'sum' => $sum,
            //     'cateory' => $cateory,
            //     'medic' => $medic,
            // ];
        // return $elchi;
        $startDay = today()->startOfWeek()->addDay(1);
        $endDay = Carbon::now();
        $department = DB::table('tg_department')->where('status',1)->get();
        $d_array =[];
        $d_for_user = [];
        $d_for_user2 = [];
        $allquestion = [];
        $allavg = 0;

        $yulduz = DB::table('tg_question')->where('grade',6)->first();

        $users = DB::table('tg_grade')
            ->select('tg_user.id','tg_user.first_name','tg_user.last_name')
            ->where('tg_grade.question_id','!=',$yulduz->id)
            ->join('tg_user','tg_user.id','tg_grade.teacher_id')
            ->distinct()
            ->get();

            foreach($department as $depar)
            {
        $question = DB::table('tg_question')->where('department_id',$depar->id)->get();
        

        foreach($users as $dnam)
        {
            $quescount = 0;
            $avg_u = 0;
            $avg_q = 0;
            $ads = [];

                foreach($question as $key => $ques)
            {
                $grade = DB::table('tg_grade')
                ->where('teacher_id',$dnam->id)
                ->where('user_id',$id)
                ->where('question_id',$ques->id)
                ->avg('grade');

                $quesforuser = DB::table('tg_grade')
                ->select('tg_department.id as did','tg_question.name as qname','tg_grade.*')
                ->where('teacher_id',$dnam->id)
                ->where('user_id',$id)
                ->where('question_id',$ques->id)
                ->join('tg_question','tg_question.id','tg_grade.question_id')
                ->join('tg_department','tg_department.id','tg_question.department_id')
                ->get();

                foreach($quesforuser as $keyd => $valued)
                {
                    $allquestion[] = $valued;
                }
                if($grade != NULL)
                {
                    $quescount++;

                }
                $avg_q += $grade;
            }
            if($quescount == 0)
            {
            $avg_u += 0;

            }else{
            $avg_u += $avg_q/$quescount;

            }

            if($avg_u > 0)
            {
            $d_for_user[] = array('uid' => $dnam->id,'avg' => number_format($avg_u,2),'depid' => $depar->id,'username' => $dnam->last_name.' '.$dnam->first_name);
            $d_for_user2[] = array('avg' => number_format($avg_u,2),'depid' => $depar->id,'username' => $dnam->last_name.' '.$dnam->first_name);
            }
            // $avg_q = 0;
            // $avg_u = 0;
        // $quescount = 0;


        }
        $avguser = 0;
        foreach($d_for_user2 as $keyr => $valuer)
        {
            $avguser += $valuer['avg'];
        }
        if(count($d_for_user2) == 0)
            {
            $allsavguser = 0;

            }else{
            $allsavguser = $avguser/count($d_for_user2);
            $ads[] = $allsavguser;
            }
        // $d_array[] = array('id'=>$depar->id,'name' => $depar->name,'avg' => $avguser);
        // $avguser = 0;

        $d_array[] = array('id'=>$depar->id,'name' => $depar->name,'avg' => number_format($allsavguser, 2));
        $d_for_user2 = [];

        

        }
        $davg = 0;
        $maxnol = 0;
        foreach($d_array as $dr)
        {   
            if($dr['avg'] > 0)
            {
                $maxnol +=1;
            }
            $davg += $dr['avg'];
        }
        if($maxnol == 0)
        {
            $allavg =0;
        }else{

        
        $allavg = $davg/$maxnol;
        }

        // return $allquestion;
        $yulduz = DB::table('tg_question')->where('grade',6)->first();

        $client = DB::table('tg_cgrade')->where('question_id',$yulduz->id)
        ->where('user_id',$id)->distinct()->pluck('teacher_id');
        // return $client;


        $tashqi = DB::table('tg_cgrade')->where('question_id',$yulduz->id)
        ->where('user_id',$id)
        ->get();
        // return $tashqi;
        $tgrade=0;
        $altgarde=0;
        foreach($client as $cl)
        {
            if(count($tashqi) != 0)
            {

            
            foreach($tashqi as $tq)
            {
                if($cl == $tq->teacher_id)
                {
                    $tgrade += $tq->grade;
                }
            }

                $altgarde += $tgrade/count($tashqi);
            
            }else{
                $altgarde += 0;

            }
            
        }

        if(count($client) == 0)
        {
            $altgardes = 0.00;
        }else{

        // return $allquestion;
        $altgardes = number_format($altgarde/count($client),2);
        }
        $allques = DB::table('tg_clientgrade')->where('user_id',$id)->get();
        $allquesgr = DB::table('tg_question')->whereIn('grade',[1,2,3,4,5])->get();
        $quecount = 0;
        $quearray = [];
        foreach($allquesgr as $key => $value)
        {
            foreach($allques as $keys => $values)
            {
                if($value->id == $values->question_id)
                {
                    $quecount += 1;
                }
            }
            $quearray[] = array('name' => $value->name,'count' => $quecount);
            $quecount = 0;

        }
        $devicegrade = DB::table('tg_cgrade')->where('user_id',$id)
        ->select('tg_cgrade.*','tg_client.device as device')
        // ->select('tg_cgrade.grade as grade','tg_cgrade.created_at as cat','tg_client.device as device','tg_cgrade')
        ->join('tg_client','tg_client.id','tg_cgrade.teacher_id')
        ->get();
        
        return view('welcome',compact('allquestion','devicegrade','allavg','d_for_user','d_array','altgardes','quearray','elchi','medic','cateory','category','sum','dateText'));
        // return $id;
    }
    public function elchiList()
    {
        $userarrayreg = [];
        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
            $users = DB::table('tg_user')
                    ->select('tg_user.id','tg_user.last_name','tg_user.first_name')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->get();
                    foreach ($users as $key => $value) {
                        $userarrayreg[] = $value->id;
                    }
        }else{
            $r_id_array = [];
                    foreach (Session::get('per') as $key => $value) {
                        if (is_numeric($key)){
                            $r_id_array[] = $key;
                        }
                    }
                    $users = DB::table('tg_user')
                    ->whereIn('tg_region.id',$r_id_array)
                    ->select('tg_user.id','tg_user.last_name','tg_user.first_name')
                    ->join('tg_region','tg_region.id','tg_user.region_id')
                    ->get();
                    foreach ($users as $key => $value) {
                        $userarrayreg[] = $value->id;
                    }
            
        }

        $elchi = DB::table('tg_user')
            ->whereIn('tg_user.id',$userarrayreg)
            ->where('tg_user.admin',FALSE)
            ->select('tg_user.admin','tg_region.id as rid','tg_region.name as v_name','tg_user.username','tg_user.id','tg_user.last_name','tg_user.first_name')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->orderBy('tg_user.admin','DESC')->get();

            
        $elchi_work=[];
        $elchi_fact=[];
        $elchi_prognoz=[];
        $cale = DB::table('tg_calendar')->where('year_month',today()->format('m.Y'))->first();
        $cale_date = json_decode($cale->day_json);
        // return $elchi;
        $date = DB::table('tg_smena')
            // ->whereIn(DB::raw('DATE(created_from)'), $all_date)
            ->whereDate('created_from','>=',today()->format('Y-m').'-01')
            ->whereDate('created_from','<=',today()->format('Y-m').'-30')
            ->where('smena',2)
            ->where('user_id', 35)
            ->orderBy('created_from','DESC')
            ->pluck('created_from');
        // return $date[0];
        $fsd=[];
        foreach($elchi as $elch)
        {

            $date = DB::table('tg_smena')
            // ->whereIn(DB::raw('DATE(created_from)'), $all_date)
            ->whereDate('created_from','>=',today()->format('Y-m').'-01')
            ->whereDate('created_from','<=',today()->format('Y-m').'-30')
            ->where('smena',2)
            ->where('user_id', $elch->id)
            ->orderBy('created_from','DESC')
            ->pluck('created_from');

            // return $date;
            // $fsd[]=$date;
        if(isset($date[0]))
        {

        
        $all_date=[];
        foreach($cale_date as $key => $value)
        {   
            if($value == 'true' && $key <=  date('d',(strtotime ( $date[0] ) )))
            {
                if (strlen($key) == 1) {
                    $key = '0'.$key;
                }
            $all_date[] = today()->format('Y-m').'-'.$key;
            }
        }
        $no_day=0;
        foreach($date as $item){
            if(!in_array($item,$all_date)){
                $no_day += 1;
            }
        }
        $sunday = 0;
        foreach($date as $d)
        {
            if(date('l',(strtotime ( $d ) )) == 'Sunday')
            {
                $sunday = $sunday + 1;
                
            }
        }


        $pr = count($all_date)+$sunday;
        // return $date;
        $elchi_work[$elch->id] = ($cale->work_day+$sunday).'/'.(count($date)).'/'.$pr;
        
                $user = DB::table('tg_productssold')
                ->selectRaw('SUM(tg_productssold.number * tg_medicine.price) as allprice,SUM(tg_productssold.number) as allnumber,tg_medicine.name,tg_medicine.price')
                ->whereIn(DB::raw('DATE(tg_productssold.created_at)'), $date)
                ->where('tg_user.id', $elch->id)
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->groupBy('tg_medicine.name','tg_medicine.price')->get();
                $user_sum=0;
                foreach($user as $key)
                {
                    $user_sum += $key->allprice;
                }
                if(count($date) == 0)
                {
                    $prognoz = 0;

                }else{

                    if($pr == 0)
                    {
                        $prognoz = 0;
                    }else{
                $prognoz = number_format(($user_sum/$pr)*($cale->work_day+$sunday),0,'','.');

                    }
                }
        $elchi_fact[$elch->id] = number_format($user_sum, 0, '', '.');

        $elchi_prognoz[$elch->id] = $prognoz;
        $user_sum=0;
        }else{
        $elchi_prognoz[$elch->id] = 0;
        $elchi_fact[$elch->id] = 0;
        $elchi_work[$elch->id] = 0;

        }
        }
        // return $fsd;/

        // return view('elchi');
        return view('elchi',compact('elchi','elchi_work','elchi_fact','elchi_prognoz'));
    }
    public function userList(Request $request)
    {
        // $getip = UserSystemInfo::get_ip();
    // $getbrowser = UserSystemInfo::get_browsers();
    // $getdevice = UserSystemInfo::get_device();
    // $getos = UserSystemInfo::get_os();

    // echo "<center>$getip <br> $getdevice <br> $getbrowser <br> $getos</center>";
    // die();
    //  $agent = new Agent();
    //  return $agent->device();
    // $host = request()->getHttpHost();
    //  return getenv('COMPUTERNAME');

        $elchi = DB::table('tg_user')
        ->where('admin',TRUE)
        ->select('tg_user.last_seen','tg_positions.id as pid','tg_positions.rol_name','tg_user.id','tg_user.tg_id','tg_user.username','tg_user.birthday','tg_user.phone_number','tg_user.first_name','tg_user.last_name','tg_region.name as v_name')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->leftjoin('tg_positions','tg_positions.id','tg_user.rol_id')
        ->get();
        // return $elchi;
        $posi = DB::table('tg_positions')->get();
        return view('user',compact('elchi','posi'));
    }
    public function proList($time)
    {
        // $time = '02.09.2022/02.09.2022';
        if ($time == 'today') {
            $date_begin = today();
            $date_end = today();

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( today()) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( today()) ) ));
            $dateText = 'Bugun';
        }
        elseif ($time == 'week') {
            $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( today()) ) ));
            $date_end = today()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-2 week' , strtotime ( today()) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 week' , strtotime ( today()) ) ));
            $dateText = 'Hafta';
        }
        elseif ($time == 'month') {
            $date_begin = today()->format('Y-m-01');
            $date_end = today()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $date_begin) ) ));
            $f_date_end = today()->format('Y-m-01');
            $dateText = 'Oy';
        }
        elseif ($time == 'year') {
            $date_begin = today()->format('Y-01-01');
            $date_end = today()->format('Y-m-d');

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 year' , strtotime ( $date_begin) ) ));
            $f_date_end = today()->format('Y-01-01');
            $dateText = 'Yil';
        }
        elseif ($time == 'all') {
            $date_begin = today()->format('1790-01-01');
            $date_end = today()->format('Y-m-d');

            $f_date_begin = today()->format('1790-01-01');
            $f_date_end = today()->format('Y-m-d');
            $dateText = 'Hammasi';
        }
        else{
            $date_begin = substr($time,0,10);
            $date_end = substr($time,11);

            $f_date_begin = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( substr($time,0,10)) ) ));
            $f_date_end = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( substr($time,11)) ) ));
            $dateText = date('d.m.Y',(strtotime ( $date_begin ) )).'-'.date('d.m.Y',(strtotime ( $date_end ) ));

        }  
        $r_id_array = [];

        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $regions = DB::table('tg_region')->get();
        foreach ($regions as $key => $value) {
            // if (is_numeric($key)){
           $r_id_array[] = $value->id;
            // }
        }

        }else{
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)){
               $r_id_array[] = $key;
                }
            }

        }
        $products = DB::table('tg_productssold')
                ->select('tg_medicine.id as m_id','tg_category.id as c_id','tg_medicine.name as m_name','tg_medicine.price as m_price','tg_productssold.number as m_number','tg_productssold.created_at as m_data')
                ->whereDate('tg_productssold.created_at','>=',$date_begin)
                ->whereDate('tg_productssold.created_at','<=',$date_end)
                ->whereIn('tg_region.id',$r_id_array)
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->get();
        $products_range = DB::table('tg_productssold')
                ->select('tg_medicine.id as m_id','tg_category.id as c_id','tg_medicine.name as m_name','tg_medicine.price as m_price','tg_productssold.number as m_number','tg_productssold.created_at as m_data')
                ->whereDate('tg_productssold.created_at','>=',$f_date_begin)
                ->whereDate('tg_productssold.created_at','<=',$f_date_end)
                ->whereIn('tg_region.id',$r_id_array)
                ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
                ->join('tg_category','tg_category.id','tg_medicine.category_id')
                ->join('tg_user','tg_user.id','tg_productssold.user_id')
                ->join('tg_region','tg_region.id','tg_user.region_id')
                ->get();

        $category = DB::table('tg_category')->get();
        $medicine = DB::table('tg_medicine')->get();

            $sum = 0;
            $catesum = 0;
            $medisum = 0;
            $number = 0;
            $cateory = [];
            $medic = [];
            $medicf = [];
            $inarray = [];
            foreach ($products as $key => $one) {
                $inarray[] = $one->m_id;
            }
            $inarraycat = [];
            foreach ($products as $key => $one) {
                $inarraycat[] = $one->c_id;
            }
            foreach ($medicine as $mkey => $med) {
                foreach ($products as $key => $one) {

                    if($med->id == $one->m_id)
                    {
                        $medisum = $medisum + ($one->m_price * $one->m_number);
                        $number = $number + $one->m_number;

                        $medic[$mkey] = array('mid'=>$one->m_id,'narx'=>$med->price,'price' => $medisum,'number' => $number, 'name' => $med->name,'cid' => $one->c_id,'nol' => 1);
                    }
                    
            
                }
                    $medisum = 0;
                    $number = 0;

            }
            $medica = $medic;
            $alls = [];
            foreach ($category as $key => $one) {

                foreach ($medicine as $mkey => $med) {
                        $alls[] = array('mid'=>$med->id,'narx'=>$med->price,'price' => 0,'number' => 0, 'name' => $med->name,'cid' => $one->id,'nol' => 0);
                }
            }

            $alls2 = $alls;

            foreach ($alls as $key => $one) {

                foreach ($medica as $mkey => $med) {
                    if($one['cid'] == $med['cid'] && $one['mid'] == $med['mid'] )
                    {
                        $alls2[$key] = $medica[$mkey];
                    }
                }

            }
            foreach ($alls2 as $key => $one) {
                unset($alls2[$key]->mid);
            }
            $medic = $alls2;

            #2
            $medic2 = [];

            foreach ($medicine as $mkey => $med) {
                foreach ($products_range as $key => $one) {

                    if($med->id == $one->m_id)
                    {
                        $medisum = $medisum + ($one->m_price * $one->m_number);
                        $number = $number + $one->m_number;

                        $medic2[$mkey] = array('mid'=>$one->m_id,'narx'=>$med->price,'price' => $medisum,'number' => $number, 'name' => $med->name,'cid' => $one->c_id,'nol' => 1);
                    }
                    
            
                }
                    $medisum = 0;
                    $number = 0;

            }
            $medica2 = $medic2;

            $alls22 = $alls;

            foreach ($alls as $key => $one) {

                foreach ($medica2 as $mkey => $med) {
                    if($one['cid'] == $med['cid'] && $one['mid'] == $med['mid'] )
                    {
                        $alls22[$key] = $medica2[$mkey];
                    }
                }

            }
            // foreach ($alls22 as $key => $one) {
            //     unset($alls22[$key]->mid);
            // }
            $medic2 = $alls22;
            
        return view('product',compact('medic','medic2','category','dateText'));
    }
    public function userOnlineStatus()
    {
        $users = DB::table('tg_user')->where('admin',true)->get();
        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id))
                echo $user->first_name . " is online. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
            else
                echo $user->first_name . " is offline. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
        }
    }

    public function grade()
    {
        $r_id_array = [];

        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
        $regions = DB::table('tg_region')->get();
        foreach ($regions as $key => $value) {
           $r_id_array[] = $value->id;
        }

        }else{
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)){
               $r_id_array[] = $key;
                }
            }

        }
        $elchilar = DB::table('tg_user')
        ->select('tg_region.id as tid','tg_user.id','tg_user.first_name','tg_user.last_name')
        ->whereIn('tg_region.id',$r_id_array)
        ->where('tg_user.admin',FALSE)
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->get();
        // return $elchilar;
        $regions = DB::table('tg_region')->whereIn('id',$r_id_array)->get();
        $departments = DB::table('tg_department')->where('status',1)->get();
        $questions = DB::table('tg_question')->get();

        $grades_user = DB::table('tg_grade')
        ->select('grade','question_id as qid','user_id as uid')
        ->where('created_at',today())
        ->where('teacher_id',Session::get('user')->id)
        ->get();
        // ->pluck('grade','question_id','user_id');
        $grades=[];
        foreach($grades_user as $gar)
        {
            $grades[$gar->qid] = array('grade'=>$gar->grade,'uid'=>$gar->uid);
        }
        // return $grades[2]['grade'];
        return view('grade',compact('elchilar','regions','departments','questions','grades'));
    }
    public function nvt(Request $request)
    {
        $agent = $request->header('User-Agent');
        // $text = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36';
        // return $agent;
        // $text2 = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.114 YaBrowser/22.9.1.1094 Yowser/2.5 Safari/537.36';
        // return str_contains($agent, $text2);
        // $text4 = 'Mozilla/5.0 (Linux; Android 12; M2101K7AG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Mobile Safari/537.36';
        // $text3 = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36 Edg/105.0.1343.50';
        // return wordSimilarity($agent, $text4);
        
        $get_agent = DB::table('tg_client')->get();
        $agent_array = [];
        $max=0;
        foreach($get_agent as $ag)
        {
            if(wordSimilarity($agent, $ag->device)>0.9)
            {
                if(wordSimilarity($agent, $ag->device) > $max)
                {
                    $max = wordSimilarity($agent, $ag->device);
                $agent_array[] = array('id' => $ag->id,'name'=>$ag->device);

                }
            }
        }
        // return count($agent_array);

        if(count($agent_array) != 1)
        {

            $id = DB::table('tg_client')->insertGetId([
                'device' => $agent,
                'created_at' => Carbon::now(),
            ]);
            $agent_array[] = array('id' => $id,'name'=>$agent);
            // return $agent_array;
        }

        // return $agent_array;

        // $currentURL = URL::current();
        // $route = Route::current()->getPrefix();
        // $prefix = Request::route()->getPrefix();""
        $route = Route::current()->uri();
        $user = DB::table('tg_user')->where('username',$route)->first();
        $questions = DB::table('tg_question')
        ->select('tg_question.id as qid','tg_question.name as qname','tg_question.grade')
        ->where('tg_department.status',2)
        ->join('tg_department','tg_department.id','tg_question.department_id')
        ->get();
        $yulduz = DB::table('tg_question')->where('grade',6)->first();

        // return $yulduz;
        // $token = $request->bearerToken();
        // var_dump($request->headers['headers']);
        // return $questions;
        return view('client',compact('user','questions','agent_array','yulduz'));

    }
    public function setting($month)
    {
        $year = substr($month,3);
        $months = substr($month,0,-5);
        $maxday =  Carbon::now()->year($year)->month($months)->daysInMonth;
        $dates = []; 

        $ym = DB::table('tg_calendar')->where('year_month',$month)->value('day_json');
        // return $ym;
        if($ym)
        {
            $ym_json = json_decode($ym);
        }else{
            $ym_json = 1;
        }
    for($i=1; $i < $maxday + 1; ++$i) {
        $dayName = \Carbon\Carbon::createFromDate($year,$months, $i)->format('l');
        $day = \Carbon\Carbon::createFromDate($year, $months, $i)->format('d');
        if($day[0] == '0')
        {
            $day = substr($day,1);
        }
        $dates[$day] = $dayName;
    }
        $monthname =  \Carbon\Carbon::createFromDate($year,$months)->format('F');
        // $monthname2 =  \Carbon\Carbon::createFromDate($year,$month)->format('Y-m')->addMonth();;
        $plusmonth = date('m.Y',(strtotime ( '+1 month' , strtotime ( '01.'.$month) ) ));
        $minusmonth = date('m.Y',(strtotime ( '-1 month' , strtotime ( '01.'.$month) ) ));
        $weeks = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        $key = array_search($dates[1],$weeks);
        return view('settings',compact('dates','monthname','minusmonth','plusmonth','month','ym_json','key'));
    }

    public function permission(Request $request)
    {
        $update = DB::table('tg_user')->where('id',$request->user_id)->update(['rol_id' => $request->rol_id]);
        return redirect()->back();
    }
    public function loginSite(Request $request)
    {   
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);
        // $schema_name = DB::select("SELECT schema_name FROM information_schema.schemata WHERE schema_name LIKE '@h%';");
        // // return $schema_name;
        // // die();
        // foreach ($schema_name as $key => $value) {
            setSchema('admin');
           

        
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
            }else{
                return redirect()->back();
            }
        // }
        if ($user) {
            Session::put('user', $user);
            $f_schema = $user['branch_key'];
            $h_schema = $user['hospital_key'];
            $id = $user['rol_id'];
            if ($f_schema == 'none') {
                Session::put('pos', 'hospital');
                Session::put('db', $h_schema);
            // $schema_row = DB::select('SELECT * FROM '.'"'."$h_schema".'"'.'.positions WHERE id = '.$id.';');
            $schema_row = Position::find($id);



            }else{
                $admin_schema = 'admin';
                Session::put('pos', 'branch');
                Session::put('db', $f_schema);
                // $schema_row = DB::select('SELECT * FROM '.'"'."$admin_schema".'"'.'.positions WHERE id = '.$id.';');
                $schema_row = Position::find($id);
            }
            // return json_decode($schema_row->position_json);

            // // if (isset($schema_row[0]->position_json)) {
            // //     Session::put('rol', json_decode($schema_row[0]->position_json));
            // // }else{
            //     Session::put('rol', json_decode($schema_row->position_json));
            // // }
            
            setSchemaInConnection();
            $all_patient = DB::table('patients')->count();
    $all_chkb = DB::table('patients')->where('treatment_tip','app.chkb')->count();
    $all_true = DB::table('patients')->where('death',true)->count();
    $chkb_true = DB::table('patients')->where('death',true)->where('treatment_tip','app.chkb')->count();
    $all_false = DB::table('patients')->where('death',false)->count();
    $chkb_false = DB::table('patients')->where('death',false)->where('treatment_tip','app.chkb')->count();
        // return view('welcome',compact('all_patient','all_chkb','all_true','chkb_true','all_false','chkb_false'));
        return view('welcome',compact('all_patient','all_chkb','all_true','chkb_true','all_false','chkb_false','user'));
        
            
        }else{ return redirect()->back(); }
            // return $schema_row;
    }

    public function login()
    {
        // Config::set('database.connections.pgsql.schema','public');
        // setSchemaInConnection();


        $all_patient = DB::table('patients')
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))->count();
        $all_chkb = DB::table('patients')->where('treatment_tip','app.chkb')
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))->count();
        $all_true = DB::table('patients')->where('death',true)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))->count();
        $chkb_true = DB::table('patients')->where('death',true)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))->where('treatment_tip','app.chkb')->count();
        $all_false = DB::table('patients')->where('death',false)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))->count();
        $chkb_false = DB::table('patients')->where('death',false)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))->where('treatment_tip','app.chkb')->count();

        return view('welcome',compact('all_patient','all_chkb','all_true','chkb_true','all_false','chkb_false'));
        // return view('welcome');
    }
    public function patientExit()
    {

        $patient = Patient::select('id','first_name','last_name','full_name','pinfl')
        ->where('death',null)
        ->where('hospital_id',Session::get('hospital_id'))
        ->where('branch_id',Session::get('branch_id'))
        ->get();
        // $patient = Patient::all();
        // $patient = 'gh';
        return view('patient.exit',compact('patient'));

    }

    // public function login()
    // {
    //     return view('user.login');
    // }
    public function logout()
    {
        // Session::flush();
        // Session::remove('user');
        // $df = Session::get('user');
        // Auth::logout();
        // return $df;
        // return redirect('/login');
        return view('auth.login');
    }

    public function settings()
    {
        return view('user.login');
    }

    

}
