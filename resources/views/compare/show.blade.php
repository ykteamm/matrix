@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title row "> <strong>{{$pharm->name}}</strong> &nbsp<span class="text-danger">Qoldiqlar</span>  </h4>
                    <div class="col-md-2 mb-2  justify-content-end">
                        <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$months[date('m',strtotime($month))-1]['name']}}</button>
                        <div class="dropdown-menu" style="left:150px !important">
                            @php $i=1 @endphp
                            @foreach($months as $m)
                                @if($i<10)
                                    <a href="{{route('compare.pharm',['id'=>$pharmacy_id,'time'=>date('Y').'-0'.$i])}}"  class="dropdown-item" > {{$m['name']}} </a>
                                @else
                                    <a href="{{route('compare.pharm',['id'=>$pharmacy_id,'time'=>date('Y').'-'.$i])}}"  class="dropdown-item" > {{$m['name']}} </a>
                                @endif
                                @php $i++ @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
                @php $i=0;@endphp
                @foreach($stock as $s)
                    @if($i!=0)
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-8 m-1  d-flex justify-content-center text-center shadow {{$compare[$i]}}">
                            <span><h3 class="{{$compare[$i]}}" onclick="yashir({{$i}})"><strong>{{date('d.m.y',strtotime($last))}}</strong><small>{{date('H:i',strtotime($last))}}</small> &nbsp</h3></span>
                            <span><h3 class="{{$compare[$i]}}" onclick="yashir({{$i}})"><strong>{{date('d.m.y',strtotime($s->date_time))}}</strong><small>{{date('H:i',strtotime($s->date_time))}}</small></h3></span>
                        </div>
                        <div class="col-2"></div>

                    </div>
                    <div style="display: none"  class="row calender-col yashir{{$i}}">
                        <div class="col-xl-12">
                            <div class="card">
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
                                                <th  style="background-color: #00d285;"><strong style="font-weight: 800; color: red">Jami</strong> </th>
                                                <th  style="background-color: #1a73e8"  class=""><strong style="color: #fff">Qoldiq</strong> </th>
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

                                                    <td class="text-end" style="background-color: #00d285;color: white" >{{$arr_qol_all[$i][$m->id]}}</td>
                                                @foreach($stocks[$i] as $key=>$s)
                                                    @if($m->id==$key+1)
                                                            <td class="text-white" style="{{$comp[$i][$m->id]}}">{{$s->number}}</td>
                                                    @endif

                                                    @endforeach


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
                    @endif
                    @php $i++; $last=$s->date_time@endphp

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

