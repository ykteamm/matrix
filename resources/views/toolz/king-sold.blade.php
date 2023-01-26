@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
    
    @foreach ($solds as $item)

    <div class="col-12 col-md-6 col-lg-6 d-flex flex-wrap">
        <div class="card detail-box1">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 d-flex flex-wrap">
                        @if($host == 'mat')
                        <img id="avatarImg" height="500px" class="avatar-img" src="https://jang.novatio.uz/images/users/king_sold/{{$item->image}}" alt="Profile Image">
                        @else
                        <img id="avatarImg" height="500px" class="avatar-img" src="https://jang.novatio.uz/images/users/passport/1673874613.jpg" alt="Profile Image">
                        @endif
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 d-flex flex-wrap ">
                        <div class="widget settings-menu text-white ml-5">
                            @php
                                $sum = 0;
                                $arr = $item->order->sold;
                                foreach ($arr as $key => $value) {
                                    $sum = $sum + $value->price_product*$value->number;
                                }
                            @endphp
                            <ul>
                                <li class="nav-item">
                                    <i class="far fa-user"></i>  <span>{{$item->order->user->last_name}} {{$item->order->user->first_name}}</span>
                                    </li>
                                    <li class="nav-item">
                                    <i class="fas fa-cog"></i>  <span>{{date('d.m.Y H:i:s',strtotime($item->created_at))}} </span>
                                    </li>
                                <li class="nav-item">
                                    <i class="far fa-user"></i>  <span>order{{$item->order_id}}</span>
                                </li>
                                <li class="nav-item">
                                    <i class="far fa-user"></i>  <span>Check summasi: {{number_format($sum,0,',',' ')}}</span>
                                </li>
                                @foreach ($arr as $a)
                                    <li class="nav-item">
                                        {{-- <i class="far fa-user"></i>   --}}
                                        <span>
                                            {{$a->medicine->name}} ({{$a->number}}x{{$a->price_product}})
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="row">
                            <div class="col-md-6 col-sm-4 col-md-2">
                                <button type="button" class="btn btn-block btn-outline-danger active" onclick="ansver(`{{$item->id}}`,2)">Rad qilish </button>
                            </div>
                            <div class="col-md-6 col-sm-4 col-md-2">
                                <button type="button" class="btn btn-block btn-outline-success active" onclick="ansver(`{{$item->id}}`,1)" >Qabul qilish </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    
    @endforeach
    </div>
   </div>
</div>
@endsection
@section('admin_script')
   <script>
      function ansver(id,ansver)
        {
            var _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/user/king-sold",
                type:"POST",
                data:{
                    ansver: ansver,
                    id: id,
                    _token: _token
                },
                success:function(response){
                    location.reload();
                }
            });
        }
   </script>
@endsection
