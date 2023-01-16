@extends('admin.layouts.app')
@section('admin_content')
    <style>

        .dd tr > *:nth-child(4) {
            background-color: #fff;
            position: sticky;
            left: 0;
        }
    </style>

    <div id="table-wrapper"  class="card-body mt-5">
        <div class="row   d-flex justify-content-between">


            <div class="col-md-2 mb-2  justify-content-end">
                <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{date('m.Y',strtotime($month))}}</button>
                <div class="dropdown-menu">
                    
                    @foreach($calendars as $m)
                            <a href="{{route('elchilar',['month'=>date('Y',strtotime('01.'.$m)).'-'.date('m',strtotime('01.'.$m))])}}"  class="dropdown-item" > {{date('m.Y',strtotime('01.'.$m))}} </a>
                    @endforeach
                </div>
            </div>
            <div class="col-4 d-flex">
                <div class="mb-2 d-flex  justify-content-end">
                    <div>
                        <button id="garb_sharq" type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> G`arb/Sharq</button>

                        <div class="dropdown-menu" style="left:150px !important">
                            <a onclick="func1()"  class="dropdown-item" > Hammasi </a>
                            <a onclick="gsh(1)"  class="dropdown-item" >G`arb </a>
                            <a onclick="gsh(2)"  class="dropdown-item" >Sharq </a>

                        </div>
                    </div>
                </div>
                <div class=" mb-2 d-flex  justify-content-end">

                    <button id="region" type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button_vil" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                        @if($test == 1) 
                          Viloyatlar
                        @else
                            @foreach($vil as $val)
                             {{$val}}
                            @endforeach
                        @endif
                    </button>

                    <div class="dropdown-menu" style="left:150px !important">
                        <a onclick="allRegion()"  class="dropdown-item" > Hammasi</a>
                        @php $i=1 @endphp
                        @foreach($viloyatlar as $m)
                            <div class="d-flex mr-2">
                                <a  onclick="regFunc({{$m->id}})"  class="dropdown-item gsh{{$m->side}}" > {{$m->name}} </a>
                                <input type="checkbox" class="checkbox gsh{{$m->side}}" name="vil{{$m->id}}" value="{{$m->id}}">
                            </div>

                            @php $i++ @endphp
                        @endforeach
                        <div class="d-flex justify-content-end">
                            <button onclick="okbtn()" class="btn btn-primary">ok</button>
                        </div>
                    </div>
                </div>


            </div>

        </div>

        <div id="table-scroll" onscroll="myFunction()"  style="overflow-x: auto">
            <table class="table mb-0 table-striped"   style="margin-top: 1rem;">
                <thead  >
               

                <tr onmouseover="$(this).css('cursor','pointer')";
                    onmouseleave="$(this).css('color','black');"
                    class="asd"
                    >
                    <th class="fixed"><strong>ID</strong> </th>
                    <th class="fixed"><strong>Garb/Sharq</strong></th>
                    <th class="fixed"><strong>Viloyat</strong> </th>
                    <th class="fixed"><strong>Elchi</strong> </th>
                    <th class="fixed"><strong>Yangi elchi</strong> </th>
                    <th class="fixed" onclick="yashir()" ><strong>Dorixona</strong> </th>
                    <th class="yashir"><strong>Plan </strong></th>
                    <th class="yashir" onclick="yashir3()"><strong>Kunlik plan </strong></th>
                    <th class="yashir">
                        <a onclick="yashir3()" class="yashir3"><strong>Fakt </strong></a>
                        <input id="qizil" style="display: none" name="plan" class="yashir3" type="number">
                        <button onclick="qizil()" style="display: none" class="btn btn-primary yashir3">ok</button>
                    </th>
                    <th class="yashir" onclick="yashir3()"><strong>Prognoz  </strong></th>
                    @php $i=0; $s=0; @endphp
                    @foreach($days as $day)


                    <th style="display: none" class="days{{$s}} "><strong onclick="days({{$s}})" class="days{{$s}}">{{date('d.m.Y',strtotime($day))}}  </strong></th>
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
                <tr  id="{{$item->id}}" class="tr tr{{$item->v_id}} gsh{{$item->side}} vil{{$item->v_id}}" onmouseover="$(this).css('cursor','pointer') ">
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
                    <td class="fixed">
                        @if ($item->new_created != NULL)
                        @php
                            $arrayDate = 0;
                            $Variable1 = strtotime($item->new_created);
                            $Variable2 = strtotime(date_now());
                            for ($currentDate = $Variable1; $currentDate <= $Variable2;$currentDate += (86400)) 
                            {                        
                            $arrayDate += 1;
                            }
                        @endphp
                            <span class="badge bg-primary-light">{{date('d.m.Y',strtotime($item->new_created))}} ({{$arrayDate}} kun)</span>
                        @else
                            Eski elchi
                        @endif
                    </td>
                    <td class="fixed">
                        @if (isset($encane[$item->id]) && count($encane[$item->id]) > 0)
                        {{-- {{count($encane[$item->id])}} --}}

                            @foreach ($encane[$item->id] as $items)
                                 <p>{{$items->name}} ({{number_format($items->allprice,'0',',','.')}})</p>
                            @endforeach
                        @else
                            Aptekasi yoq
                        @endif
                        
                    </td>
                    <td class="yashir "><span class="badge bg-primary-light">{{number_format($plan[$t], 0, '', '.')}}</span> </td>
                    <td class="yashir "><span class="badge bg-success-light">{{number_format($plan_day[$t], 0, '', '.')}}</span> </td>
                    <td class="yashir qizil" name="{{$elchi_fact[$item->id]}}"> <span class="badge bg-warning-light">{{number_format($elchi_fact[$item->id], 0, ',', ' ') }}</span></td>
                    <td class="yashir "> <span class="badge bg-success-light">{{number_format($elchi_prognoz[$item->id], 0, '', '.')}}</span></td>
                    @php $i=0; $s=0;  $arr=0; @endphp
                    @foreach($days as $day)
                        @if($i==0||$i==7||$i==14||$i==21)
                            @if($haftalik[$t][$s]==0)
                            <td onclick="weeks({{$s}})"  class="week{{$s}}  week hover{{$s}}"
                                onmouseover="$(`.hover{{$s}}`).css('background','yellow').css('cursor','pointer').css('color','blue');"
                                onmouseleave="$(`.hover{{$s}}`).css('background','white').css('color','black');"  data-bs-toggle="tooltip" title="{{ $item->last_name}} {{$item->first_name}}"
                            ><span  class="week{{$s}}">{{number_format($haftalik[$t][$s],0,'','.')}} </span></td>
                            @else
                            <td onclick="weeks({{$s}})"   class="week{{$s}} weeks{{$i}}   week hover{{$s}} "
                                onmouseover="$(`.hover{{$s}}`).css('background','yellow').css('cursor','pointer').css('color','blue');"
                                onmouseleave="$(`.hover{{$s}}`).css('background','white').css('color','black');"  data-bs-toggle="tooltip" title="{{ $item->last_name}} {{$item->first_name}}"
                            ><span  class="week{{$s}} badge bg-success-light">{{number_format($haftalik[$t][$s],0,'','.')}} </span></td>
                            @endif
                        @endif


                    @if($sold[$t][$i]==0)
                    <td style="display: none" onclick="days({{$s}})" class="days{{$s}} "
                        onmouseover="$(`.hover{{$s}}`).css('cursor','pointer');"
                        data-bs-toggle="tooltip" title="{{ $item->last_name}} {{$item->first_name}}"
                        >{{ number_format($sold[$t][$i],0,'','.')}}</span></td>
                    @else
                    <td style="display: none" onclick="days({{$s}})" class=" days{{$s}} "
                        onmouseover="$(`.hover{{$s}}`).css('cursor','pointer');"
                        data-bs-toggle="tooltip" title="{{ $item->last_name}} {{$item->first_name}}"
                        > <span class="days{{$s}} badge bg-primary-light">{{ number_format($sold[$t][$i],0,'','.')}}</span></td>
                    @endif
{{--                        @php $tot_sold[$t]+= @endphp--}}
                    @php $i++; if ($i==7||$i==14||$i==21){$s++;}  @endphp
                    @endforeach
                </tr>

                @php
                    $t++;
                @endphp

                    @endif
                @endforeach
                <tr  id="sticky" style="position: sticky;z-index: 1000; top:76vh; color: white" class="bg-success tr" >
                    <td>{{00}}</td>
                    <td>Jami</td>
                    <td class="text-center" style="width: 13rem;">Viloyatlar</td>
                    <td style="width: 17rem;" class="bg-success">Elchi</td>
                    <td style="width: 13rem">Dorixonalar</td>
                    <td style="width: 6.5rem;">{{number_format($total_plan,0,'','.')}}</td>
                    <td style="width:6rem">{{number_format($total_planday,0,'','.')}}</td>
                    <td style="width: 8.5rem">{{number_format($total_fact,0,'','.')}}</td>
                    <td>{{number_format($total_prog,0,'','.')}}</td>
                    @php $i=0; $s=0;  $arr=0; @endphp
                    @foreach($tot_sold_day as $item)

                        @if($i==0||$i==7||$i==14||$i==21)
                            @if($total_haftalik[$s]==0)
                                <td style="z-index: 1000" onclick="weeks({{$s}})"  class="week{{$s}}  week"
                                ><span  class="week{{$s}}">{{number_format($total_haftalik[$s],0,'','.')}}</span></td>
                            @else
                                <td style="z-index: 1000;color: white" onclick="weeks({{$s}})"   class="week{{$s}} weeks{{$i}}   week "
                                ><span  class="week{{$s}} ">{{number_format($total_haftalik[$s],0,'','.')}} </span></td>
                            @endif
                        @endif


                        @if($item==0)
                            <td style="display: none;color: white!important;" onclick="days({{$s}})" class="days{{$s}} "
                                {{--                                onmouseover="$(`.hover{{$s}}`).css('cursor','pointer');"--}}
                                {{--                                data-bs-toggle="tooltip" title="all"--}}
                            ><span style="color: white">{{number_format($item, 0, '', '.')}}</span></td>
                        @else
                            <td style="display: none; color: white!important;" onclick="days({{$s}})" class=" days{{$s}} "
                                {{--                                onmouseover="$(`.hover{{$s}}`).css('cursor','pointer');"--}}
                                {{--                                data-bs-toggle="tooltip" title="all"--}}
                            > <span style="color: white" class="days{{$s}} ">{{number_format($item, 0, '', '.')}}</span></td>
                        @endif
                        {{--                        @php $tot_sold[$t]+= @endphp--}}
                        @php $i++; if ($i==7||$i==14||$i==21){$s++;}  @endphp
                        {{--                        <td class="days{{$s}}">{{number_format($item, 0, '', '.')}}</td>--}}
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@section('admin_script')
<script>
    function qizil()
    {
        let qizil=document.querySelectorAll('.qizil')
        let input=document.getElementById('qizil')
        // console.log(input.value)
        qizil.forEach(e=>{
            e.style.background='white'

            if(e.attributes.name.value*1<input.value*1){
                console.log(e.attributes.name.value)
                e.style.background='red'
            }
        })
    }
    function allRegion()
    {
        var month = <?php echo json_encode( $month ) ?>;
        var url ="{{route('elchilar',['month'=> ':month']) }}";
        url = url.replace(':month', month);
        location.href = url;
    }
    function regFunc(id)
    {
        var month = <?php echo json_encode( $month ) ?>;
        var region = id;
        var url ="{{route('elchilar',['month'=> ':month','region' => ':region']) }}";
        url = url.replace(':month', month);
        url = url.replace(':region', region);
        location.href = url;

    }
    function okbtn(){
        var array = []
        var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

        for (var i = 0; i < checkboxes.length; i++) {
        array.push(checkboxes[i].value)
        }
        // console.log(array)
         var month = <?php echo json_encode( $month ) ?>;
         var region = array;
            var url ="{{route('elchilar',['month'=> ':month','region' => ':region']) }}";
            url = url.replace(':month', month);
            url = url.replace(':region', region);
            location.href = url;
        
        // let checks=document.querySelectorAll('.checkbox');
        // let tr=document.querySelectorAll('.tr');
        // tr.forEach(e=>{
        //     e.style.display='none'
        // })
        // checks.forEach(e=>{
        //     if(e.checked==true){
        //         a=e.name;
        //         x='.tr'+a.substr(3,4)
        //         let b=document.querySelectorAll(x)
        //         b.forEach(d=>{
        //             d.style.display=''
        //         })

        //     }
        // })

    }
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
    function gsh(id)
    {
        btn=document.getElementById('garb_sharq')

        if(id==1){
            let side1=document.querySelectorAll('.gsh1');
            let side2=document.querySelectorAll('.gsh2');
            side1.forEach(e=>{
                e.style.display='';
            })
            side2.forEach(s=>{
                s.style.display='none';
            })
            btn.innerText='G`arb'
        }
        if(id==2){
            let side1=document.querySelectorAll('.gsh1');
            let side2=document.querySelectorAll('.gsh2');
            side1.forEach(e=>{
                e.style.display='none';
            })
            side2.forEach(s=>{
                s.style.display='';
            })
            btn.innerText='Sharq'
        }
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
            reg.innerText = 'Namangan viloyati';
        }
        if(id==8) {
            reg.innerText = 'Samarqand viloyati';
        }
        if(id==9) {
            reg.innerText = 'Surxondaryo viloyati';
        }
        if(id==10) {
            reg.innerText = 'Sirdaryo viloyati';
        }
        if(id==11) {
            reg.innerText = 'Toshkent viloyati';
        }
        if(id==12) {
            reg.innerText = 'Farg`ona viloyati';
        }
        if(id==13) {
            reg.innerText = 'Xorazm viloyati';
        }
        if(id==14) {
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
        let btn=document.getElementById('garb_sharq')
        btn.innerText='G`arb/Sharq'
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
            function yashir3(){
                let a=document.querySelectorAll('.yashir3');
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
