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
                        <li class="nav-item"><a class="nav-link active" href="#solid-rounded-justified-tab2"
                                data-toggle="tab">Tarix </a></li>
                    </ul>
                    <div class="btn-group d-flex justify-content-end">
                        <div class="row">
                            <div class="col-md-12" align="center">
                                Sana
                            </div>
                            <div class="col-md-12">
                                <form action="{{ route('king.history') }}" method="GET">
                                    <input value="{{ $date }}" name="_date" type="date"
                                        onchange="filterByDate(this)" class="form-control">
                                    <button id="close-smena-button" type="submit" class="d-none">button</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="solid-rounded-justified-tab1">
                            @if (!$date)
                                <div class="d-flex mb-4 align-items-center justify-content-center">
                                    {!! $solds->links() !!}
                                </div>
                            @endif
                            <div class="row">
                                @foreach ($solds as $item)
                                    <div class="col-12 col-md-6 col-lg-6 d-flex flex-wrap">
                                        <div class="card detail-box1">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-6 d-flex flex-wrap" data-toggle="modal"
                                                    data-target="#kingSoldHis{{ $item->id }}">
                                                        @if ($host == 'mat')
                                                            <img id="avatarImg" width="100%" class="avatar-img"
                                                                src="https://jang.novatio.uz/images/users/king_sold/{{ $item->image }}"
                                                                alt="Profile Image">
                                                        @else
                                                            <img id="avatarImg" width="100%" class="avatar-img"
                                                                src="https://jang.novatio.uz/images/users/passport/1673874613.jpg"
                                                                alt="Profile Image">
                                                        @endif
                                                        <div class="modal fade" id="kingSoldHis{{ $item->id }}"
                                                            tabindex="-1" aria-labelledby="kingSoldHisLabel"
                                                            aria-hidden="true">
                                                            <div
                                                                class="modal-dialog modal-dialog-centered d-md-flex justify-content-md-center">
                                                                <div class="smena-image-detail">
                                                                    <button type="button"
                                                                        class="close bg-white rounded p-2 d-none d-md-block"
                                                                        data-dismiss="modal">&times;</button>
                                                                    <img style="max-width: 900px" src="https://jang.novatio.uz/images/users/king_sold/{{ $item->image }}"
                                                                        alt="Message image">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6 d-flex flex-wrap ">
                                                        <div class="widget settings-menu text-white ml-5">
                                                            @php
                                                                $sum = 0;
                                                                $arr = $item->order->sold;
                                                                foreach ($arr as $key => $value) {
                                                                    $sum = $sum + $value->price_product * $value->number;
                                                                }
                                                            @endphp
                                                            <ul>
                                                                <li class="nav-item">
                                                                    <i class="far fa-user"></i>
                                                                    <span>{{ $item->order->user->last_name }}
                                                                        {{ $item->order->user->first_name }}</span>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <i class="fas fa-cog"></i>
                                                                    <span>{{ date('d.m.Y H:i:s', strtotime($item->created_at)) }}
                                                                    </span>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <i class="far fa-user"></i>
                                                                    <span>order{{ $item->order_id }}</span>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <i class="far fa-user"></i> <span>Check summasi:
                                                                        {{ number_format($sum, 0, ',', ' ') }}</span>
                                                                </li>
                                                                @foreach ($arr as $a)
                                                                    <li class="nav-item">
                                                                        {{-- <i class="far fa-user"></i>   --}}
                                                                        <span>
                                                                            {{ $a->medicine->name }}
                                                                            ({{ $a->number }}x{{ $a->price_product }})
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <div class="row">
                                                            @if ($item->admin_check == 1)
                                                                <div class="col-md-12">
                                                                    <button type="button"
                                                                        class="btn btn-block btn-outline-success active">Qabul
                                                                        qilingan </button>
                                                                </div>
                                                            @endif
                                                            @if ($item->admin_check == 2)
                                                                <div class="col-md-12">
                                                                    <button type="button"
                                                                        class="btn btn-block btn-outline-danger active">Rad
                                                                        qilingan </button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                @endforeach
                            </div>
                            @if (!$date)
                                <div class="d-flex align-items-center justify-content-center">
                                    {!! $solds->links() !!}
                                </div>
                            @endif
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
        function filterByDate(data) {
            if(data.value) {
                $('#close-smena-button').click();
            } else {
                location.href = "{{ route('king.history') }}"
            }
        }

        function ansver(id, ansver) {
            $('.ansversms').addClass('d-none');
            $('.ansversmsnone').removeClass('d-none');
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/user/king-sold",
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
