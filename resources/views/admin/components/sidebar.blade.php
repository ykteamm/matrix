<div class="sidebar mt-5"  >
    <div class="sidebar-inner">
       <div id="sidebar-menu" style="height: 100vh; overflow-y: scroll" class="sidebar-menu">
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

             @isset(Session::get('per')['elchi-day'])
             @if(Session::get('per')['elchi-day'] == 'true')
                 <li><a href="{{route('elchilar',['month'=>date('Y-m')])}}"><i class="feather-filter"></i>  <span>Elchilar kunlik</span></a>
               @endif
               @endisset
             {{-- @isset(Session::get('per')['elchi'])
             @if(Session::get('per')['elchi'] == 'true')
               <li><a href="{{route('elchi-list')}}"><i class="feather-filter"></i>  <span>Elchilar</span></a>
                  @endif
             @endisset --}}

             {{-- @isset(Session::get('per')['pharmacy'])
             @if(Session::get('per')['pharmacy'] == 'true')
             <li><a href="{{route('pharmacy-list','today')}}"><i class="feather-filter"></i>  <span>Dorixonalar</span></a>
             @endif
             @endisset --}}
             @isset(Session::get('per')['user_pharmacy'])
             @if(Session::get('per')['user_pharmacy'] == 'true')
             <li><a href="{{route('pharmacy-user','today')}}"><i class="feather-filter"></i>  <span>Dorixona - elchi</span></a>
             @endif
             @endisset

             @isset(Session::get('per')['team'])
             @if(Session::get('per')['team'] == 'true')
             <li><a href="{{route('team.index')}}"><i class="feather-filter"></i>  <span>Jamoalar</span></a>
             @endif
             @endisset

             @isset(Session::get('per')['pro'])
             @if(Session::get('per')['pro'] == 'true')
             <li><a href="{{route('pro-list','today')}}"><i class="feather-filter"></i>  <span>Mahsulotlar </span></a>
             </li>
            @endif
             @endisset
             @isset(Session::get('per')['grade'])
             @if(Session::get('per')['grade'] == 'true')
             {{-- <li><a href="{{route('grade')}}"><i class="feather-filter"></i>  <span>Baholash </span></a> --}}
             {{-- </li> --}}
             @endif
             @endisset


             @isset(Session::get('per')['ques'])
             @if(Session::get('per')['ques'] == 'true')
             <li class="submenu">
                  <a href="settings.html"><i class="feather-sliders"></i>  <span> Savollar </span><span class="menu-arrow"></span></a>
                  <ul style="display: none;">
                     <li><a href="{{route('bolim.create')}}">Bo'limlar</a></li>
                     <li><a href="{{route('question.create')}}">Ichki savollar</a></li>
                     <li><a href="{{route('image.grade')}}">Rasm biriktirish</a></li>
                  </ul>
               </li>
               @endif
             @endisset

             @isset(Session::get('per')['know_ques'])
             @if(Session::get('per')['know_ques'] == 'true')
             <li class="submenu">
               <a href="settings.html"><i class="feather-sliders"></i>  <span> Bilim savollar </span><span class="menu-arrow"></span></a>
               <ul style="display: none;">
                  <li><a href="{{route('knowledge.create')}}">Asosiy savollar</a></li>
                  <li><a href="{{route('pill-question.create')}}">Asosiy kategoriya</a></li>
                  <li><a href="{{route('condition-question.create')}}">Ichki kategoriya</a></li>
                  <li><a href="{{route('knowledge-question.create')}}">Savollar</a></li>
               </ul>
            </li>
            @endif
            @endisset

            @isset(Session::get('per')['grade'])
             @if(Session::get('per')['grade'] == 'true')
            <li><a href="{{route('all.grade')}}"><i class="feather-filter"></i>  <span>Baholash </span></a>
            </li>
            @endif
            @endisset

             @isset(Session::get('per')['setting'])
             @if(Session::get('per')['setting'] == 'true')
             <li><a href="{{route('setting','09.2022')}}"><i class="feather-filter"></i>  <span>Sozlamalar </span></a>
             </li>
             @endif
             @endisset

             @isset(Session::get('per')['narx'])
             @if(Session::get('per')['narx'] == 'true')
             <li class="submenu">
               <a href="settings.html"><i class="feather-sliders"></i>  <span> Shablon </span><span class="menu-arrow"></span></a>
               <ul style="display: none;">
                  <li><a href="{{route('shablon.create')}}">Shablon yaratish</a></li>
               </ul>
            </li>
            @endif
             @endisset

             @isset(Session::get('per')['control'])
             @if(Session::get('per')['control'] == 'true')
             <li><a href="{{route('user-control')}}"><i class="feather-filter"></i>  <span>User boshqaruvi</span></a>
             </li>
             @endif
             @endisset

             {{-- @isset(Session::get('per')['zavod'])
             @if(Session::get('per')['zavod'] == 'true')
             <li class="submenu">
               <a href="settings.html"><i class="feather-sliders"></i>  <span> Zavod </span><span class="menu-arrow"></span></a>
               <ul style="display: none;">
                  <li><a href="{{route('warehouse.create')}}">Sklad</a></li>
                  <li><a href="{{route('product-category.create')}}">O'lcham</a></li>
                  <li><a href="{{route('product.create')}}">Mahsulot</a></li>
                  <li><a href="{{route('product-journal.show')}}">Tarix</a></li>
               </ul>
            </li>
            @endif
             @endisset --}}

             @isset(Session::get('per')['show_purchase'])
             @if(Session::get('per')['show_purchase'] == 'true')
             <li><a href="{{route('purchase.journal')}}"><i class="feather-filter"></i>  <span>Taxrirlash tarixi </span></a>
             </li>
             @endif
             @endisset

                  {{-- @isset(Session::get('per')['User'])
             @if(Session::get('per')['User'] == 'true')
               <li><a href="{{route('user-list')}}"><i class="feather-filter"></i>  <span>Adminlar </span></a>
             </li>
             @endif
             @endisset --}}

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

             @isset(Session::get('per')['rol'])
             @if(Session::get('per')['rol'] == 'true')
                  <li class="submenu">
                  {{-- @if(isset(Session::get('per')['rol_create']) || isset(Session::get('per')['rol_read'])) --}}
                     <a href="settings.html"><i class="feather-sliders"></i>  <span> Rol System </span><span class="menu-arrow"></span></a>
                  {{-- @endisset --}}
                     <ul style="display: none;">
                     {{-- @isset(Session::get('per')['rol_create']) --}}
                        <li><a href="{{route('admin-list')}}">Admin</a></li>
                     {{-- @endisset --}}
                     {{-- @isset(Session::get('per')['rol_read']) --}}
                        <li><a href="{{route('rm-list')}}">RM</a></li>
                        <li><a href="{{route('cap-list')}}">Capitan</a></li>
                        <li><a href="{{route('user-list')}}">Elchi</a></li>
                     {{-- @endisset --}}
                     </ul>
                  </li>
               @endif
              @endisset
              <li class="mb-5"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="feather-home"></i>  <span> Chiqish </span></a>
               <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
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
               
            </ul>
          {{-- </div> --}}


       </div>
    </div>
 </div>
