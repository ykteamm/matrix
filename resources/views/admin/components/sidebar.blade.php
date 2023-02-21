<div class="sidebar mt-5">
    <div class="sidebar-inner">
       <div id="sidebar-menu" style="height: 100vh; overflow-y: scroll" class="sidebar-menu">
          <ul>
               <?php 
                  $cap = Session::get('cap');
                  $rm = Session::get('rm');
               ?>
            @isset(Session::get('per')['dash'])
             @if(Session::get('per')['dash'] == 'true')

               @if($rm == 1 && $cap == 2)

               <li><a href="/"><i class="feather-home"></i>  <span> Dashboard</span></a>
               </li>
               <li><a href="{{route('capitan',['month'=>date('Y-m')])}}"><i class="feather-home"></i>  <span>Capitan dashboard</span></a>
               </li>
               @elseif($rm != 1 && $cap == 2)
               <li><a href="{{route('capitan',['month'=>date('Y-m')])}}"><i class="feather-home"></i>  <span>Capitan dashboard</span></a>
               </li>
               @else
               <li><a href="/"><i class="feather-home"></i>  <span> Dashboard</span></a>
               </li>
               @endif
             @endif
             @endisset

             <!-- @if(Session::get('cap') == 2)
             <li><a href="{{route('capitan',['month'=>date('Y-m')])}}"><i class="feather-home"></i>  <span>Capitan dashboard</span></a>
             </li>
             @endif -->

             @isset(Session::get('per')['filter'])
             @if(Session::get('per')['filter'] == 'true')
               <li><a href="/search"><i class="feather-filter"></i>  <span>Filter </span></a>
               <!-- <li><a href="{{route('smsfly')}}"><i class="feather-filter"></i>  <span>Filter </span></a> -->
             @endif
             @endisset

             @isset(Session::get('per')['elchi-day'])
             @if(Session::get('per')['elchi-day'] == 'true')
                 <li><a href="{{route('elchilar',['month'=>date('Y-m')])}}"><i class="feather-users"></i>  <span>Elchilar kunlik</span></a>
               @endif
               @endisset
             @isset(Session::get('per')['elchi'])
             @if(Session::get('per')['elchi'] == 'true')
               {{-- <li><a href="{{route('elchi-list')}}"><i class="feather-users"></i>  <span>Elchilar</span></a> --}}
                  @endif
             @endisset


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

            @isset(Session::get('per')['user-pharm'])
                @if(Session::get('per')['user-pharm'] == 'true')
                    <li class="submenu">
                        <a href="settings.html"><i class="feather-sliders"></i>  <span>User Dorixona</span><span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{route('pharm.users')}}"> <span> Dorixona biriktirish</span></a></li>
                            <li class="submenu">
                                <a href="settings.html"> <span>Biriktirilganlar</span><span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="{{route('pharm.users.bypharm')}}"> <span> Dorixona bo'yicha</span></a></li>
                                    <li><a href="{{route('pharm.users.all')}}"><span> Userlar bo'yicha</span></a></li>
                                </ul>

                            </li>
                        </ul>
                    </li>
            @endif
            @endisset
                 
            @isset(Session::get('per')['team'])
             @if(Session::get('per')['team'] == 'true')
            <li class="submenu">
               <a href="settings.html"><i class="feather-sliders"></i>  <span> Elchi jang </span><span class="menu-arrow"></span></a>
               <ul style="display: none;">
                  <li><a href="{{route('elchi-battle')}}">Jang</a></li>
                  <li><a href="{{route('elchi-battle-select')}}">Elchi tanlash</a></li>
                  <li><a href="{{route('elchi-battle-exercise')}}">Jang default topshiriq</a></li>
                  <li><a href="{{route('elchi-user-battle-exercise')}}">Jang elchiga topshiriq</a></li>
                  <li><a href="{{route('elchi-battle-setting')}}">Sozlamalar</a></li>
               </ul>
            </li>
            @endif
            @endisset

            @isset(Session::get('per')['toolz'])
            @if(Session::get('per')['toolz'] == 'true')
           <li class="submenu">
              <a href="settings.html"><i class="feather-sliders"></i>  <span> Toolz Bot </span><span class="menu-arrow"></span></a>
              <ul style="display: none;">
                 <li><a href="{{route('selfi')}}">Selfi</a></li>
                 <li><a href="{{route('king.sold')}}">Shox yurish</a></li>
                 <li><a href="{{route('king.history',['date'=>date('Y-m-d')])}}">Shox yurish tarix</a></li>
                 <li><a href="{{route('king-liga')}}">Shox yurish Liga</a></li>
               </ul>
           </li>
           @endif
           @endisset

             @isset(Session::get('per')['team'])
             @if(Session::get('per')['team'] == 'true')
             <li><a href="{{route('team',['time'=>'today'])}}"><i class="feather-filter"></i>  <span>Jamoalar</span></a>
             @endif
             @endisset

             @isset(Session::get('per')['trend'])
             @if(Session::get('per')['trend'] == 'true')
             <li><a href="{{route('team-battle')}}"><i class="feather-filter"></i>  <span>Jamoalar jangi</span></a>

               <li class="submenu">
                  <a href="settings.html"><i class="feather-activity"></i>  <span> Trend </span><span class="menu-arrow"></span></a>
                  <ul style="display: none;">
                     <li><a href="{{route('trend.region','three')}}">Viloyat</a></li>
                     <li><a href="{{route('trend.product','three')}}">Mahsulot</a></li>
                     <li><a href="{{route('trend.user','three')}}">Elchi</a></li>
                     <li><a href="{{route('trend.pharmacy','three')}}">Dorixona</a></li>
                  </ul>
               </li>
               @endif
             @endisset

             @isset(Session::get('per')['pro'])
             @if(Session::get('per')['pro'] == 'true')
             <li><a href="{{route('pro-list',['time'=>'today','region'=>'all','pharm' => 'all'])}}"><i class="feather-filter"></i>  <span>Mahsulotlar </span></a>
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
             @isset(Session::get('per')['accept'])
                                @if(Session::get('per')['accept'] == 'true')
                    <li class="submenu">
                        <a href="settings.html"><i class="feather-sliders"></i>  <span> Mahsulot kirim/qoldiq </span><span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @isset(Session::get('per')['accept'])
                                @if(Session::get('per')['accept'] == 'true')
                            <li><a href="{{route('accept.med')}}">Kiritilganlar</a></li>
                                @endif
                            @endisset
                            @isset(Session::get('per')['stock'])
                                @if(Session::get('per')['stock'] == 'true')
                                        <li><a href="{{route('stock.med')}}">Qoldiqlar</a></li>
                                @endif
                            @endisset

                        </ul>
                    </li>
                    @endif
                            @endisset
                @isset(Session::get('per')['grade'])
                    @if(Session::get('per')['grade'] == 'true')
                        <li><a href="{{route('compare')}}"><i class="feather-filter"></i>  <span>Taqqoslash </span></a>
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
             <li><a href="{{route('setting',date('m.Y'))}}"><i class="feather-settings"></i>  <span>Kalendar </span></a>
             </li>
             @endif
             @endisset

             @isset(Session::get('per')['narx'])
             @if(Session::get('per')['narx'] == 'true')
             <li class="submenu">
               <a href="settings.html"><i class="feather-sliders"></i>  <span> Narx </span><span class="menu-arrow"></span></a>
               <ul style="display: none;">
                  <li><a href="{{route('shablon.create')}}">Narx yaratish</a></li>
                  <li><a href="{{route('shablon.pharmacy')}}">Dorixona biriktirish</a></li>
               </ul>
            </li>
            @endif
             @endisset

             @isset(Session::get('per')['control'])
             @if(Session::get('per')['control'] == 'true')

               <li class="submenu">
                  <a href="settings.html"><i class="feather-activity"></i>  <span> User boshqaruvi </span><span class="menu-arrow"></span></a>
                  <ul style="display: none;">
                     <li><a href="{{route('user-control')}}">Status</a></li>
                     <li><a href="{{route('user-register')}}">Registratsiya</a></li>
                  </ul>
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

             {{-- @isset(Session::get('per')['rol'])
             @if(Session::get('per')['rol'] == 'true')
                  <li class="submenu">
                     <a href="settings.html"><i class="feather-sliders"></i>  <span> Ro'l </span><span class="menu-arrow"></span></a>
                     <ul style="display: none;">
                        <li><a href="{{route('position.create')}}">Rol qo'shish</a></li>
                        <li><a href="{{route('position.index')}}">Rollar ro'yhati</a></li>
                     </ul>
                  </li>
                  @endif
             @endisset --}}

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
