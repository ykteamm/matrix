@extends('admin.layouts.app')
@section('admin_content')
<div class="content mt-1 main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')

        <div class="card flex-fill">

          <div class="btn-group mr-5 ml-auto">
            <div class="row">
               <div class="col-md-12" align="center">
                        Sana
               </div>
               <div class="col-md-12">
                  <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$dateText}} </button>
                  <div class="dropdown-menu timeclass">
                     <a href="{{route('elchi',['id' => $elchi->id,'time' => 'today'])}}" class="dropdown-item">Bugun</a>
                     <a href="{{route('elchi',['id' => $elchi->id,'time' => 'week'])}}" class="dropdown-item">Hafta</a>
                     <a href="{{route('elchi',['id' => $elchi->id,'time' => 'month'])}}" class="dropdown-item">Oy</a>
                     <a href="{{route('elchi',['id' => $elchi->id,'time' => 'year'])}}" class="dropdown-item">Yil</a>
                     <a href="{{route('elchi',['id' => $elchi->id,'time' => 'all'])}}" class="dropdown-item" id="aftertime">Hammasi</a>
                     <input type="text" name="datetimes" class="form-control"/>
                  </div>
               </div>
            </div>
          </div>
       </div>
      </div>

      @php
      $i = 0;
      $avgs = 0;
      foreach ($pill_array as $key => $item)
         {$i++;
         $avgs += $item['avg'];}
      // @endforeach
      foreach ($step_array as $key => $item)
        { $i++;
         if($item['count'] == 0)
         {
            $avgs += 0;
         }else{
            $avgs += $item['avg']/$item['count'];
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

      @endphp
<div class="content headbot">
    <div class="row">
       <div class="col-12 col-xl-4 d-flex flex-wrap">
          <div class="card">
             <div class="card-body">
                <div class="text-center">
                   <img src="{{$elchi->image_url}}" style="border-radius:50%" height="200px">
                   <h4>{{$elchi->last_name}} {{$elchi->first_name}} </h4>
                   <h5> <button type="button" class="btn btn-info" onclick="collapseGrade()">Ichki reyting {{number_format($allavg,2)}}</button> </h5>
                   <h5> <button type="button" class="btn btn-info" onclick="collapseGrade2()">Tashqi reyting {{number_format($altgardes,2)}}</button> </h5>
                   @if($plan)
                   <h5> <a href="{{route('plan.edit',['id'=>$elchi->id])}}" type="button" class="btn btn-info" >Planni Tahrirlash</a> </h5>
                   <h5> <a onclick="show_weeks()"  type="button" class="open-plan text-white btn btn-info" >Planni Ko'rish</a> </h5>
                   <h5> <a onclick="close_weeks()" type="button" style="display: none" class="close-plan text-white btn btn-info" >Planni Ko'rish</a> </h5>
                  @else
                     <h5> <a href="{{route('plan',['id'=>$elchi->id])}}" type="button" class="btn btn-info" >Plan Qo'shish</a> </h5>


                  @endif
               </div>
             </div>
          </div>
       </div>
       <div class="col-12 col-xl-8 d-flex flex-wrap">
          <div class="card">
             <div class="card-body pb-0" style="margin-top: 35px;">
                <div class="patient-details d-block">
                   <div class="details-list">
                     <div>
                        <h6>Username</h6>
                        <span class="ml-auto">{{$elchi->username}} </span>
                     </div>
                      <div>
                         <h6>Telefon raqami</h6>
                         <span class="ml-auto">{{$elchi->phone_number}} </span>
                      </div>
                      <div>
                        <h6>Lavozimi</h6>
                        <span class="ml-auto">{{$elchi->lv}} </span>
                     </div>
                           {{-- <td>{{date('Y',(strtotime ( today()) )) - date('Y',(strtotime ( $item->birthday) ))}} </td> --}}

                      <div>
                         <h6>Tug'ilgan sanasi</h6>
                         <span class="ml-auto">{{date('d.m.Y',(strtotime ( $elchi->birthday) ))}}</span>
                      </div>
                      <div>
                        <h6>Yoshi</h6>
                        <span class="ml-auto">{{date('Y',(strtotime ( today()) )) - date('Y',(strtotime ( $elchi->birthday) ))}}</span>
                     </div>


                      <div>
                         <h6>Viloyat</h6>
                         <span class="ml-auto">{{$elchi->v_name}} </span>
                      </div>
                      <div>
                        <h6>Tuman</h6>
                        <span class="ml-auto">{{$elchi->d_name}} </span>
                     </div>
                     <div>
                        <h6>Dorixona</h6>
                        @if(isset($pharmacy_user->name))
                        <span class="ml-auto">{{$pharmacy_user->name}} </span>

                        @endif
                     </div>
                       <div>
                           <button onclick="yashir2()" class="btn btn-primary" >Vazifalar</button>
                       </div>
                       <div>
                           <button onclick="yashir()" class="btn btn-primary" >Vazifa berish</button>
                       </div>

                   </div>
                    <div class="row yashir" style="display: none">
                        <div class="col-12">
                            <form action="{{route('task.store')}}" method="post">
                                @csrf
                                <input name="id" style="display: none" value="{{$elchi->id}}">
                                <div class="form-group d-flex">
                                    <div class="d-flex mr-2">
                                        <label class="m-2" for="exampleFormControlTextarea1">Vazifa</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" name="task" required  rows="5" cols="50"></textarea>
                                    </div>
                                    <div>
                                        <label for="t_sana">Tugash Sanasi</label>
                                        <input id="t_sana" type="date" name="date" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success ">Jo'natish >></button>
                            </form>
                        </div>
                    </div>




                </div>


             </div>

          </div>
       </div>
    </div>
    <div class="card yashir2" style="display: none">
        <div class="card-header no-border">
            <h4 class="card-title float-left">Topshiriqlar</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>ID </th>
                        <th>Topshiriq nomi</th>
                        <th>Tugash sanasi</th>
                        <th class="text-right">Action </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($tasks as $task)
                    <tr>
                        <td>{{$loop->index+1}} </td>

                        <td>{{$task->message}} </td>
                        <td>{{$task->finish_day}} </td>
                        <td class="text-right">
                            <a href="#" class="btn btn-sm btn-white text-success mr-2"><i class="far fa-edit mr-1"></i> Edit </a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i>Delete </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-between"  id="catid">
      @if($plan)
          @php $t=0;  @endphp

          @foreach($ps[0]->planweek as $pw)


            <div style="display: none" onclick="show_week(`{{substr($pw->startday,8)}}`)" class="table-plans container btn col-12 col-md-6 col-lg-3 d-flex flex-wrap delcat">

            <div style="display: none" style="border-radius:26px;" class="card table-plans
            @if($numbers[$t] >= $allweekplan[$t])
            detail-box12
            @elseif($numbers[$t] < $allweekplan[$t] && $numbers[$t] != 0)
            detail-box17
            @else
            detail-box13
            @endif


            ">
                <div class="card-body"><div class="dash-content">
                        <h2 style="    background: -webkit-linear-gradient(#77f9ed, #c649d5);-webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;text-align:center;font-size:40px;font-family:Gilroy;"><b>
                                <span>{{$numbers[$t]}}</span>/
                                <span>{{$allweekplan[$t]}}</span>
                            </b>
                        </h2>
                        <h1 style="color:#ffffff;margin-left:0px;">
                            <div class="row">
                                <div style="font-size:20px; z-index:1000;padding-left: 0px !important;padding-right: 0px !important" class="col-md-4">{{date('d.m',strtotime($pw->startday))}}</div>
                                <div class="col-md-4" style="position:relative; z-index:1; padding-left: 0px !important;padding-right: 0px !important">
                                    <img style="position: absolute;top:-60%;left:-25%;height:50px; color: white; width:150%; " src="{{asset('assets/img/whiteArrow.png')}}">

                                </div>
                                <div style=" z-index:1000; font-size: 20px;padding-left: 0px !important;padding-right: 0px !important" class="col-md-4">{{date('d.m',strtotime($pw->endday))}}</div>
                            </div>
                            {{-- <span class="" title="5.203.100">
                               <span style="font-size: 15px" class="numberkm">{{date('d.m',strtotime($pw->startday))}}</span>
                               <span style="width: 4px; height: 20px; margin-top: 2px">
                                  <img style="color: white; margin-top: 0px; height: 50px; width: 130px;" src="{{asset('assets/img/whiteArrow.png')}}">
                               </span>
                               <span style="font-size: 15px" class="numberkm">{{date('d.m',strtotime($pw->endday))}}</span>
                            </span> --}}
                        </h1>

                    </div>
                </div>
            </div>
            </div>
      @php $t++; @endphp
  @endforeach
@endif
</div>

<div id="maindata1" class="row d-flex justify-content-between p-2">
   @if($plan)

       <table class="table table-striped plan">
           <thead class="plan">
           <tr class="plan" style="display: none">
               <th scope="col">#</th>
               <th scope="col">Dori nomi</th>
               <th scope="col">Sotildi</th>
           </tr>
           </thead>
           <tbody>

           @php $t=0;  @endphp

           @foreach($ps[0]->planweek as $pw)
           @foreach($plan_product as $p)
               @if($pw->startday==$p['begin'])
               <tr style="display: none" class="alldatebegin plan{{substr($pw->startday,8)}}">
                   <td>{{$loop->index+1}}</td>
                   <td>{{$p['name']}}</td>
                   <td>{{$p['count']}}/{{$p['plan']}}</td>
               </tr>
               @endif
           @endforeach

           @php $t++; @endphp
           @endforeach
           </tbody>
       </table>
   @endif
</div>

    <div class="row" id="forcollapsegrade" style="display: none;">
      <div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap">
            <div class="card bg-white">
            {{-- <div class="card-header">
            <h5 class="card-title">Ball </h5>
            </div> --}}
            <div class="row row-sm align-items-center mt-3">
               <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                  <button onclick="lastYear()" type="button" class="btn btn-block btn-outline-danger">
                     <-
                  </button>
               </div>
               <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                  <button type="button" class="btn btn-block btn-outline-danger active year-button">
                     {{date('Y',strtotime(date_now()))}}
                  </button>
               </div>
               <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                  <button onclick="nextYear()" type="button" class="btn btn-block btn-outline-danger">
                     ->
                  </button>
               </div>
            </div>
            <div class="row row-sm align-items-center mt-3">
               @foreach (month_name() as $key => $item)
               <div class="col-2 col-sm-2 col-md-2 col-xl-2 mb-3 mb-xl-2">
                  @if(date('m',strtotime(date_now())) == $key)
                  <button onclick="getMonth(`{{$key}}`)" name="{{$key}}" type="button" class="for-active get-key-code month{{$key}} btn btn-block btn-outline-danger active">
                     {{$item}}
                  </button>
                  @else
                  <button onclick="getMonth(`{{$key}}`)" name="{{$key}}" type="button" class="for-active month{{$key}} btn btn-block btn-outline-danger">
                     {{$item}}
                  </button>
                  @endif
               </div>
               @endforeach
            </div>
            <div class="row row-sm align-items-center mt-3">
               <div class="col-4 col-sm-4 col-md-4 col-xl mb-3 mb-xl-0">
                  <button onclick="getDep()" name="0" type="button" class="get-key-dep department btn btn-block btn-outline-danger active">
                     Bilim
                  </button>
               </div>
               @foreach (dep_name() as $item)
               <div class="col-4 col-sm-4 col-md-4 col-xl mb-3 mb-xl-0">
                  <button onclick="getDep()" name="{{$item->id}}" type="button" class="department btn btn-block btn-outline-danger">
                     {{$item->name}}
                  </button>
               </div>
               @endforeach
            </div>
            <div class="row">
               {{-- <div class="card-body"> --}}
                  {{-- <div class="table-responsive"> --}}
                     <table class="for-table-border">
                        <thead>
                           <tr id="thead_ajax">
                           </tr>
                        </thead>
                        <tbody id="tbody_ajax">
                        </tbody>
                     </table>
                  {{-- </div> --}}
               {{-- </div> --}}
            </div>
            <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-solid nav-justified">
               @foreach ($d_array as $key => $item)
                  <li class="nav-item"><a class="nav-link @if($key == 0) active @endif" href="#solid-justified-tab{{$key+1}}" data-toggle="tab">{{ $item['name'] }} ({{$item['avg']}})</a></li>
               @endforeach
            <li class="nav-item"><a class="nav-link" href="#solid-justified-tab-bilim" data-toggle="tab">Bilim
               ({{$all_avgs}})
            </a>
            </li>
            {{-- <li class="nav-item"><a class="nav-link" href="#solid-justified-tab3" data-toggle="tab">Messages </a></li> --}}
            </ul>
            <div class="tab-content">
               @foreach ($d_array as $key => $item)

               <div class="tab-pane show @if($key==0) active @endif" id="solid-justified-tab{{$key+1}}">
                  <div class="tab-left">

                     @foreach ($d_for_user as $ite)
                     @if($ite['depid'] == $item['id'])
                     <div class="d-flex mb-3">
                        <div class="medicne d-flex">
                           <a style="cursor: pointer" onclick="getQuestion(`qd{{$ite['uid']}}{{$item['id']}}`)"> {{$ite['username']}}</a>

                        </div>
                        <div class="medicne-time ml-auto">
                           {{$ite['avg']}}
                        </div>
                     </div>
                     @endif
                     @endforeach

                  </div>
                  @foreach ($allquestion as $ite)

                  <div class="tab-left ml-4 allqd qd{{$ite->teacher_id}}{{$item['id']}}" style="display: none;">
                     @if($ite->did == $item['id'])
                     <div class="d-flex mb-3">
                        <div class="medicne d-flex">
                           <span>{{$ite->qname}}</span>
                        </div>
                        <div class="medicne-time ml-auto mr-5">
                           {{$ite->grade}}
                        </div>
                        <div class="medicne">
                           {{$ite->created_at}}
                        </div>
                     </div>
                     @endif

                  </div>
                  @endforeach

               </div>
               <div class="tab-pane" id="solid-justified-tab-bilim">
                  <div class="tab-left">

                     @foreach ($step3_get_user as $ite)
                     {{-- @if($ite['depid'] == $item['id']) --}}

                     <div class="d-flex mb-3">
                        <div class="medicne d-flex">
                           {{-- <a style="cursor: pointer" onclick="getQuestion(qd{{$ite['uid']}}{{$item['id']}})"> {{$ite['username']}}</a> --}}
                           <a style="cursor: pointer"> {{$ite->last_name}} {{$ite->first_name}}</a>

                        </div>
                        <div class="medicne-time ml-auto">
                           {{-- {{$ite->first_name}} --}}
                        </div>
                     </div>
                     {{-- @endif --}}
                     @foreach ($step1_get as $item)

                     <div class=" ml-4  qd{{$ite->id}}{{$item->teacher_id}}" style="">
                        @if($ite->id == $item->teacher_id)
                        <div class="row">
                           <div class="d-flex mb-3">
                              <div class="medicne d-flex mr-4">
                                 <span>{{$item->name}}</span>
                              </div>
                              <div class="medicne-time ml-auto mr-5">
                                 {{$item->grade}}
                              </div>
                              <div class="medicne">
                                 {{$item->created_at}}
                              </div>
                           </div>
                        </div>
                        @endif
                     </div>
                     @endforeach
                     @foreach ($step3_get as $item)
                     <div class=" ml-4  qd{{$ite->id}}{{$item->teacher_id}}" style="">
                        @if($ite->id == $item->teacher_id)
                        <div class="row">
                           <div class="d-flex mb-3">
                              <div class="medicne d-flex mr-4">
                                 <span>{{$item->name}}</span>
                              </div>
                              <div class="medicne-time ml-auto mr-5">
                                 {{$item->grade}}
                              </div>
                              <div class="medicne">
                                 {{$item->created_at}}
                              </div>
                           </div>
                        </div>


                        @endif

                     </div>
                     @endforeach


                     @endforeach

                  </div>
               </div>
            @endforeach

            </div>
            </div>
            </div>
      </div>

   </div>
   <div class="row" id="forcollapsegrade2" style="display: none;">

      <div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap">
            <div class="card bg-white">
            <div class="card-body">
               @foreach ($quearray as $item)
               <button type="button" class="btn btn-outline-info ml-3 mt-3 notification">
                  <span>{{$item['name']}}</span>
                  <span class="badge">{{$item['count']}}</span>
                </button>
               @endforeach

            </div>
            </div>
      </div>
      <div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap">
         <div class="card bg-white">
         <div class="card-body">

            @php
               $browser = "Unknown Browser";

               $browser_array = array(
                  '/msie/i'  => 'Internet Explorer',
                  '/Trident/i'  => 'Internet Explorer',
                  '/firefox/i'  => 'Firefox',
                  '/safari/i'  => 'Safari',
                  '/chrome/i'  => 'Chrome',
                  '/edge/i'  => 'Edge',
                  '/opera/i'  => 'Opera',
                  '/netscape/'  => 'Netscape',
                  '/maxthon/i'  => 'Maxthon',
                  '/knoqueror/i'  => 'Konqueror',
                  '/ubrowser/i'  => 'UC Browser',
                  '/mobile/i'  => 'Safari Browser',
               );


            @endphp
               <h4> <span> </span> </h4>

                     <div class="table-responsive">
                        <table class="table mb-0" id="dtBasicExample">
                           <thead>
                              <tr>
                                 <th>Qurilma</th>
                                 <th>Ball </th>
                                 <th>Sana </th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach ($devicegrade as $item)
                                 @php
                                 foreach($browser_array as $regex => $value){
                                       if(preg_match($regex, $item->device)){
                                          $browser = $value;
                                       }
                                    }
                                 @endphp
                              <tr>
                                 <td>{{$browser.$item->teacher_id}} </td>
                                 <td>{{$item->grade}}</td>
                                 {{-- <td>{{$item->created_at}}</td> --}}
                                 <td>{{date('d.m.Y H:i',(strtotime ( $item->created_at) ))}} </td>
                           {{-- <td>{{ date('d.m.Y H:i',(strtotime ( '+0 hours' , strtotime ( $item->created_at) ) )) }}</td> --}}
                           {{-- <td>{{ date('H:i',(strtotime ( '+10 hours' , strtotime ( $item->created_at) ) )) }}</td> --}}

                              </tr>
                              @endforeach

                           </tbody>
                        </table>
                     </div>

         </div>
         </div>
   </div>

   </div>
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap" onclick="tabNone('solid-tab1')"
      onmouseover="$(this)
       .css('cursor','pointer')"
      >
         <div class="card" style="background-color: #3b3d83">
            <div class="card-body">
                @php $a=0 @endphp
                @foreach ($cateory as $key => $item)
                   @php  $a+=$item['price'];
                    $i = $i + 1 @endphp

                @endforeach
               <div class="dash-contetnt">
                  <h2 style="color:#ffffff;text-align:center;">Barchasi</h2>
                  <h3 style="color:#ffffff;text-align:center;">{{ number_format($a, 0, '', ' ')}} so'm</h3>
               </div>
            </div>
         </div>
      </div>
      @php $i=2 @endphp

      @foreach ($cateory as $key => $item)
       <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap nav-link solid-tab{{$i}} dborder" onclick="tabNone('solid-tab{{$i}}')"
       onmouseover="$(this)
       .css('cursor','pointer')"
      style="border-bottom: 3px solid #3b3d83"

       >
         <div class="card detail-box1{{$i}}" >
            <div class="card-body">
               <div class="dash-contetnt">
                  <h2 style="color:#ffffff;text-align:center;">{{$item['name']}}</h2>
                  <h3 style="color:#ffffff;text-align:center;">{{ number_format($item['price'], 0, '', ' ')}} so'm</h3>
               </div>
            </div>
         </div>
      </div>

       @php $i = $i + 1 @endphp



      @endforeach

   </div>
    <div class="row" id="maindata">
        <div class="col-lg-12" id="da">
            <div class="card">
               <div class="card-body">
                  <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                     <li class="nav-item"><a class="nav-link active" href="#solid-justified-tab21" data-toggle="tab">Sotilganlar </a></li>
                     <li class="nav-item"><a class="nav-link" href="#solid-justified-tab31" data-toggle="tab">Barchasi </a></li>
                  </ul>
                  <div class="tab-content pt-0">
                    @php $i=2 @endphp
                    <div class="tab-pane show active dnone" id="solid-tab1">
                        {{-- <div class="tab-data"> --}}
                           <div class="tab-content pt-0">
                              <div class="tab-pane show active " id="solid-justified-tab21">
                                 <div class="col-lg-12">
                                    <div class="card">
                                       <div class="card-body">
                                          <div class="table-responsive" id="asdasd">
                                             <table class="table mb-0" id="example123">
                                                <thead>
                                                   <tr>
                                                      <th>Mahsulot nomi1</th>
                                                      <th>Soni</th>
                                                      <th>Summasi</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $n = 0
                                                    @endphp
                                                @foreach ($medic as $mkey => $mitem)
                                                    <tr>
                                                        <td>{{$mitem['name']}} </td>
                                                        <td>{{$mitem['number']}} </td>
                                                        <td>{{ number_format($mitem['price'], 0, '', ' ')}}</td>
                                                        {{-- <td class="text-right"><a href="#">View Summary </a></td> --}}
                                                     </tr>
                                                     @php
                                                         $n += $mitem['number']
                                                     @endphp
                                                @endforeach
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane" id="solid-justified-tab31">
                                 <div class="col-lg-12">
                                    <div class="card">
                                       <div class="card-body">
                                          <div class="table-responsive" id="asdasd1">
                                             <table class="table mb-0" id="example1231">
                                                <thead>
                                                   <tr>
                                                      <th>ID</th>
                                                      <th>Mahsulot nomi</th>
                                                      <th>Soni</th>
                                                      {{-- <th>Summasi</th> --}}
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $n = 0
                                                    @endphp
                                                @foreach ($medicineall as $mkey => $mitem)
                                                    <tr>
                                                        <td style="display: none">{{$mitem['id']}}</td>
                                                        <td>{{$mitem['name']}}</td>
                                                        <td>{{$mitem['number']}} </td>
                                                        {{-- <td>{{ number_format($mitem['price'], 0, '', ' ')}}</td> --}}
                                                        {{-- <td class="text-right"><a href="#">View Summary </a></td> --}}
                                                     </tr>
                                                     @php
                                                         $n += $mitem['number']
                                                     @endphp
                                                @endforeach
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>

                        {{-- </div> --}}
                     </div>
                    @foreach ($cateory as $key => $item)
                     <div class="tab-pane dnone" id="solid-tab{{$i}}" style="display:none;">
                        <div class="tab-data">
                            <div class="col-lg-12">
                                <div class="card flex-fill">
                                   <div class="card-body">
                                      <div class="table-responsive">
                                         <table class="table mb-0">
                                            <thead>
                                               <tr>
                                                  <th>Mahsulot nomi</th>
                                                  <th>Soni</th>
                                                  <th>Summasi </th>
                                                  {{-- <th class="text-right">Summary </th> --}}
                                               </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $t = 0
                                            @endphp
                                            @foreach ($medic as $mkey => $mitem)
                                                @if ($item['id'] == $mitem['cid'])
                                                <tr>
                                                    <td>{{$mitem['name']}} </td>
                                                    <td>{{$mitem['number']}} </td>
                                                    <td>{{ number_format($mitem['price'], 0, '', ' ')}}</td>

                                                    {{-- <td class="text-right"><a href="#">View Summary </a></td> --}}
                                                 </tr>
                                                 @php
                                                 $t += $mitem['number']
                                             @endphp
                                                @endif

                                            @endforeach
                                            {{-- <tr>
                                                <td>Jami</td>
                                                <td>{{$t}} </td>
                                                <td>{{$item['price']}}</td>
                                             </tr> --}}
                                             @php
                                                $t = 0
                                            @endphp
                                            </tbody>
                                         </table>
                                      </div>
                                   </div>
                                </div>
                             </div>
                        </div>
                     </div>
                     @php $i = $i + 1 @endphp
                    @endforeach
                  </div>
               </div>
            </div>
         </div>

    </div>
</div>
<div class="row align-items-center justify-content-center">
@foreach ($pill_array as $item)

   <div class="col-12 col-md-6 col-lg-4 d-flex flex-wrap delregion">
      <div class="card detail-box1">
         <div class="card-body">
         <div class="dash-contetnt">
            <h2 style="color:#05f705;text-align:center;">{{$item['name']}}</h2>
            <h3 style="color:#ffffff;text-align:center;margin-left:12px;">
            <span title="0">{{$item['avg']}}</span>
            </h3>
         </div>
         </div>
      </div>
   </div>
@endforeach


</div>
<div class="row align-items-center justify-content-center">

@foreach ($step_array as $item)

   <div class="col-12 col-md-4 col-lg-3 d-flex flex-wrap delregion">
      <div class="card detail-box1">
         <div class="card-body">
         <div class="dash-contetnt">
            <h2 style="color:#05f705;text-align:center;">{{$item['name']}}</h2>
            <h3 style="color:#ffffff;text-align:center;margin-left:12px;">
            <span title="0">{{ number_format($item['avg']/$item['count'],2) }} </span>
            </h3>
         </div>
         </div>
      </div>
   </div>
@endforeach
</div>

</div>
@endsection
@section('admin_script')
   <script>
      $(document).ready(function(){   
         detAjax();
      });
      $(function(){
         $(".department").click(function(){
            $('.department').removeClass('active');
            $('.department').removeClass('get-key-dep');
            $(this).addClass('active');
            $(this).addClass('get-key-dep');
            detAjax()
         })
      })
      function detAjax()
      {
         var year = $('.year-button').text();
         var month = $('.get-key-code').attr('name');
         var dep = $('.get-key-dep').attr('name');
         var id = <?php echo json_encode( $elchi->id ) ?>;

         var _token   = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
             url: "/grades",
             type:"POST",
             data:{
               year: year,
               month: month,
               dep: dep,
               id: id,
                _token: _token
             },
             success:function(response){
                if(response){
                  if(response.dep == 0)
                  {
                     $.each(response.step_question, function(q, question){
                              var questions = $('<tr class="for-tbody-td">'+
                                       '<td id='''+question.id+' class="for-table-border">'+ question.name + '</td>'+
                                       '</tr>');
                           $('#tbody_ajax').append(questions);
                     });

                     $(".for_savol").remove();
                     $(".for_date").remove();
                  
                     var $savol = $(
                                 '<th style="border: 1px solid rgb(126, 182, 220);" class="for_savol">Savol</th>');
                     $('#thead_ajax').append($savol);
                     $.each(response.date_array, function(index, value){
                        var grades = $(
                                    '<th style="padding:3px 6px;border: 1px solid rgb(126, 182, 220);" class="for_date">'+ value['day'] +'</th>');
                        $('#thead_ajax').append(grades);
                     });
                  }
                  if(response.dep == 1)
                  {
                     $(".for-tbody-td").remove();

                     $.each(response.questions, function(q, question){
                        var dates = '';
                        $.each(response.date_array, function(d, date){
                              if(date['isset'] == 1)
                              {
                                 dates = dates+'<td style="padding:3px 6px;" class="for-table-border"><span data-toggle="tooltip" title="" data-placement="top" id='+question.id+date['day']+' style="cursor:pointer;min-width:0px !important;padding: 0px 0px !important;" class="badge bg-success-light"></span></td>';
                              }else{
                                 dates = dates+'<td style="padding:3px 6px;" class="for-table-border">-</td>';
                              }
                              
                        });
                              var questions = $('<tr class="for-tbody-td">'+
                                       '<td class="for-table-border">'+ question.name + '</td>'+
                                       dates+
                                       '</tr>');
                           $('#tbody_ajax').append(questions);
                     });
                     $(".for_savol").remove();
                     $(".for_date").remove();
                  
                     var $savol = $(
                                 '<th style="border: 1px solid rgb(126, 182, 220);" class="for_savol">Savol</th>');
                     $('#thead_ajax').append($savol);
                     $.each(response.date_array, function(index, value){
                        var grades = $(
                                    '<th style="padding:3px 6px;border: 1px solid rgb(126, 182, 220);" class="for_date">'+ value['day'] +'</th>');
                        $('#thead_ajax').append(grades);
                     });
                     $.each(response.grade_array, function(g, grade){
                        var teach = '';
                        $.each(grade.grades, function(t, teacher){
                           var d = new Date(teacher.created_at);
                           var curr_hour = d.getHours();
                           var curr_minutes = d.getMinutes();
                           if(curr_minutes < 10)
                              {
                                 var ddatem = '0'+curr_minutes
                              }else{
                                 var ddatem = curr_minutes
                              }
                           teach = teach + teacher.last_name+' '+teacher.first_name+' ('+teacher.grade+') '+' ('+curr_hour+':'+ddatem+')\n';
                        });
                        var teacher = grade.grades;
                        $.each(response.date_array, function(d, date){
                           $(`#${grade['q_id']}${date['day']}`).text(grade['avg']);
                           $(`#${grade['q_id']}${date['day']}`).attr('title',teach);
                        });
                     });
                  }
                }
             }
            });
      }
      function getMonth(id)
      {
         $('.for-active').removeClass('active');
         $('.for-active').removeClass('get-key-code');
         $(`.month${id}`).addClass('active');
         $(`.month${id}`).addClass('get-key-code');
         detAjax()
      }
      function nextYear()
      {
         var now = $('.year-button').text();
         $('.year-button').text(parseInt(now)+1);
         detAjax()
      }
      function lastYear()
      {
         var now = $('.year-button').text();
         $('.year-button').text(parseInt(now)-1);
         detAjax()
      }
   </script>
   <script>
       function yashir(){
           let a=document.querySelectorAll('.yashir');
           a.forEach(e=>{
               if(e.style.display=='none') {
                   e.style.display = ''
               }else{
                   e.style.display='none';
               }
           })

       }
       function yashir2(){
           let a=document.querySelectorAll('.yashir2');
           a.forEach(e=>{
               if(e.style.display=='none') {
                   e.style.display = ''
               }else{
                   e.style.display='none';
               }
           })

       }
      function show_weeks()
       {
           $('.open-plan').css('display','none');
           $(`.close-plan`).css('display','');
           $(`.table-plans`).css('display','');
       }
       function close_weeks()
       {
           $('.open-plan').css('display','');
           $(`.close-plan`).css('display','none');
           $(`.table-plans`).css('display','none');
           $(`.plan`).css('display','none');
       }
       function show_week(id)
       {
           $('.alldatebegin').css('display','none');
           $(`.plan${id}`).css('display','');
           $(`.plan`).css('display','');
       }
      function getQuestion(id)
      {
         $('.allqd').css('display','none')
         // alert(id)
         $(`.${id}`).css('display','')

      }
       function collapseGrade()
    {
        $('#forcollapsegrade').slideToggle("slow");
    }
    function collapseGrade2()
    {
        $('#forcollapsegrade2').slideToggle("slow");
    }
      $(function() {
  $('input[name="datetimes"]').daterangepicker({
   //  timePicker: true,
   //  startDate: moment().startOf('hour'),
   //  endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      format: 'DD.MM.YY'
    }
  });
  $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
            // $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
      //   console.log(picker.startDate.format('YYYY-MM-DD'))
         // $('.in-range').onclick(function()
         // {
         //    alert(123);
         //    $('.opensright').css('top','115px !important');

         // });

         window.location = $(this).data("href");
         var tim = picker.startDate.format('YYYY-MM-DD')+'_'+picker.endDate.format('YYYY-MM-DD');
         var id = <?php echo json_encode($elchi->id); ?>;
            var url = "{{ route('elchi',['id' => ':id','time' => ':tim']) }}";
            url = url.replace(':tim', tim);
            url = url.replace(':id', id);
            location.href = url;

  });

});
      function a ()
      {
         console.log('ee')
      }
      function tabNone(tab)
      {
         $('.dnone').css('display','none')
         $(`#${tab}`).css('display','block')

         $('.dborder').css('border-top','none')
       .css('border-left','none')
       .css('border-right','none')
       .css('border-bottom','3px solid #3b3d83');

         $(`.${tab}`).css('border-top','3px solid #3b3d83')
       .css('border-left','3px solid #3b3d83')
       .css('border-top-left-radius','30px')
       .css('border-top-right-radius','30px')
       .css('border-right','3px solid #3b3d83')
       .css('border-bottom','none');

       $('#maindata').css('border','3px solid #3b3d83')
       .css('border-top','none').css('border-bottom','none');
      }
       function getDate(){
         var date = new Date($('#date-input').val());
  var day = date.getDate();
  var month = date.getMonth() + 1;
  var year = date.getFullYear();
  if(month < 10)
                           {
                              var ddate = '0'+month
                           }else{
                              var ddate = month
                           }
                           var date1 = [year, ddate, day].join('-')
                           // $("#age_button2").text(date1);
         // $('#age_button2').click()
         $('#aftertime').after(`<a href='{{route('elchi',['id' => $elchi->id,'time' => 'week'])}}' class='dropdown-item'>Hammasi</a>`)

         // region(date1);

      }
   </script>
@endsection
