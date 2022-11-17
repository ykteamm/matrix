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
                                <form action="{{ route('elchi-battle-select.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">Jang boshlanish sanasi</label>
                                            <input placeholder="{{$starts}} {{$startdays}}" type="text" class="form-control form-control-sm" disabled>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Jang tugash sanasi</label>
                                            <input placeholder="{{$ends}} {{$enddays}}" type="text" class="form-control form-control-sm" disabled>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Elchi tanlash</label>
                                            {{-- <input type="date" class="form-control form-control-sm" name="start_day" required> --}}
                                            <select class="form-control form-control-sm" name='user1'>
                                                <option value="" disabled selected hidden></option>
                                                @foreach ($usersarray as $item)
                                                    <option value="{{$item->user->id}}">{{$item->user->last_name}} {{$item->user->first_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Elchi tanlash</label>
                                            {{-- <input type="date" class="form-control form-control-sm" name="end_day" required> --}}
                                            <select class="form-control form-control-sm" name='user2'>
                                                <option value="" disabled selected hidden></option>
                                                @foreach ($usersarray as $item)
                                                    <option value="{{$item->user->id}}">{{$item->user->last_name}} {{$item->user->first_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2 mt-4">
                                                <button type="submit" class="btn btn-primary"> Saqlash </button>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-12">
                        <div class="card">
                           <div class="card-body">
                              <div class="table-responsive">
                                 <table class="table mb-0">
                                    <thead>
                                       <tr>
                                          <th>Boshanish kuni</th>
                                          <th>Tugash kuni </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                     <tr>
                                         <th>{{ $start }}</th>
                                         <th>{{ $end }}</th>
                                      </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                    </div> --}}
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
