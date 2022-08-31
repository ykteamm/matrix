<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
       <div id="sidebar-menu" class="sidebar-menu">
          <ul style="margin-top: 25%;">
             {{-- <li class="menu-title">  <span>Main </span>
             </li>
             <li class="active">  <a href="index.html"><i class="feather-home"></i><span class="shape1"></span><span class="shape2"></span><span>Dashboard </span></a>
             </li> --}}
             <li><a href="/home"><i class="feather-home"></i>  <span> {{ __('app.home') }} </span></a>
             </li>
             {{-- <li class="submenu">
                <a href="#"><i class="feather-user"></i>  <span>{{ __('app.patient') }} </span>  <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                   <li><a href="{{ route('patient.create')}}">{{ __('app.patient_add') }}  </a></li>
                   <li><a href="{{ route('patient.index')}}" onclick="pList()">{{ __('app.patient_list') }} </a></li>
                </ul>
             </li> --}}
             {{-- <li><a href="{{ route('ekg.index')}}"><i class="feather-activity"></i>  <span>{{ __('app.ekg') }} </span></a>
             </li>
             <li><a href="{{ route('exo.index')}}"><i class="feather-activity"></i>  <span>{{ __('app.exo') }} </span></a>
             </li>
             <li><a href="{{ url('patient_exit')}}"><i class="feather-refresh-cw"></i>  <span> {{ __('app.exodus') }} </span></a>
             </li> --}}
             {{-- <li class="submenu">
                <a href="#"><i class="feather-map-pin"></i>  <span>{{ __('app.adres') }} </span>  <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                   <li><a href="{{ route('province.index')}}">{{ __('app.province_add') }}</a></li>
                   <li><a href="{{ route('district.index')}}">{{ __('app.district_add') }}</a></li>
                </ul>
             </li> --}}
             {{-- <li><a href="{{ route('ekg.index')}}"><i class="feather-activity"></i>  <span>{{ __('app.ekg') }} </span></a> --}}
             </li>
             <li class="submenu">
               @if(isset(Session::get('per')['user_create']) || isset(Session::get('per')['user_read']))
               <a href="settings.html"><i class="feather-users"></i>  <span> {{ __('app.user') }} </span><span class="menu-arrow"></span></a>
               @endif
               <ul style="display: none;">
               @isset(Session::get('per')['user_create'])
                  <li><a href="{{ route('user.create')}}">{{ __('app.add_user') }}</a></li>
               @endisset
               @isset(Session::get('per')['user_read'])
                  <li><a href="{{ route('user.index')}}">{{ __('app.list_user') }}</a></li>
               @endisset
               </ul>
            </li>
            {{-- <li class="submenu">
               <a href="settings.html"><i class="feather-settings"></i>  <span> {{ __('app.setting') }} </span><span class="menu-arrow"></span></a>
               <ul style="display: none;"> --}}
               @isset(Session::get('per')['hospital_read'])
                  <li><a href="{{ route('hospital.index')}}"><i class="feather-plus-circle"></i> <span>{{ __('app.add_hospital') }} </span></a></li>
               @endisset

               @isset(Session::get('per')['branch_read'])
                  <li><a href="{{ route('branch.index')}}"><i class="feather-plus-circle"></i> <span>{{ __('app.add_filial') }} </span></a></li>
               @endisset
                  <li class="submenu">
                  @if(isset(Session::get('per')['rol_create']) || isset(Session::get('per')['rol_read']))
                     <a href="settings.html"><i class="feather-shield"></i>  <span> {{ __('app.position') }} </span><span class="menu-arrow"></span></a>
                  @endisset
                     <ul style="display: none;">
                     @isset(Session::get('per')['rol_create'])
                        <li><a href="{{ route('position.create')}}">{{ __('app.add_position') }}</a></li>
                     @endisset
                     @isset(Session::get('per')['rol_read'])
                        <li><a href="{{ route('position.index')}}">{{ __('app.list_position') }}</a></li>
                     @endisset
                     </ul>
                  </li>
               {{-- </ul>
            </li> --}}
            {{-- <li><a href="{{ route('back') }}"><i class="feather-home"></i>  <span> 2 </span></a> --}}
          </ul>
       </div>
    </div>
    <div class="modal fade show" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-body">
                     <form action="{{ route('branch.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="form-group col-md-12">
                           <label> {{ __('app.hospital') }} </label>
                              <select class="form-control form-control-sm" name="hospital_id" id="get-branchs">
                                 @isset($hospitals)
                                 <option value="" disabled selected hidden></option>
   
                                 @foreach($hospitals as $key => $value)
                                 <option value="{{ $value->id }}">{{ $value->hospital_name }}
                                 </option>
                              @endforeach
                                 @endisset
                                 
                              </select>
                        </div>
                        <div class="form-group col-md-12">
                           <label> {{ __('app.filial') }} </label>
                           <input type="text" name="branch_name" class="form-control form-control-sm" />
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
       {{-- <div class="modal-footer">
         <button type="button" class="btn btn-primary">Save changes</button>
       </div> --}}
     </div>
   </div>
</div>
 </div>