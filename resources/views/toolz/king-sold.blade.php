@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
    <div class="col-md-12">
        <div class="card bg-white">
            <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
            <li class="nav-item"><a class="nav-link active" href="#solid-rounded-justified-tab1" data-toggle="tab">Yangi </a></li>
            <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab2" data-toggle="tab">Tarix </a></li>
            </ul>
            <div class="tab-content">
            <div class="tab-pane show active" id="solid-rounded-justified-tab1">
                @foreach ($registers as $item)
                    @if ($item->status == 2)
                        @php
                            $user = json_decode($item->elchi);
                        @endphp
                        <div class="row mb-5 mt-5 pt-2 pb-2" style="border: 1px solid black; border-radius:15px;">
                            <div class="col-md-4">
                                <div class="mt-4">
                                    <img id="avatarImg" height="100px" class="avatar-img" src="https://jang.novatio.uz/images/users/passport/1673874613.jpg" alt="Profile Image">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mt-4">
                                    <img id="avatarImg" height="100px" class="avatar-img" src="https://jang.novatio.uz/images/users/passport/1673873679.jpg" alt="Profile Image">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="widget settings-menu">
                                    <ul>
                                    <li class="nav-item">
                                    <a href="settings.html" class="nav-link active">
                                    <i class="far fa-user"></i>  <span>{{$user->last_name}} {{$user->first_name}}</span>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                    <a href="preferences.html" class="nav-link">
                                    <i class="fas fa-cog"></i>  <span>{{date('d.m.Y',strtotime($user->year.'-'.$user->month.'-'.$user->day))}} </span>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                    <a href="tax-types.html" class="nav-link">
                                    <i class="far fa-check-square"></i>  <span> {{$region[$user->region]}}, {{$district[$user->district]}} </span>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                    <a href="expense-category.html" class="nav-link">
                                    <i class="far fa-list-alt"></i>  
                                    <span> 
                                        @if ($user->lavozim == 1)
                                            Elchi
                                        @endif
                                        @if ($user->lavozim == 2)
                                            Provizor 
                                        @endif
                                    </span>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                    <a href="notifications.html" class="nav-link">
                                    <i class="far fa-bell"></i>  <span>{{$user->phone}} </span>
                                    </a>
                                    </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="row">
                                    <div class="col-md-6 col-sm-4 col-md-2 mb-3">
                                        <button type="button" class="btn btn-block btn-outline-primary active" onclick="success(`{{$item->id}}`)">Qabul qilish </button>
                                    </div>
                                    <div class="col-md-6 col-sm-4 col-md-2 mb-3">
                                        <button type="button" class="btn btn-block btn-outline-warning active" onclick="cancel(`{{$item->id}}`)" >Bekor qilish </button>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-2 col-xl mb-3 mb-1 d-none input{{$item->id}}">
                                    <input type="textarea" class="form-control" name="comment{{$item->id}}" placeholder="Izoh yozing...">
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                
            </div>
            <div class="tab-pane" id="solid-rounded-justified-tab2">
            </div>
            </div>
            </div>
            </div>
    </div>
    @foreach ($solds as $item)

    <div class="col-12 col-md-6 col-lg-6 d-flex flex-wrap">
        <div class="card detail-box1">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 d-flex flex-wrap">
                        @if($host == 'mat')
                        <img id="avatarImg" height="500px" class="avatar-img" src="https://jang.novatio.uz/images/users/king_sold/{{$item->open_image}}" alt="Profile Image">
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
