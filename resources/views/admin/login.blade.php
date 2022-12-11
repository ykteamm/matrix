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
<body>
   <div class="main-wrapper login-body">
   <div class="login-wrapper">
      <div class="container">
         {{-- <img class="img-fluid logo-dark mb-2" src="assets/img/logo.png" alt="Logo" /> --}}
         <div class="loginbox">
            <div class="login-right">
               <div class="login-right-wrap">
                  <h1>Авторизоваться </h1>
                  {{-- <p class="account-subtitle">Доступ к нашей панели управления</p> --}}
                  <form action="{{ route('login-admin') }}" method="POST">
                     @csrf
                     <div class="form-group">
                        <label class="form-control-label">Эмаил </label>
                        <input type="email" name="email" class="form-control" />
                     </div>
                     <div class="form-group">
                        <label class="form-control-label">Парол </label>
                        <div class="pass-group">
                           <input type="password" name="password" id="password2" class="form-control pass-input" />
                           <span class="fas fa-eye toggle-password" onclick="myFunction2()"></span>
                        </div>
                     </div>
                     {{-- <div class="form-group">
                        <div class="row">
                           <div class="col-6">
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" class="custom-control-input" id="cb1" />
                                 <label class="custom-control-label" for="cb1">Remember me </label>
                              </div>
                           </div>
                           <div class="col-6 text-right">
                              <a class="forgot-link" href="forgot-password.html">Forgot Password ? </a>
                           </div>
                        </div>
                     </div> --}}
                     <button class="btn btn-lg btn-block btn-primary" type="submit"> Login </button>
                     {{-- <div class="login-or">
                        <span class="or-line"></span>
                        <span class="span-or">or </span>
                     </div>
                     <div class="social-login mb-3">
                        <span>Login with </span>
                        <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a><a href="#" class="google"><i class="fab fa-google"></i></a>
                     </div>
                     <div class="text-center dont-have">Don't have an account ___?  <a href="register.html">Register </a></div> --}}
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
