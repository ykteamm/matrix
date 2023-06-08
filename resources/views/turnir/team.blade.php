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
                <form action="{{ route('turnir-member.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-4">
                            <select class="form-control form-control-sm" name='team_id' required>
                                <option value="" disabled selected hidden></option>

                                @foreach ($teams as $team)
                                    <option value='{{$team->id}}'>{{$team->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select class="form-control form-control-sm" name='user_id' required>
                                <option value="" disabled selected hidden></option>

                                @foreach ($users as $user)
                                    <option value='{{$user->id}}'>{{$user->last_name}} {{$user->first_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="date" value="{{date('Y-m').'-01'}}"  name="month" class="form-control form-control-sm" required/>
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
                @foreach ($teams as $team)
                    <div class="text-left">
                        <h3>{{$team->name}}</h3>
                    </div>
                    <table class="table mb-0">
                        <thead>
                            {{-- <tr>
                                <th>Tur</th>
                                <th>Azo 1</th>
                                <th>Azo 2</th>
                            </tr> --}}
                        </thead>
                        <tbody>
                            <tr>

                            @foreach ($team->turnir_member as $member)
                                @if ($member->tour == 1)
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                        <td>{{$member->user->last_name}} {{$member->user->first_name}}</td>
                                        {{-- <td>
                                            {{$elchi->test->name}}
                                        </td>
                                        <td>{{date('d.m.Y H:i:s',strtotime($elchi->created_at))}}</td> --}}
                                @endif
                            @endforeach

                            </tr>



                        </tbody>
                    </table>
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
