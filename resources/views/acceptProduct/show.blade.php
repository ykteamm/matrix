@extends('admin.layouts.app')
@section('admin_content')




<div class="row mt-5 pt-3">
    <div class="col-sm-12">
        <div class="card" >

            <div class="card-body p-0">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header no-border d-flex justify-content-between">
                                <h5 class="card-title">{{$pharm->name}} <span class="text-danger">Kirimlar ro'yhati</span></h5>
                                <div class="col-md-2 mb-2  justify-content-end">
                                    <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$months[date('m',strtotime($month))-1]['name']}}</button>
                                    <div class="dropdown-menu" style="left:150px !important">
                                        @php $i=1 @endphp
                                        @foreach($months as $m)
                                            @if($i<10)
                                                <a href="{{route('accept.med.show',['id'=>$pharmacy_id,'time'=>date('Y').'-0'.$i])}}"  class="dropdown-item" > {{$m['name']}} </a>
                                            @else
                                                <a href="{{route('accept.med.show',['id'=>$pharmacy_id,'time'=>date('Y').'-'.$i])}}"  class="dropdown-item" > {{$m['name']}} </a>
                                            @endif
                                            @php $i++ @endphp
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
                                                    <div><strong>{{$p->created_at}}</strong></div>
                                                    <div>[{{number_format($p->all_price, 0, ',', ' ')}}]</div>

                                                </th>
                                            @endforeach
                                            {{--                                                    href="{{route('stock.med.create',['id'=>$pharmacy_id])}}"--}}
                                            <th class="  text-center text-white ">
                                                <input style="display: none" name="created_by" value="{{$id}}">
                                                <a  style="font-size: 1.5rem;" onclick="yashir()" class= "w-100 px-5 yashir  bg-success">+</a>
                                                <button type="submit" style="font-size: 1.5rem;display: none " class="yashir px-2 py-1 text-white border-none bg-success">Saqlash</button>

                                            </th>
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
                                                    @endif
                                                @endforeach
                                                <td class="d-flex justify-content-center">
                                                    <input style="display: none"  class="yashir" name="med{{$m->id}}">
                                                    <input style="display: none" value="{{$m->price}}"  class="" name="price{{$m->id}}">
                                                </td>
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

