@extends('admin.layouts.app')
@section('admin_content')
    <style>
        @media (max-width: 500px) {
            img.smena-img {
                text-align: center;
                width: 90%;
            }

            .smena-image-detail {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .smena-image-detail img {
                width: 98%;
                max-height: 90vh;
            }
        }

        @media (min-width: 500px) {
            img.smena-img {
                width: 350px;
            }

            .smena-image-detail {
                width: 80vw;
                height: 80vh;
            }

            .smena-image-detail img {
                max-height: 100%;
            }
        }
    </style>
    <div class="content main-wrapper">
        <div class="row gold-box">
            @include('admin.components.logo')
        </div>
        <div class="row headbot">
            <div class="col-md-12">
                <div class="card bg-white">
                    <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
                        <li class="nav-item"><a class="nav-link active" href="#solid-rounded-justified-tab1"
                                data-toggle="tab">Tasdiqlanmagan
                            </a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab2"
                                data-toggle="tab">Tasdiqlangan</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="solid-rounded-justified-tab1">
                            <div class="row">
                                @foreach ($uncheckedshifts as $item)
                                    <div class="col-md-12">
                                        <div class="row mb-5 mt-5 pt-2 pb-2"
                                            style="border: 1px solid black; border-radius:15px;">
                                            <div class="col-md-4">
                                                <div class="mt-4">
                                                    @if ($host == 'mat')
                                                        <div class="btn d-flex justify-content-center d-md-inline"
                                                            data-toggle="modal"
                                                            data-target="#exampleModal{{ $item->id }}">
                                                            <img class="smena-img"
                                                                src="https://jang.novatio.uz/images/users/open_smena/{{ $item->close_image }}"
                                                                alt="item image">
                                                            <div class="modal fade" id="exampleModal{{ $item->id }}"
                                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div
                                                                    class="modal-dialog modal-dialog-centered d-md-flex justify-content-md-center">
                                                                    <div class="smena-image-detail">
                                                                        <button type="button"
                                                                            class="close bg-white rounded p-2 d-none d-md-block"
                                                                            data-dismiss="modal">&times;</button>
                                                                        <img src="https://jang.novatio.uz/images/users/open_smena/{{ $item->close_image }}"
                                                                            alt="Message image">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="btn d-flex justify-content-center d-md-inline"
                                                            data-toggle="modal"
                                                            data-target="#exampleModal{{ $item->id }}">
                                                            <img class="smena-img"
                                                                src="https://jang.novatio.uz/images/users/open_smena/{{ $item->close_image }}"
                                                                alt="item image">
                                                            <div class="modal fade" id="exampleModal{{ $item->id }}"
                                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div
                                                                    class="modal-dialog modal-dialog-centered d-md-flex justify-content-md-center">
                                                                    <div class="smena-image-detail">
                                                                        <button type="button"
                                                                            class="close bg-white rounded p-2 d-none d-md-block"
                                                                            data-dismiss="modal">&times;</button>
                                                                        <img src="https://jang.novatio.uz/images/users/open_smena/{{ $item->close_image }}"
                                                                            alt="Message image">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mt-4">
                                                    <h1>{{ $item->close_code }}</h1>
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
                                                                <span>{{ date('d.m.Y H:i:s', strtotime($item->close_date)) }}
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
                                                <form action="{{ route('admin-check-close-smena') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <input type="number" class="d-none" name="shift_id"
                                                            value="{{ $item->id }}">
                                                        <input type="text" class="d-none" name="test_id"
                                                            value="{{ 4 }}">
                                                        <input type="number" class="d-none" name="user_id"
                                                            value="{{ $item->user_id }}">
                                                        <div class="col-sm-4 col-md-2 mb-3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="kunSoni{{ $item->id }}" value="true"
                                                                    name="kun_soni">
                                                                <label class="form-check-label"
                                                                    for="kunSoni{{ $item->id }}">
                                                                    Kun soni yo'q
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 col-md-2 mb-3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="beyjikYoq{{ $item->id }}" value="true"
                                                                    name="beyjik_yoq">
                                                                <label class="form-check-label"
                                                                    for="beyjikYoq{{ $item->id }}">
                                                                    Beyjik yo'q
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 col-md-2 mb-3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="xalatYoq{{ $item->id }}" value="true"
                                                                    name="xalat_yoq">
                                                                <label class="form-check-label"
                                                                    for="xalatYoq{{ $item->id }}">
                                                                    Xalat yo'q
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 col-md-2 mb-3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="lokatsiya{{ $item->id }}" value="true"
                                                                    name="lokatsiya_notogri">
                                                                <label class="form-check-label"
                                                                    for="lokatsiya{{ $item->id }}">
                                                                    Lokatsiya noto'g'ri
                                                                </label>
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
                        <div class="tab-pane" id="solid-rounded-justified-tab2">
                            <div class="btn-group d-flex justify-content-end">
                                <div class="row">
                                    <div class="col-md-12" align="center">
                                        Sana
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('close-smena') }}" method="GET">
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
                                                        <div class="btn d-flex justify-content-center d-md-inline"
                                                            data-toggle="modal"
                                                            data-target="#exampleModal{{ $item->id }}">
                                                            <img class="smena-img"
                                                                src="https://jang.novatio.uz/images/users/open_smena/{{ $item->close_image }}"
                                                                alt="item image">
                                                            <div class="modal fade" id="exampleModal{{ $item->id }}"
                                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div
                                                                    class="modal-dialog modal-dialog-centered d-md-flex justify-content-md-center">
                                                                    <div class="smena-image-detail">
                                                                        <button type="button"
                                                                            class="close bg-white rounded p-2 d-none d-md-block"
                                                                            data-dismiss="modal">&times;</button>
                                                                        <img src="https://jang.novatio.uz/images/users/open_smena/{{ $item->close_image }}"
                                                                            alt="Message image">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="btn d-flex justify-content-center d-md-inline"
                                                            data-toggle="modal"
                                                            data-target="#exampleModal{{ $item->id }}">
                                                            <img class="smena-img"
                                                                src="https://jang.novatio.uz/images/users/open_smena/{{ $item->close_image }}"
                                                                alt="item image">
                                                            <div class="modal fade" id="exampleModal{{ $item->id }}"
                                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div
                                                                    class="modal-dialog modal-dialog-centered d-md-flex justify-content-md-center">
                                                                    <div class="smena-image-detail">
                                                                        <button type="button"
                                                                            class="close bg-white rounded p-2 d-none d-md-block"
                                                                            data-dismiss="modal">&times;</button>
                                                                        <img src="https://jang.novatio.uz/images/users/open_smena/{{ $item->close_image }}"
                                                                            alt="Message image">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mt-4">
                                                    <h1>{{ $item->close_code }}</h1>
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
                                                                <span>{{ date('d.m.Y H:i:s', strtotime($item->close_date)) }}
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
                                                        @if (json_decode($item->admin_check_close)->check == 'ok')
                                                            <button type="button"
                                                                class="btn btn-block btn-outline-info active">Tasdiqlangan
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-block btn-outline-info active">
                                                                {{ json_decode($item->admin_check_close)->check }}
                                                            </button>
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
    </script>
@endsection
