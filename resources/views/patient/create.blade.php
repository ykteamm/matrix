<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
     {{-- <link href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('assets/css/feather.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" /> --}}

    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" /> --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/css/bootstrap.min.css') }}" />

    <link href="{{ asset('/assets/plugins/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/plugins/simple-calendar/simple-calendar.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/css/feather.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('/dash_assets/daterangepicker.css') }}" />




    
</head>
<body>
    <div class="main-wrapper">
        {{-- @include('components.flash'); --}}
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="header">
   <div class="header-left">
      <a href="{{ route('super_admin') }}" class="logo">
      {{-- <p>РОКС</p> --}}
      <p style="font-size: 18px;">Регистр ОКС <img src="/assets/img/logo-small.png" alt="Logo" width="25" height="30"/></p>
      
      </a>
      <a href="/main" class="logo logo-small">
      <img src="/assets/img/logo-small.png" alt="Logo" width="30" height="30" />
      </a>
   </div>
   <a href="javascript:void(0);" id="toggle_btn">  <i class="fas fa-bars"></i>
   </a>
   {{-- <div class="top-nav-search">
      <form>
         <input type="text" class="form-control" placeholder="Search here" />
         <button class="btn" type="submit"><i class="fa fa-search"></i>
         </button>
      </form>
   </div> --}}
   <a class="mobile_btn" id="mobile_btn">  <i class="fas fa-bars"></i>
   </a>
   <ul class="nav user-menu">
      <li class="nav-item dropdown has-arrow flag-nav mr-2">
         <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
         <img src="/assets/img/flags/{{ app()->getlocale() }}.png" alt="" width="32" height="32" class="rounded-circle" />
         </a>
         <div class="dropdown-menu dropdown-menu-right">
            {{-- <a href="/locale/en" class="dropdown-item">
            <img src="/assets/img/flags/us.png" alt="" height="16" /> English
            </a> --}}
            <a href="/locale/ru" class="dropdown-item">
            <img src="/assets/img/flags/ru.png" alt="" height="16" /> Русский
            </a>
            <a href="/locale/uz" class="dropdown-item">
            <img src="/assets/img/flags/uz.png" alt="" height="16" /> O'zbekcha
            </a>
         </div>
      </li>
      {{-- <li class="nav-item dropdown">
         <a href="#" class="nav-link notifications-item">
         <i class="feather-bell"></i>  <span class="badge badge-pill">3 </span>
         </a>
      </li> --}}
      <li class="nav-item dropdown">
        {{-- <a class="dropdown-item" href="{{ route("logout") }}" style="margin-top:3px;"><i class="feather-log-out" ></i></a> --}}
        <a class="dropdown-item" href="{{ route('logout') }}" style="margin-top:3px;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           <i class="feather-log-out" ></i>
        </a>

           <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
               @csrf
           </form>
      </li>
      {{-- <li class="nav-item dropdown has-arrow main-drop ml-md-3">
         <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
         <span class="user-img">
            <img src="/assets/img/avatar.jpg" alt="" />
         <span class="status online"></span></span>
         </a>
         <div class="dropdown-menu">
            <a class="dropdown-item" href="/"><i class="feather-log-out"></i> Logout </a>
         </div>
      </li> --}}
   </ul>
</div>
        @include('components.sidebar');
        <div class="page-wrapper">
         @if (\Session::has('success'))
    <div class="alert alert-success" id="message">
        <ul>
            <li>{{ __('app.flash_add') }}</li>
        </ul>
    </div>
@endif
<div class="content container-fluid">
    <div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <ul class="breadcrumb ml-2">
                <li class="breadcrumb-item"><a href="/main"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item">{{ __('app.patient') }}</li>
                <li class="breadcrumb-item active">{{ __('app.patient_add') }} </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
    {{-- <div class="page-header">
      <div class="row align-items-center">
          <div class="col-md-10"> --}}
              {{-- <div class="d-flex align-items-center"> --}}
               
               <div class="alert alert-success" id="back_patient" style="display: none">
                  <ul>
                      {{-- <li>{{ __('app.flash_add') }}</li> --}}
                      <li>Bu bemor oldin bizda davolangan</li>
                  </ul>
              </div>
              {{-- </div> --}}
          {{-- </div>
          <div class="col-md-2">
               <button type="button" class="btn btn-block btn-outline-primary">Primary </button>
         </div>
      </div>
      </div> --}}
    <div class="row">
       <div class="col-md-12">
          <div class="card bg-white">
             <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-bottom">
                   <li class="nav-item"><a @if (Session::get('success') == 'patient_saved' || Session::get('success') == 'diagnos_updated' || Session::get('success') == 'exam_updated' || Session::get('success') == 'ekg_updated' || Session::get('success') == 'exo_updated') class="nav-link" @else class="nav-link active" @endif href="#solid-justified-tab1" data-toggle="tab"> {{ __('app.patient_reg') }}</a></li>
                   
                   @isset(Session::get('per')['p_diagnos_create'])
                   <li class="nav-item"><a @if (Session::get('success') == 'patient_saved') class="nav-link active" @else class="nav-link" @endif href="#solid-justified-tab2" data-toggle="tab"> {{__('app.diagnos')}} </a></li>
                   @endisset
                  
                  @isset(Session::get('per')['p_illnes_create'])
                  <li class="nav-item"><a @if (Session::get('success') == 'diagnos_updated') class="nav-link active" @else class="nav-link" @endif href="#solid-justified-tab3" data-toggle="tab"> {{__('app.examination')}} </a></li>
                  @endisset

                  @isset(Session::get('per')['p_ekg_create'])
                   <li class="nav-item"><a @if (Session::get('success') == 'exam_updated') class="nav-link active" @else class="nav-link" @endif href="#solid-justified-tab4" data-toggle="tab"> {{__('app.ekg')}} </a></li>
                  @endisset
                   
                  @isset(Session::get('per')['p_exo_create'])
                     <li class="nav-item"><a @if (Session::get('success') == 'ekg_updated') class="nav-link active" @else class="nav-link" @endif href="#solid-justified-tab5" data-toggle="tab"> {{__('app.exo')}} </a></li>
                  @endisset
                   
                  @isset(Session::get('per')['p_treatment_create'])
                     <li class="nav-item"><a @if (Session::get('success') == 'exo_updated') class="nav-link active" @else class="nav-link" @endif href="#solid-justified-tab6" data-toggle="tab"> {{__('app.lech')}} </a></li>
                  @endisset
                
                  </ul>
                <div class="tab-content">
                   <div @if (Session::get('success') == 'patient_saved' || Session::get('success') == 'diagnos_updated' || Session::get('success') == 'exam_updated' || Session::get('success') == 'ekg_updated' || Session::get('success') == 'exo_updated') class="tab-pane" @else class="tab-pane show active mt-3" @endif id="solid-justified-tab1">
                     {{-- <form action="{{ route('patient.store') }}" method="POST"> --}}
                        <form action="{{ route('patient.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                           <div class="form-group col-md-3">
                        <div id="success"></div>
                           <label> {{ __('app.pinfl') }}  </label>
                              <input type="text" name="pinfl"  maxlength="14" class="form-control form-control-sm"/>
                           </div>
                           <div class="form-group col-md-3">
                              <label> {{ __('app.last_name') }} </label>
                              <input type="text" name="last_name" class="form-control form-control-sm"  required/>
                           </div>
                           <div class="form-group col-md-3">
                              <label> {{ __('app.first_name') }} </label>
                              <input type="text" name="first_name" class="form-control form-control-sm"  required/>
                           </div>
                           
                           <div class="form-group col-md-3">
                              <label> {{ __('app.fio') }} </label>
                              <input type="text" name="full_name" class="form-control form-control-sm"  required/>
                           </div>
                           <div class="form-group col-md-3">
                              <label> {{ __('app.pasport') }}  </label>
                              <input style="text-transform: uppercase;" type="text" name="passport" id="passport" class="form-control form-control-sm" placeholder="AB1234567"/>
                           </div>
                           <div class="form-group col-md-3">
                              <label> {{__('app.patient_phone')}} </label>
                              <input type="text" id="phone" name="phone" class="form-control form-control-sm"/>
                           </div>
                           <div class="form-group col-md-2 date_of_day">
                              <label> {{ __('app.patient_date') }} </label>
                              <input type="text" id="date" name="birth_date" class="form-control form-control-sm" placeholder="дд.мм.гггг"/>
                           </div>
                           <div class="form-group col-md-2">
                              <label> {{__('app.patient_age')}} </label>
                              <input type="number" name="age" class="form-control form-control-sm" id="age" readonly/>
                           </div>
                           <!--<div class="form-group col-md-2"-->
                           <!--   <label> {{__('app.patient_temp')}} </label>-->
                           <!--   <input type="number" name="temp" class="form-control form-control-sm" required/>-->
                           <!--</div>-->
                           <div class="form-group col-md-2">
                              <label> {{ __('app.patient_temp') }} </label>
                              <input type="text" name="temp" class="form-control form-control-sm"  required/>
                           </div>
                           <div class="form-group col-md-2">
                              <label> {{ __('app.province') }} </label>
                              <select class="form-control form-control-sm" name="province_id" class="form-control form-control-sm" id="province" required>
                                 <option value="" disabled selected hidden></option>
                                 @foreach($province as $key => $value)
                                 <option value="{{ $value->id }}">{{ $value->province_name }}
                                 </option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="form-group col-md-2" id="for_district">
                              <label> {{ __('app.district') }} </label>
                              <input type="number" class="form-control form-control-sm" disabled/>
                           </div>
                           <div class="form-group col-md-2" style="display: none" id="district">
                              <label id="add_select"> {{ __('app.district') }} </label>
                              <select class="form-control form-control-sm" name="district_id" id="place_dist" required>
                                 <option value="" disabled selected hidden id="add_option"></option>
                              </select>
                           </div>
                           <div class="form-group col-md-2" id="div_rost">
                              <label> {{ __('app.patient_rost') }} </label>   
                              <div class="input-group">
                                 <input class="form-control form-control-sm" id="rost" name="height" type="text" step="any" id="rost" required/>
                                 <div class="input-group-prepend">
                                    <span class="input-group-text"> метр </span>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-2">
                              <label> {{ __('app.patient_ves') }} </label>
                              <div class="input-group">
                                 <input class="form-control form-control-sm" name="weight" type="number" id="ves" required/>
                                 <div class="input-group-prepend">
                                    <span class="input-group-text"> кг </span>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-2">
                              <label> {{ __('app.patient_imt') }} </label>
                              <input type="number" class="form-control form-control-sm" name="bmi" step="any" id="imt" readonly/>
                           </div>
                           <div class="form-group col-md-2">
                              <label class="d-block"> {{__('app.gender')}} </label>
                              <div class="form-check form-check-inline mt-2">
                                 <input class="form-check-input" type="radio" name="gender" id="gender_male" value="true" required/>
                                 <label class="form-check-label" for="gender_male"> {{__('app.male')}} </label>
                              </div>
                              <div class="form-check form-check-inline">
                                 <input class="form-check-input" type="radio" name="gender" id="gender_female" value="false" />
                                 <label class="form-check-label" for="gender_female"> {{__('app.female')}} </label>
                              </div>
                           </div>
                        </div>
                        <div class="card-header mb-3">
                           <h5 class="card-title">{{__('app.hospital')}}</h5>
                        </div>
                        <div class="row">
                           <div class="form-group col-md-3">
                              <label> {{__('app.hospital_number')}} </label>
                              <input type="number" value="{{ $case_number }}" name="case_number" class="form-control form-control-sm" readonly/>
                           </div>
                           <div class="form-group col-md-3">
                              <label> {{__('app.hospital_date')}} </label>
                              <input type="text" name="case_date" class="form-control form-control-sm" placeholder="дд.мм.гггг" required/>
                           </div>
                           {{-- <div class="form-group col-md-3">
                              <label> {{__('app.hospital_time')}} </label>
                              <input type="text" id="case_time" name="case_time" class="form-control form-control-sm" placeholder="чч:мм" required/>
                           </div> --}}
                           <div class="form-group col-md-6">
                              <label class="d-block"> {{__('app.admission')}} </label>
                              <div class="form-check form-check-inline mt-2">
                                 <input class="form-check-input" type="radio" name="amb" id="gender_male" value="true" required/>
                                 <label class="form-check-label" for="gender_male"> {{__('app.samotek')}} </label>
                              </div>
                              <div class="form-check form-check-inline">
                                 <input class="form-check-input" type="radio" name="amb" id="gender_female" value="false" />
                                 <label class="form-check-label" for="gender_female"> {{__('app.ambulance')}} </label>
                              </div>
                           </div>
                           <div class="form-group col-md-3" >
                              <input type="number" name="patient_back" class="form-control form-control-sm" readonly/>
                           </div>
                           <div class="mt-4 ml-auto mr-2">
                              <button type="submit" class="btn btn-primary" id="add_data"> {{ __('app.add_data') }} </button>
                          </div>
                          {{-- </div> --}}
                        </div>
                     </form>
                   </div>
                   @isset(Session::get('per')['p_diagnos_create'])
                   <div @if (Session::get('success') == 'patient_saved') class="tab-pane show active mt-3" @else class="tab-pane" @endif id="solid-justified-tab2">
                     <form action="{{ url('patient/store_diagnos') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                           @if (Session::get('success') == 'patient_saved')
                           <div class="col-md-6 container-fluid">
                              <input type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" value="{{ Session::get('patient')->id }}" />
                           </div>

                           <div class="form-group col-md-6 container-fluid">
                              <input type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="{{ Session::get('patient')->first_name }} {{ Session::get('patient')->last_name }} {{ Session::get('patient')->full_name }} ({{ Session::get('patient')->pinfl }}) 333" readonly/>
                           </div>
                           @else
                           @isset($count_diagnos)
                           @if($count_diagnos == 1)
                           <div class="col-md-6 container-fluid">
                              <input type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" value="{{ $diagnos[0]->id }}" />
                           </div>

                           <div class="form-group col-md-6 container-fluid">
                              <input type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="{{ $diagnos[0]->first_name }} {{ $diagnos[0]->last_name }} {{ $diagnos[0]->full_name }} ({{ $diagnos[0]->pinfl }})" readonly/>
                           </div>
                           @elseif($count_diagnos > 1)
                           <div class="col-md-6 container-fluid">
                              <input id="for_id" type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" />
                           </div>
                           <div class="form-group col-md-6 container-fluid">
                              <input id="for_diagnos" onmouseleave="$('#to_diagnos').css('display','none')" onmouseenter="$('#to_diagnos').css('display','')" type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" onkeyup="filterFunction()" required/>
                              
                              <div style="border:1px solid #ddd;display:none;" class="ml-3 ml-auto rounded" onmouseleave="$(this).css('display','none')" id="to_diagnos">
                                 @foreach($diagnos as $key => $value)
                                 
                           <div class="row">
                              <div class="col-md-12">
                                 <a href="#" id="for_diagnos2" onmouseleave="$('#to_diagnos').css('display','none')" onmouseenter="$('#to_diagnos').css('display','')" onclick="$('#for_id').val({{$value->id}}),$('#for_diagnos').val(this.text),$('#to_diagnos').css('display','none')" style="display:block;" class="pt-1 pl-2 float-left">{{ $value->first_name }} {{ $value->last_name }} {{ $value->full_name }}({{ $value->pinfl }}) ({{ $value->patient_back }})</a>
                              </div>
                           </div>

                                 @endforeach
                              </div>
                           </div>
                           @elseif($count_diagnos == 0)
                           @endif
                           @endisset
                           @endif
                           <div class="form-group col-md-6">
                              <div class="card-header mb-3">
                                 <h5 class="card-title">{{__('app.diagnos')}}</h5>
                              </div>
                              <div class="form-group col-md-12">
                                 <div class="form-group">
                                 <div class="col-md-12">
                                 <div class="radio">
                                    <label id="label_oks_pod">
                                    <input type="radio" name="diagnos" value="app.oks_pod" onclick="rDiagnos('label_oks_pod')" required/> {{__('app.oks_pod')}}
                                    </label>
                                 </div>
                                 <div class="radio">
                                    <label id="label_oks_bez_pod">
                                    <input type="radio" name="diagnos" value="app.oks_bez_pod" onclick="rDiagnos('label_oks_bez_pod')"/> {{__('app.oks_bez_pod')}}
                                    </label>
                                 </div>
                                 <div class="radio">
                                    <label id="label_oks_infarct">
                                    <input type="radio" name="diagnos" value="app.oks_infarct" onclick="rDiagnos('label_oks_infarct')"/> {{__('app.oks_infarct')}}
                                    </label>
                                 </div>
                                 <div class="radio">
                                    <label id="label_oks_bez_infarct">
                                    <input type="radio" name="diagnos" value="app.oks_bez_infarct" onclick="rDiagnos('label_oks_bez_infarct')"/> {{__('app.oks_bez_infarct')}}
                                    </label>
                                 </div>
                                 <!--<div class="radio">-->
                                 <!--   <label id="label_nonef">-->
                                 <!--   <input type="radio" name="diagnos" value="app.angina" onclick="rDiagnos('label_angina')"/> {{__('app.angina')}}d-->
                                 <!--   </label>-->
                                 <!--</div>-->
                                 </div>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-6">
                              <div class="card-header mb-3">
                                 <h5 class="card-title">{{__('app.add_diagnos')}}</h5>
                              </div>
                              <div class="form-group col-md-12">
                                 <div class="checkbox col-md-12">
                                    <label>
                                    <input type="checkbox" value="app.ag" name="ag" /> {{__('app.ag')}}
                                    </label>
                                 </div>
                                 <div class="checkbox col-md-12">
                                    <label>
                                    <input type="checkbox" value="app.tip" name="tip" /> {{__('app.tip')}}
                                    </label>
                                 </div>
                                 <div class="checkbox col-md-12">
                                    <label>
                                    <input type="checkbox" value="app.ojireniya" name="ojireniya" /> {{__('app.ojireniya')}}
                                    </label>
                                 </div>
                                 <div class="checkbox col-md-12">
                                    <label>
                                    <input type="checkbox" value="app.giperlipedimya" name="giperlipedimya" /> {{__('app.giperlipedimya')}}
                                    </label>
                                 </div>
                                 <div class="col-md-12">
                                    <label>
                                    <input type="checkbox" value="app.other" name="other_check" id="check_other"/> {{__('app.other')}}
                                    </label>
                                    <input type="text" name="other_name_d" style="border: none;border-bottom:solid 1px black;display:none" class="ml-2 w-50" id="other"/>
                                 </div>
                              </div>
                           </div>
                           @isset($count_diagnos)
                               @if($count_diagnos == 0)
                                  
                               @else
                                  
                           <div class="mt-4 ml-auto mr-2">
                              <button type="submit" class="btn btn-primary" id="add_diagnoz"> {{ __('app.add_data') }} </button>
                          </div>
                               @endif

                           @endisset
                        </div>
                     </form>
                   </div>
                  @endisset

                  @isset(Session::get('per')['p_illnes_create'])
                   <div @if (Session::get('success') == 'diagnos_updated') class="tab-pane show active mt-3" @else class="tab-pane" @endif id="solid-justified-tab3">
                     <form action="{{ url('patient/store_exam') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                           @if (Session::get('success') == 'diagnos_updated')
                           <div class="col-md-6 container-fluid">
                              <input type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" value="{{ Session::get('patient')->id }}" />
                           </div>

                           <div class="form-group col-md-6 container-fluid">
                              <input type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="{{ Session::get('patient')->first_name }} {{ Session::get('patient')->last_name }} {{ Session::get('patient')->full_name }} ({{ Session::get('patient')->pinfl }})" readonly/>
                           </div>
                           @else
                           @isset($count_exam)
                               @if($count_exam == 1)
                               <div class="col-md-6 container-fluid">
                                 <input type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" value="{{ $exam[0]->id }}" />
                              </div>
   
                              <div class="form-group col-md-6 container-fluid">
                                 <input type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="{{ $exam[0]->first_name }} {{ $exam[0]->last_name }} {{ $exam[0]->full_name }} ({{ $exam[0]->pinfl }})" readonly/>
                              </div>
                               @elseif($count_exam > 1)
                               <div class="col-md-6 container-fluid">
                                 <input id="for_id_exam" type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" />
                              </div>
   
                              <div class="form-group col-md-6 container-fluid">
                                 <input id="for_diagnos_exam" onmouseleave="$('#to_diagnos_exam').css('display','none')" onmouseenter="$('#to_diagnos_exam').css('display','')" type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" onkeyup="filterFunctionExam()" required/>
                                 
                                 <div style="border:1px solid #ddd;display:none;"  class="ml-3 ml-auto rounded" onmouseleave="$(this).css('display','none')" id="to_diagnos_exam">
                                    @foreach($exam as $key => $value)
                                    <div class="row">
                                       <div class="col-md-12">
                                          
                                    <a href="#" id="for_diagnos_exam" onmouseleave="$('#to_diagnos_exam').css('display','none')" onmouseenter="$('#to_diagnos_exam').css('display','')" onclick="$('#for_id_exam').val({{$value->id}}),$('#for_diagnos_exam').val(this.text),$('#to_diagnos_exam').css('display','none')" style="display:block;" class="pt-1 pl-2 float-left">{{ $value->first_name }} {{ $value->last_name }} {{ $value->full_name }} ({{ $value->pinfl }}) ({{ $value->patient_back }})</a>
                                       </div>
                                    </div>

                                    @endforeach
                                 </div>
                              </div>
                              @elseif($count_exam == 0)
                               @endif
                           @endisset
                           @endif
                           <div class="col-md-5">
                              <div class="checkbox col-md-12">
                                 <label>
                                    <h6>{{__('app.complaints')}}:e</h6>
                                 </label>
                              </div>
                              <div class="col-md-6">
                                 <div class="checkbox col-md-12">
                                    <label>
                                    <input type="checkbox" name="pain" value="app.pain" /> {{__('app.pain')}}
                                    </label>
                                 </div>
                                 <div class="checkbox col-md-12">
                                    <label>
                                    <input type="checkbox" name="dyspnea" value="app.dyspnea" /> {{__('app.dyspnea')}}
                                    </label>
                                 </div>
                                 <div class="checkbox col-md-12">
                                    <label>
                                    <input type="checkbox" name="sweat" value="app.sweat" /> {{__('app.sweat')}}
                                    </label>
                                 </div>
                                 <div class="checkbox col-md-12">
                                    <label>
                                    <input type="checkbox" name="weakness" value="app.weakness" /> {{__('app.weakness')}}
                                    </label>
                                 </div>
                                 <div class="checkbox col-md-12">
                                    <label>
                                    <input type="checkbox" name="cough" value="app.cough" /> {{__('app.cough')}}
                                    </label>
                                 </div>
                                 <div class="col-md-12 mb-3">
                                    <label>
                                    <input type="checkbox" name="check_other2" value="app.other" id="check_other2"/> {{__('app.other')}}
                                    </label>
                                    <input type="text" name="check_other2_e" style="border: none;border-bottom:solid 1px black;display:none;" class="ml-2" id="other2"/>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-7">
                              <div class="col-md-12">
                                 <div class="row">
                                    <label class="col-md-4"> {{__('app.ad')}} </label>
                                    <div class="form-group col-md-6">
                                       <input type="text" name="ad" id="davleniya" style="border:solid 1px #ddd;padding:5px 5px;" class="ml-2 w-100 rounded" required/>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="row">
                                    <label class="col-md-4"> {{__('app.pulse')}} </label>
                                    <div class="form-group col-md-6">
                                       <input type="text" name="pulse" style="border:solid 1px #ddd;padding:5px 5px;" class="ml-2 w-100 rounded" required/>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="row">
                                    <label class="col-md-4"> {{__('app.rate')}} </label>
                                    <div class="form-group col-md-6">
                                       <input type="text" name="rate" style="border:solid 1px #ddd;padding:5px 5px;" class="ml-2 w-100 rounded" required/>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="row">
                                    <label class="col-md-4"> {{__('app.saturation')}} </label>
                                    <div class="form-group col-md-6">
                                       <input type="text" name="saturation" style="border:solid 1px #ddd;padding:5px 5px;" class="ml-2 w-100 rounded" required/>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                           @isset($count_exam)
                               @if($count_exam == 0)
                                  
                               @else
                                  
                           <div class="mt-4 ml-auto mr-2">
                              <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                          </div>
                               @endif

                           @endisset
                        </div>
                     </form>
                   </div>
                   @endisset

                   @isset(Session::get('per')['p_ekg_create'])
                   <div @if (Session::get('success') == 'exam_updated') class="tab-pane show active mt-3" @else class="tab-pane" @endif id="solid-justified-tab4">
                     <form action="{{ route('ekg.store') }}" method="POST" autocomplete="off">
                        @csrf
                     <div class="row">
                        @if (Session::get('success') == 'exam_updated')
                           <div class="col-md-6 container-fluid">
                              <input type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" value="{{ Session::get('patient')->id }}" />
                           </div>

                           <div class="form-group col-md-6 container-fluid">
                              <input type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="{{ Session::get('patient')->first_name }} {{ Session::get('patient')->last_name }} {{ Session::get('patient')->full_name }} ({{ Session::get('patient')->pinfl }})" readonly/>
                           </div>
                           @else
                        @isset($count_ekg)
                               @if($count_ekg == 1)
                               <div class="col-md-6 container-fluid">
                                 <input type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" value="{{ $ekg[0]->id }}" />
                              </div>
   
                              <div class="form-group col-md-6 container-fluid">
                                 <input type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="{{ $ekg[0]->first_name }} {{ $ekg[0]->last_name }} {{ $ekg[0]->full_name }} ({{ $ekg[0]->pinfl }})" readonly/>
                              </div>
                               @elseif($count_ekg > 1)
                               <div class="col-md-6 container-fluid">
                                 <input id="for_id_ekg" type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" />
                              </div>
   
                              <div class="form-group col-md-6 container-fluid">
                                 <input id="for_diagnos_ekg" onmouseleave="$('#to_diagnos_ekg').css('display','none')" onmouseenter="$('#to_diagnos_ekg').css('display','')" type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" onkeyup="filterFunctionEkg()" required/>
                                 
                                 <div style="border:1px solid #ddd;display:none;"  class="ml-3 ml-auto rounded" onmouseleave="$(this).css('display','none')" id="to_diagnos_ekg">
                                    @foreach($ekg as $key => $value)
                                    <div class="row">
                                       <div class="col-md-12">
                                          
                                    <a href="#" id="for_diagnos_ekg" onmouseleave="$('#to_diagnos_ekg').css('display','none')" onmouseenter="$('#to_diagnos_ekg').css('display','')" onclick="$('#for_id_ekg').val({{$value->id}}),$('#for_diagnos_ekg').val(this.text),$('#to_diagnos_ekg').css('display','none')" style="display:block;" class="pt-1 pl-2 float-left">{{ $value->first_name }} {{ $value->last_name }} {{ $value->full_name }} ({{ $value->pinfl }}) ({{ $value->patient_back }})</a>
                                       </div>
                                    </div>

                                    @endforeach
                                 </div>
                              </div>
                              @elseif($count_exam == 0)
                               @endif
                        @endisset
                        @endif
                        <div class="form-group col-md-2">
                           <div class="checkbox col-md-12">
                              <label>
                                 <h6>{{__('app.ritm')}}:</h6>
                              </label>
                           </div>
                           <div class="col-md-12">
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.norma" name="ritm" /> {{__('app.norma')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.sinus" name="ritm" /> {{__('app.sinus')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.fp" name="ritm" /> {{__('app.fp')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.tp" name="ritm" /> {{__('app.tp')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.jt" name="ritm" /> {{__('app.jt')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.fj" name="ritm" required/> {{__('app.fj')}}
                                 </label>
                              </div>
                           </div>
                        </div>
                        <div class="form-group col-md-2">
                           <div class="checkbox col-md-12">
                              <label>
                                 <h6>{{__('app.st')}}:</h6>
                              </label>
                           </div>
                           <div class="col-md-12">
                               <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.norma" name="ritm_st" /> {{__('app.norma')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label id="label_st_1">
                                 <input type="radio" value="app.elevation" name="ritm_st" onclick="rEkg('label_st_1')" required/> {{__('app.elevation')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label id="label_st_2">
                                 <input type="radio" value="app.depression" name="ritm_st" onclick="rEkg('label_st_2')"/> {{__('app.depression')}}
                                 </label>
                              </div>
                           </div>
                        </div>
                        <div class="form-group col-md-2">
                           <div class="checkbox col-md-12">
                              <label>
                                 <h6>{{__('app.zubec_t')}}:</h6>
                              </label>
                           </div>
                           <div class="col-md-12">
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.norma" name="zubec_t" /> {{__('app.norma')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.smoot" name="zubec_t" /> {{__('app.smoot')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.negativ" name="zubec_t" /> {{__('app.negativ')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.pointed" name="zubec_t" required/> {{__('app.pointed')}}
                                 </label>
                              </div>
                           </div>
                        </div>
                        <div class="form-group col-md-2">
                           <div class="checkbox col-md-12">
                              <label>
                                 <h6>{{__('app.zubec_q')}}:</h6>
                              </label>
                           </div>
                           <div class="col-md-12">
                              <label>
                              <input type="radio" value="app.norma" name="zubec_q" /> {{__('app.norma')}}
                              </label>
                           </div>
                           <div class="col-md-12">
                              <label>
                              <input type="radio" value="app.front_wall" name="zubec_q" /> {{__('app.front_wall')}}
                              </label>
                           </div>
                           <div class="col-md-12">
                              <label>
                              <input type="radio" value="app.lateral_wall" name="zubec_q" /> {{__('app.lateral_wall')}}
                              </label>
                           </div>
                           <div class="col-md-12">
                              <label>
                              <input type="radio" value="app.bottom_wall" name="zubec_q" required/> {{__('app.bottom_wall')}}
                              </label>
                           </div>
                        </div>
                        <div class="form-group col-md-2">
                           <div class="checkbox col-md-12">
                              <label>
                                 <h6>{{__('app.blockade')}}:</h6>
                              </label>
                           </div>
                           <div class="col-md-12">
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.norma" name="blockade" /> {{__('app.norma')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.blockade_l" name="blockade" /> {{__('app.blockade_l')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.blockade_p" name="blockade" required/> {{__('app.blockade_p')}}
                                 </label>
                              </div>
                           </div>
                        </div>
                        <div class="form-group col-md-2">
                           <div class="checkbox col-md-12">
                              <label>
                                 <h6>{{__('app.av_blockade')}}:</h6>
                              </label>
                           </div>
                           <div class="col-md-12">
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.norma" name="av_blockade" /> {{__('app.norma')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.stepen_1" name="av_blockade" /> {{__('app.stepen_1')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.stepen_2" name="av_blockade" /> {{__('app.stepen_2')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.stepen_3" name="av_blockade" required/> {{__('app.stepen_3')}}
                                 </label>
                              </div>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="checkbox col-md-12">
                              <label>
                                 <h6>{{__('app.marker')}}:</h6>
                              </label>
                           </div>
                           <div class="col-md-12">
                              <div class="col-md-12 mb-3">
                                 <div class="row">
                                    <label class="col-md-2" id="for_troponin_t"><input type="radio" value="app.troponin_t" name="ekg_marker" onclick="rMarker('for_troponin_t')"/> {{__('app.troponin_t')}}</label>
                                 </div>
                              </div>
                              <div class="col-md-12 mb-3">
                                 <div class="row">
                                    <label class="col-md-2" id="for_troponin_i"><input type="radio" value="app.troponin_i" name="ekg_marker" onclick="rMarker('for_troponin_i')"/> {{__('app.troponin_i')}}</label>
                                 </div>
                              </div>
                              <div class="col-md-12 mb-3">
                                 <div class="row">
                                    <label class="col-md-2" id="for_kfk"><input type="radio" value="app.kfk" name="ekg_marker" onclick="rMarker('for_kfk')"/> {{__('app.kfk')}}</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @isset($count_ekg)
                               @if($count_ekg == 0)
                                  
                               @else
                                  
                           <div class="mt-4 ml-auto mr-2">
                              <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                          </div>
                               @endif

                           @endisset
                     </div>
                     </form>
                   </div>
                   @endisset
                   
                   @isset(Session::get('per')['p_exo_create'])
                   <div @if (Session::get('success') == 'ekg_updated') class="tab-pane show active mt-3" @else class="tab-pane" @endif id="solid-justified-tab5">
                     <form action="{{ route('exo.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                           @if (Session::get('success') == 'ekg_updated')
                           <div class="col-md-6 container-fluid">
                              <input type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" value="{{ Session::get('patient')->id }}" />
                           </div>

                           <div class="form-group col-md-6 container-fluid">
                              <input type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="{{ Session::get('patient')->first_name }} {{ Session::get('patient')->last_name }} {{ Session::get('patient')->full_name }} ({{ Session::get('patient')->pinfl }})" readonly/>
                           </div>
                           @else
                           @isset($count_exo)
                                 @if($count_exo == 1)
                                 <div class="col-md-6 container-fluid">
                                    <input type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" value="{{ $exo[0]->id }}" />
                                 </div>
      
                                 <div class="form-group col-md-6 container-fluid">
                                    <input type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="{{ $exo[0]->first_name }} {{ $exo[0]->last_name }} {{ $exo[0]->full_name }} ({{ $exo[0]->pinfl }})" readonly/>
                                 </div>
                                 @elseif($count_exo > 1)
                                 <div class="col-md-6 container-fluid">
                                    <input id="for_id_exo" type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" />
                                 </div>
      
                                 <div class="form-group col-md-6 container-fluid">
                                    <input id="for_diagnos_exo" onmouseleave="$('#to_diagnos_exo').css('display','none')" onmouseenter="$('#to_diagnos_exo').css('display','')" type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" onkeyup="filterFunctionExo()" required/>
                                    
                                    <div style="border:1px solid #ddd;display:none;"  class="ml-3 ml-auto rounded" onmouseleave="$(this).css('display','none')" id="to_diagnos_exo">
                                       @foreach($exo as $key => $value)
                                       <div class="row">
                                          <div class="col-md-12">
                                             
                                       <a href="#" id="for_diagnos_exo" onmouseleave="$('#to_diagnos_exo').css('display','none')" onmouseenter="$('#to_diagnos_exo').css('display','')" onclick="$('#for_id_exo').val({{$value->id}}),$('#for_diagnos_exo').val(this.text),$('#to_diagnos_exo').css('display','none')" style="display:block;" class="pt-1 pl-2 float-left">{{ $value->first_name }} {{ $value->last_name }} {{ $value->full_name }} ({{ $value->pinfl }}) ({{ $value->patient_back }})</a>
                                          </div>
                                       </div>

                                       @endforeach
                                    </div>
                                 </div>
                                 @elseif($count_exam == 0)
                                 @endif
                           @endisset
                           @endif
                        <div class="col-md-12">
                           <div class="col-md-12 mb-3 ml-3">
                                 <div class="row">
                                    <label class="col-md-2">{{__('app.kdo')}}</label>
                                    <div class="form-group col-md-6">
                                    <input type="text" name="kdo" style="border:solid 1px #ddd;padding:5px 5px;" class="ml-2 w-100 rounded" required/>
                                    </div>
                                 </div>
                           </div>
                           <div class="col-md-12 mb-3 ml-3">
                                 <div class="row">
                                    <label class="col-md-2">{{__('app.kso')}}</label>
                                    <div class="form-group col-md-6">
                                    <input type="text" name="kso" style="border:solid 1px #ddd;padding:5px 5px;" class="ml-2 w-100 rounded" required/>
                                    </div>
                                 </div>
                           </div>
                           <div class="col-md-12 mb-3 ml-3">
                                 <div class="row">
                                    <label class="col-md-2">{{__('app.uo')}}</label>
                                    <div class="form-group col-md-6">
                                    <input type="text" name="uo" style="border:solid 1px #ddd;padding:5px 5px;" class="ml-2 w-100 rounded" required/>
                                    </div>
                                 </div>
                           </div>
                           <div class="col-md-12 mb-3 ml-3">
                                 <div class="row">
                                    <label class="col-md-2">{{__('app.fb')}}</label>
                                    <div class="form-group col-md-6">
                                    <input type="text" name="fb" style="border:solid 1px #ddd;padding:5px 5px;" class="ml-2 w-100 rounded" required/>
                                    </div>
                                 </div>
                           </div>
                        </div>
                        {{-- <div class="row"> --}}
                        <div class="form-group col-md-6">
                           <div class="col-md-12">
                                 <label><h6>{{__('app.kinetika')}}:</h6></label>
                           </div>
                           <div class="form-group col-md-12">
                                 <div class="col-md-12">
                                    <div class="col-md-12">
                                       <label>
                                       <input type="radio" value="app.norma" name="exo_kinetik" onclick="rKinetika('none_label')"/> {{__('app.norma')}}
                                       </label>
                                    </div>
                                    <div class="col-md-12">
                                       <label id="label_gipokinez">
                                       <input type="radio" value="app.gipokinez" name="exo_kinetik" onclick="rKinetika('label_gipokinez')"/> {{__('app.gipokinez')}}
                                       </label>
                                    </div>
                                    <div class="col-md-12">
                                       <label id="label_akinez">
                                       <input type="radio" value="app.akinez" name="exo_kinetik" onclick="rKinetika('label_akinez')"/> {{__('app.akinez')}}
                                       </label>
                                    </div>
                                    <div class="col-md-12">
                                       <label id="label_diskinez">
                                       <input type="radio" value="app.diskinez" name="exo_kinetik" onclick="rKinetika('label_diskinez')" required/> {{__('app.diskinez')}}
                                       </label>
                                    </div>
                                 </div>
                           </div>
                        </div>
                        <div class="form-group col-md-6">
                           <div class="col-md-12">
                                 <label><h6>{{__('app.klapan')}}:</h6></label>
                           </div>
                           <div class="form-group col-md-12">
                                 <div class="col-md-12">
                                    <div class="col-md-12">
                                       <label>
                                       <input type="radio" value="app.nak" name="klapan"/> {{__('app.nak')}}
                                       </label>
                                    </div>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="col-md-12">
                                       <label>
                                       <input type="radio" value="app.nmk" name="klapan"/> {{__('app.nmk')}}
                                       </label>
                                    </div>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="col-md-12">
                                       <label>
                                       <input type="radio" value="app.ntk" name="klapan"/> {{__('app.ntk')}}
                                       </label>
                                    </div>
                                 </div>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="col-md-12">
                                 <label>
                                 <input type="checkbox" name="app.other" id="check_other3"/> {{__('app.other')}}
                                 </label>
                                 <input type="text" name="other_exo" style="border: none;border-bottom:solid 1px black;display:none" class="ml-2 w-50" id="other3"/>
                           </div>
                        </div>
                        @isset($count_exo)
                        @if($count_exo == 0)
                           
                        @else
                        <div class="mt-4 ml-auto mr-2">
                           <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                     </div>
                        
                        @endif

                           @endisset
                        </div>
                     </form>
                   </div>
                   @endisset

                   @isset(Session::get('per')['p_treatment_create'])
                   <div @if (Session::get('success') == 'exo_updated') class="tab-pane show active mt-3" @else class="tab-pane" @endif id="solid-justified-tab6">
                     <form action="{{ url('patient/store_treatment') }}" method="POST" autocomplete="off">
                        @csrf
                          <div class="row">
                             @if (Session::get('treatment') !== null)
                                 
                             @else
                             @if (Session::get('success') == 'exo_updated')
                             <div class="col-md-6 container-fluid">
                                <input type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" value="{{ Session::get('patient')->id }}" />
                             </div>
  
                             <div class="form-group col-md-6 container-fluid">
                                <input type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="{{ Session::get('patient')->first_name }} {{ Session::get('patient')->last_name }} {{ Session::get('patient')->full_name }} ({{ Session::get('patient')->pinfl }})" readonly/>
                             </div>
                             @else
                             @isset($count_treatment)
                             @if($count_treatment == 1)
                             <div class="col-md-6 container-fluid">
                               <input type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" value="{{ $treatment[0]->id }}" />
                            </div>
  
                            <div class="form-group col-md-6 container-fluid">
                               <input type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="{{ $treatment[0]->first_name }} {{ $treatment[0]->last_name }} {{ $treatment[0]->full_name }} ({{ $treatment[0]->pinfl }})" readonly/>
                            </div>
                             @elseif($count_treatment > 1)
                             <div class="col-md-6 container-fluid">
                               <input id="for_id_treatment" type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" />
                            </div>
  
                            <div class="form-group col-md-6 container-fluid">
                               <input id="for_diagnos_treatment" onmouseleave="$('#to_diagnos_treatment').css('display','none')" onmouseenter="$('#to_diagnos_treatment').css('display','')" type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" onkeyup="filterFunctionTreatment()" required/>
                               
                               <div style="border:1px solid #ddd;display:none;"  class="ml-3 ml-auto rounded" onmouseleave="$(this).css('display','none')" id="to_diagnos_treatment">
                                  @foreach($treatment as $key => $value)
                                  <div class="row">
                                     <div class="col-md-12">
                                        
                                  <a href="#" id="for_diagnos_treatment" onmouseleave="$('#to_diagnos_treatment').css('display','none')" onmouseenter="$('#to_diagnos_treatment').css('display','')" onclick="$('#for_id_treatment').val({{$value->id}}),$('#for_diagnos_treatment').val(this.text),$('#to_diagnos_treatment').css('display','none')" style="display:block;" class="pt-1 pl-2 float-left">{{ $value->first_name }} {{ $value->last_name }} {{ $value->full_name }} ({{ $value->pinfl }}) ({{ $value->patient_back }})</a>
                                     </div>
                                  </div>
  
                                  @endforeach
                               </div>
                            </div>
                             @endif
                             @endisset
                             @endif
                             @endif
                            <div class="form-group col-md-6">
                               <div class="col-md-12">
                                    <div class="col-md-12">
                                       <label>
                                       <input type="radio" value="app.chkb" name="lech" id="check_lech"/> {{__('app.chkb')}}:
                                       </label>
                                       <div id="lech" style="display:none">
                                           <div class="col-md-12">
                                               <label>
                                               <input type="radio" value="app.dostup" name="dostup" id="check_dostup"/> {{__('app.dostup')}}:
                                               </label>
                                               <div id="dostup" style="display:none">
                                                   <div class="col-md-12">
                                                       <label id="label_radial">
                                                       <input type="radio" value="app.radial" name="chkb_dostup" onclick="rChkb('label_radial')"/> {{__('app.radial')}}:
                                                       </label>
                                                    </div>
                                                    <div class="col-md-12">
                                                       <label id="label_plech">
                                                       <input type="radio" value="app.plech" name="chkb_dostup" onclick="rChkb('label_plech')"/> {{__('app.plech')}}:
                                                       </label>
                                                    </div>
                                                    <div class="col-md-12">
                                                       <label id="label_bedren">
                                                       <input type="radio" value="app.bedren" name="chkb_dostup" onclick="rChkb('label_bedren')"/> {{__('app.bedren')}}:
                                                       </label>
                                                    </div>
                                                    <div class="col-md-12">
                                                       <label id="drg_dostup">
                                                       <input type="radio" name="chkb_dostup" onclick="rChkb('drg_dostup')"/> {{__('app.drg')}}
                                                       </label>
                                                       
                                                    </div>
                                                    {{-- <div class="col-md-12">
                                                       <label>
                                                       <input type="checkbox" value="app.syntax" name="syntax"/> {{__('app.syntax')}}
                                                       </label>
                                                    </div> --}}
                                                    <div class="checkbox col-md-12">
                                                       <label id="label_iv">
                                                       <input type="radio" value="app.iv" name="chkb_dostup" onclick="rChkb('label_iv')"/> {{__('app.iv')}}:
                                                       </label>
                                                    </div>
                                                    <div class="checkbox col-md-12">
                                                       <label>
                                                       <input type="radio" value="app.oslo" name="oslo" id="check_oslo"/> {{__('app.oslo')}}:
                                                       </label>
                                                       <div id="oslo" style="display:none">
                                                           <div class="checkbox col-md-12">
                                                               <label>
                                                               <input type="checkbox" value="app.fj" name="ch_fj" /> {{__('app.fj')}}
                                                               </label>
                                                            </div>
                                                            <div class="checkbox col-md-12">
                                                               <label>
                                                               <input type="checkbox" value="app.otek" name="ch_otek" /> {{__('app.otek')}}
                                                               </label>
                                                            </div>
                                                            <div class="checkbox col-md-12">
                                                               <label>
                                                               <input type="checkbox" value="app.kard" name="ch_kard" /> {{__('app.kard')}}
                                                               </label>
                                                            </div>
                                                            <div class="checkbox col-md-12">
                                                               <label>
                                                               <input type="checkbox" value="app.perf" name="ch_perf" /> {{__('app.perf')}}
                                                               </label>
                                                            </div>
                                                            <div class="checkbox col-md-12">
                                                               <label>
                                                               <input type="checkbox" value="app.trom" name="ch_trom" /> {{__('app.trom')}}
                                                               </label>
                                                            </div>
                                                            <div class="checkbox col-md-12">
                                                               <label>
                                                               <input type="checkbox" value="app.reflow" name="ch_reflow" /> {{__('app.reflow')}}
                                                               </label>
                                                            </div>
                                                            <div class="checkbox col-md-12">
                                                               <label>
                                                               <input type="checkbox" value="app.bloka" name="ch_bloka" /> {{__('app.bloka')}}
                                                               </label>
                                                            </div>
                                                            <div class="checkbox col-md-12">
                                                               <label>
                                                               <input type="checkbox" value="app.drgg" name="checkbox" id="check_drgg"/> {{__('app.drgg')}}
                                                               </label>
                                                               <input type="text" name="check_drgg" style="border: none;border-bottom:solid 1px black;display:none" class="ml-2 w-50" id="drgg"/>
                                                            </div>
                                                       </div>
                                                    </div>
                                               </div>
                                            </div>
                                       </div>
                                    </div>
                               </div>
                            </div>
                            <div class="form-group col-md-6">
                               <div class="col-md-12">
                                   <div class="col-md-12">
                                   <label>
                                   <input type="radio" value="app.tlt" name="lech" id="check_tlt"/> {{__('app.tlt')}}:
                                   </label>
                                   <div id="tlt" style="display:none">
                                       <div class="col-md-12">
                                           <label>
                                           <input type="radio" value="app.strep" name="chkb_tlt" id="check_strep"/> {{__('app.strep')}}:
                                           </label>
                                           <div id="strep" style="display:none">
                                               <div class="col-md-12">
                                                   <label>
                                                   <input type="checkbox" value="app.oslo" name="t_oslo" id="check_oslo2"/> {{__('app.oslo')}}:
                                                   </label>
                                                   <div id="oslo2" style="display:none">
                                                       <div class="checkbox col-md-12">
                                                           <label>
                                                           <input type="checkbox" value="app.fj" name="t_fj" /> {{__('app.fj')}}
                                                           </label>
                                                        </div>
                                                        <div class="checkbox col-md-12">
                                                           <label>
                                                           <input type="checkbox" value="app.otek" name="t_otek" /> {{__('app.otek')}}
                                                           </label>
                                                        </div>
                                                        <div class="checkbox col-md-12">
                                                           <label>
                                                           <input type="checkbox" value="app.kard" name="t_kard" /> {{__('app.kard')}}
                                                           </label>
                                                        </div>
                                                        <div class="checkbox col-md-12">
                                                           <label>
                                                           <input type="checkbox" value="app.aritm" name="t_aritm" /> {{__('app.aritm')}}
                                                           </label>
                                                        </div>
                                                   </div>
                                                </div>
                                           </div>
                                        </div>
                                        <div class="col-md-12">
                                           <label>
                                           <input type="radio" value="app.aktil" name="chkb_tlt" id="check_strep"/> {{__('app.aktil')}}
                                           </label>
                                        </div>
                                        <div class="col-md-12">
                                           <label>
                                           <input type="radio" value="app.drg" name="chkb_tlt" id="check_drg2"/> {{__('app.drg')}}
                                           </label>
                                           <input type="text" name="check_drg2_t" style="border: none;border-bottom:solid 1px black;display:none" class="ml-2 w-50" id="drg2"/>
                                        </div>
                                   </div>
                                   </div>
                                </div>
                            </div>
                            @isset($count_treatment)
                               @if($count_treatment == 0)
                                  
                               @else
                                  
                                    <div class="mt-4 ml-auto mr-2">
                                       <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                                 </div>
                               @endif

                           @endisset
                          </div>
                     </form>
                   </div>
                   @endisset

          </div>
       </div>
    </div>
</div>
        </div>
    </div>
</body>
<script type="text/javascript" src="{{asset('/assets/js/jquery-3.6.0.min.js')}}"></script>

 <script type="text/javascript" src="{{asset('/assets/js/bootstrap.bundle.min.js')}}"></script>

 <script type="text/javascript" src="{{asset('/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

 <script type="text/javascript" src="{{asset('/assets/plugins/apexchart/apexcharts.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('/assets/plugins/apexchart/dsh-apaxcharts.js')}}"></script>

 <script type="text/javascript" src="{{asset('/assets/plugins/simple-calendar/jquery.simple-calendar.js')}}"></script>
 
 <script type="text/javascript" src="{{asset('/assets/js/calander.js')}}"></script>

 <script type="text/javascript" src="{{asset('/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('/assets/plugins/datatables/datatables.min.js')}}"></script>


 <script type="text/javascript" src="{{ asset('/assets/js/script.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/js/jquery.maskedinput.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/js/mask.js') }}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>



<script type="text/javascript" src="{{ asset('/dash_assets/daterangepicker.js') }}"></script>
<script>
   $(function() {
     $('input[name="case_date"]').daterangepicker({
       timePicker: true,
       timePicker24Hour: true,
       singleDatePicker: true,
       showDropdowns: true,
       minYear: 1901,
       "drops": "up"
      //  maxYear: parseInt(moment().format('DD.MM.YYYY'))
     }, function(start, end, label) {
      //  var years = moment().diff(start, 'years');
     });
     $('input[name="case_date"]').on('apply.daterangepicker', function(ev, picker) {
        // $(this).val(picker.startDate.format('DD.MM.YYYY') + ' - ' + picker.endDate.format('DD.MM.YYYY'));
        $('input[name="case_date"]').val(picker.startDate.format('DD.MM.YYYY HH:mm'));
        oneFunction(picker.startDate.format('DD.MM.YYYY'));
        // var date_ses = picker.startDate.format('DD.MM.YYYY');



    });
   });
   </script>
 <script>
    
    $("input[name=pinfl]").keyup(function(){
      // event.preventDefault();

      let name = $("input[name=pinfl]").val();
      let _token   = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        url: "/patient/pinfl",
        type:"POST",
        data:{
          name:name,
          _token: _token
        },
        success:function(response){
          if(response) {
            var p_back = response.patient_back
            $("input[name=patient_back]").val(p_back);
             if(response.count >= 1)
             {
            var id = response.patient[0].id;
               // window.location.href = "{{ route('patient.show','" + id + "')}}";

             $('#back_patient').css('display','')
             $('#back_patient').delay(5000).fadeOut();
               //  $('#success').text(response.success);
            $("input[name=last_name]").val(response.patient[0].last_name);
            $("input[name=first_name]").val(response.patient[0].first_name);
            $("input[name=full_name]").val(response.patient[0].full_name);
            $("input[name=passport]").val(response.patient[0].passport.toUpperCase());
            $("input[name=phone]").val(response.patient[0].phone);
            var date = response.patient[0].birth_day;
            var newDateTime = moment(date, "YYYY-MM-DD").format('DD.MM.YYYY');
            $("input[name=birth_date]").val(newDateTime);

            var patient_date = $("#date").val();
            var patient_year = new Date(patient_date).getFullYear() 
            var current_year = new Date().getFullYear()
            var age = current_year-patient_year;
            $("#age").val(age);
            $("#province").val(response.patient[0].province_id).change();
            $("#place_dist").val(response.patient[0].district_id).change();
            $("input[name=height]").val(response.patient[0].height);
            $("input[name=weight]").val(response.patient[0].weight);
            $("input[name=bmi]").val(response.patient[0].bmi);
            if (response.patient[0].gender == true) {
               // $("#gender_male").attr('checked', 'checked');
               $('input[name=gender][value=true]').attr('checked', true); 

               
            } else {
               // $("#gender_female").attr('checked', 'checked');
               $('input[name=gender][value=false]').attr('checked', true); 


            }
             }
             else{
               $("input[name=last_name]").val('');
            $("input[name=first_name]").val('');
            $("input[name=full_name]").val('');
            $("input[name=passport]").val('');
            $("input[name=phone]").val('');
            $('#back_patient').css('display','none')
            $("input[name=birth_date]").val('');
            $("#age").val('');
            $("#province").val('').change();
            $("#place_dist").val('').change();
            $("input[name=height]").val('');
            $("input[name=weight]").val('');
            $("input[name=bmi]").val('');
            // $("#gender_male").attr('checked', false);
            $('input[name=gender][value=true]').attr('checked', false); 

            // $("#gender_female").attr('checked', false);
            $('input[name=gender][value=false]').attr('checked', false); 


               }
           
          }
        },
        error: function(error) {
         console.log(error);
        }
       });
  });
    $(document).ready(function(){
        $("#rost").keyup(function(){
            var rost = $("#rost").val();
            var ves = $("#ves").val();
            var imt = ves/(rost*rost);
            $("#imt").val(imt.toFixed(2));
        });
        $("#ves").keyup(function(){
            var rost = $("#rost").val();
            var ves = $("#ves").val();
            var imt = ves/(rost*rost);
            $("#imt").val(imt.toFixed(2));
        });
        $("#province").change(function(){
            var province = $("#province").val();
            // alert(province);

            var _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
            url: "/district/get_districts",
            type:"POST",
            data:{
               data:province,
               _token: _token
            },
            success:function(response){
               if(response) {
                  // alert(response.district[0]['id'])
               }
               $("#place_dist").val('');
               $("#for_district").css("display","none");
               $("#district").css("display","");
               // array.forEach(response.district => {
               //    $( "#add_option" ).after( "<option style='display: none' value=''></option>" );
               // });
               $(`#place_dist`).remove();
               $( "#add_select" ).after(`<select class='form-control form-control-sm' name='district_id' id='place_dist' required>
                                 <option value='' disabled selected hidden id='add_option'></option>
                              </select>`);
               $.each(response.district, function(index, value){
                  $( "#add_option" ).after(`<option value='${value.id}' id='province_delete'>${value.district_name}</option>`);
               });
               
               

            },
            error: function(error) {
               console.log(error);
            }
            });
            // if (province) {
            //     var district = {!! json_encode($district->toArray()) !!};
            
            // $.each(district, function(key,val) {
            //     if(province == val['province_id']){
            // $(`#${val['district_name']}${val['province_id']}`).css("display","");


            //     }
            //     else{
            // $(`#${val['district_name']}${val['province_id']}`).css("display","none");

            //     }

            // });
            // }
            
            // $("#place_dist").val('');
            // $("#for_district").css("display","none");
            // $("#district").css("display","");
        });
    });
    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("for_diagnos");
        filter = input.value.toUpperCase();
        div = document.getElementById("to_diagnos");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
        }
        function filterFunctionExam() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("for_diagnos_exam");
        filter = input.value.toUpperCase();
        div = document.getElementById("to_diagnos_exam");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
        }
        function filterFunctionEkg() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("for_diagnos_ekg");
        filter = input.value.toUpperCase();
        div = document.getElementById("to_diagnos_ekg");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
        }
        function filterFunctionExo() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("for_diagnos_exo");
        filter = input.value.toUpperCase();
        div = document.getElementById("to_diagnos_exo");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
        }
        function filterFunctionTreatment() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("for_diagnos_treatment");
        filter = input.value.toUpperCase();
        div = document.getElementById("to_diagnos_treatment");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
        }
        
     function handleClick() {
            $("#add_diagnoz").prop('type', 'submit');
            $("#oks_begin").css("color", "black");
            $('#check_infarct').val('oks_infarct');
        }
        function rDiagnos(label_id)
        {
         $('#rad_oks_pod').remove();
         $(`#${label_id}`).after("<div id='rad_oks_pod'><div class='form-group col-md-12'><div class='col-md-12'><label><h6 id='oks_begin'>{{__('app.oks_begin')}} </h6></label></div><div class='col-md-12'><label><input class='radioR' type='radio' name='time' value='app.begin_3' required/> {{__('app.begin_3')}}</label></div><div class='col-md-12'><label><input class='radioR' type='radio' name='time' value='app.begin_3_6' /> {{__('app.begin_3_6')}}</label></div><div class='col-md-12'><label><input class='radioR' type='radio' name='time' value='app.begin_6_12' /> {{__('app.begin_6_12')}}</label></div><div class='col-md-12'><label><input class='radioR' type='radio' name='time' value='app.begin_12_24' /> {{__('app.begin_12_24')}}</label></div><div class='col-md-12'><label><input class='radioR' type='radio' name='time' value='app.begin_24_72' /> {{__('app.begin_24_72')}}</label></div></div></div>");
        }
        function rEkg(label_st_id)
        {
         $('#for_st').remove();
         $(`#${label_st_id}`).after("<div id='for_st'><div class='col-md-12'><label><input type='radio' value='app.front_wall' name='st' required/> {{__('app.front_wall')}}</label></div><div class='col-md-12'><label><input type='radio' value='app.lateral_wall' name='st' /> {{__('app.lateral_wall')}}</label></div><div class='col-md-12'><label><input type='radio' value='app.bottom_wall' name='st' /> {{__('app.bottom_wall')}}</label></div></div>");
        }
        function rKinetika(label_kinetik)
        {
         $('#for_kinetik').remove();
         $(`#${label_kinetik}`).after("<div id='for_kinetik'><div class='col-md-12'><label><input type='radio' value='app.front_wall' name='kinetik' /> {{__('app.front_wall')}}</label></div><div class='col-md-12'><label><input type='radio' value='app.lateral_wall' name='kinetik' /> {{__('app.lateral_wall')}}</label></div><div class='col-md-12'><label><input type='radio' value='app.bottom_wall' name='kinetik' required/> {{__('app.bottom_wall')}}</label></div></div>");
        }
        function rMarker(label_marker)
        {
         $('#input_marker').remove();
         $(`#${label_marker}`).after("<div class='form-group col-md-6' id='input_marker'><input type='text' name='text_marker' style='border:solid 1px #ddd;padding:5px 5px;' class='ml-2 w-100 rounded' required/></div>");
        }
        function rChkb(label_chkb)
        {
         $('#radial').remove();
         $('#iv').remove();
         $('#delete_drg').remove();

         $(`#${label_chkb}`).after("<div id='radial'><div class='col-md-12'><label><input type='radio' value='app.left' name='r_dostup' /> {{__('app.left')}}</label></div><div class='col-md-12'><label><input type='radio' value='app.right' name='r_dostup' required/> {{__('app.right')}}</label></div></div>");
         if(label_chkb == 'drg_dostup')
         {
            $('#delete_drg').remove();
         $('#iv').remove();
         $('#radial').remove();

         $(`#${label_chkb}`).after("<input type='text' name='check_drg_dostup' style='border: none;border-bottom:solid 1px black;' class='ml-2 w-50' id='delete_drg'/>");
         }
         if(label_chkb == 'label_iv')
         {
            $('#delete_drg').remove();
         $('#radial').remove();
         $('#iv').remove();

         $(`#${label_chkb}`).after("<div id='iv'><div class='col-md-12'><label><input type='radio' value='app.rek' name='chkb_iv' /> {{__('app.rek')}}</label></div><div class='col-md-12'><label><input type='radio' value='app.sten' name='chkb_iv' /> {{__('app.sten')}}</label></div><div class='col-md-12'><label><input type='radio' value='app.trom' name='chkb_iv' required/> {{__('app.trom')}}</label></div></div>");
         }
         
        }
        
        
        
    // function diagnosClick() {
    //     // $('#for_diagnos2').mousedown(function() {
    //         var province = $("#for_diagnos2").text();
    //         $("#for_diagnos").val('');
    //         $("#for_diagnos").val(province);
    //         $("#to_diagnos").css("display","none");
    //     // });
    //     }
    $(document).ready(function(){
        $('#message').delay(500).fadeOut();
      //   $('#back_patient').css('display','');
        // $('#for_diagnos').mouseenter(function() {
        //     $("#to_diagnos").css("display","");
        // });
        
        // $('#for_diagnos').mouseleave(function() {
        //     $("#to_diagnos").css("display","none");

        // });
        // $('#for_diagnos2').mouseenter(function() {
        //     $("#to_diagnos").css("display","");
        // });
        // $('#for_diagnos2').mouseleave(function() {
        //     $("#to_diagnos").css("display","none");
        // });
        $("#rost").keyup(function(){
            var rost = $("#rost").val();
            var ves = $("#ves").val();
            var imt = ves/(rost*rost);
            $("#imt").val(imt.toFixed(2));
        });
        $("#ves").keyup(function(){
            var rost = $("#rost").val();
            var ves = $("#ves").val();
            var imt = ves/(rost*rost);
            $("#imt").val(imt.toFixed(2));
        });
        $("#date").change(function(){
            var patient_date = $("#date").val();
            var patient_year = patient_date.substring(6, patient_date.length);
            var current_year = new Date().getFullYear()
            var age = current_year-patient_year;
            $("#age").val(age);
        });
        $('#check_infarct').click(function() {
            $('#check_infarct').val('');
            $("#infarct").toggle(this.radio);
            $("#add_diagnoz").prop('type', 'button');
        });
        $('#add_diagnoz').click(function() {
            if(!$('#check_infarct').val()){
            $("#oks_begin").css("color", "red");
            }
        });
        $('#check_infarct2').click(function() {
            $("#infarct2").toggle(this.checked);
        });
        $('#check_infarct3').click(function() {
            $("#infarct3").toggle(this.checked);
        });
        $('#check_infarct4').click(function() {
            $("#infarct4").toggle(this.checked);
        });
        $('#check_infarct5').click(function() {
            $("#infarct5").toggle(this.checked);
        });
        $('#check_infarct6').click(function() {
            $("#infarct6").toggle(this.checked);
        });
        $('#check_lech').click(function() {
            $("#lech").toggle(this.radio);
        });
        $('#check_dostup').click(function() {
            $("#dostup").toggle(this.radio);
        });
        $('#check_radial').click(function() {
            $("#radial").toggle(this.checked);
        });
        $('#check_radial2').click(function() {
            $("#radial2").toggle(this.checked);
        });
        $('#check_radial3').click(function() {
            $("#radial3").toggle(this.checked);
        });
        $('#check_iv').click(function() {
            $("#iv").toggle(this.checked);
        });
        $('#check_oslo').click(function() {
            $("#oslo").toggle(this.radio);
        });
        $('#check_oslo2').click(function() {
            $("#oslo2").toggle(this.checked);
        });
        $('#check_other').click(function() {
            $("#other").toggle(this.checked);
        });
        $('#for_troponin_t').click(function() {
            $("#troponin_t").toggle(this.checked);
        });
        $('#for_troponin_i').click(function() {
            $("#troponin_i").toggle(this.checked);
        });
        $('#for_kfk').click(function() {
            $("#kfk").toggle(this.checked);
        });
        $('#check_other2').click(function() {
            $("#other2").toggle(this.checked);
        });
        $('#check_other3').click(function() {
            $("#other3").toggle(this.checked);
        });
        $('#check_drg').click(function() {
            $("#drg").toggle(this.checked);
        });
        $('#check_drg2').click(function() {
            $("#drg2").toggle(this.radio);
        });
        $('#check_drgg').click(function() {
            $("#drgg").toggle(this.checked);
        });
        $('#check_tlt').click(function() {
            $("#tlt").toggle(this.checked);
        });
        $('#check_strep').click(function() {
            $("#strep").toggle(this.radio);
        });
      //   $('#add_data').click(function() {
            
      //    var pinfl = $("input[name=pinfl]").val();
      //    var first_name = $("input[name=first_name]").val();
      //    var last_name = $("input[name=last_name]").val();
      //    var full_name = $("input[name=full_name]").val();
      //    var passport = $("input[name=passport]").val();
      //    var birth_date = $("input[name=birth_date]").val();
      //    var age = $("input[name=age]").val();
      //    var province_id = $("input[name=province_id]").val();
      //    var district_id = $("input[name=district_id]").val();
      //    var height = $("input[name=height]").val();
      //    var weight = $("input[name=weight]").val();
      //    var bmi = $("input[name=bmi]").val();
      //    var gender = $("input[name=gender]").val();
      //    var case_number = $("input[name=case_number]").val();
      //    var case_date = $("input[name=case_date]").val();
      //    var amb = $("input[name=amb]").val();
      //    var _token   = $('meta[name="csrf-token"]').attr('content');

      //    $.ajax({
      //    url: "/patient",
      //    type:"POST",
      //    data:{
      //       data:pinfl,
      //       _token: _token
      //    },
      //    success:function(response){
      //       if(response) {
      //          alert(response.req)
      //       }
      //    },
      //    error: function(error) {
      //       console.log(error);
      //    }
      //    });

      //   });     
        
        $("#for_rad_oks_pod").click(function() {
         
         // $("#rad_oks_pod").toggle(this.radio);
        });

   //      $('#for_rad_oks_pod').click(function() {
   //          $("#rad_oks_pod").toggle(this.radio);
   //          $("#rad_oks_bez_pod").css('display','none');
   //          $("#rad_oks_infarct").css('display','none');
   //          $("#rad_oks_bez_infarct").css('display','none');
   //          $("#rad_angina").css('display','none');
   //          $("input:radio[class*='radioR']").attr("checked", "checked");
   //          $(':radio').each(function() {
   //      names[$(this).attr('name')] = true;
   //  });
   //      });
   //      $('#for_rad_oks_bez_pod').click(function() {
   //          $("#rad_oks_bez_pod").toggle(this.radio);
   //          $("#rad_oks_pod").css('display','none');
   //          $("#rad_oks_infarct").css('display','none');
   //          $("#rad_oks_bez_infarct").css('display','none');
   //          $("#rad_angina").css('display','none');
   //          $("input:radio[name='radio']").removeAttr("checked"); 
   //      });
   //      $('#for_rad_oks_infarct').click(function() {
   //          $("#rad_oks_infarct").toggle(this.radio);
   //          $("#rad_oks_pod").css('display','none');
   //          $("#rad_oks_bez_pod").css('display','none');
   //          $("#rad_oks_bez_infarct").css('display','none');
   //          $("#rad_angina").css('display','none')
   //          $("input:radio[name='radio']").removeAttr("checked"); 
   //      });
   //      $('#for_rad_oks_bez_infarct').click(function() {
   //          $("#rad_oks_bez_infarct").toggle(this.radio);
   //          $("#rad_oks_pod").css('display','none');
   //          $("#rad_oks_bez_pod").css('display','none');
   //          $("#rad_oks_infarct").css('display','none');
   //          $("#rad_angina").css('display','none')
   //          $("input:radio[name='radio']").removeAttr("checked"); 
   //      });
   //      $('#for_rad_angina').click(function() {
   //          $("#rad_angina").toggle(this.radio);
   //          $("#rad_oks_pod").css('display','none');
   //          $("#rad_oks_bez_pod").css('display','none');
   //          $("#rad_oks_infarct").css('display','none');
   //          $("#rad_oks_bez_infarct").css('display','none')
   //          $("input:radio[name='radio']").removeAttr("checked"); 
   //      });

    });
 </script>

</html>
