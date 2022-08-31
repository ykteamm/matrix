<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
       <div id="sidebar-menu" class="sidebar-menu">
          <ul style="margin-top: 25%;">
             {{-- <li class="menu-title">  <span>Main </span>
             </li>
             <li class="active">  <a href="index.html"><i class="feather-home"></i><span class="shape1"></span><span class="shape2"></span><span>Dashboard </span></a>
             </li> --}}
             <li><a href="/home"><i class="feather-home"></i>  <span> Главная </span></a>
             </li>
             <li class="submenu">
               @if(isset(Session::get('per')['p_create']) || isset(Session::get('per')['p_read']))
                <a href="#"><i class="feather-user"></i>  <span>{{ __('app.patient') }} </span>  <span class="menu-arrow"></span></a>
               @endif
                <ul style="display: none;">
                  @isset(Session::get('per')['p_create'])
                     <li><a href="{{ route('patient.create')}}">{{ __('app.patient_add') }}</a></li>
                  @endisset
                  @isset(Session::get('per')['p_read'])
                     <li><a href="{{ route('patient.index')}}" onclick="pList()">{{ __('app.patient_list') }} </a></li>
                  @endisset
                </ul>
             </li>
             @isset(Session::get('per')['p_ekg_create'])
               <li>
                  <a href="{{ route('ekg.index')}}"><i class="feather-activity"></i>  <span>{{ __('app.ekg') }} </span></a>
               </li>
             @endisset
             
             @isset(Session::get('per')['p_exo_create'])
             <li><a href="{{ route('exo.index')}}"><i class="feather-activity"></i>  <span>{{ __('app.exo') }} </span></a>
             </li>
            @endisset
             
            @isset(Session::get('per')['exit_create'])
            <li><a href="{{ url('patient_exit')}}"><i class="feather-refresh-cw"></i>  <span> {{ __('app.exodus') }}</span></a>
            </li>
            @endisset
             {{-- @isset(Session::get('rol')->hospital_create) --}}
               {{-- @if(Session::get('rol')->hospital_create == 'create') --}}
               
               {{-- @endif --}}
             {{-- @endisset --}}

             

             {{-- <li class="submenu">
                <a href="#"><i class="feather-map-pin"></i>  <span>{{ __('app.adres') }} </span>  <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                   <li><a href="{{ route('province.index')}}">{{ __('app.province_add') }}</a></li>
                   <li><a href="{{ route('district.index')}}">{{ __('app.district_add') }}</a></li>
                </ul>
             </li> --}}
             {{-- <li class="submenu">
               <a href="settings.html"><i class="feather-users"></i>  <span> {{ __('app.user') }} </span><span class="menu-arrow"></span></a>
               <ul style="display: none;">
                  <li><a href="{{ route('user.create')}}">{{ __('app.add_user') }}</a></li>
                  <li><a href="{{ route('district.index')}}">{{ __('app.district_add') }}</a></li>
               </ul>
            </li> --}}
            <li>
               <a href="{{ route('super_admin') }}"><i class="feather-settings"></i>  <span> {{ __('app.setting') }} </span></a>
               {{-- <ul style="display: none;">
                  <li><a href="{{ route('user.create')}}">{{ __('app.users') }}</a></li>
                  <li><a href="{{ route('position.index')}}">{{ __('app.position') }}</a></li>

               </ul> --}}
            </li>
            <li>

               <a href="{{ route('exchange-index') }}"><i class="feather-refresh-cw"></i>  <span> {{ __('app.obmen') }} </span></a>
               {{-- <ul style="display: none;">
                  <li><a href="{{ route('user.create')}}">{{ __('app.users') }}</a></li>
                  <li><a href="{{ route('position.index')}}">{{ __('app.position') }}</a></li>

               </ul> --}}
            </li>
            
          </ul>
       </div>
    </div>
 </div>