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
                                <form action="{{ route('elchi-battle-setting.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Boshanish kuni</label>
                                            {{-- <input type="date" class="form-control form-control-sm" name="start_day" required> --}}
                                            <select class="form-control form-control-sm" name='start_day'>
                                                <option value="" disabled selected hidden></option>
                                                <option value="0">Dushanba</option>
                                                <option value="1">Seshanba</option>
                                                <option value="2">Chorshanba</option>
                                                <option value="3">Payshanba</option>
                                                <option value="4">Juma</option>
                                                <option value="5">Shanba</option>
                                                <option value="6">Yakshanba</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Tugash kuni</label>
                                            {{-- <input type="date" class="form-control form-control-sm" name="end_day" required> --}}
                                            <select class="form-control form-control-sm" name='end_day'>
                                                <option value="" disabled selected hidden></option>
                                                <option value="0">Dushanba</option>
                                                <option value="1">Seshanba</option>
                                                <option value="2">Chorshanba</option>
                                                <option value="3">Payshanba</option>
                                                <option value="4">Juma</option>
                                                <option value="5">Shanba</option>
                                                <option value="6">Yakshanba</option>
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
                    <div class="col-sm-12">
                        <div class="card">
                           <div class="card-body">
                              <div class="table-responsive">
                                 <table class="table mb-0">
                                    <thead>
                                       <tr>
                                          <th>Boshanish kuni</th>
                                          <th>Tugash kuni </th>
                                          <th>Holat </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>{{ $week_start }} ({{date('d.m.Y',strtotime($week_date->start_day))}})</th>
                                            <th>{{ $week_end }} ({{date('d.m.Y',strtotime($week_date->end_day))}})</th>
                                            <th>Oxirgi jang</th>
                                        </tr>
                                        @if ($week_start == 0)
                                        
                                        <tr>
                                            <th>{{ $start }} ({{$now_start}})</th>
                                            <th>{{ $end }} ({{$now_end}})</th>
                                            <th>Keyingi jang</th>
                                        </tr>
                                        @else
                                        <tr>
                                            <th>{{ $start }} ({{$now_start}})</th>
                                            <th>{{ $end }} ({{$now_end}})</th>
                                            <th>Keyingi jang</th>
                                        </tr>
                                        @endif

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
    </div>
@endsection
@section('admin_script')
    <script>
    </script>
@endsection
