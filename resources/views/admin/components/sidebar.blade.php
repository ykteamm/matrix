<div class="sidebar mt-5">
    <div class="sidebar-inner">
        <div id="sidebar-menu" style="height: 100vh; overflow-y: scroll" class="sidebar-menu">
            <ul>
                <?php
                $cap = Session::get('cap');
                $rm = Session::get('rm');
                ?>
                @isset(Session::get('per')['dash'])
                    @if (Session::get('per')['dash'] == 'true')
                        @if ($rm == 1 && $cap == 2)
                            <li><a href="/"><i class="fas fa-home"></i> <span> Dashboard</span></a>
                            </li>
                            <li><a href="{{ route('capitan', ['month' => date('Y-m')]) }}"><i class="fas fa-home"></i>
                                    <span>Capitan dashboard</span></a>
                            </li>
                        @elseif($rm != 1 && $cap == 2)
                            <li><a href="{{ route('capitan', ['month' => date('Y-m')]) }}"><i class="fas fa-home"></i>
                                    <span>Capitan dashboard</span></a>
                            </li>
                        @else
                            <li><a href="/"><i class="fas fa-home"></i> <span> Dashboard</span></a>
                            </li>
                        @endif
                    @endif
                @endisset

                <!-- @if (Session::get('cap') == 2)
<li><a href="{{ route('capitan', ['month' => date('Y-m')]) }}"><i class="feather-home"></i>  <span>Capitan dashboard</span></a>
             </li>
