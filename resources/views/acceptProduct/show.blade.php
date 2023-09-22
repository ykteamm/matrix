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
                                <h5 class="card-title"> <span class="badge badge-primary mr-2">{{$pharm->name}}</span> <span class="text-danger">Kirim</span></h5>
                                <div class="col-md-2 mb-2  justify-content-end">
                                    <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$months[date('m',strtotime($month))-1]['name']}}</button>
                                    <div class="dropdown-menu" style="left:150px !important">

                                        @foreach($calendar as $m)
                                            <a href="{{route('accept.med.show',['id'=>$pharmacy_id,'time'=>date('Y-m',strtotime('01.'.$m->year_month))])}}"  class="dropdown-item" > {{$m->year_month}} </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" >
                                <div class="table-responsive" style="height: 80vh;overflow-y: scroll ">
                                    <table class="table table-striped mb-0 border">
                                        <form action="{{route('accept.med.store',['id'=>$pharmacy_id])}}" method="post">
                                            @csrf
                                        <thead>
                                        <tr>
                                            <th><strong>No</strong> </th>
                                            <th><strong> Dori nomi </strong></th>
                                            @foreach($accept_date as $p)
                                                <th class="text-center">
                                                    <div>
                                                        <p class="p-0 m-0 @if (!$tim) p-2 @endif">
                                                            <span class="badge badge-secondary" style="font-size:15px;">{{date('d.m.Y H:i', strtotime($p->created_at))}}</span>

                                                        </p>

                                                        {{-- @if ($tim) --}}

                                                            <p class="p-0 m-0 pt-1">
                                                                <a href="{{route('accept.med.edit',['pharmacy_id'=>$pharmacy_id,'date'=>$p->created_at])}}" class="mx-1"><i class="fas fa-edit" style="font-size: 18px;"></i></a>
                                                                <a href="{{route('accept.med.delete',['pharmacy_id'=>$pharmacy_id,'date'=>$p->created_at])}}" class="mx-1"><i class="fas fa-trash" style="font-size: 18px;color:red;"></i></a>
                                                            </p>
                                                        {{-- @endif --}}
                                                    </div>
                                                    <div>[{{number_format($p->all_price, 0, ',', ' ')}}]</div>

                                                </th>
                                            @endforeach

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
                                                <td><strong>{{$m->name}} ({{number_format($m->price, 0, ',', ' ')}})</strong></td>
                                                @php $i=0; @endphp
                                                @foreach($accept as $p)
                                                    @if($m->id==$p->medicine_id)
                                                        <td class="text-center">{{$p->number}} ta [{{number_format($p->price, 0, ',', ' ')}}]</td>
                                                        @php $i++; @endphp
                                                    {{-- @else --}}
                                                        {{-- <td class="text-center"></td> --}}
                                                    @endif
                                                @endforeach
                                                <td class="d-flex justify-content-center">
                                                    <input style="display: none;border-radius: 10px;border: 1px solid blue;padding: 8px 14px;"  class="yashir" name="med{{$m->id}}">
                                                    <input style="display: none" value="{{$m->price}}"  class="" name="price{{$m->id}}">
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                            <div class="text-right " style="position: fixed;right: 1rem;top: 95vh; width: 100%"  >
                                                <button type="submit" style="width: 83.5%; display: none" class="yashir btn btn-primary">Saqlashd </button>
                                            </div>
                                        </form>
                                    </table>
                                </div>
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

