@extends('admin.layouts.app')
@section('admin_content')




    <div id="table-wrapper"  class="card-body mt-5">
        <div id="table-scroll" onscroll="myFunction()"  class="table-responsive" style="height: 90vh; overflow-y: scroll">
            <div class="row   d-flex justify-content-between">


                <div class="col-md-2 mb-2  justify-content-end">
                    <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$months[date('m',strtotime($month))-1]['name']}}</button>
                    <div class="dropdown-menu" style="left:150px !important">
                        @php $i=1 @endphp
                        @foreach($months as $m)
                            @if($i<10)
                            <a href="{{route('elchilar',['month'=>date('Y').'-0'.$i])}}"  class="dropdown-item" > {{$m['name']}} </a>
                            @else
                            <a href="{{route('elchilar',['month'=>date('Y').'-'.$i])}}"  class="dropdown-item" > {{$m['name']}} </a>
                            @endif
                                @php $i++ @endphp
                        @endforeach
                    </div>
                </div>
                <div class="col-md-2 mb-2  justify-content-end">
                    <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$months[date('m',strtotime($month))-1]['name']}}</button>
                    <div class="dropdown-menu" style="left:150px !important">
                        @php $i=1 @endphp
                        @foreach($months as $m)
                            @if($i<10)
                            <a href="{{route('elchilar',['month'=>date('Y').'-0'.$i])}}"  class="dropdown-item" > {{$m['name']}} </a>
                            @else
                            <a href="{{route('elchilar',['month'=>date('Y').'-'.$i])}}"  class="dropdown-item" > {{$m['name']}} </a>
                            @endif
                                @php $i++ @endphp
                        @endforeach
                    </div>
                </div>

            </div>
            <table class="table mb-0 table-striped "   >
                <thead >
                <tr onmouseover="$(this).css('cursor','pointer')";
                    onmouseleave="$(this).css('color','black');"
                    >
                    <th class="fixed"><strong>ID</strong> </th>
                    <th class="fixed"><strong>Garb/Sharq</strong></th>
                    <th class="fixed"><strong>Viloyat</strong> </th>
                    <th class="fixed"><strong>Elchi</strong> </th>
                    <th class="fixed" onclick="yashir()" ><strong>Dorixona</strong> </th>
                    <th class="yashir"><strong>Plan </strong></th>
                    <th class="yashir"><strong>Kunlik plan </strong></th>
                    <th class="yashir"><strong>Fakt </strong></th>
                    <th class="yashir"><strong>Prognoz  </strong></th>
                    @php $i=0; $s=0; @endphp
                    @foreach($days as $day)


                    <th style="display: none" class="days{{$s}} hover{{$i}}"><strong onclick="days({{$s}})" class="days{{$s}}">{{date('d.m.Y',strtotime($day))}}  </strong></th>
                        @if($i==0||$i==7||$i==14||$i==21)
                            @if($i==21)
                                <th   class="week{{$s}} weeks{{$i}} hover{{$s}}"><span onclick="weeks({{$s}})"  class="text-warning week{{$s}}  ">{{date('d.m',strtotime($day))}}  ->  {{$endofmonth}}.{{date('m',strtotime($day))}} </span></th>
                            @else
                                <th   class="week{{$s}} weeks{{$i}} hover{{$s}}"><span onclick="weeks({{$s}})" class="text-warning week{{$s}}  ">{{date('d.m',strtotime($day))}}  ->  {{$i+7}}.{{date('m',strtotime($day))}} </span></th>
                            @endif

                            @endif
                    @php $i++; if ($i==7||$i==14||$i==21){$s++;}  @endphp

                    @endforeach

