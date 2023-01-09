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
                                            <select class="form-control form-control-sm" name='start_day' onchange="startBattle(this);">
                                                <option value="" disabled selected hidden></option>
                                                <option class="startbattle0 sallbattle" value="0">Dushanba</option>
                                                <option class="startbattle1 sallbattle" value="1">Seshanba</option>
                                                <option class="startbattle2 sallbattle" value="2">Chorshanba</option>
                                                <option class="startbattle3 sallbattle" value="3">Payshanba</option>
                                                <option class="startbattle4 sallbattle" value="4">Juma</option>
                                                <option class="startbattle5 sallbattle" value="5">Shanba</option>
                                                <option class="startbattle6 sallbattle" value="6">Yakshanba</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Tugash kuni</label>
                                            {{-- <input type="date" class="form-control form-control-sm" name="end_day" required> --}}
                                            <select class="form-control form-control-sm" name='end_day' onchange="endBattle(this);">
                                                <option value="" disabled selected hidden></option>
                                                <option class="endbattle0 eallbattle" value="0">Dushanba</option>
                                                <option class="endbattle1 eallbattle" value="1">Seshanba</option>
                                                <option class="endbattle2 eallbattle" value="2">Chorshanba</option>
                                                <option class="endbattle3 eallbattle" value="3">Payshanba</option>
                                                <option class="endbattle4 eallbattle" value="4">Juma</option>
                                                <option class="endbattle5 eallbattle" value="5">Shanba</option>
                                                <option class="endbattle6 eallbattle" value="6">Yakshanba</option>
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
        function startBattle(day)
        {
            $('.eallbattle').css('display','');

            for (let index = 0; index <= day.value; index++) {
                $(`.endbattle${index}`).css('display','none');
            }

        }
        function endBattle(day)
        {
            var valu = $('select[name="start_day"] option:selected').val();
            if(valu)
            {
                $('.sallbattle').css('display','');
                for (let index = day.value; index <= 6; index++) {
                    $(`.startbattle${index}`).css('display','none');
                }
            }
            
        }
    </script>
@endsection
