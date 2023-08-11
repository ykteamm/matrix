<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Matrix') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
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
</head>
<body >
   <div class="main-wrapper login-body" style="background: white !important">
   <div class="login-wrapper">
      <div class="container">
         <img class="img-fluid logo-dark mb-2" src="{{asset('nvt/logo2.png')}}" alt="Logo" />
         <div class="loginbox">
            <div class="login-right" style="box-shadow:0px 0px 15px 5px #656565;border-radius:5px;">
               <div class="login-right-wrap">
                  <form action="{{route('admin-login')}}" method="POST">
                     @csrf
                     <div class="form-group text-center">
                        <label class="form-control-label">PAROL </label>
                        <div class="pass-group">
                           <input type="password" name="password" id="password2" class="form-control pass-input" />
                           <span class="fas fa-eye toggle-password" onclick="myFunction2()"></span>
                        </div>
                     </div>
                     <button class="btn btn-lg btn-block btn-primary" type="submit"> KIRISH </button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</body>

<script type="text/javascript" src="{{asset('/assets/js/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/assets/js/script.js') }}"></script>
 
<script>
   function myFunction2() {
  var x = document.getElementById("password2");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
</html>
