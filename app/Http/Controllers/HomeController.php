<?php

namespace App\Http\Controllers;

use App\Helpers\UserSystemInfo;
use App\Models\Plan;
use App\Models\PlanWeek;
use App\Models\ProductSold;
use App\Services\PlanHomeControllerService;
use App\Services\Sold;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Pharmacy;
use App\Models\PharmacyUser;
use App\Models\Position;
use App\Models\Pill;
use App\Models\Question;
use App\Models\Region;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Jenssegers\Agent\Agent;
use Storage;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\isEmpty;
use App\Models\Knowledge;
use App\Models\UserQuestion;
use App\Models\PillQuestion;
use App\Models\ConditionQuestion;

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
    public function pharmacyList(Request $request)
    {
        // dd($request);
        // \File::delete(public_path() . '/assets/img/'.$getimg);
        // $id =2;
            
        $pharmacy = Pharmacy::all();
        // foreach($pharmacy as $item)
        // {
        //     $response = Http::get('http://128.199.2.165:8100/api/v1/pharm/image/'.$item->id.'/');
        //     $url = $response['image'];
        //     $contents = file_get_contents($url);
        //     $name = substr($url, strrpos($url, '/') + 1);
        //     Storage::disk('public_uploads')->put($name, $contents);
        // }
        return view('pharmacy',compact('pharmacy'));
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
        //  DB::table('tg_grade')
        // ->whereIn('question_id',DB::table('tg_question')
        // ->where('department_id',DB::table('tg_department')->where('name','Bilim')->where('status',1)->first()->id)
        // ->pluck('id'))
        // ->delete();
        //  DB::table('tg_question')
        // ->where('department_id',DB::table('tg_department')->where('name','Bilim')->where('status',1)->first()->id)
        // ->delete();
        // DB::table('tg_department')->where('name','Bilim')->where('status',1)->delete();
        
        // $deparid = DB::table('tg_productssold')->where('order_id',720)->update([
        //     'number' => 1
        // ]);
        // $deparid = DB::table('tg_productssold')->where('order_id',720)->get();
        // return $deparid;
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

        // $regions = Question::with('pill')->get();
        // return $regions;
        // $array = [1, 2, 3, 4, 5];
        // $pluck_id = PillQuestion::where('knowledge_id',3)->pluck('id');
 
        // $random = array_rand($pluck_id,2);
        // return Carbon::now();
        // $users = DB::table('tg_user_questions')->where('id','>',470)->delete();

        // $user_question = UserQuestion::where('user_id',59)->get('step3');
        // // return $user_question;
        // $pluck_id = PillQuestion::where('knowledge_id',3)->count();
        // $step1_ids = [];
        // foreach($user_question as $user)
        // {
        //     $step1_user = json_decode($user->step3);
        //     foreach($step1_user as $key => $value)
        //     {   
        //         if ($key == 2) {  
        //             foreach($value as $v_item) 
        //             {
        //                 $step1_ids[] = $v_item;
        //             }
        //         }
        //     }
        // }
        // rsort($step1_ids);
        // return $step1_ids;
        // $step1_ids_slice = $step1_ids;
        // if($pluck_id <= count($step1_ids))
        // {
        //     $max = floor(count($step1_ids) / $pluck_id);
        //     for ($i=0; $i < $max*$pluck_id; $i++) { 
        //         array_splice($step1_ids,0,1);
        //     }
        // }
        // return $step1_ids;


        #save-bilim-ai
        // $knowledges = Knowledge::with('pill_question')->get();
        // $users = DB::table('tg_user')->where('admin',FALSE)->get('id');

        // $knowledges2 = ConditionQuestion::distinct()->pluck('pill_question_id');
        // $knowledges = PillQuestion::where('knowledge_id',3)->distinct()->pluck('id');
        // $knowledges = PillQuestion::get;
        // $knowledge = PillQuestion::all();
        // $knowledge = PillQuestion::all();
        // return $users;  
        // $step1 = [];
        // $step3 = [];
        // $question_step = [];
        // $testarray = [];
        // foreach($users as $user_items)
        // {
        //     $user_question = UserQuestion::where('user_id',$user_items->id)->get();
        //     foreach($knowledges as $key => $pills)
        //     {   
                
        //         if($pills->step == 1)
        //         {
        //             $step1_ids = [];
        //                 foreach($user_question as $user)
        //                 {
        //                     $step1_user = json_decode($user->step1);
        //                     foreach($step1_user as $key => $value)
        //                     {   
        //                         if ($key == $pills->id) {
        //                             foreach($value as $v_item) 
        //                                 {
        //                                     $step1_ids[] = $v_item;
        //                                 }
        //                         }
        //                     }
        //                 }

        //             $step1_count = PillQuestion::where('knowledge_id',$pills->id)->count();
        //             if($step1_count <= count($step1_ids))
        //                 {
        //                     if($step3_count == 0)
        //                         {
        //                         $max = 0;

        //                         }else{
        //                             $max = floor(count($step1_ids) / $step1_count);

        //                         }
                            
        //                     for ($i=0; $i < $max*$step1_count; $i++) { 
        //                     unset($step1_ids[$i]);
        //                     }
        //                 }
        //             $pluck_id = PillQuestion::where('knowledge_id',$pills->id)->inRandomOrder()
        //             ->whereNotIn('id',$step1_ids)
        //             ->limit($pills->number)->pluck('id');
        //             if(count($pluck_id) == 0){
        //                 $pluck_id = PillQuestion::where('knowledge_id',$pills->id)->inRandomOrder()
        //                 ->limit($pills->number)->pluck('id');
        //             }
        //             $step1[$pills->id] = $pluck_id;

        //         }
        //         if($pills->step == 3)
        //         {
        //             $step3_ids = [];
        //                 foreach($user_question as $user)
        //                 {
        //                     $step3_user = json_decode($user->step3);
        //                     foreach($step3_user as $key => $value)
        //                     {   
        //                         if ($key == $pills->id) {
        //                             foreach($value as $v_item) 
        //                                 {
        //                                     $step3_ids[] = $v_item;
        //                                 }
        //                         }
        //                     }
        //                 }
        //                 $step3_count = PillQuestion::where('knowledge_id',$pills->id)->count();
        //                 if($step3_count <= count($step3_ids))
        //                     {
        //                         if($step3_count == 0)
        //                         {
        //                         $max = 0;

        //                         }else{
        //                         $max = floor(count($step3_ids) / $step3_count);

        //                         }
        //                         for ($i=0; $i < $max*$step3_count; $i++) { 
        //                         unset($step3_ids[$i]);
        //                         }
        //                     }
        //             $pluck_id = PillQuestion::where('knowledge_id',$pills->id)->inRandomOrder()
        //             ->whereNotIn('id',$step3_ids)
        //             ->limit($pills->number)->pluck('id');
        //             if(count($pluck_id) == 0)
        //             {
        //                 $pluck_id = PillQuestion::where('knowledge_id',$pills->id)->inRandomOrder()
        //                  ->limit($pills->number)->pluck('id');
        //             }
        //             $step3[$pills->id] = $pluck_id;
        //             foreach($step3[$pills->id] as $item_key => $item)
        //             {
        //                 $condition_id = ConditionQuestion::where('pill_question_id',$item)->pluck('id');
                    
        //                 foreach($condition_id as $condition_key => $condition)
        //                 {
        //                     $condition_item_id = KnowledgeQuestion::where('condition_question_id',$condition)->inRandomOrder()
        //                     ->limit(1)->pluck('id');
        //                     $question_step[$condition] = $condition_item_id;

        //                 }
        //             }
        //         }
                
        //     }
        //     // $new_user_question = new UserQuestion([
        //     //     'user_id' => $user_items->id,
        //     //     'step1' => json_encode($step1),
        //     //     'step3' => json_encode($step3),
        //     //     'question_step' => json_encode($question_step),
        //     //     'created_at' => '2022-10-02 12:19:21',
        //     //     'updated_at' => '2022-10-02 12:19:21',
        //     // ]);
        //     // $new_user_question->save();
        //     $step1 = [];
        //         $step3 = [];
        //         $question_step = [];
        //             $step1_ids = [];
        //             $step3_ids = [];

        // }

        #end-save-bilim-ai

        // $user_question = UserQuestion::where('user_id',59)->get();
        // $pluck_id = PillQuestion::where('knowledge_id',2)->pluck('id');
        // $step1_ids = [];
        // foreach($user_question as $user)
        // {
        //     $step1_user = json_decode($user->step1);
        //     foreach($step1_user as $key => $value)
        //     {   
        //         if ($key == 3) {
        //             $step1_ids[] = $value[0];
        //         }
        //     }
        // }
        // $pluck_id = PillQuestion::where('knowledge_id',3)
        // ->whereNotIn('id',$step1_ids)
        // ->inRandomOrder()
        //             ->limit(1)->pluck('id');
        // return $step1_user;
        // var_dump($pluck_id);
        // die();

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
        // $getimg = DB::table('tg_user')->where('id',$id)->value('image');
        // $img = DB::table('tg_user')->where('id',$id)->value('image_change');
        // if($img)
        // {
        //     \File::delete(public_path() . '/assets/img/'.$getimg);
        //     $response = Http::get('http://128.199.2.165:8100/api/v1/user/image/'.$id);
        //     $url = $response['image'];
        //     $contents = file_get_contents($url);
        //     $name = substr($url, strrpos($url, '/') + 1);
        //     Storage::disk('public_uploads')->put($name, $contents);
        //     $update = DB::table('tg_user')->where('id',$id)->update([
        //         'image_change' => FALSE
        //     ]);
        // }
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
        ->select('tg_user.image_url','tg_specialty.name as lv','tg_user.id','tg_user.tg_id','tg_user.username','tg_user.birthday','tg_user.phone_number','tg_user.first_name','tg_user.last_name','tg_region.name as v_name','tg_district.name as d_name')
        ->join('tg_region','tg_region.id','tg_user.region_id')
        ->join('tg_district','tg_district.id','tg_user.district_id')
        ->join('tg_specialty','tg_specialty.id','tg_user.specialty_id')
        ->first();
        // $date_begin = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( today()) ) ));
            // $date_end = today()->format('Y-m-d');
            $category = DB::table('tg_category')->get();
            $medicine = DB::table('tg_medicine')->get();
            $medicine_cate = DB::table('tg_medicine')
            ->select('tg_category.id as c_id','tg_medicine.id as m_id','tg_medicine.name as m_name','tg_medicine.price as m_price')
            ->join('tg_category','tg_category.id','tg_medicine.category_id')
            ->get();
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
            $medicineall = [];

            foreach ($medicine_cate as $mkey => $med) {

                $medicineall[$mkey] = array('price' => 0,'number' => 0, 'name' => $med->m_name,'cid'=>$med->c_id);
                

            }
            foreach ($medicine_cate as $mkey => $med) {
                foreach ($oneuser as $key => $one) {

                    if($med->m_id == $one->m_id)
                    {
                        $medisum = $medisum + ($one->m_price * $one->m_number);
                        $number = $number + $one->m_number;

                        $medicineall[$mkey] = array('price' => $medisum,'number' => $number, 'name' => $med->m_name,'cid'=>$one->c_id);
                    }
                }
                    $medisum = 0;
                    $number = 0;

            }
            // return  $medicineall;
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
            // return $medic;
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

        $know_grade = DB::table('tg_knowledge_grades')
        ->where('user_id',$id)->get();

        $knowledges = DB::table('tg_knowledge')->whereIn('step',[1,3])->get();
        $know_teachers = DB::table('tg_knowledge_grades')->distinct()->pluck('teacher_id');
        // return $know_teachers;
        $pill_array = [];
        $step_array = [];
        $step_array_counter = [];
        $step_array_grade_all = [];
        
        foreach($knowledges as $knowledge)
        {
            if($knowledge->step == 1){
            $pill_counter = 0;
                foreach($know_teachers as $teachers)
            {
                $condition = DB::table('tg_pill_questions')->where('knowledge_id',$knowledge->id)->pluck('id');
                $questions = DB::table('tg_knowledge_grades')
                ->whereIn('pill_id',$condition)
                ->where('user_id',$id)
                ->where('teacher_id',$teachers)->avg('grade');

                $questions_grade = DB::table('tg_knowledge_grades')
                ->whereIn('pill_id',$condition)
                ->where('user_id',$id)
                ->where('teacher_id',$teachers)->first();

                $step_array_grade_all[] = $questions_grade;

                $questions_count = DB::table('tg_knowledge_grades')
                ->whereIn('pill_id',$condition)
                ->where('user_id',$id)
                ->where('teacher_id',$teachers)->count();

                $step_array_grade = [];

                if($questions == 0 )
                {
                    $pill_avg = 0;

                }else{
                    $pill_avg = $questions/$questions_count;
                }

                $pill_counter += $pill_avg;
            }
                if($pill_counter == 0)
                {
                    $all_avg = 0;
                }else{
                    $all_avg = $pill_counter/count($know_teachers);
                }
                $pill_array[] = array('avg' => number_format($all_avg,2),'name' =>$knowledge->name);
            }
            if($knowledge->step == 3){

                $condition_step = DB::table('tg_pill_questions')->where('knowledge_id',$knowledge->id)->get();
                
                foreach($condition_step as $key_con => $con)
                {
            $pill_counter = 0;
            $pill_counter_count = 0;

                foreach($know_teachers as $teachers)
                {

                $step3 = DB::table('tg_knowledge_grades')
                ->select('tg_knowledge_grades.grade','tg_pill_questions.name','tg_pill_questions.id as pid')
                ->where('tg_knowledge_grades.teacher_id',$teachers)
                ->where('tg_pill_questions.id',$con->id)
                ->where('tg_knowledge_grades.user_id',$id)
                ->join('tg_knowledge_questions','tg_knowledge_questions.id','tg_knowledge_grades.knowledge_question_id')
                ->join('tg_condition_questions','tg_condition_questions.id','tg_knowledge_questions.condition_question_id')
                ->join('tg_pill_questions','tg_pill_questions.id','tg_condition_questions.pill_question_id')
                ->avg('tg_knowledge_grades.grade');
                if($step3 != 0)
                        {
                            if(isset($step_array_counter[$key_con]))
                            {
                                $step_array_counter[$key_con] = $step_array_counter[$key_con] + 1;
                            $step_array[$key_con] = array('count' => $step_array[$key_con]['count'] + 1,'id' => $key_con,'avg' => $step_array[$key_con]['avg'] + $step3,'name' => $con->name);

                            }else{
                                $step_array_counter[$key_con] = 1;
                            $step_array[$key_con] = array('count' => 1,'avg' => $step3,'name' => $con->name);

                            }
                        }
                }
                        
                }

                
            }
            
            
        }
        $plan=Plan::where('user_id',$id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->exists();
        $ps=Plan::where('user_id',$id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->with('planweek')->get();


        $allplans=0;
        $allweekplan=[];
        $numbers=[];
        for ($s=0;$s<4;$s++){
            $allweekplan[$s]=0;
        }
        if ($plan){
            foreach ($ps as $p){
                foreach ($p->planweek as $pw){
                    $allplans+=$pw->plan;
                }
            }
            $t=0;

            foreach ($ps[0]->planweek as $item){
                $allweekplan[$t]=0;
                foreach ($ps as $p){
                    foreach ($p->planweek as $pw){
                        if($item->startday==$pw->startday){

                            $allweekplan[$t]+=$pw->plan;

                        }
                    }

                }
                $t++;
            }

            $k=0;
            $numbers=[];

            foreach ($ps[0]->planweek as $item){

                $solds=ProductSold::where('user_id',$id)->whereBetween('created_at', [$item->startday, $item->endday])->get();
//                dd($solds);
                $numbers[$k]=0;
                $l=0;
                $sum=0;

                foreach ($solds as $sold){

                    $numbers[$k]+=$sold->number;
                }
                $k++;
            }
        }
        $plan_product = [];
        foreach ($ps as $p){
//            dd($p);
            foreach ($p->planweek as $pw) {
//                dd($pw);
                $count = ProductSold::where('user_id', $id)
                    ->where('medicine_id', $p->medicine_id)
                    ->whereBetween('created_at', [$pw->startday, $pw->endday])->sum('number');
                $name = DB::table('tg_medicine')->where('id', $p->medicine_id)->value('name');
//                if ($count!=0){
                $plan_product[] = array('plan' => $pw->plan, 'count' => $count, 'name' => $name, 'begin' => $pw->startday, 'end' => $pw->endday);
//            }
            }
        }
        // return $step_array_grade_all;
        $pharmacy = Pharmacy::all();
        $pharmacy_user = PharmacyUser::where('tg_pharmacy_users.user_id',$id)
        ->select('tg_pharmacy_users.id','tg_pharmacy.name')
        ->join('tg_pharmacy','tg_pharmacy.id','tg_pharmacy_users.pharma_id')
        ->orderBy('tg_pharmacy_users.created_at','DESC')->first();
        // return $pharmacy_user;
        return view('welcome',compact('pharmacy_user','pharmacy','allweekplan','plan_product','numbers','allplans','ps','plan','step_array_grade_all','step_array','pill_array','medicineall','allquestion','devicegrade','allavg','d_for_user','d_array','altgardes','quearray','elchi','medic','cateory','category','sum','dateText'));

        // return view('welcome',compact('step_array','pill_array','medicineall','allquestion','devicegrade','allavg','d_for_user','d_array','altgardes','quearray','elchi','medic','cateory','category','sum','dateText'));
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
            ->select('tg_user.image_url','tg_user.admin','tg_region.id as rid','tg_region.name as v_name','tg_user.username','tg_user.id','tg_user.last_name','tg_user.first_name')
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
    public function knowGrade(Request $request)
    {
        $elchi = DB::table('tg_user')
            // ->whereIn('tg_user.id',$userarrayreg)
            ->where('tg_user.admin',FALSE)
            ->select('tg_user.image','tg_user.admin','tg_region.id as rid','tg_region.name as v_name','tg_user.username','tg_user.id','tg_user.last_name','tg_user.first_name')
            ->join('tg_region','tg_region.id','tg_user.region_id')
            ->orderBy('tg_user.admin','DESC')->get();

        return view('elchi-know',compact('elchi'));
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
       
        if($ym)
        {
            $ym_json = json_decode($ym);
            $ary=[];
            foreach($ym_json as $key => $val)
            {
                $ary[$key] = $val;
            }
            $ym_json = $ary;

        }else{
            $ym_json = NULL;
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

    public function logout()
    {
        return view('auth.login');
    }

    public function settings()
    {
        return view('user.login');
    }

    

}
