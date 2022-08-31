@extends('admin.layouts.app')
@section('admin_content')
<div class="content container-fluid">
    <div class="page-header">
       <div class="row align-items-center">
          <div class="col-md-12">
             <div class="d-flex align-items-center">
                {{-- <h5 class="page-title">Dashboard </h5> --}}
                <ul class="breadcrumb ml-2">
                   <li class="breadcrumb-item"><a href="{{ route('super_admin') }}"><i class="fas fa-home"></i></a></li>
                   {{-- <li class="breadcrumb-item"><a href="">Dashboard </a></li> --}}
                   <li class="breadcrumb-item active">{{ __('app.edit_user') }}</li>
                </ul>
             </div>
          </div>
       </div>
    </div>
    <div class="row">
       <div class="col-xl-12 col-md-12">
          <div class="card">
             <div class="card-header">
                <h5 class="card-title">{{ __('app.basic_info') }}</h5>
             </div>
             <div class="card-body">
                <form action="{{ route('a_u_user',$user->id) }}" method="POST" autocomplete="off">
                    @csrf
                 <div class="row form-group">
                  <label class="col-sm-3 col-form-label input-label ml-5">{{ __('app.hospital_a') }}</label>
                  <div class="col-sm-6">
                     <select class="form-control form-control-sm" name="hospital" id="h_name_f_user" required>
                        @isset($h_name)
                        <option value="{{ $user->hospital_key }}" selected hidden>{{ $user->hospital_name }}</option>

                        @foreach($h_name as $key => $value)
                        <option value="{{ $key }}">{{ $value }}
                        </option>
                        @endforeach
                        @endisset
                        
                    </select>
                  </div>
               </div>
               <div class="row form-group">
                  <label class="col-sm-3 col-form-label input-label ml-5" id="b_name_f"> {{ __('app.filial') }} </label>
                  <div class="col-sm-6" id="b_name_f_user">
                     <select id='select_branch' class="form-control form-control-sm" name="branch" required>
                        @if($user->hospital_name == 'none')
                            <option value="{{ $user->hospital_key }}" selected hidden>{{ $user->hospital_name }}</option>
                        @else
                            <option value="{{ $user->branch_key }}" selected hidden>{{ $user->branch_name }}</option>
                            @isset($b_name_array)
                            @foreach($b_name_array as $key => $value)
                            <option value="{{ $key }}">{{ $value }}
                            </option>
                            @endforeach
                            @endisset
                        @endif

                        
                     </select>
                  </div>
               </div>
               <div class="row form-group">
                  <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.position') }} </label>
                  <div class="col-sm-6">
                     <select class="form-control form-control-sm" name="role_id" required>
                        @isset($listRol)
                        <option value="{{ $user->rol->id }}" selected hidden>{{ $user->rol->role_name }}</option>

                        @foreach($listRol as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->role_name }}
                        </option>
                        @endforeach
                        @endisset
                        {{-- <option value="super" disabled selected hidden id="r_name_user"></option> --}}
                     </select>
                  </div>
               </div>
                   <div class="row form-group">
                      <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.first_name') }} </label>
                      <div class="col-sm-6">
                         <input type="text" class="form-control form-control-sm" name="user_name" value="{{$user->user_name}}" required/>
                      </div>
                   </div>
                   <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.adres') }}  </label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="adress" value="{{$user->user_adress}}" required/>
                     </div>
                  </div>
                  <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.patient_phone') }}  </label>
                     <div class="col-sm-6">
                        <input type="text" id="phone" class="form-control form-control-sm" name="phone" value="{{$user->user_phone}}" required/>
                     </div>
                  </div>
                   <div class="row form-group">
                      <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.email') }}</label>
                      <div class="col-sm-6">
                         <input type="email" class="form-control form-control-sm for_email" id="email" name="email" value="{{$user->email}}" required/>
                      </div>
                     <div id="error_email" style="display:none;">uji yest</div>

                   </div>
                   {{-- <div class="row form-group"> --}}

                  {{-- </div> --}}

                   <div class="row form-group">
                    <label class="col-sm-3 col-form-label input-label ml-5"> Парол </label>
                    <div class="col-sm-6">
                       <input type="password" class="form-control form-control-sm" id="password" name="password" minlength="8" required/>
                       <span class="fas fa-eye toggle-password mr-2" onclick="myFunction()"></span>
                    </div>
                 </div>
                   {{-- <div class="row form-group">
                      <label for="phone" class="col-sm-3 col-form-label input-label">Phone  <span class="text-muted">(Optional) </span></label>
                      <div class="col-sm-9">
                         <input type="text" class="form-control" id="phone" placeholder="+x(xxx)xxx-xx-xx" value="+1 (304) 499-13-66" />
                      </div>
                   </div> --}}
                   <div class="text-right">
                      <button type="submit" class="btn btn-primary for_email_button"> {{ __('app.add_data') }} </button>
                   </div>
                </form>
             </div>
          </div>
       </div>
    </div>
 </div>
 @endsection
       