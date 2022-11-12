@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >

                <div class="card-body">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-1 ">
                        </div>
                        <div class="col-md-1 ">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header no-border">
                                    <h5 class="card-title">Dorilar ro'yhati </h5>
                                </div>
                                <div class="card-body" style="height: 80vh; overflow-y: scroll">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0 border">
                                            <form action="{{route('accept.med.store',['id'=>$pharmacy_id])}}" method="post">
                                                @csrf
                                                <thead>

                                                <tr class="border">
                                                    <th>No </th>
                                                    <th>Dori nomi </th>
                                                    @foreach($accept_date as $p)
                                                        <th class="text-center">
                                                            {{$p->date}}<span class="mx-1"><i class="fas fa-edit "></i></span>
                                                        </th>
                                                    @endforeach
                                                    {{--                                                    href="{{route('stock.med.create',['id'=>$pharmacy_id])}}"--}}
                                                    <th class=" d-flex text-center text-white justify-content-center">
                                                        <input style="display: none" name="created_by" value="{{$id}}">
                                                        <a  style="font-size: 1.5rem;" onclick="yashir()" class= "w-100 p-0 yashir  bg-success">+</a>
                                                        <input type="datetime-local" id="meeting-time" style="display: none" class="yashir"
                                                               name="meeting-time" value="{{date("Y-m-d H:i", time())}}"
                                                               min="2018-06-07T00:00" >
                                                        <button type="submit" style="font-size: 1.5rem;display: none " class="yashir px-2 py-1 text-white border-none bg-success">Saqlash</button>

                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($med as $m)
                                                    <tr>
                                                        <td>{{$loop->index+1}} </td>
                                                        <td>{{$m->name}} </td>
                                                        @php $i=0; @endphp
                                                        @foreach($accept as $p)
                                                            @if($m->id==$p->medicine_id)
                                                                <td class="text-center">{{$p->number}} </td>
                                                                @php $i++; @endphp
                                                            @endif
                                                        @endforeach
                                                        @if($i==0)
                                                            <td></td>
                                                        @endif
                                                        <td class="d-flex justify-content-center"><input style="display: none"  class="yashir" name="med{{$m->id}}"></td>
                                                    </tr>

                                                @endforeach

                                                </tbody>
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

