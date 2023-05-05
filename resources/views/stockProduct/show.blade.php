@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-3">
        <div class="col-sm-12">
            <div class="card" >

                <div class="card-body p-0">
                    @php
                        if (strtotime($month.'-01') < strtotime(date('Y-m').'-01')) {
                            $tim = 0;
                        }else{
                            $tim = 1;
                        }
                    @endphp
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header no-border d-flex justify-content-between">
                                    <h5 class="card-title"> <span class="badge badge-primary mr-2">{{$pharm->name}}</span>  <span class="text-danger">Qoldiq</span></h5>
                                    <div class="col-md-2 mb-2  justify-content-end">
                                        <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$months[date('m',strtotime($month))-1]['name']}}</button>
                                        <div class="dropdown-menu" style="left:150px !important">
                                            @foreach($calendar as $m)
                                            <a href="{{route('stock.med.show',['id'=>$pharmacy_id,'time'=>date('Y-m',strtotime('01.'.$m->year_month))])}}"  class="dropdown-item" > {{$m->year_month}} </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" >
                                    <div class="table-responsive" style="height: 80vh;overflow-y: scroll ">
                                            <table class="table table-striped mb-0 border">
                                                <form action="{{route('stock.med.store',['id'=>$pharmacy_id])}}" method="post">
                                                    @csrf
                                                <thead>

                                                <tr class="border">
                                                    <th>No </th>
                                                    <th>Dori nomi </th>
                                                    @foreach($stock_date as $p)
                                                        <th class="text-center p-1">
                                                            <p class="p-0 m-0 @if (!$tim) p-2 @endif">
                                                                <span class="badge badge-secondary" style="font-size:15px;">{{date('d.m.Y H:i', strtotime($p->date))}}</span> 
                                                            </p>
                                                        @if ($tim)

                                                            <p class="p-0 m-0 pt-1"> 
                                                                <a href="{{route('stock.med.edit',['pharmacy_id'=>$pharmacy_id,'date'=>$p->date])}}" class="mx-1"><i class="fas fa-edit" style="font-size: 18px;"></i></a>
                                                                <a href="{{route('stock.med.delete',['pharmacy_id'=>$pharmacy_id,'date'=>$p->date])}}" class="mx-1"><i class="fas fa-trash" style="font-size: 18px;color:red;"></i></a>
                                                            </p>
                                                        @endif

                                                        </th>
                                                    @endforeach
{{--                                                    href="{{route('stock.med.create',['id'=>$pharmacy_id])}}"--}}
                                                    @if ($tim)
                                                        <th class="  text-center text-white ">
                                                            <input style="display: none" name="created_by" value="{{$id}}">
                                                            <a  style="font-size: 1.5rem;border-radius:10px;padding: 4px 8px;cursor-pointer;" onclick="yashir()" class= "w-100 px-5 yashir  bg-success">+</a>
                                                            <input style="display: none;border-radius: 10px;border: 1px solid green;padding: 8px 14px;" type="datetime-local" id="meeting-time" class="yashir"
                                                                name="meeting-time" value="{{date("Y-m-d H:i", time())}}"
                                                                min="2018-06-07T00:00" >

                                                        </th>
                                                    @endif
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($med as $m)
                                                    <tr>
                                                        <td>{{$loop->index+1}} </td>
                                                        <td>{{$m->name}} </td>
                                                        @php $i=0; @endphp
                                                        @foreach($stock as $p)
                                                            @if($m->id==$p->medicine_id)
                                                                <td class="text-center">{{$p->number}} </td>
                                                                @php $i++; @endphp
                                                            @endif
                                                        @endforeach
                                                        <td class="d-flex justify-content-center"><input style="display: none;border-radius: 10px;border: 1px solid blue;padding: 8px 14px;"  class="yashir" name="med{{$m->id}}"></td>
                                                    </tr>

                                                @endforeach

                                                </tbody>
                                                    <div class="text-right " style="position: fixed;right: 1rem;top: 95vh; width: 100%"  >
                                                        <button type="submit" style="width: 83.5%; display: none" class="yashir btn btn-primary">Saqlash </button>
                                                    </div>
                                                </form>

                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
{{--                    <div class="row">--}}
{{--                        <a onclick="yashir()" class="btn btn-primary text-white w-100 ">Har bitta kiritilganni alohida ko'rish</a>--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-12">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-header no-border yashir" style="display: none">--}}
{{--                                    <h5  class="card-title">Dorilar ro'yhati </h5>--}}
{{--                                </div>--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="table-responsive">--}}
{{--                                        <table class="table table-striped mb-0 yashir" style="display: none" >--}}
{{--                                            <thead>--}}
{{--                                            <tr>--}}
{{--                                                <th>No </th>--}}
{{--                                                <th>Dori nomi </th>--}}
{{--                                                <th>Soni </th>--}}
{{--                                                <th>Kim kiritdi </th>--}}
{{--                                                <th>Qachon kiritdi</th>--}}
{{--                                                <th>Kim o'zgartirdi </th>--}}
{{--                                                <th>Qachon o'zgartirdi </th>--}}
{{--                                                <th>Tahrirlash </th>--}}

{{--                                            </tr>--}}
{{--                                            </thead>--}}
{{--                                            <tbody>--}}
{{--                                            @foreach($stocks as $med)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{{$loop->index+1}} </td>--}}
{{--                                                        <td>{{$med->medicine->name}} </td>--}}
{{--                                                        <td>{{$med->number}}</td>--}}
{{--                                                        <td>{{$med->user_created->first_name}} {{$med->user_created->last_name}}</td>--}}
{{--                                                        <td>{{$med->created_at}}</td>--}}
{{--                                                        <td>{{$med->user_updated->first_name}} {{$med->user_updated->last_name}}</td>--}}
{{--                                                        <td>{{$med->updated_at}}</td>--}}

{{--                                                        <td>--}}
{{--                                                            <form action="{{route('stock.med.edit',['pharmacy_id'=>$pharmacy_id])}}" method="post">--}}
{{--                                                                @csrf--}}
{{--                                                                <input name="id" style="display: none" value="{{$med->id}}">--}}
{{--                                                                <button type="submit" ><i class="fas fa-edit text-primary"></i></button>--}}
{{--                                                            </form>--}}
{{--                                                        </td>--}}

{{--                                                    </tr>--}}
{{--                                            @endforeach--}}
{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>
            </div>
        </div>
    </div>
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
    </script>
@endsection

