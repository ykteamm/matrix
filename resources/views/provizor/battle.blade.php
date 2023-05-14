@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box">
            @include('admin.components.logo')

            <div class="content container-fluid headbot">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('pro-battle.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        @if (Session::has('msg_pro'))
                                            <h4>{{Session::get('msg_pro')}}</h4>
                                        @endif
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-3">
                                            <select class="form-control form-control-sm" name='u1id' required>
                                            <option value="" disabled selected hidden></option>
                                                @foreach ($provizors as $provizor)
                                                    <option value='{{$provizor['id']}}'>{{$provizor['last_name']}} {{$provizor['first_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <select class="form-control form-control-sm" name='u2id' required>
                                            <option value="" disabled selected hidden></option>
                                                @foreach ($provizors as $provizor)
                                                    <option value='{{$provizor['id']}}'>{{$provizor['last_name']}} {{$provizor['first_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="date" class="form-control form-control-sm" name="start_date" required>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <input type="date" class="form-control form-control-sm" name="end_date" required>
                                        </div>

                                        <div class="form-group col-md-2">
                                                <button type="submit" class="btn btn-primary"> Saqlash </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('admin_script')
    <script>
    </script>
@endsection
