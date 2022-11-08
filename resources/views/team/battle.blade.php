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
                                        <div class="form-group col-md-4">
                                            <select class="form-control form-control-sm" name='team1_id'>
                                            <option value="" disabled selected hidden></option>
                                                @foreach ($teams as $team)
                                                    <option value='{{$team->id}}'>{{$team->name}}</option>
                                                @endforeach 
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <select class="form-control form-control-sm" name='team2_id'>
                                            <option value="" disabled selected hidden></option>
                                                @foreach ($teams as $team)
                                                    <option value='{{$team->id}}'>{{$team->name}}</option>
                                                @endforeach 
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="date" class="form-control form-control-sm" name="begin">
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
                    @foreach ($battles as $battle)
                        
                    <div class="col-12 col-md-6 col-lg-6 d-flex flex-wrap">
                        <div class="card @if($team1[$battle->team1_id] > $team1[$battle->team2_id]) detail-box12 @else detail-box13 @endif">
                            <div class="card-body">
                                <div class="dash-contetnt">
                                    <h4 class="text-white">
                                        @foreach ($teams as $item)
                                            @if ($item->id == $battle->team1_id)
                                            {{$item->name}}  
                                            (
                                                @isset($team1[$battle->team1_id])
                                                {{number_format($team1[$battle->team1_id],0,",",".")}}
                                                @endisset
                                            )
                                            @endif
                                        @endforeach
                                    </h4>
                                    @foreach ($users as $user)
                                            @foreach ($user as $item)
                                                @if ($item->team_id == $battle->team1_id)
                                                <h2 class="text-white">
                                                    {{$item->l_name}}  {{$item->f_name}}
                                                (
                                                {{number_format($item->allprice,0,",",".")}}
                                                )
                                                </h2>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 d-flex flex-wrap">
                        <div class="card @if($team1[$battle->team1_id] < $team1[$battle->team2_id]) detail-box12 @else detail-box13 @endif">
                            <div class="card-body">
                                <div class="dash-contetnt">
                                    <h4 class="text-white">
                                        @foreach ($teams as $item)
                                            @if ($item->id == $battle->team2_id)
                                            {{$item->name}}  
                                            ( 
                                                @isset($team1[$battle->team2_id])
                                                {{number_format($team1[$battle->team2_id],0,",",".")}}
                                                @endisset 
                                            )
                                            @endif
                                        @endforeach
                                    </h4>
                                    @foreach ($users as $user)
                                            @foreach ($user as $item)
                                                @if ($item->team_id == $battle->team2_id)
                                                <h2 class="text-white">
                                                    {{$item->l_name}}  {{$item->f_name}}
                                                (
                                                {{number_format($item->allprice,0,",",".")}}
                                                )
                                                </h2>
                                                @endif
                                            @endforeach
                                        @endforeach
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
@endsection
@section('admin_script')
    <script>
    </script>
@endsection