{{--                    <th class="text-right">Action </th>--}}
                </tr>
                </thead>
                <tbody  >
                @php $t=0; @endphp
                @foreach($elchilar as $item)
                    @if($item['elchi']->status ==1)
                <tr >
                    <td>{{$t+1}} </td>
                    <td>@if($item['elchi']->side==2)Sharq @else G‘arb @endif </td>
                    <td>{{$item['elchi']->v_name}} </td>
                    <th class="fixed">
                        <div class="mb-1">
                            <strong>
                                <img class="mr-2 mb-1" src="{{$item['elchi']->image_url}}" style="border-radius:50%" height="20px"> {{ $item['elchi']->last_name}} {{$item['elchi']->first_name}} ( Elchi )
                            </strong>
                        </div>
                        <div class="mt-1">
                            <span class="badge bg-success-light">Ichki reyting:  <span class="text-danger">{{$item['ichki-reyting']}} </span> </span>
                            <span class="badge bg-primary-light">Tashqi reyting:  <span class="text-danger">{{$item['tashqi-reyting']}} </span></span>
                        </div>
                    </th>
                    <th class="fixed">{{$encane[$t]}} </th>
                    <td class="yashir "><span class="badge bg-primary-light">{{number_format($plan[$t])}}</span> </td>
                    <td class="yashir "><span class="badge bg-success-light">{{number_format($plan_day[$t])}}</span> </td>
                    <td class="yashir "> <span class="badge bg-warning-light">{{$elchi_fact[$item['elchi']->id]}}</span></td>
                    <td class="yashir "> <span class="badge bg-success-light">{{$elchi_prognoz[$item['elchi']->id]}}</span></td>
                    @php $i=0; $s=0;  $arr=0; @endphp
                    @foreach($days as $day)

                        @if($i==0||$i==7||$i==14||$i==21)
                            @if($haftalik[$t][$s]==0)
                            <td onclick="weeks({{$s}})"  class="week{{$s}}  week hover{{$s}}"
                                onmouseover="$(`.hover{{$s}}`).css('background','yellow').css('cursor','pointer').css('color','blue');"
                                onmouseleave="$(`.hover{{$s}}`).css('background','white').css('color','black');"  data-bs-toggle="tooltip" title="{{ $item['elchi']->last_name}} {{$item['elchi']->first_name}}"
                            ><span  class="week{{$s}}">{{number_format($haftalik[$t][$s])}} </span></td>
                            @else
                            <td onclick="weeks({{$s}})"   class="week{{$s}} weeks{{$i}}   week hover{{$s}} "
                                onmouseover="$(`.hover{{$s}}`).css('background','yellow').css('cursor','pointer').css('color','blue');"
                                onmouseleave="$(`.hover{{$s}}`).css('background','white').css('color','black');"  data-bs-toggle="tooltip" title="{{ $item['elchi']->last_name}} {{$item['elchi']->first_name}}"
                            ><span  class="week{{$s}} badge bg-success-light">{{number_format($haftalik[$t][$s])}} </span></td>
                            @endif
                        @endif


                    @if($sold[$t][$i]==0)
                    <td style="display: none" onclick="days({{$s}})" class="days{{$s}} "
                        onmouseover="$(`.hover{{$s}}`).css('cursor','pointer');"
                        data-bs-toggle="tooltip" title="{{ $item['elchi']->last_name}} {{$item['elchi']->first_name}}"
                        >{{ number_format($sold[$t][$i])}}</span></td>
                    @else
                    <td style="display: none" onclick="days({{$s}})" class=" days{{$s}} "
                        onmouseover="$(`.hover{{$s}}`).css('cursor','pointer');"
                        data-bs-toggle="tooltip" title="{{ $item['elchi']->last_name}} {{$item['elchi']->first_name}}"
                        > <span class="days{{$s}} badge bg-primary-light">{{ number_format($sold[$t][$i])}}</span></td>
                    @endif
                    @php $i++; if ($i==7||$i==14||$i==21){$s++;}  @endphp
                    @endforeach
{{--                    <td class="text-right">--}}
{{--                        <a href="#" class="btn btn-sm btn-white text-success mr-2"><i class="far fa-edit mr-1"></i> Edit </a>--}}
{{--                        <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i>Delete </a>--}}
{{--                    </td>--}}
                </tr>
                @php $t++; @endphp

                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    <script>
        let x = 0;
        function myFunction() {
            document.getElementById("demo").innerHTML = x += 1;
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
        function region(region)
        {
            let reg=document.querySelector('#tgregion');
            reg.textContent=region;
        }
        function days(id)
        {
            let days,week;
            if(id==0){
                days=document.querySelectorAll('.days0');
                week=document.querySelectorAll('.week0');
            }
            if(id==1){
                days=document.querySelectorAll('.days1');
                week=document.querySelectorAll('.week1');
            }
            if(id==2){
                days=document.querySelectorAll('.days2');
                week=document.querySelectorAll('.week2');
            }
            if(id==3){
                days=document.querySelectorAll('.days3'),
                    week=document.querySelectorAll('.week3');
            }

            week.forEach(element=>{
                element.style.display=""
            });
            days.forEach(element => {
                element.style.display="none";
            });

        }
        // console.log('days'+5);
        function weeks(id)
        {
            let days,week;
            if(id==0){
                days=document.querySelectorAll('.days0');
                week=document.querySelectorAll('.week0');
            }
            if(id==1){
                days=document.querySelectorAll('.days1');
                week=document.querySelectorAll('.week1');
            }
            if(id==2){
                days=document.querySelectorAll('.days2');
                week=document.querySelectorAll('.week2');
            }
            if(id==3){
                days=document.querySelectorAll('.days3'),
                    week=document.querySelectorAll('.week3');
            }
            week.forEach(element=>{
                element.style.display="none"
            });
            days.forEach(element => {
                element.style.display="";
            });

        }
    </script>
@endsection
