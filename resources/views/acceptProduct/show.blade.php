@extends('admin.layouts.app')
@section('admin_content')




    <div class="card">
        <div class="card-header no-border">
            <h4 class="card-title float-left">Upcoming Appointments </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="height: 90vh; overflow-y: scroll">
                <table class="table mb-0 table-striped">
                    <form action="{{route('accept.med.store',['id'=>$pharmacy_id])}}" method="post">
                        @csrf
                    <thead>
                    <tr>
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
{{--                            <input type="datetime-local" id="meeting-time" style="display: none" class="yashir"--}}
{{--                                   name="meeting-time" value="{{date("Y-m-d H:i", time())}}"--}}
{{--                                   min="2018-06-07T00:00" >--}}
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

