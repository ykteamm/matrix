<div class="sidebar mt-5"  >
    <div class="sidebar-inner">
       <div id="sidebar-menu" class="sidebar-menu">
          <ul>
            @isset(Session::get('per')['dash'])
             @if(Session::get('per')['dash'] == 'true')
             <li><a href="/"><i class="feather-home"></i>  <span> Dashboard</span></a>
             </li>
             @endif
             @endisset
             @isset(Session::get('per')['filter'])
             @if(Session::get('per')['filter'] == 'true')
               <li><a href="/search"><i class="feather-filter"></i>  <span>Filter </span></a>
             @endif
             @endisset
             @isset(Session::get('per')['elchi'])
             @if(Session::get('per')['elchi'] == 'true')
               <li><a href="{{route('elchi-list')}}"><i class="feather-filter"></i>  <span>Elchilar</span></a>
                  @endif
             @endisset

             {{-- @isset(Session::get('per')['pro']) --}}
             {{-- @if(Session::get('per')['pro'] == 'true') --}}
             <li><a href="{{route('pro-list','today')}}"><i class="feather-filter"></i>  <span>Mahsulotlar </span></a>
             </li>
            {{-- @endif --}}
             {{-- @endisset --}}

                  @isset(Session::get('per')['User'])
             @if(Session::get('per')['User'] == 'true')
               <li><a href="{{route('user-list')}}"><i class="feather-filter"></i>  <span>Adminlar </span></a>
             </li>
             @endif
             @endisset
             @isset(Session::get('per')['rol'])
             @if(Session::get('per')['rol'] == 'true')
                  <li class="submenu">
                  {{-- @if(isset(Session::get('per')['rol_create']) || isset(Session::get('per')['rol_read'])) --}}
                     <a href="settings.html"><i class="feather-sliders"></i>  <span> Ro'l </span><span class="menu-arrow"></span></a>
                  {{-- @endisset --}}
                     <ul style="display: none;">
                     {{-- @isset(Session::get('per')['rol_create']) --}}
                        <li><a href="{{route('position.create')}}">Rol qo'shish</a></li>
                     {{-- @endisset --}}
                     {{-- @isset(Session::get('per')['rol_read']) --}}
                        <li><a href="{{route('position.index')}}">Rollar ro'yhati</a></li>
                     {{-- @endisset --}}
                     </ul>
                  </li>
                  @endif
             @endisset
             {{-- @isset(Session::get('per')['User']) --}}
             {{-- @if(Session::get('per')['User'] == 'true') --}}
               
             {{-- @endif --}}
             {{-- @endisset --}}

               {{-- </ul>
            </li> --}}
            {{-- <li><a href="{{ route('back') }}"><i class="feather-home"></i>  <span> 2 </span></a> --}}
             
          </ul>
          {{-- <div> --}}
            <ul>
               <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="feather-home"></i>  <span> Chiqish </span></a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                 </form>
            </ul>
          {{-- </div> --}}
          

       </div>
    </div>
 </div>