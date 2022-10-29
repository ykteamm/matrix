<?php

namespace App\Services;

use App\Items\ElchilarKunlikItems;
use App\Models\Calendar;
use App\Models\Medicine;
use App\Models\Plan;
use App\Models\ProductSold;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ElchilarService
{
    public function elchilar()
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
            ->select('tg_user.pharmacy_id','tg_user.image_url','tg_user.admin','tg_region.id as rid','tg_region.name as v_name','tg_user.username','tg_user.id','tg_user.last_name','tg_user.first_name')
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
        $data=new ElchilarKunlikItems();
        $data->elchi=$elchi;
        $data->elchi_fact=$elchi_fact;
        $data->elchi_work=$elchi_work;
        $data->elchi_prognoz=$elchi_prognoz;





     return $data;
    }

    public function plan($elchi)
    {
        $plan_sum=[];
        $i=0;
        foreach ($elchi as $item){
            $plan_sum[$i]=0;
            $plans=Plan::where('user_id',$item->id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
            foreach ($plans as $plan){
                $narx=DB::table('tg_medicine')
                    ->select('tg_medicine.price')
                    ->where('id',$plan->medicine_id)->first();
                $plan_sum[$i]+=$plan->number*$narx->price;
            }
            $i++;
        }
//        dd($plan_sum);
        return $plan_sum;
    }

    public function planday($elchi)
    {
        $plan_sum=[];
        $cal=Calendar:: select('work_day')->where('year_month',date('m.Y'))->first();
//        dd($cal->work_day);
        $i=0;
        foreach ($elchi as $item){
            $plan_sum[$i]=0;
            $plans=Plan::where('user_id',$item->id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
            foreach ($plans as $plan){
                $narx=DB::table('tg_medicine')
                    ->select('tg_medicine.price')
                    ->where('id',$plan->medicine_id)->first();
                $plan_sum[$i]+=$plan->number*$narx->price/$cal->work_day;
            }
            $i++;
        }
        return $plan_sum;
    }

    public function encane($elchi)
    {
        $encane=[];
        $t=0;
        $apteka=DB::table('tg_pharmacy')->get();
//        dd($apteka);
        foreach ($elchi as $item){
            $encane[$t]='nomalum';
            foreach ($apteka as $apt){
                if ($item->pharmacy_id==$apt->id){
                    $encane[$t]=$apt->name;
                }
            }
                $t++;
        }
        return $encane;
    }

    public function checkCalendar()
    {
        $startOfMonth=date('d.m.Y',strtotime(Carbon::now()->startOfMonth()));
        $today=date('d.m.Y',strtotime(Carbon::now()));
        $difference=date('d',strtotime($today)) - date('d',strtotime($startOfMonth))+1;
        for($i=0;$i<$difference;$i++){
            $d=$i.' day';
            $days[$i]=date("Y-m-d", strtotime($d, strtotime((Carbon::now()->startOfMonth()))));
        }


        return $days;
    }

    public function sold($elchi,$days)
    {
        $sold=[];
        $i=0;
        foreach ($elchi as $item){
            $MonthSold=ProductSold::where('user_id',$item->id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])->get();
            $j=0;
            foreach ($days as $day){
                $sold[$i][$j]=0;
                foreach ($MonthSold as $daysold){
                    if(date('d',strtotime($daysold->created_at))==date('d',strtotime($day))){
                        $sold[$i][$j]+=$daysold->price_product*$daysold->number;
                    }
                }
                $j++;
            }
            $i++;
        }
        return $sold;
    }
    public function reyting($elchi)
    {
        $yulduz = DB::table('tg_question')->where('grade',6)->first();
        $department = DB::table('tg_department')->where('status',1)->get();

        $users = DB::table('tg_grade')
            ->select('tg_user.id','tg_user.first_name','tg_user.last_name')
            ->where('tg_grade.question_id','!=',$yulduz->id)
            ->join('tg_user','tg_user.id','tg_grade.teacher_id')
            ->distinct()
            ->get();
        $elchilar=[];
        foreach ($elchi as $item){





            $id=$item->id;

            $d_array =[];
            $d_for_user = [];
            $d_for_user2 = [];
            $allquestion = [];
            $allavg = 0;



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


            $i = 0;
            $avgs = 0;
            foreach ($pill_array as $key => $item1)
            {$i++;
                $avgs += $item1['avg'];}
            // @endforeach
            foreach ($step_array as $key => $item1)
            { $i++;
                if($item1['count'] == 0)
                {
                    $avgs += 0;
                }else{
                    $avgs += $item1['avg']/$item1['count'];
                }

            }
            if($i == 0)
            {
                $all_avgs = 0;
            }else{
                $all_avgs = number_format($avgs/$i,2);

            }

            if($all_avgs != 0)
            {
                if($allavg == 0)
                {
                    $allavg = $all_avgs;
                }else{
                    $allavg = ($allavg + $all_avgs)/2;

                }
            }





            $elchilar[]=array('elchi'=>$item,'ichki-reyting'=>$allavg,'tashqi-reyting'=>$altgardes);
        }
        return $elchilar;
    }


}
