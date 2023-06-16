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
                <form action="{{ route('team-group.store') }}" method="POST">
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
                            <select class="form-control form-control-sm" name='group_id' required>
                                <option value="" disabled selected hidden></option>

                                @foreach ($groups as $group)
                                    <option value='{{$group->id}}'>{{$group->name}}</option>
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
            <div class="card-body">
                <div class="table-responsive">
                    @foreach ($groups as $group)
                        <div class="text-left">
                            <h3>{{$group->name}}</h3>
                        </div>
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                @foreach ($group->team_groups as $team_group)

                                    <th>{{$team_group->team->name}}</th>
                                @endforeach

                                </tr>
                            </thead>
                        </table>
                   @endforeach
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
