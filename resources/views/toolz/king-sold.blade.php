@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
    <div class="col-md-12">
        <div class="card bg-white">
            {{-- <div class="card-body"> --}}
            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
            <li class="nav-item"><a class="nav-link active" href="#solid-rounded-justified-tab1" data-toggle="tab">Yangi </a></li>
            </ul>
            <div class="tab-content">
            <div class="tab-pane show active" id="solid-rounded-justified-tab1">
                <div class="row">
                    @foreach ($solds as $item)
                    @if ($item->admin_check == 0)
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
                                    <form action="{{ route('ks-ansver') }}" method="POST" style="display: contents;">
                                        @csrf
                                    <div class="col-6 col-md-6 col-lg-6 d-flex flex-wrap">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                value="2"
                                                name="ansver" style="height:30px; width:30px; vertical-align: middle;" required>
                                            <label class="form-check-label" style="font-size:17px;color:white;">
                                                Rad qilish
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6 d-flex flex-wrap">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                value="1"
                                                name="ansver" style="height:30px; width:30px; vertical-align: middle;" required>
                                            <label class="form-check-label" style="font-size:17px;color:white;">
                                                Qabul qilish
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6 d-flex flex-wrap mt-3">
                                        <label class="mr-2" for="izoh" style="font-size:17px;color:white;">Izoh: </label>
                                                <textarea class="form-control form-control-lg"
                                                    name="izoh" rows="4" cols="50"></textarea>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6 d-flex flex-wrap mt-3">
                                        <label class="mr-2" for="izoh" style="font-size:17px;color:white;">Soni: </label>
                                                <input type="text" class="form-control form-control-lg"
                                                    name="count">
                                    </div>
                                    <input class="d-none" type="number" name="id" value="{{$item->id}}">
                                        <div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap mt-2" >
                                            <button type="submit" id="asdasdf"
                                                            class="btn btn-block btn-outline-success active" onclick="ansver()">
                                                            Saqlash
                                            </button>
                                            <button type="button" id="asdasdfnone" style="display: none;"
                                                            class="d-none btn btn-block btn-outline-success active">
                                                            Iltimos biroz kuting !!!
                                            </button>
                                        </div>
                                    </form>
                                    {{-- <div class="col-md-12 mt-5"> --}}
                                        
                                    {{-- </div> --}}
                                    {{-- <div class="col-md-12 mt-3 ansversms">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-4 col-md-2">
                                                <button type="button" class="btn btn-block btn-outline-danger active" onclick="ansver(`{{$item->id}}`,2)">Rad qilish </button>
                                            </div>
                                            <div class="col-md-6 col-sm-4 col-md-2">
                                                <button type="button" class="btn btn-block btn-outline-success active" onclick="ansver(`{{$item->id}}`,1)" >Qabul qilish </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3 d-noned-none ansversmsnone">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-4 col-md-2 text-center">
                                                <h2 class="text-white">Iltimos biroz kuting !!!</h2>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    @endif
                    @endforeach
                </div>
                
            </div>
            </div>
            {{-- </div> --}}
            </div>
    </div>
    
    </div>
   </div>
</div>
@endsection
@section('admin_script')
   <script>
      function ansver()
        {
            $('#asdasdf').css('display','none');
            $('#asdasdfnone').css('display','');
        }
   </script>
@endsection
