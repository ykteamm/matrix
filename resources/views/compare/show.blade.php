@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-header">
{{--                    <h4 class="card-title row d-flex justify-content-between"> <span>{{$pharm->name}} {{$pharm->region}}</span>  </h4>--}}
                </div>
                @php $i=0;@endphp
                @foreach($stock as $s)
                    <div class="row">
                        <div class="col-6 ">

                            <h1 onclick="yashir({{$i}})">{{$s->date_time}}</h1>
                            <div style="display: none"  class="row calender-col yashir{{$i}}">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header no-border">
                                            <h4 class="card-title">Medicine </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th><strong>No</strong> </th>
                                                        <th><strong>Dori nomi</strong> </th>
                                                        <th><strong>Avvalgisi soni</strong> </th>
                                                        <th><strong>sotildi</strong> </th>
                                                        <th><strong>kirib kelgan</strong> </th>
                                                        <th><strong>Jami</strong> </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $j=0;@endphp
                                                    @foreach($med as $m)
                                                    <tr>
                                                        <td>{{$loop->index+1}} </td>
                                                        <td>{{$m->name}} </td>
                                                        @if($i==0)
                                                        <td>{{$arr_qol_all[$i][$m->id]}}</td>
                                                        @else
                                                            <td>{{$stock_all[$i-1][$m->id]}}</td>
                                                        @endif
                                                        @if($i==0)
                                                            <td>0 ta sotildi </td>

                                                        @else
                                                            <td>
                                                            @php $w=0; @endphp
                                                            @foreach($arr_sold[$i-1] as $key=>$val)
                                                                @if($key==$m->id)
                                                                    @php $w++; @endphp
                                                            {{$val}}
                                                                @endif
                                                            @endforeach
                                                                @if($w==0)
                                                                    0
                                                                @endif
                                                                ta sotildi

                                                            </td>

                                                        @endif
                                                        @if($i==0)
                                                            <td>0 ta kelgan</td>
                                                        @else

                                                            @if(isset($arr_accepts[$i-1][$m->id]))
                                                            <td>{{$arr_accepts[$i-1][$m->id]}} ta kelgan </td>
                                                            @else
                                                                <td>0 ta kelgan</td>
                                                            @endif
                                                        @endif

                                                        <td>{{$arr_qol_all[$i][$m->id]}}</td>

                                                    </tr>
                                                    @php $j++;@endphp
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 ">

                            <h1 onclick="yashir({{$i}})" class="{{$compare[$i]}}">{{$s->date_time}}</h1>
                            <div  style="display: none" class="row yashir{{$i}}  calender-col">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header no-border">
                                            <h4 class="card-title">Medicine </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th><strong>No</strong> </th>
                                                        <th><strong>Dori nomi</strong> </th>
                                                        <th><strong>Qolgan</strong> </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($stocks[$i] as $m)
                                                        <tr>
                                                            <td>{{$loop->index+1}} </td>

                                                            <td>{{$m->medicine->name}} </td>
                                                            @if(!$m->number==null)
                                                            <td>{{$m->number}}</td>
                                                            @else
                                                                <td>0</td>
                                                            @endif
                                                        </tr>

                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $i++;@endphp
                @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        function yashir(id){
            let x='.yashir'+id;
            let a=document.querySelectorAll(x);
            a.forEach(e=>{
                if(e.style.display=='none') {
                    e.style.display = ''
                }else{
                    e.style.display='none';
                }
            })

        }
    </script>
@endsection

