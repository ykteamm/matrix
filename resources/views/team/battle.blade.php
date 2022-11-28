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
                                <form action="{{ route('team-battle.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <select class="form-control form-control-sm" name='team1_id'>
                                            <option value="" disabled selected hidden></option>
                                                @foreach ($teams as $team)
                                                    <option value='{{$team->id}}'>{{$team->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <select class="form-control form-control-sm" name='team2_id'>
                                            <option value="" disabled selected hidden></option>
                                                @foreach ($teams as $team)
                                                    <option value='{{$team->id}}'>{{$team->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="date" class="form-control form-control-sm" name="begin" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="date" class="form-control form-control-sm" name="end" required>
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
            <div class="content container-fluid headbot">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap">
                        <div class="card">
                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Jamoa 1</th>
                                                            <th scope="col">Jamoa 2</th>
                                                            <th scope="col">Boshlanish sanasi</th>
                                                            <th scope="col">Tugash sanasi</th>
                                                            <th scope="col">Tugagan</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach( $team_battle as $key => $team)
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{$team['team1']}}</td>
                                                            <td>{{$team['team2']}}</td>
                                                            <td>{{ date('d.m.Y',strtotime($team['begin'])) }}</td>
                                                            <td>{{ date('d.m.Y',strtotime($team['end'])) }}</td>
                                                            @if($team['ended'] == 0)
                                                                <td>---</td>
                                                            @else
                                                            <td>Tugagan</td>
                                                            @endif
                                                            <td>
                                                                <a href="{{ route('battle.view',$team['id']) }}">
                                                                    <button type="submit"  class="btn btn-md btn-info"><i class="fas fa-eye mr-1"></i></button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
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
