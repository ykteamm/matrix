@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper">
        <div class="row gold-box">
            @include('admin.components.logo')
        </div>
        <div class="row headbot">
            <div class="col-md-12">
                <div class="card bg-white">
                    <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
                        <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab1"
                                data-toggle="tab">Tasdiqlanmagan
                            </a></li>
                        <li class="nav-item"><a class="nav-link active" href="#solid-rounded-justified-tab2"
                                data-toggle="tab">Tasdiqlangan</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="solid-rounded-justified-tab1">
                            <div class="row">
                                @foreach ($uncheckedshifts as $item)
                                    <div class="col-md-12">
                                        <div class="row mb-5 mt-5 pt-2 pb-2"
                                            style="border: 1px solid black; border-radius:15px;">
                                            <div class="col-md-4">
                                                <div class="mt-4">
                                                    @if ($host == 'mat')
                                                        <img id="avatarImg" height="500px" class="avatar-img"
                                                            src="https://jang.novatio.uz/images/users/open_smena/{{ $item->open_image }}"
                                                            alt="Profile Image">
                                                    @else
                                                        <img id="avatarImg" height="500px" class="avatar-img"
                                                            src="https://jang.novatio.uz/images/users/passport/1673874613.jpg"
                                                            alt="Profile Image">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mt-4">
                                                    <h1>{{ $item->open_code }}</h1>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="widget settings-menu">
                                                    <ul>
                                                        <li class="nav-item">
                                                            <a href="settings.html" class="nav-link active">
                                                                <i class="far fa-user"></i>
                                                                <span>{{ $item->user->last_name }}
                                                                    {{ $item->user->first_name }}</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="preferences.html" class="nav-link">
                                                                <i class="fas fa-cog"></i>
                                                                <span>{{ date('d.m.Y H:i:s', strtotime($item->open_date)) }}
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="tax-types.html" class="nav-link">
                                                                <i class="far fa-check-square"></i> <span>
                                                                    {{ $item->user->region->name }}, </span>
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
                                                                <i class="far fa-bell"></i>
                                                                <span>{{ $item->user->phone_number }} </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-5">
                                                <form action="{{ route('admin-check-open-smena') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <input type="number" class="d-none" name="shift_id"
                                                            value="{{ $item->id }}">
                                                        <input type="number" class="d-none" name="user_id"
                                                            value="{{ $item->user_id }}">
                                                        <div class="col-sm-4 col-md-2 mb-3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="kunSoni" value="true" name="kun_soni">
                                                                <label class="form-check-label" for="kunSoni">
                                                                    Kun soni yo'q
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 col-md-2 mb-3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="beyjikYoq" value="true" name="beyjik_yoq">
                                                                <label class="form-check-label" for="beyjikYoq">
                                                                    Beyjik yo'q
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 col-md-2 mb-3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="xalatYoq" value="true" name="xalat_yoq">
                                                                <label class="form-check-label" for="xalatYoq">
                                                                    Xalat yo'q
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 col-md-2 mb-3">
                                                            <div class="form-check form-check-inline">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="lokatsiya" value="true" name="lokatsiya_notogri">
                                                                    <label class="form-check-label" for="lokatsiya">
                                                                        Lokatsiya noto'g'ri
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 col-md-2 mb-3">
                                                            <button type="submit"
                                                                class="btn btn-block btn-outline-success active">
                                                                Qabul qilish
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <label class="mr-2" for="izoh">Izoh: </label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="izoh">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane show active" id="solid-rounded-justified-tab2">
                            <div class="btn-group d-flex justify-content-end">
                                <div class="row">
                                    <div class="col-md-12" align="center">
                                        Sana
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('open-smena') }}" method="GET">
                                            <input value="{{ $date }}" name="smena_date" type="date"
                                                onchange="filterByDate(this)" class="form-control">
                                            <button id="close-smena-button" type="submit" class="d-none">button</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($checkedshifts as $item)
                                    <div class="col-md-12">
                                        <div class="row mb-5 mt-5 pt-2 pb-2"
                                            style="border: 1px solid black; border-radius:15px;">
                                            <div class="col-md-4">
                                                <div class="mt-4">
                                                    @if ($host == 'mat')
                                                        <img id="avatarImg" height="500px" class="avatar-img"
                                                            src="https://jang.novatio.uz/images/users/open_smena/{{ $item->open_image }}"
                                                            alt="Profile Image">
                                                    @else
                                                        <img id="avatarImg" height="500px" class="avatar-img"
                                                            src="https://jang.novatio.uz/images/users/passport/1673874613.jpg"
                                                            alt="Profile Image">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mt-4">
                                                    <h1>{{ $item->open_code }}</h1>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="widget settings-menu">
                                                    <ul>
                                                        <li class="nav-item">
                                                            <a href="settings.html" class="nav-link active">
                                                                <i class="far fa-user"></i>
                                                                <span>{{ $item->user->last_name }}
                                                                    {{ $item->user->first_name }}</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="preferences.html" class="nav-link">
                                                                <i class="fas fa-cog"></i>
                                                                <span>{{ date('d.m.Y H:i:s', strtotime($item->open_date)) }}
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="tax-types.html" class="nav-link">
                                                                <i class="far fa-check-square"></i> <span>
                                                                    {{ $item->user->region->name }}, </span>
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
                                                                <i class="far fa-bell"></i>
                                                                <span>{{ $item->user->phone_number }} </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-5">
                                                <div class="row">
                                                    <div class="col-md-2 col-sm-4 col-md-2 mb-3">
                                                        @if (json_decode($item->admin_check)->check == 'ok')
                                                            <button type="button"
                                                                class="btn btn-block btn-outline-info active">Tasdiqlangan
                                                            </button>
                                                        @elseif(json_decode($item->admin_check)->check == 'robe')
                                                            <button type="button"
                                                                class="btn btn-block btn-outline-info active">Xalati
                                                                yoq</button>
                                                        @elseif(json_decode($item->admin_check)->check == 'code')
                                                            <button type="button"
                                                                class="btn btn-block btn-outline-info active">Kun soni
                                                                yoq</button>
                                                        @elseif(json_decode($item->admin_check)->check == 'card')
                                                            <button type="button"
                                                                class="btn btn-block btn-outline-info active">Beyjik
                                                                yoq yoq</button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-block btn-outline-info active">Lokatsiya
                                                                yoq</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($paginated)
                                <div class="d-flex align-items-center justify-content-center">
                                    {!! $checkedshifts->links() !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">

            </div>
        </div>
    </div>
@endsection
@section('admin_script')
    <script>
        function filterByDate(data) {
            $('#close-smena-button').click();
        }

        function shiftAnsver(id, ansver) {
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/user/shift",
                type: "POST",
                data: {
                    ansver: ansver,
                    id: id,
                    _token: _token
                },
                success: function(response) {
                    location.reload();
                }
            });
        }
    </script>
@endsection
