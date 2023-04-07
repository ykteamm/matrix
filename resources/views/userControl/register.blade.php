@extends('admin.layouts.app')
@section('admin_content')
    <div class="row d-flex  justify-content-center heatbot" style="margin-top: 120px;">
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
                            <form action="{{route('user-success',$item->id)}}" method="POST">
                                @csrf
                                <div class="row mb-5 mt-5 pt-2 pb-2" style="border: 1px solid black; border-radius:15px;">
                                    <div class="col-md-4">
                                        <div class="mt-4">
                                            @if($host == 'mat')
                                            <img id="avatarImg" height="500px" class="avatar-img" src="https://jang.novatio.uz/images/users/passport/{{$user->passport }}" alt="Profile Image">
                                            @else
                                            <img id="avatarImg" height="500px" class="avatar-img" src="https://jang.novatio.uz/images/users/passport/1673874613.jpg" alt="Profile Image">
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mt-4">
                                            @if($host == 'mat')
                                            <img id="avatarImg" height="500px" class="avatar-img" src="https://jang.novatio.uz/images/users/photo/{{$user->photo}}" alt="Profile Image">
                                            @else
                                            <img id="avatarImg" height="500px" class="avatar-img" src="https://jang.novatio.uz/images/users/passport/1673874613.jpg" alt="Profile Image">
                                            @endif
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
                                                <button type="submit" class="btn btn-block btn-outline-primary active">Qabul qilish </button>
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

                            </form>
                        @endif
                    @endforeach
                    
                </div>
                <div class="tab-pane" id="solid-rounded-justified-tab2">
                    @foreach ($registers as $item)
                        @php
                            $user = json_decode($item->elchi);
                        @endphp
                        <div class="row mb-5 mt-5 pt-2 pb-2" style="border: 1px solid black; border-radius:15px;">
                            <div class="col-md-4">
                                <div class="mt-4">
                                    @if($host == 'mat')
                                    <img id="avatarImg" height="500px" class="avatar-img" src="https://jang.novatio.uz/images/users/passport/{{$user->passport}}" alt="Profile Image">
                                    @else
                                    <img id="avatarImg" height="500px" class="avatar-img" src="https://jang.novatio.uz/images/users/passport/1673874613.jpg" alt="Profile Image">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mt-4">
                                    @if($host == 'mat')
                                    <img id="avatarImg" height="500px" class="avatar-img" src="https://jang.novatio.uz/images/users/photo/{{$user->photo}}" alt="Profile Image">
                                    @else
                                    <img id="avatarImg" height="500px" class="avatar-img" src="https://jang.novatio.uz/images/users/passport/1673874613.jpg" alt="Profile Image">
                                    @endif
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
                                    @if ($item->status == 1)
                                    <div class="col-md-12 col-sm-4 col-md-2 mb-3">
                                        <button type="button" class="btn btn-block btn-outline-success active">Qabul qilingan</button>
                                    </div>
                                    @endif
                                    @if ($item->status == 0)
                                    <div class="col-md-12 col-sm-4 col-md-2 mb-3">
                                        <button type="button" class="btn btn-block btn-outline-danger active">Bekor qilingan</button>
                                    </div>
                                    @endif
                                    @if ($item->status == 2)
                                    <div class="col-md-12 col-sm-4 col-md-2 mb-3">
                                        <button type="button" class="btn btn-block btn-outline-warning active">Tekshirilmagan</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                </div>
                </div>
                </div>
        </div>
        
    </div>
@endsection
@section('admin_script')
    <script>
        function cancel(id)
        {
            var comment = $(`input[name=comment${id}]`).val();
            $(`.input${id}`).removeClass('d-none');
            var _token   = $('meta[name="csrf-token"]').attr('content');

            if(comment.length > 0)
            {
                $.ajax({
                    url: "/user/cancel",
                    type:"POST",
                    data:{
                        comment: comment,
                        id: id,
                        _token: _token
                    },
                    success:function(response){
                        location.reload();
                    }
                });
            }
        }
        function success(id)
        {
          var _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                    url: "/user/success",
                    type:"POST",
                    data:{
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
