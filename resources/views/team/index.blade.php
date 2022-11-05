@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box">
            @include('admin.components.logo')

            <div class="card flex-fill">

                <div class="btn-group mr-5 ml-auto">
                    <div class="row">
                        <div class="col-md-12" align="center">
                            Sana
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$dateText}} </button>
                            <div class="dropdown-menu timeclass">
                                <a href="{{route('team',['time' => 'today'])}}" class="dropdown-item">Bugun</a>
                                <a href="{{route('team',['time' => 'week'])}}" class="dropdown-item">Hafta</a>
                                <a href="{{route('team',['time' => 'month'])}}" class="dropdown-item">Oy</a>
                                <a href="{{route('team',['time' => 'year'])}}" class="dropdown-item">Yil</a>
                                <a href="{{route('team',['time' => 'all'])}}" class="dropdown-item" id="aftertime">Hammasi</a>
                                <input type="text" name="datetimes" class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content container-fluid headbot">
                <div class="row">
                    @foreach ($teams as $item)
                        @if (isset($item->team[0]))
                            <div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap">
                                <div class="card detail-box1">
                                    <div class="card-body">
                                        <div class="dash-contetnt">
                                            <h4 class="text-white" style="text-align: center"> {{$item->name}} </h4>
                                            <div class="row">
                                                @php $s=0; @endphp
                                                @foreach ($item->team as $team_item)
                                                    <div class="col-4 col-md-4 col-lg-4 d-flex flex-wrap">
                                                        <div class="card detail-box2 details-box">
                                                            <div class="card-body">
                                                                <div class="dash-contetnt">
                                                                    <h4 class="text-white" style="text-align: center"> {{$team_item->name}} @if(isset($team1[$team_item->id])){{number_format($team1[$team_item->id],0,",",".")}}@else 0 @endif </h4>
                                                                    @php $i=0; @endphp
                                                                    @foreach ($members as $member)
                                                                        @if($i>=$count)
                                                                            @if($team_item->id == $member->team_id)
                                                                            @if ($member->user->level == 2)
                                                                                <h2 class="text-white">{{$member->user->last_name}} {{$member->user->first_name}}<i class="fas fa-crown"></i> </h2>
                                                                                @endif

                                                                            @endif
                                                                        @else
                                                                        @if($team_item->id == $members2[$i]->team_id)
                                                                                @if ($members2[$i]->level == 2)

                                                                                    <h2 class="text-white">{{$member->user->last_name}} {{$member->user->first_name}} {{$members2[$i]->allprice}} <i class="fas fa-crown"></i> </h2>
                                                                                @endif
                                                                            @endif
                                                                        @endif


                                                                            @php $i++; @endphp
                                                                    @endforeach
                                                                    @php $i=0; @endphp
                                                                    @foreach ($members as $member)
                                                                        @if($i>=$count)

                                                                            @if($team_item->id == $member->team_id)

                                                                            @if ($member->user->level != 2)

                                                                                    <h2 class="text-white">{{$member->user->last_name}} {{$member->user->first_name}} 0 sum</h2>

                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            @if($team_item->id == $members2[$i]->team_id)
                                                                                @if ($members2[$i]->level != 2)
                                                                                    <h2 class="text-white justify-content-between"><span>{{$member->user->last_name}} {{$member->user->first_name}}</span>  <span>{{number_format($members2[$i]->allprice,0,",",".")     }}</span> </h2>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                        @php $i++; @endphp
                                                                    @endforeach
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <button type="submit" style="width:100%;" class="btn btn-primary" data-toggle="modal" data-target="#addmember{{$team_item->id}}">
                                                                                <i class="fas fa-plus"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <button type="submit" style="width:100%;" class="btn btn-danger" data-toggle="modal" data-target="#minusmember{{$team_item->id}}">
                                                                                <i class="fas fa-minus"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php $s++;@endphp
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap">
                        <button type="submit" style="width:100%;" class="btn btn-primary" data-toggle="modal" data-target="#addteam">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="addteam">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Jamoa qo'shish</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form action="{{ route('team.store') }}" method="POST">

                    <div class="modal-body">
                        <ul class="list-group">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <select class="form-control form-control-sm" name='region_id' required>
                                        <option value="" disabled selected hidden>Viloyatni tanlang</option>
                                        @foreach ($regions as $item)
                                            <option value='{{$item->id}}'>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" placeholder="Jamoa kiriting"  name="name" class="form-control form-control-sm" required/>

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
    @foreach ($teams as $item)
        @if (isset($item->team[0]))
            @foreach ($item->team as $team_item)
                <div class="modal fade" id="addmember{{$team_item->id}}">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">{{$team_item->name}}
                                    {{-- <button type="submit" class="btn btn-outline-primary btn-sm ml-3">
                                        <i class="fas fa-plus"></i>
                                    </button> --}}
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <form action="{{ route('member.store') }}" method="POST">

                                <div class="modal-body">
                                    <ul class="list-group">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <select class="form-control form-control-sm" name='user_id' required>
                                                    <option value="" disabled selected hidden>Elchini tanlang</option>
                                                    @foreach ($users as $item)
                                                        <option value='{{$item->id}}'>{{$item->last_name}} {{$item->first_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12" style="display: none">
                                                <input type="number" value="{{$team_item->id}}" name="team_id">
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
                <div class="modal fade" id="minusmember{{$team_item->id}}">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">{{$team_item->name}}
                                    {{-- <button type="submit" class="btn btn-outline-primary btn-sm ml-3">
                                        <i class="fas fa-plus"></i>
                                    </button> --}}
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <form action="{{ route('member.minus') }}" method="POST">

                                <div class="modal-body">
                                    <ul class="list-group">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <select class="form-control form-control-sm" name='user_id' required>
                                                    <option value="" disabled selected hidden>Elchini tanlang</option>
                                                    @php $i=0; @endphp
                                                    @foreach ($members as $member)

                                                    @if($i>=$count)
                                                        @if($team_item->id == $member->team_id)
                                                            @if ($member->user->level == 2)
                                                                <option value='{{$member->user->id}}'>{{$member->user->last_name}} {{$member->user->first_name}}  </option>
                                                            @endif
                                                        @endif
                                                        @else
                                                            @if($team_item->id == $members2[$i]->team_id)
                                                                @if ($members2[$i]->level == 2)
                                                                    <option value='{{$members2[$i]->id}}'>{{$members2[$i]->l_name}} {{$members2[$i]->f_name}}   {{$members2[$i]->allprice}} sum</option>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @php $i++; @endphp
                                                    @endforeach
                                                    @php $i=0; @endphp
                                                    @foreach ($members as $member)
                                                        @if($i>=$count)
                                                            @if($team_item->id == $member->team_id)
                                                                @if ($member->user->level != 2)
                                                                    <option value='{{$member->user->id}}'>{{$member->user->last_name}} {{$member->user->first_name}}</option>
                                                                @endif
                                                            @endif
                                                        @else
                                                            @if($team_item->id == $members2[$i]->team_id)
                                                                @if ($members2[$i]->level != 2)
                                                                    <option value='{{$members2[$i]->id}}'>{{$members2[$i]->l_name}} {{$members2[$i]->f_name}}</option>
                                                                @endif
                                                            @endif
                                                        @endif
                                                        @php $i++; @endphp
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12" style="display: none">
                                                <input type="number" value="{{$team_item->id}}" name="team_id">
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
            @endforeach
        @endif
    @endforeach
@endsection
@section('admin_script')
    <script>
    </script>
@endsection
