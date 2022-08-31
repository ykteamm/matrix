<div class="header">
    <div class="header-left">
       <a href="/home" class="logo">
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