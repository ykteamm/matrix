@extends('admin.layouts.app')
@section('admin_content')
    <style>

        .dd tr > *:nth-child(4) {
            background-color: #fff;
            position: sticky;
            /*top: 0;*/

            left: 0;
        }
    </style>

    <div id="table-wrapper"  class="card-body mt-5">
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

                <button id="region" type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Viloyatlar</button>

                <div class="dropdown-menu" style="left:150px !important">
                    <a onclick="func1()"  class="dropdown-item" > Hammasi </a>
                    @php $i=1 @endphp
                    @foreach($viloyatlar as $m)
                        <a onclick="func({{$m->id}})"  class="dropdown-item" > {{$m->name}} </a>
                        @php $i++ @endphp
                    @endforeach
                </div>
            </div>

        </div>

        <div id="table-scroll" onscroll="myFunction()"  class="table-responsive" style="height: 85vh; overflow-y: scroll">
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
                <tbody  class="dd">
                @php $t=0; @endphp
                @foreach($elchi as $item)
                    @if($item->status ==1)
                <tr  id="{{$item->id}}" class="tr tr{{$item->v_id}}" onmouseover="$(this).css('cursor','pointer') ">
                    <td onclick="myf({{$item->id}})">{{$t+1}} </td>
                    <td onclick="myf({{$item->id}})" >@if($item->side==2)Sharq @else G‘arb @endif </td>
                    <td >{{$item->v_name}} </td>
                    <td  class='clickable-row fixed' data-href='{{route('elchi',['id' => $item->id,'time' => 'today'])}}'>
                        <div class="mb-1">
                            <strong>
                                <img class="mr-2 mb-1" src="{{$item->image_url}}" style="border-radius:50%" height="20px"> {{ $item->last_name}} {{$item->first_name}} ( Elchi )
                            </strong>
                        </div>
                        <div class="mt-1">
{{--                            <span class="badge bg-success-light">Ichki reyting:  <span class="text-danger">{{$item['ichki-reyting']}} </span> </span>--}}
{{--                            <span class="badge bg-primary-light">Tashqi reyting:  <span class="text-danger">{{$item['tashqi-reyting']}} </span></span>--}}
                        </div>
                    </td>
                    <td class="fixed">{{$encane[$t]}} </td>
                    <td class="yashir "><span class="badge bg-primary-light">{{number_format($plan[$t])}}</span> </td>
                    <td class="yashir "><span class="badge bg-success-light">{{number_format($plan_day[$t])}}</span> </td>
                    <td class="yashir "> <span class="badge bg-warning-light">{{number_format($elchi_fact[$item->id], 0, ',', ' ') }}</span></td>
                    <td class="yashir "> <span class="badge bg-success-light">{{$elchi_prognoz[$item->id]}}</span></td>
                    @php $i=0; $s=0;  $arr=0; @endphp
                    @foreach($days as $day)

                        @if($i==0||$i==7||$i==14||$i==21)
                            @if($haftalik[$t][$s]==0)
                            <td onclick="weeks({{$s}})"  class="week{{$s}}  week hover{{$s}}"
                                onmouseover="$(`.hover{{$s}}`).css('background','yellow').css('cursor','pointer').css('color','blue');"
                                onmouseleave="$(`.hover{{$s}}`).css('background','white').css('color','black');"  data-bs-toggle="tooltip" title="{{ $item->last_name}} {{$item->first_name}}"
                            ><span  class="week{{$s}}">{{number_format($haftalik[$t][$s])}} </span></td>
                            @else
                            <td onclick="weeks({{$s}})"   class="week{{$s}} weeks{{$i}}   week hover{{$s}} "
                                onmouseover="$(`.hover{{$s}}`).css('background','yellow').css('cursor','pointer').css('color','blue');"
                                onmouseleave="$(`.hover{{$s}}`).css('background','white').css('color','black');"  data-bs-toggle="tooltip" title="{{ $item->last_name}} {{$item->first_name}}"
                            ><span  class="week{{$s}} badge bg-success-light">{{number_format($haftalik[$t][$s])}} </span></td>
                            @endif
                        @endif


                    @if($sold[$t][$i]==0)
                    <td style="display: none" onclick="days({{$s}})" class="days{{$s}} "
                        onmouseover="$(`.hover{{$s}}`).css('cursor','pointer');"
                        data-bs-toggle="tooltip" title="{{ $item->last_name}} {{$item->first_name}}"
                        >{{ number_format($sold[$t][$i])}}</span></td>
                    @else
                    <td style="display: none" onclick="days({{$s}})" class=" days{{$s}} "
                        onmouseover="$(`.hover{{$s}}`).css('cursor','pointer');"
                        data-bs-toggle="tooltip" title="{{ $item->last_name}} {{$item->first_name}}"
                        > <span class="days{{$s}} badge bg-primary-light">{{ number_format($sold[$t][$i])}}</span></td>
                    @endif
                    @php $i++; if ($i==7||$i==14||$i==21){$s++;}  @endphp
                    @endforeach
                </tr>
                @php $t++; @endphp

                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@section('admin_script')
<script>
    function myf(id){
        let a=document.querySelectorAll('.tr');
        let b=document.getElementById(id);
            a.forEach(e=>{
                if(e.style.display=='none') {
                    e.style.display = ''
                }else{
                    e.style.display='none';
                    b.style.display='';
                }
            })
    }
    function func(id){
        let reg=document.getElementById('region');
        if(id==1){
            reg.innerText='Qoraqalpog`iston Respublikasi';
        }
        if(id==2) {
            reg.innerText ='Andijon viloyati';
        }
        if(id==3) {
            reg.innerText = 'Buxoro viloyati';
        }
        if(id==4){
            reg.innerText='Jizzax viloyati';
        }
        if(id==5) {
            reg.innerText = 'Qashqadaryo viloyati';
        }
        if(id==6) {
            reg.innerText = 'Navoiy viloyati';
        }
        if(id==7) {
            reg.innerText = 'Surxondaryo viloyati';
        }
        if(id==8) {
            reg.innerText = 'Sirdaryo viloyati';
        }
        if(id==9) {
            reg.innerText = 'Toshkent viloyati';
        }
        if(id==10) {
            reg.innerText = 'Farg`ona viloyati';
        }
        if(id==11) {
            reg.innerText = 'Xorazm viloyati';
        }
        if(id==12) {
            reg.innerText = 'Toshkent shahri';
        }
        let a=document.querySelectorAll('.tr');
        var x='.tr'+id;
        let b=document.querySelectorAll(x);
        console.log(b);
        a.forEach(e=>{
            if(e.style.display=='none') {
                b.forEach(t=>{
                    t.style.display=''
                })
            }else{
                e.style.display='none';
                b.forEach(t=>{
                    t.style.display=''
                })
            }
        })
    }
    function func1(){
        let reg=document.getElementById('region');
        reg.innerText='Hammasi';
        let a=document.querySelectorAll('.tr');
        a.forEach(e=>{
            if(e.style.display=='none') {
                e.style.display='';
            }
        })
    }

</script>
    <script>
        let x = 0;
        function myFunction() {
            document.getElementById("demo").innerHTML = x += 1;
        }
    </script>
    <script>
            $(document).ready(function($) {
                $(".clickable-row").click(function() {
                    window.location = $(this).data("href");
                });
            });

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
@endsection
