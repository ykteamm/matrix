@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box">
            @include('admin.components.logo')
        </div>
        <div class="row headbot">
            <div class="col-sm-12">
                <div class="card mt-5">
                    <div class="card-body">
                        <form action="{{ route('turnir-games-store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <select class="form-control form-control-sm" name='team1_id' required>
                                        <option value="" disabled selected hidden></option>
                                        @foreach ($teams as $team)
                                            <option value='{{ $team->id }}'>
                                                {{ $team->turnir_member[0]->user->first_name . ' + ' . $team->turnir_member[1]->user->first_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <select class="form-control form-control-sm" name='team2_id' required>
                                        <option value="" disabled selected hidden></option>

                                        @foreach ($teams as $team)
                                            <option value='{{ $team->id }}'>
                                                {{ $team->turnir_member[0]->user->first_name . ' + ' . $team->turnir_member[1]->user->first_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2 d-none">
                                    <input type="date" value="{{ date('Y-m') . '-01' }}" name="month"
                                        class="form-control form-control-sm" required />
                                </div>

                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-primary"> Saqlash </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @foreach ($battles as $battle)
                            <div class="card rounded border">
                                <div class="card-header p-0"></div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div>
                                                {{ $battle->team1[0]->users[0]->f . '  ' . $battle->team1[0]->users[0]->l }}
                                            </div>
                                            <div>
                                                {{ $battle->team1[0]->users[1]->f . '  ' . $battle->team1[0]->users[1]->l }}
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                {{ $battle->team2[0]->users[0]->f . '  ' . $battle->team2[0]->users[0]->l }}
                                            </div>
                                            <div>
                                                {{ $battle->team2[0]->users[1]->f . '  ' . $battle->team2[0]->users[1]->l }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer p-0"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin_script')
    <script></script>
@endsection
