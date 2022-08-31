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
     {{-- <link href="{{ asset('dash_assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('dash_assets/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('dash_assets/css/feather.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('dash_assets/css/select2.min.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('dash_assets/css/style.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="shortcut icon" type="image/x-icon" href="dash_assets/img/favicon.png" /> --}}

    <link href="{{ asset('/dash_assets/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('/dash_assets/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="shortcut icon" type="image/x-icon" href="dash_assets/img/favicon.png" /> --}}
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/dash_assets/css/bootstrap.min.css') }}" /> --}}

    <link href="{{ asset('/dash_assets/plugins/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/dash_assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">

    {{-- <link href="{{ asset('/dash_assets/plugins/simple-calendar/simple-calendar.css') }}" rel="stylesheet"> --}}

    <link href="{{ asset('/dash_assets/css/feather.css') }}" rel="stylesheet">
    <link href="{{ asset('/dash_assets/css/mobiscroll.javascript.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/dash_assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('/dash_assets/daterangepicker.css') }}" />

  
    <style>
      body {
        user-select: none !important;
      }
  
      a {
        text-decoration: none;
      }
  
      /* .btn-group {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
      }
  
      .dropdown-item {
        font-size: 18px;
      } */
  
      .dropdown__menu {
        display: block !important;
      }
  
      .dropdown__menu {
        position: absolute;
        z-index: 1000;
        display: none;
        min-width: 30rem;
        padding: 0.5rem 0;
        margin-left: -31rem;
        margin-top: -2rem;
        font-size: 1rem;
        /* color: #99a5b1; */
        text-align: left;
        list-style: none;
        background-clip: padding-box;
        background-color: #fff;
        box-shadow: -8px 12px 18px 0 rgb(21 21 62 / 30%);
      }
  
      .dropdown-item:active,
      .dropdown-item:hover {
        background-color: #fff;
        color: #000;
      }
  
      .gender__input,
      .gender__label {
        margin-left: -50px !important;
      }
    </style>
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
        @include('components.login-header');
        {{-- <div class="page-wrapper">
          
        </div> --}}
        <div class="container-fluid" style="margin-top: 5%;">
          <div class="card-body">
              
            <ul class="nav nav-tabs">
              <li class="ms-auto">
                <div class="btn-group" id="dropdownNotClosing">
                  <button type="button dropdown" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" id="chec_select" value="none">Выбрать</button>
                  <div class="dropdown-menu dropdown-menu-left">
                    <div class="dropdown-item" href="#">
                      Пол
                      <div class="dropdown__menu text-center">
                        <input class="dropdown__item" type="checkbox" name="gender[]" id="male" value="male">
                        <label class="me-2" id="male">Male</label>
                        <input class="dropdown__item" type="checkbox" name="gender[]" id="female" value="female">
                        <label class="me-2" id="female">Female</label>
                      </div>
                    </div>
                    <div class="dropdown-item" href="#">
                      Возраст
                      <div class="dropdown__menu text-center">
                        <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect" value="29">
                        <label class="me-3" for="ageselect" id="29">-29</label>
                        <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect2" value="3045">
                        <label class="me-3" for="ageselect2" id="3045">30-45</label>
                        <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect3" value="4655">
                        <label class="me-3" for="ageselect3" id="4655">46-55</label>
                        <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect4" value="5665">
                        <label class="me-3" for="ageselect4" id="5665">56-65</label>
                        <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect5" value="6675">
                        <label class="me-3" for="ageselect5" id="6675">66-75</label>
                        <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect6" value="75">
                        <label class="me-3" for="ageselect6" id="75">75-</label>
                      </div>
                    </div>
                    <div class="dropdown-item" href="#">
                      Госпитализация
                      <div class="dropdown__menu text-center">
                        <input class="dropdown__item" type="checkbox" name="skori[]" value="samotek">
                        <label class="me-2" id="samotek">Самотек</label>
                        <input class="dropdown__item" type="checkbox" name="skori[]" value="skori">
                        <label class="me-2" id="skori">Скорой</label>
                      </div>
                    </div>
                    <div class="dropdown-item" href="#">
                      Заболевания
                      <div class="dropdown__menu text-center">
                        <input class="dropdown__item" type="checkbox" name="illness[]" value="ag">
                        <label class="me-2" id="ag">АГ</label>
                        <input class="dropdown__item" type="checkbox" name="illness[]" value="sdtip">
                        <label class="me-2" id="sdtip">СД II тип</label>
                        <input class="dropdown__item" type="checkbox" name="illness[]" value="ojireniya">
                        <label class="me-2" id="ojireniya">Ожирение</label>
                        <input class="dropdown__item" type="checkbox" name="illness[]" value="giper">
                        <label class="me-2" id="giper">Гиперлипедемия</label>
                      </div>
                    </div>
                    <div class="dropdown-item" href="#">
                      Лечение
                      <div class="dropdown__menu text-center">
                        <input class="dropdown__item" type="checkbox" name="lech[]" value="chkb">
                        <label class="me-2" id="chkb">ЧКВ</label>
                        <input class="dropdown__item" type="checkbox" name="lech[]" value="tlt">
                        <label class="me-2" id="tlt">ТЛТ</label>
                      </div>
                    </div>
                    <div class="dropdown-item" href="#">
                      Исход
                      <div class="dropdown__menu text-center">
                        <input class="dropdown__item" type="checkbox" name="exit[]" value="live">
                        <label class="me-2" id="live">Выздоровление</label>
                        <input class="dropdown__item" type="checkbox" name="exit[]" value="death">
                        <label class="me-2" id="death">Летальный исход</label>
                      </div>
                    </div>
                    <div>
                    <button style="margin-left: 5rem" class="btn btn-rounded btn-outline-primary btn-sm" type="button" id="get_check" onclick="checkFunction()">Submit</button>
                    </div>
                  </div>
                </div>
                {{-- <div class="btn-group" id="datefilter"> --}}
                  <div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" id="age_button" value="a_all"><i class="fas fa-hourglass-end"></i> Все </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    {{-- <a class="dropdown-item" href="#" onclick="dateChart('a_today')" id="a_today"><i class="fas fa-calendar-check"></i> Сегодня </a> --}}
                    <a class="dropdown-item" href="#" onclick="dateChart('a_week')" id="a_week"><i class="fas fa-calendar-check"></i> Неделя </a>
                    <a class="dropdown-item" href="#" onclick="dateChart('a_month')" id="a_month"><i class="fas fa-calendar-check"></i> Месяц </a>
                    <a class="dropdown-item" href="#" onclick="dateChart('a_year')" id="a_year"><i class="fas fa-calendar-check"></i> Год </a>
                    <a class="dropdown-item" href="#" onclick="dateChart('a_all')" id="a_all"><i class="fas fa-calendar-check"></i> Все </a>
                  </div>
                </div>
              </li>
            </ul>
            
            {{-- <div class="tab-content"> --}}
              {{-- <div class="tab-pane show active" title="all_count" id="solid-rounded-tab1">
                <div id="all_count"></div>
              </div>
              <div class="tab-pane" id="solid-rounded-tab2">
                <div id="pol_count"></div>
              </div> --}}
              {{-- <div class="tab-pane" id="solid-rounded-tab3">
                <div id="age_count"></div>
              </div> --}}
              {{-- <div class="tab-pane" id="solid-rounded-tab4">
                <div id="come_count"></div>
              </div> --}}
              {{-- <div class="tab-pane" id="solid-rounded-tab5">
                <div id="dia_count"></div>
              </div> --}}
              {{-- <div class="tab-pane" id="solid-rounded-tab6">
                <div id="ill_count"></div>
              </div> --}}
            {{-- </div> --}}
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card bg-white">
                 {{-- <div class="card-header">
                    <h5 class="card-title">Sizing </h5>
                 </div> --}}
                 <div class="card-body">
                  <div id="pol_one_id"></div>
                  <div id="pol_one"></div>
                 </div>
              </div>
           </div>
            <div class="col-md-6">
              <div class="card bg-white">
                 <div class="card-body">
                  <div class="tab-pane" id="solid-rounded-tab1">
                    <div id="all_count">
                    </div>
                  </div>
                 </div>
              </div>
           </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card bg-white">
                 <div class="card-body">
                  <div id="pol_one_id"></div>
                  <div id="pol_one"></div>
                 </div>
              </div>
           </div>
            <div class="col-md-6">
              <div class="card bg-white">
                 <div class="card-body">
                  <div class="tab-pane" id="solid-rounded-tab2">
                    <div id="pol_count"></div>
                  </div>
                 </div>
              </div>
           </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card bg-white">
                 <div class="card-body">
                  <div id="pol_one_id"></div>
                  <div id="pol_one"></div>
                 </div>
              </div>
           </div>
            <div class="col-md-6">
              <div class="card bg-white">
                 <div class="card-body">
                  <div class="tab-pane" id="solid-rounded-tab3">
                    <div id="age_count"></div>
                  </div>
                 </div>
              </div>
           </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card bg-white">
                 <div class="card-body">
                  <div id="pol_one_id"></div>
                  <div id="pol_one"></div>
                 </div>
              </div>
           </div>
            <div class="col-md-6">
              <div class="card bg-white">
                 <div class="card-body">
                  <div class="tab-pane" id="solid-rounded-tab4">
                    <div id="come_count"></div>
                  </div>
                 </div>
              </div>
           </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card bg-white">
                 <div class="card-body">
                  <div id="pol_one_id"></div>
                  <div id="pol_one"></div>
                 </div>
              </div>
           </div>
            <div class="col-md-6">
              <div class="card bg-white">
                 <div class="card-body">
                  <div class="tab-pane" id="solid-rounded-tab5">
                    <div id="dia_count"></div>
                  </div>
                 </div>
              </div>
           </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card bg-white">
                 <div class="card-body">
                  <div id="pol_one_id"></div>
                  <div id="pol_one"></div>
                 </div>
              </div>
           </div>
            {{-- <div class="col-md-6">
              <div class="card bg-white">
                 <div class="card-body">
                  <div class="tab-pane" id="solid-rounded-tab6">
                    <div id="ill_count"></div>
                  </div>
                 </div>
              </div>
           </div> --}}
          </div>
        </div>
        <div class="container-fluid" style="margin-top: 5%;">
          <div class="card bg-white">
            <div class="card-header">
              <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded" style="background-color:white !important;">
                <li class="nav-item"  onclick="tabFunction('all_count')"><a class="nav-link active" href="#solid-rounded-tab1" data-toggle="tab"><i class="fas fa-home"></i> Количество пациентов
                  </a></li>
                <li class="nav-item" onclick="tabFunction('pol_count')">
                  <a class="nav-link" href="#solid-rounded-tab2" data-toggle="tab"><i class="fas fa-user-alt"></i> Пол
                  </a>
                </li>
                <li class="nav-item" onclick="tabFunction('age_count')"><a class="nav-link" href="#solid-rounded-tab3" data-toggle="tab"><i class="fas fa-envelope"></i> Возраст
                  </a></li>
                  <li class="nav-item" onclick="tabFunction('come_count')"><a class="nav-link" href="#solid-rounded-tab4" data-toggle="tab"><i class="fas fa-envelope"></i> Госпитализация
                  </a></li>
                  <li class="nav-item" onclick="tabFunction('dia_count')"><a class="nav-link" href="#solid-rounded-tab5" data-toggle="tab"><i class="fas fa-envelope"></i> Сопутствующие заболевания
                  </a></li>
                  <li class="nav-item" onclick="tabFunction('ill_count')"><a class="nav-link" href="#solid-rounded-tab6" data-toggle="tab"><i class="fas fa-envelope"></i> Лечение
                  </a></li>
              </ul>
            </div>
            <div class="card-body">
              
              <ul class="nav nav-tabs">
                <li class="ms-auto">
                  <div class="btn-group" id="dropdownNotClosing">
                    <button type="button dropdown" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false" id="chec_select" value="none">Выбрать</button>
                    <div class="dropdown-menu dropdown-menu-left">
                      <div class="dropdown-item" href="#">
                        Пол
                        <div class="dropdown__menu text-center">
                          <input class="dropdown__item" type="checkbox" name="gender[]" id="male" value="male">
                          <label class="me-2" id="male">Male</label>
                          <input class="dropdown__item" type="checkbox" name="gender[]" id="female" value="female">
                          <label class="me-2" id="female">Female</label>
                        </div>
                      </div>
                      <div class="dropdown-item" href="#">
                        Возраст
                        <div class="dropdown__menu text-center">
                          <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect" value="29">
                          <label class="me-3" for="ageselect" id="29">-29</label>
                          <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect2" value="3045">
                          <label class="me-3" for="ageselect2" id="3045">30-45</label>
                          <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect3" value="4655">
                          <label class="me-3" for="ageselect3" id="4655">46-55</label>
                          <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect4" value="5665">
                          <label class="me-3" for="ageselect4" id="5665">56-65</label>
                          <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect5" value="6675">
                          <label class="me-3" for="ageselect5" id="6675">66-75</label>
                          <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect6" value="75">
                          <label class="me-3" for="ageselect6" id="75">75-</label>
                        </div>
                      </div>
                      <div class="dropdown-item" href="#">
                        Госпитализация
                        <div class="dropdown__menu text-center">
                          <input class="dropdown__item" type="checkbox" name="skori[]" value="samotek">
                          <label class="me-2" id="samotek">Самотек</label>
                          <input class="dropdown__item" type="checkbox" name="skori[]" value="skori">
                          <label class="me-2" id="skori">Скорой</label>
                        </div>
                      </div>
                      <div class="dropdown-item" href="#">
                        Заболевания
                        <div class="dropdown__menu text-center">
                          <input class="dropdown__item" type="checkbox" name="illness[]" value="ag">
                          <label class="me-2" id="ag">АГ</label>
                          <input class="dropdown__item" type="checkbox" name="illness[]" value="sdtip">
                          <label class="me-2" id="sdtip">СД II тип</label>
                          <input class="dropdown__item" type="checkbox" name="illness[]" value="ojireniya">
                          <label class="me-2" id="ojireniya">Ожирение</label>
                          <input class="dropdown__item" type="checkbox" name="illness[]" value="giper">
                          <label class="me-2" id="giper">Гиперлипедемия</label>
                        </div>
                      </div>
                      <div class="dropdown-item" href="#">
                        Лечение
                        <div class="dropdown__menu text-center">
                          <input class="dropdown__item" type="checkbox" name="lech[]" value="chkb">
                          <label class="me-2" id="chkb">ЧКВ</label>
                          <input class="dropdown__item" type="checkbox" name="lech[]" value="tlt">
                          <label class="me-2" id="tlt">ТЛТ</label>
                        </div>
                      </div>
                      <div class="dropdown-item" href="#">
                        Исход
                        <div class="dropdown__menu text-center">
                          <input class="dropdown__item" type="checkbox" name="exit[]" value="live">
                          <label class="me-2" id="live">Выздоровление</label>
                          <input class="dropdown__item" type="checkbox" name="exit[]" value="death">
                          <label class="me-2" id="death">Летальный исход</label>
                        </div>
                      </div>
                      <div>
                      <button style="margin-left: 5rem" class="btn btn-rounded btn-outline-primary btn-sm" type="button" id="get_check" onclick="checkFunction()">Submit</button>
                      </div>
                    </div>
                  </div>
                  {{-- <div class="btn-group" id="datefilter"> --}}
                    <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false" id="age_button" value="a_all"><i class="fas fa-hourglass-end"></i> Все </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      {{-- <a class="dropdown-item" href="#" onclick="dateChart('a_today')" id="a_today"><i class="fas fa-calendar-check"></i> Сегодня </a> --}}
                      <a class="dropdown-item" href="#" onclick="dateChart('a_week')" id="a_week"><i class="fas fa-calendar-check"></i> Неделя </a>
                      <a class="dropdown-item" href="#" onclick="dateChart('a_month')" id="a_month"><i class="fas fa-calendar-check"></i> Месяц </a>
                      <a class="dropdown-item" href="#" onclick="dateChart('a_year')" id="a_year"><i class="fas fa-calendar-check"></i> Год </a>
                      <a class="dropdown-item" href="#" onclick="dateChart('a_all')" id="a_all"><i class="fas fa-calendar-check"></i> Все </a>
                    </div>
                  </div>
                </li>
              </ul>
              
              {{-- <div class="tab-content"> --}}
                {{-- <div class="tab-pane show active" title="all_count" id="solid-rounded-tab1">
                  <div id="all_count"></div>
                </div>
                <div class="tab-pane" id="solid-rounded-tab2">
                  <div id="pol_count"></div>
                </div> --}}
                {{-- <div class="tab-pane" id="solid-rounded-tab3">
                  <div id="age_count"></div>
                </div> --}}
                {{-- <div class="tab-pane" id="solid-rounded-tab4">
                  <div id="come_count"></div>
                </div> --}}
                {{-- <div class="tab-pane" id="solid-rounded-tab5">
                  <div id="dia_count"></div>
                </div> --}}
                {{-- <div class="tab-pane" id="solid-rounded-tab6">
                  <div id="ill_count"></div>
                </div> --}}
              {{-- </div> --}}
            </div>
          </div>
        </div>

        <div style="display: none;" class="container-fluid" style="margin-top: 5%;">
          <div class="card bg-white">
            
            <div class="card-body">
              
              <ul class="nav nav-tabs">
                <li class="ms-auto">
                  <div class="btn-group" id="dropdownNotClosingOne">
                    <button type="button dropdown" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false" id="chec_select" value="none">Выбрать</button>
                    <div class="dropdown-menu dropdown-menu-left">
                      <div class="dropdown-item" href="#">
                        Пол
                        <div class="dropdown__menu text-center">
                          <input class="dropdown__item" type="checkbox" name="gender[]" id="male" value="male_one">
                          <label class="me-2" id="male_one">Male</label>
                          <input class="dropdown__item" type="checkbox" name="gender[]" id="female" value="female_one">
                          <label class="me-2" id="female_one">Female</label>
                        </div>
                      </div>
                      <div class="dropdown-item" href="#">
                        Возраст
                        <div class="dropdown__menu text-center">
                          <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect" value="29">
                          <label class="me-3" for="ageselect" id="29">-29</label>
                          <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect2" value="3045">
                          <label class="me-3" for="ageselect2" id="3045">30-45</label>
                          <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect3" value="4655">
                          <label class="me-3" for="ageselect3" id="4655">46-55</label>
                          <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect4" value="5665">
                          <label class="me-3" for="ageselect4" id="5665">56-65</label>
                          <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect5" value="6675">
                          <label class="me-3" for="ageselect5" id="6675">66-75</label>
                          <input class="dropdown__item" type="checkbox" name="age[]" id="ageselect6" value="75">
                          <label class="me-3" for="ageselect6" id="75">75-</label>
                        </div>
                      </div>
                      <div class="dropdown-item" href="#">
                        Госпитализация
                        <div class="dropdown__menu text-center">
                          <input class="dropdown__item" type="checkbox" name="skori[]" value="samotek">
                          <label class="me-2" id="samotek">Самотек</label>
                          <input class="dropdown__item" type="checkbox" name="skori[]" value="skori">
                          <label class="me-2" id="skori">Скорой</label>
                        </div>
                      </div>
                      <div class="dropdown-item" href="#">
                        Заболевания
                        <div class="dropdown__menu text-center">
                          <input class="dropdown__item" type="checkbox" name="illness[]" value="ag">
                          <label class="me-2" id="ag">АГ</label>
                          <input class="dropdown__item" type="checkbox" name="illness[]" value="sdtip">
                          <label class="me-2" id="sdtip">СД II тип</label>
                          <input class="dropdown__item" type="checkbox" name="illness[]" value="ojireniya">
                          <label class="me-2" id="ojireniya">Ожирение</label>
                          <input class="dropdown__item" type="checkbox" name="illness[]" value="giper">
                          <label class="me-2" id="giper">Гиперлипедемия</label>
                        </div>
                      </div>
                      <div class="dropdown-item" href="#">
                        Лечение
                        <div class="dropdown__menu text-center">
                          <input class="dropdown__item" type="checkbox" name="lech[]" value="chkb">
                          <label class="me-2" id="chkb">ЧКВ</label>
                          <input class="dropdown__item" type="checkbox" name="lech[]" value="tlt">
                          <label class="me-2" id="tlt">ТЛТ</label>
                        </div>
                      </div>
                      <div class="dropdown-item" href="#">
                        Исход
                        <div class="dropdown__menu text-center">
                          <input class="dropdown__item" type="checkbox" name="exit[]" value="live">
                          <label class="me-2" id="live">Выздоровление</label>
                          <input class="dropdown__item" type="checkbox" name="exit[]" value="death">
                          <label class="me-2" id="death">Летальный исход</label>
                        </div>
                      </div>
                      <div>
                      <button style="margin-left: 5rem" class="btn btn-rounded btn-outline-primary btn-sm" type="button" id="get_check" onclick="checkFunction()">Submit</button>
                      </div>
                    </div>
                  </div>
                    <button type="button" class="btn btn-primary" id="age_button_one" value="a_all"><i class="fas fa-hourglass-end"></i> {{date('d.m.Y')}} </button>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div id="pol_one_id"></div>
                <div id="pol_one"></div>
              </div>
              <div class="col-md-2">
              </div>
              <div class="col-md-6">
                <div id="age_one_id"></div>
                <div id="age_one"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-5">
                <div id="ill_one_id"></div>
                <div id="ill_one"></div>
              </div>
              <div class="col-md-2">
              </div>
              <div class="col-md-2">
                <div id="skori_one_id"></div>
                <div id="skori_one"></div>
              </div>
            </div>
          </div>
        </div>
   </div> 
</body>
<script type="text/javascript" src="{{asset('/dash_assets/js/jquery-3.6.0.min.js')}}"></script>

 <script type="text/javascript" src="{{asset('/dash_assets/js/bootstrap.bundle.min.js')}}"></script>

 <script type="text/javascript" src="{{asset('/dash_assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

 <script type="text/javascript" src="{{asset('/dash_assets/plugins/apexchart/apexcharts.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('/dash_assets/plugins/apexchart/dsh-apaxcharts.js')}}"></script>

 <script type="text/javascript" src="{{asset('/dash_assets/js/mobiscroll.javascript.min.js')}}"></script>


 <script type="text/javascript" src="{{ asset('/dash_assets/js/script.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/dash_assets/js/dscript.js') }}"></script>
<script>
  $(document).ready(function(){
    $('#f_pol').mouseover(function() {
        // $("#for_pol").slideToggle("slow");
        $("#for_pol").css('display','');
    });
    $('#f_pol').mouseleave(function() {
        // $("#for_pol").slideToggle("slow");
        $("#for_pol").css('display','none');
    });
    $('#for_pol').mouseleave(function() {
        // $("#for_pol").slideToggle("slow");
        $("#for_pol").css('display','none');
    });
    
});
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>



<script type="text/javascript" src="{{ asset('/dash_assets/daterangepicker.js') }}"></script>
<script type="text/javascript">
  $(function() {
  
    $('#age_button2').daterangepicker({
        autoUpdateInput: false,
        "showDropdowns": true,
        "opens": "left",
        "drops": "up",
        "startDate": "01/01/2022",
        // "endDate": "10/01/2022",
        locale: {
            cancelLabel: 'Clear'
        }
    });
  
    $('#age_button2').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD.MM.YYYY') + ' - ' + picker.endDate.format('DD.MM.YYYY'));
        $('#age_button2').text(picker.startDate.format('DD.MM.YYYY') + ' - ' + picker.endDate.format('DD.MM.YYYY'));

    });
  
    $('#age_button2').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
  
  

      
  $('#dropdownNotClosing').on('hide.bs.dropdown', function (e) {
      if (e.clickEvent) {
        e.preventDefault();
      }
    });

    $('input[type="checkbox"]').on('change', function() {
    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
    });


$('#age_button_one').daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        locale: {
            cancelLabel: 'Clear'
        }
    });
    $('#age_button_one').on('apply.daterangepicker', function(ev, picker) {
        // $(this).val(picker.startDate.format('DD.MM.YYYY') + ' - ' + picker.endDate.format('DD.MM.YYYY'));
        $('#age_button_one').text(picker.startDate.format('DD.MM.YYYY'));
        oneFunction(picker.startDate.format('DD.MM.YYYY'));
        // var date_ses = picker.startDate.format('DD.MM.YYYY');



    });


  });


  $(document).ready(function() {
    var today = moment().format('DD.MM.YYYY');

    $("#age_button_one").val(today);
    oneFunction(today)
    // var date_ses = today;



  }); 
  </script>

</html>
