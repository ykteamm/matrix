@extends('admin.layouts.app')
@section('admin_content')
@isset(Session::get('per')['dash'])
    @if(Session::get('per')['dash'] == 'true')
    <div class="content mt-1 main-wrapper ">
        <div class="row gold-box">
        @include('admin.components.logo')
        </div>
        <div class="main-wrapper headbot">
            <div class="content">
                <div class="col-xl-12 mt-3">
                    <h3 style="margin-top:100px;">                  
                        Hush kelibsiz!  <span style="font-weight:bold;color:rgb(8, 175, 28)">{{Session::get('user')->last_name}} {{Session::get('user')->first_name}}</span>
                    </h3>
                </div>
                <div class="col-xl-12 mt-3">
                    <h3>      
                        <span>
                            @if(intval(date('h',strtotime(date_now()))) > 0 && intval(date('h',strtotime(date_now()))) < 13)            
                            Kechagi kungi hisobot
                            @else
                            Bugungi kun hozirgacha hisobot
                            @endif
                        </span>
                    </h3>
                </div>
            </div>
            <div class="row">
                <livewire:counter />
               
                <div class="col-12 col-md-6 col-lg-3 flex-wrap">
                <div class="card detail-box2 details-box">
                <div class="card-body">
                <div class="dash-contetnt">
                <div class="mb-3">
                <img src="assets/img/icons/visits.svg" alt="" width="26">
                </div>
                <h4 class="text-white">Patients Visit </h4>
                <h2 class="text-white">137 </h2>
                <div class="growth-indicator">
                <span class="text-white"><i class="fas fa-angle-double-down mr-1"></i> (4.78%) </span>
                </div>
                </div>
                </div>
                </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 flex-wrap">
                <div class="card detail-box3 details-box">
                <div class="card-body">
                <div class="dash-contetnt">
                <div class="mb-3">
                <img src="assets/img/icons/hospital-bed.svg" alt="" width="26">
                </div>
                <h4 class="text-white">New Admit </h4>
                <h2 class="text-white">24 </h2>
                <div class="growth-indicator">
                <span class="text-white"><i class="fas fa-angle-double-up mr-1"></i> (18.32%) </span>
                </div>
                </div>
                </div>
                </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 flex-wrap">
                <div class="card detail-box4 details-box">
                <div class="card-body">
                <div class="dash-contetnt">
                <div class="mb-3">
                <img src="assets/img/icons/operating.svg" alt="" width="26">
                </div>
                <h4 class="text-white">Operations </h4>
                <h2 class="text-white">05 </h2>
                <div class="growth-indicator">
                <span class="text-white"><i class="fas fa-angle-double-down mr-1"></i> (25.14%) </span>
                </div>
                </div>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endisset
@endsection
@section('admin_script')
    <script>
        function arrowDown()
        {
            $('.region-hide').css('display','');
            $('.arrow-up').css('display','');
            $('.arrow-down').css('display','none');
        }
        function arrowUp()
        {
            $('.region-hide').css('display','none');
            $('.arrow-up').css('display','none');
            $('.arrow-down').css('display','');
        }
    </script>
@endsection
