<div class="sidebar mt-5">
    <div class="sidebar-inner">
        <div id="sidebar-menu" style="height: 100vh; overflow-y: scroll" class="sidebar-menu">
            <ul>


                <li><a href="{{ route('super-admin-list') }}"><i class="fas fa-filter"></i> <span>Ruhsatlar</span></a>
                
                    <li class="mb-5">
                        <a href="{{ route('admin-logout') }}">
                            <i
                                class="fas fa-sign-out-alt">
                            </i> 
                            <span> Chiqish </span>
                        </a>
                    </li>


                {{-- @isset(Session::get('per')['rekrut'])
                    @if (Session::get('per')['rekrut'] == 'true')

                        @if (in_array(Session::get('user')->rm,[1,2]))
                            <li><a href="{{ route('rekrut') }}"><i class="fas fa-filter"></i> <span>Rekruting</span></a>
                        @else
                        <li><a href="{{ route('rekrut-add-user') }}"><i class="fas fa-filter"></i> <span>Rekruting</span></a>
                        @endif
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
                </li> --}}

            </ul>
        </div>
    </div>
</div>
