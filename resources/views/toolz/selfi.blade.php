@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
        @foreach ($shifts as $item)
            <div class="row mb-5 mt-5 pt-2 pb-2" style="border: 1px solid black; border-radius:15px;">
                <div class="col-md-4">
                    <div class="mt-4">
                        @if($host == 'mat')
                        <img id="avatarImg" height="100px" class="avatar-img" src="https://jang.novatio.uz/images/users/open_smena/{{$item->open_image}}" alt="Profile Image">
                        @else
                        <img id="avatarImg" height="100px" class="avatar-img" src="https://jang.novatio.uz/images/users/passport/1673874613.jpg" alt="Profile Image">
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mt-4">
                        <h1>{{$item->open_code}}</h1>
                    </div>
                </div>
                <div class="col-md-4">
                                    <div class="widget settings-menu">
                                        <ul>
                                        <li class="nav-item">
                                        <a href="settings.html" class="nav-link active">
                                        <i class="far fa-user"></i>  <span>{{$item->user->last_name}} {{$item->user->first_name}}</span>
                                        </a>
                                        </li>
                                        <li class="nav-item">
                                        <a href="preferences.html" class="nav-link">
                                        <i class="fas fa-cog"></i>  <span>{{date('d.m.Y H:i:s',strtotime($item->open_date))}} </span>
                                        </a>
                                        </li>
                                        <li class="nav-item">
                                        <a href="tax-types.html" class="nav-link">
                                        <i class="far fa-check-square"></i>  <span> {{$item->user->region->name}}, </span>
                                        </a>
                                        </li>
                                        <li class="nav-item">
                                        <a href="expense-category.html" class="nav-link">
                                        <i class="far fa-list-alt"></i>  
                                        <span> 
                                            Elchi
                                        </span>
                                        </a>
                                        </li>
                                        <li class="nav-item">
                                        <a href="notifications.html" class="nav-link">
                                        <i class="far fa-bell"></i>  <span>{{$item->user->phone_number}} </span>
                                        </a>
                                        </li>
                                        </ul>
                                    </div>
                </div>
                <div class="col-md-12 mt-5">
                    <div class="row">
                        <div class="col-md-2 col-sm-4 col-md-2 mb-3">
                            <button type="button" class="btn btn-block btn-outline-info active" onclick="shiftAnsver(`{{$item->id}}`,`code`)">Kun soni yo'q </button>
                        </div>
                        <div class="col-md-2 col-sm-4 col-md-2 mb-3">
                            <button type="button" class="btn btn-block btn-outline-info active" onclick="shiftAnsver(`{{$item->id}}`,`card`)" >Beyjik yo'q </button>
                        </div>
                        <div class="col-md-2 col-sm-4 col-md-2 mb-3">
                            <button type="button" class="btn btn-block btn-outline-info active" onclick="shiftAnsver(`{{$item->id}}`,`robe`)" >Xalat yo'q </button>
                        </div>
                        <div class="col-md-2 col-sm-4 col-md-2 mb-3">
                            <button type="button" class="btn btn-block btn-outline-info active" onclick="shiftAnsver(`{{$item->id}}`,`location`)" >Lokatsiya noto'g'ri </button>
                        </div>
                        <div class="col-md-2 col-sm-4 col-md-2 mb-3">
                            <button type="button" class="btn btn-block btn-outline-success active" onclick="shiftAnsver(`{{$item->id}}`,`ok`)" >Qabul qilish </button>
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
      function shiftAnsver(id,ansver)
        {
            var _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/user/shift",
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