@endif -->

                @isset(Session::get('per')['filter'])
                    @if (Session::get('per')['filter'] == 'true')
                        <li><a href="/search"><i class="fas fa-filter"></i> <span>Filter </span></a>
                            <!-- <li><a href="{{ route('smsfly') }}"><i class="feather-filter"></i>  <span>Filter </span></a> -->
                    @endif
                @endisset

                @isset(Session::get('per')['elchi-day'])
                    @if (Session::get('per')['elchi-day'] == 'true')
                        <li><a href="{{ route('elchilar', ['month' => date('Y-m')]) }}"><i class="fas fa-users"></i>
                                <span>Hisobotlar</span></a>
                    @endif
                @endisset

                {{-- <li class="submenu">
                    <a href="settings.html"><i class="fas fa-filter"></i> <span> Hisobotlar </span><span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        @isset(Session::get('per')['rekrut-atchot'])
                            @if (Session::get('per')['rekrut-atchot'] == 'true')
                                <li><a href="{{ route('rekrut-hisobot') }}"><span>Rekrut</span></a>
                            @endif
                        @endisset

                        @isset(Session::get('per')['provizor-atchot'])
                            @if (Session::get('per')['provizor-atchot'] == 'true')
                                <li><a href="{{ route('provizor-hisobot') }}"><span>Provizor</span></a>
                            @endif
                        @endisset

                        @isset(Session::get('per')['user_pharmacy'])
                            @if (Session::get('per')['user_pharmacy'] == 'true')
                                <li><a href="{{ route('pharmacy-user', 'today') }}">
                                        <span>Dorixona</span></a>
                            @endif
                        @endisset

                        @isset(Session::get('per')['pro'])
                            @if (Session::get('per')['pro'] == 'true')
                                <li><a href="{{ route('pro-list', ['time' => 'today', 'region' => 'all', 'pharm' => 'all']) }}"><span>Mahsulotlar </span></a>
                                </li>
                            @endif
                        @endisset

                        @isset(Session::get('per')['show_purchase'])
                            @if (Session::get('per')['show_purchase'] == 'true')
                                <li><a href="{{ route('purchase.journal') }}"><span>Taxrirlash
                                            tarixi </span></a>
                                </li>
                            @endif
                        @endisset

                        @isset(Session::get('per')['oylik'])
                            @if (Session::get('per')['oylik'] == 'true')
                            <li><a href="{{ route('user-money', ['region_id' => 5, 'month' => date('Y-m')]) }}">
                                <span>Oylik </span></a>
                            </li>
                            @endif
                        @endisset

                        @isset(Session::get('per')['trend'])
                            @if (Session::get('per')['trend'] == 'true')
                                <li class="submenu">
                                    <a href="settings.html"><span> Trend </span><span
                                            class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="{{ route('trend.region', 'three') }}">Viloyat</a></li>
                                        <li><a href="{{ route('trend.product', 'three') }}">Mahsulot</a></li>
                                        <li><a href="{{ route('trend.user', 'three') }}">Elchi</a></li>
                                        <li><a href="{{ route('trend.pharmacy', 'three') }}">Dorixona</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endisset
                    </ul>
                </li> --}}


                    @if (in_array(Session::get('user')->id,[154,37,405]))
                        @isset(Session::get('per')['order'])
                        @if (Session::get('per')['order'] == 'true')
                            <li class="submenu">
                                <a href="settings.html"><i class="fas fa-crown"></i> <span> Order </span><span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    @isset(Session::get('per_admin')['order_zakaz'])
                                        @if (Session::get('per_admin')['order_zakaz'] == 'true')

                                        <li><a href="{{ route('order.index') }}"><span>Buyurtma berish</span></a>

                                        @endif
                                    @endisset

                                    @isset(Session::get('per_admin')['order_report'])
                                        @if (Session::get('per_admin')['order_report'] == 'true')

                                        <li><a href="{{ route('orders') }}"><span>Buyurtmalar</span></a>
                                        <li><a href="{{ route('warehouse') }}"><span>Sklad</span></a>
                                        <li><a href="{{ route('money-coming') }}"><span>Pul kelishi</span></a>
                                        {{-- <li><a href="{{ route('last.order') }}"><span>Eski buyurtmalar</span></a> --}}
                                        <li><a href="{{ route('report') }}"><span>Hisobot 1</span></a>
                                        <li><a href="{{ route('mc-pharmacy') }}"><span>Dorixonalar</span></a>

                                        @endif
                                    @endisset
                                </ul>
                            </li>
                        @endif
                        @endisset
                    @endif

                    @isset(Session::get('per')['rek'])
                        @if (Session::get('per')['rek'] == 'true')
                            <li class="submenu">
                                {{-- <a href="settings.html"><i class="fas fa-crown"></i> <span> Order </span><span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;"> --}}

                                    <li><a href="{{ route('rek.index') }}">
                                        <i class="fas fa-crown"></i>
                                        <span>Rek</span></a>

                                {{-- </ul> --}}
                            </li>
                        @endif
                    @endisset
                            
                @isset(Session::get('per')['order'])
                @if (Session::get('per')['order'] == 'true')
                    <li class="submenu">
                        <a href="settings.html"><i class="fas fa-crown"></i> <span> Mijoz </span><span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{ route('mijoz-banner') }}"><span>Banner</span></a>
                        </ul>
                    </li>
                @endif
                @endisset

                <li class="submenu">
                    <a href="settings.html"><i class="fas fa-crown"></i> <span> Toolz bot </span><span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        @isset(Session::get('per')['king_sold'])
                            @if (Session::get('per')['king_sold'] == 'true')
                                <li class="submenu">
                                    <a href="settings.html"><span> Shox yurish </span><span
                                            class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="{{ route('king.sold') }}">Tasdiqlash</a></li>
                                        <li><a href="{{ route('king.history', ['date' => date('Y-m-d')]) }}">Tarix</a></li>
                                        <li><a href="{{ route('kingliga.index') }}">Ligalar</a></li>
                                        <li><a href="{{ route('king-liga') }}">Turnir liga</a></li>
                                        <li><a
                                                href="{{ route('king-sold', ['user_id' => 'all', 'region_id' => 'all', 'date' => 'today']) }}"><span>Hisobot
                                                </span></a>
                                    </ul>
                                </li>
                            @endif
                        @endisset
                        @isset(Session::get('per')['teacher'])
                            @if (Session::get('per')['teacher'] == 'true')
                                <li class="submenu">
                                    <a href="settings.html"><span> Ustoz-shogird </span><span
                                            class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="{{ route('add-teacher') }}">Ustoz tayinlash</a></li>
                                        <li><a href="{{ route('add-shogird') }}">Shogird tayinlash</a></li>
                                        <li><a href="{{ route('st-grade') }}">Baholashlar</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endisset

                        @isset(Session::get('per')['toolz'])
                            @if (Session::get('per')['toolz'] == 'true')
                                <li class="submenu">
                                    <a href="settings.html"><span> Smena </span><span
                                            class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="{{ route('open-smena') }}">Smena ochish</a></li>
                                        <li><a href="{{ route('close-smena') }}">Smena yopish</a></li>
                                        <li><a href="{{ route('provizor') }}">Provizor tayinlash</a></li>
                                        <li><a href="{{ route('premya.index') }}">Premyalar</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endisset

                        @isset(Session::get('per')['rol'])
                            @if (Session::get('per')['rol'] == 'true')
                                <li class="submenu">
                                    <a href="settings.html">
                                    <span> News </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                    <ul style="display: none;">
                                        <li><a href="{{ route('openNews') }}">News</a></li>
                                        <li><a href="{{ route('openInfos') }}">Info</a></li>
                                        <li><a href="{{ route('openVideos') }}">Videos</a></li>
                                    </ul>
                                </li>
                            @endisset
                        @endif

                        @isset(Session::get('per')['market'])
                        @if (Session::get('per')['market'] == 'true')
                            <li class="submenu">
                                <a href="settings.html">
                                <span> Market </span>
                                <span class="menu-arrow"></span>
                            </a>
                                <ul style="display: none;">
                                    <li><a href="{{ route('market-product') }}">Mahsulotlar</a></li>
                                    <li><a href="{{ route('market-category') }}">Slider categeory</a></li>
                                    <li><a href="{{ route('market-slider') }}">Slider</a></li>
                                </ul>
                            </li>
                        @endisset
                        @endif

                        @isset(Session::get('per')['firewall'])
                        @if (Session::get('per')['firewall'] == 'true')
                            <li><a href="{{ route('firewall') }}">Firewall</a></li>
                        @endisset
                        @endif

                        @isset(Session::get('per')['crystal'])
                        @if (Session::get('per')['crystal'] == 'true')
                            <li><a href="{{ route('crystal-add') }}">Crystal</a></li>
                        @endisset
                        @endif
                    </ul>
                </li>

                {{-- @isset(Session::get('per')['pharmacy'])
             @if (Session::get('per')['pharmacy'] == 'true')
             <li><a href="{{route('pharmacy-list','today')}}"><i class="feather-filter"></i>  <span>Dorixonalar</span></a>
             @endif
             @endisset --}}


                        <li class="submenu">
                            <a href="settings.html"><i class="fas fa-synagogue"></i> <span> Jang </span><span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @isset(Session::get('per')['team'])
                                    @if (Session::get('per')['team'] == 'true')
                                        <li class="submenu">
                                            <a href="settings.html"><span> Jamoa </span><span
                                                    class="menu-arrow"></span></a>
                                            <ul style="display: none;">
                                                <li><a href="{{ route('team-slider') }}"><span>Slider</span></a>
                                                    <li><a href="{{ route('team-plan') }}"><span>Kvartalniy plan</span></a>
                                                    <li><a href="{{ route('team', ['time' => 'today']) }}"><span>Jamoalar</span></a>
                                                <li><a href="{{ route('team-battle') }}"><span>Jamoalar Jangi</span></a>

                                            </ul>
                                        </li>
                                    @endif
                                @endisset

                                @isset(Session::get('per')['team'])
                                    @if (Session::get('per')['team'] == 'true')
                                        <li class="submenu">
                                            <a href="settings.html"><span> Elchi </span><span
                                                    class="menu-arrow"></span></a>
                                            <ul style="display: none;">
                                                <li><a href="{{ route('elchi-battle') }}">Jang</a></li>
                                                <li><a href="{{ route('elchi-battle-select') }}">Elchi tanlash</a></li>
                                                <li><a href="{{ route('elchi-battle-exercise') }}">Jang default topshiriq</a></li>
                                                <li><a href="{{ route('elchi-user-battle-exercise') }}">Jang elchiga topshiriq</a></li>
                                                <li><a href="{{ route('elchi-battle-setting') }}">Sozlamalar</a></li>
                                            </ul>
                                        </li>
                                    @endif
                                @endisset
                            </ul>
                        </li>





                @isset(Session::get('per')['turnir'])
                    @if (Session::get('per')['turnir'] == 'true')
                        <li class="submenu">
                            <a href="settings.html"><i class="fas fa-gamepad"></i> <span> Turnir </span><span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="{{ route('turnir-team') }}">Jamoalar</a></li>
                                <li><a href="{{ route('turnir-group') }}">Guruhlar</a></li>
                                <li><a href="{{ route('group-state') }}">Guruh bosqichi</a></li>
                                <li><a href="{{ route('turnir-tour') }}">Turnir tur</a></li>
                                <li><a href="{{ route('turnir-playoff') }}">Turnir play-off</a></li>
                                <li><a href="{{ route('turnir-games') }}">Turnir games</a></li>
                            </ul>
                        </li>
                    @endif
                @endisset

                @isset(Session::get('per')['rekrut'])
                    @if (Session::get('per')['rekrut'] == 'true')

                        @if (in_array(Session::get('user')->rm,[1,2]))
                            <li><a href="{{ route('rekrut') }}"><i class="fas fa-filter"></i> <span>Rekruting</span></a>
                        @else
                        <li><a href="{{ route('rekrut-add-user') }}"><i class="fas fa-filter"></i> <span>Rekruting</span></a>
                        @endif
                    @endif
                @endisset



                @isset(Session::get('per')['teacher'])
                    @if (Session::get('per')['teacher'] == 'true')
                        <li class="submenu">
                            <a href="settings.html"><i class="fas fa-graduation-cap"></i> <span> Provizor </span><span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="{{ route('pro-order') }}">Buyurtmalar</a></li>
                                <li><a href="{{ route('pro-money') }}">Pul kelishi</a></li>
                                <li><a href="{{ route('pro-crystal-history') }}">Crystal tarix</a></li>
                                <li><a href="{{ route('pro-battle') }}">Jang</a></li>
                            </ul>
                        </li>
                    @endif
                @endisset











                @isset(Session::get('per')['grade'])
                    @if (Session::get('per')['grade'] == 'true')
                        {{-- <li><a href="{{route('grade')}}"><i class="feather-filter"></i>  <span>Baholash </span></a> --}}
                        {{-- </li> --}}
                    @endif
                @endisset




                <li class="submenu">
                    <a href="settings.html"><i class="fas fa-balance-scale-left"></i> <span> Ostatka </span><span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">

                        @isset(Session::get('per')['accept'])
                            @if (Session::get('per')['accept'] == 'true')
                                <li><a href="{{ route('accept.med') }}">Kiritilganlar</a></li>
                            @endif
                        @endisset
                        @isset(Session::get('per')['stock'])
                            @if (Session::get('per')['stock'] == 'true')
                                <li><a href="{{ route('stock.med') }}">Qoldiqlar</a></li>
                            @endif
                        @endisset
                        @isset(Session::get('per')['grade'])
                            @if (Session::get('per')['grade'] == 'true')
                                <li><a href="{{ route('compare') }}"><span>Taqqoslash </span></a>
                                </li>
                            @endif
                        @endisset
                    </ul>
                </li>


                {{-- <li class="submenu">
                    <a href="settings.html"><i class="fas fa-user-graduate"></i> <span> Baholash </span><span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        @isset(Session::get('per')['grade'])
                            @if (Session::get('per')['grade'] == 'true')
                                <li><a href="{{ route('all.grade') }}"><span> Elchiga baxo berish </span></a>
                                </li>
                            @endif
                        @endisset
                        @isset(Session::get('per')['ques'])
                            @if (Session::get('per')['ques'] == 'true')
                                <li class="submenu">
                                    <a href="settings.html"><span> Savollar </span><span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="{{ route('bolim.create') }}">Bo'limlar</a></li>
                                        <li><a href="{{ route('question.create') }}">Ichki savollar</a></li>
                                        <li><a href="{{ route('image.grade') }}">Rasm biriktirish</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endisset
                        @isset(Session::get('per')['know_ques'])
                            @if (Session::get('per')['know_ques'] == 'true')
                                <li class="submenu">
                                    <a href="settings.html"> <span> Bilim savollar </span><span
                                            class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="{{ route('knowledge.create') }}">Asosiy savollar</a></li>
                                        <li><a href="{{ route('pill-question.create') }}">Asosiy kategoriya</a></li>
                                        <li><a href="{{ route('condition-question.create') }}">Ichki kategoriya</a></li>
                                        <li><a href="{{ route('knowledge-question.create') }}">Savollar</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endisset
                    </ul>
                </li> --}}











                @isset(Session::get('per')['control'])
                    @if (Session::get('per')['control'] == 'true')
                        <li class="submenu">
                            <a href="settings.html"><i class="fas fa-vihara"></i> <span> User boshqaruvi </span><span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="{{ route('user-control') }}">Status</a></li>
                                <li><a href="{{ route('user-register') }}">Registratsiya</a></li>
                                <li><a href="{{ route('users-without-pharmacy') }}">New users</a></li>

                                <li><a href="{{ route('blacklist.all') }}">Bloklanganlar</a></li>
                                <li><a href="{{ route('dublicat.index') }}">Duclicat elchilar</a></li>
                                <li><a href="{{ route('users-crystall') }}">User tashqi market</a></li>
                                @isset(Session::get('per')['all_user'])
                                    @if (Session::get('per')['all_user'] == 'true')
                                        <li>
                                            <a href="{{ route('users-all') }}">
                                                <span>
                                                    Elchilar
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endisset
                            </ul>
                        </li>
                    @endif
                @endisset

                {{-- @isset(Session::get('per')['zavod'])
             @if (Session::get('per')['zavod'] == 'true')
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



                {{-- @isset(Session::get('per')['User'])
             @if (Session::get('per')['User'] == 'true')
               <li><a href="{{route('user-list')}}"><i class="feather-filter"></i>  <span>Adminlar </span></a>
             </li>
             @endif
             @endisset --}}

                {{-- @isset(Session::get('per')['rol'])
             @if (Session::get('per')['rol'] == 'true')
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
                    @if (Session::get('per')['rol'] == 'true')
                        <li class="submenu">
                            {{-- @if (isset(Session::get('per')['rol_create']) || isset(Session::get('per')['rol_read'])) --}}
                            <a href="settings.html"><i class="fas fa-user-shield"></i> <span> Rol System </span><span
                                    class="menu-arrow"></span></a>
                            {{-- @endisset --}}
                            <ul style="display: none;">
                                {{-- @isset(Session::get('per')['rol_create']) --}}
                                <li><a href="{{ route('admin-list') }}">Admin</a></li>
                                {{-- @endisset --}}
                                {{-- @isset(Session::get('per')['rol_read']) --}}
                                <li><a href="{{ route('rm-list') }}">RM</a></li>
                                <li><a href="{{ route('cap-list') }}">Capitan</a></li>
                                <li><a href="{{ route('user-list') }}">Elchi</a></li>
                                {{-- @endisset --}}
                            </ul>
                        </li>
                    @endif
                @endisset
                <li class="submenu">
                    <a href="settings.html">
                        <i class="fas fa-cog"></i>
                    <span> Sozlamalar </span>
                    <span class="menu-arrow"></span>
                    </a>
                    <ul style="display: none;">
                        @isset(Session::get('per')['narx'])
                            @if (Session::get('per')['narx'] == 'true')
                                <li class="submenu">
                                    <a href="settings.html"><span> Narx </span><span
                                            class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="{{ route('shablon.create') }}">Narx yaratish</a></li>
                                        <li><a href="{{ route('shablon.pharmacy') }}">Dorixona biriktirish</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endisset
                                @isset(Session::get('per')['setting'])
                            @if (Session::get('per')['setting'] == 'true')
                                <li><a href="{{ route('setting', date('m.Y')) }}"><i class="fas fa-calendar-week"></i>
                                        <span>Kalendar </span></a>
                                </li>
                            @endif
                        @endisset
                    </ul>
                </li>
                <li class="mb-5"><a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="fas fa-sign-out-alt"></i> <span> Chiqish </span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    {{-- @isset(Session::get('per')['User']) --}}
                    {{-- @if (Session::get('per')['User'] == 'true') --}}

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
