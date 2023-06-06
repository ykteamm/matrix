@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box">
            @include('admin.components.logo')
            <div class="content container-fluid headbot">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap">
                        <div class="card detail-box1">
                            <div class="card-body">
                                <div class="dash-contetnt">
                                    <h4 class="text-white" style="text-align: center"> Shox turnir ligasi </h4>
                                    <div class="row">
                                        @foreach ($ligas as $item)
                                            <div class="col-6 col-md-6 col-lg-6 d-flex flex-wrap">
                                                <div class="card detail-box2">
                                                    <div class="card-body">
                                                        <div class="dash-contetnt">
                                                            <h1 class="text-white" style="text-align: center">
                                                                <span class="badge bg-primary">
                                                                    {{ $item->name }}
                                                                </span>
                                                            </h1>
                                                            @foreach ($item->liga_user as $k => $l)
                                                                @if ($l->liga_id == $item->id)
                                                                    <h2 class="text-white">
                                                                        <span class="badge bg-primary">
                                                                            {{ $k + 1 }}
                                                                        </span>
                                                                        <span class="badge bg-primary">
                                                                            {{ $l->user->last_name }}
                                                                            {{ $l->user->first_name }}
                                                                        </span>
                                                                    </h2>
                                                                @endif
                                                            @endforeach
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <button type="submit" style="width:100%;"
                                                                        class="btn btn-primary" data-toggle="modal"
                                                                        data-target="#addmember{{ $item->id }}">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <button type="submit" style="width:100%;"
                                                                        class="btn btn-danger" data-toggle="modal"
                                                                        data-target="#minusmember{{ $item->id }}">
                                                                        <i class="fas fa-minus"></i>
                                                                    </button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @foreach ($ligas as $liga)
        <div class="modal fade" id="addmember{{ $liga->id }}">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $liga->name }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <form action="{{ route('user-add-liga.king') }}" method="POST">
                        <div class="modal-body">
                            <ul class="list-group">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <select class="form-control form-control-sm" name='user_id' required>
                                            <option value="" disabled selected hidden>Elchini tanlang</option>
                                            @foreach ($users as $item)
                                                <option value="{{ $item->id }}">{{ $item->last_name }}
                                                    {{ $item->first_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12" style="display: none">
                                        <input type="number" value="{{ $liga->id }}" name="liga_id">
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Saqlash</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="minusmember{{ $liga->id }}">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $liga->name }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('user-delete-liga.king') }}" method="POST">
                        <div class="modal-body">
                            <ul class="list-group">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <select class="form-control form-control-sm" name='user_id' required>
                                            <option value="" disabled selected hidden>Elchini tanlang</option>
                                            @foreach ($liga->liga_user as $l)
                                                @if ($l->liga_id == $liga->id)
                                                    <option value='{{ $l->user->id }}'>{{ $l->user->last_name }}
                                                        {{ $l->user->first_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12" style="display: none">
                                        <input type="number" value="{{ $liga->id }}" name="team_id">
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Saqlash</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('admin_script')
    <script></script>
@endsection
