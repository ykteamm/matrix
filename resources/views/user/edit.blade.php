
@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
       <div class="row align-items-center">
          <div class="col-md-12">
             <div class="d-flex align-items-center">
                <ul class="breadcrumb ml-2">
                   <li class="breadcrumb-item"><a href="/main"><i class="fas fa-home"></i></a></li>
                   <li class="breadcrumb-item active">{{__('app.patient_list')}} </li>
                </ul>
             </div>
          </div>
       </div>
    </div>
    <div class="row">
      <div class="col-xl-12 col-md-12">
         <div class="card">
            <div class="card-header">
               <h5 class="card-title">Основная информация </h5>
            </div>
            <div class="card-body">
               <form action="{{ route('user.store') }}" method="POST" autocomplete="off">
                   @csrf
                   {{-- @isset(Session::get('pos')) --}}
                      @if(Session::get('pos') == 'hospital')
                      <div class="row form-group">
                        <label class="col-sm-3 col-form-label input-label ml-5" id="r_name_f"> filial </label>
                        <div class="col-sm-6" id="r_name_f_user">
                           <select class="form-control form-control-sm" name="filial">
                               {{-- @if(Session::get('pos') == "hospital") --}}
                               @isset($user)
                                <option value="{{ $user[0]->hospital_key }}" selected >{{ $user[0]->hospital_name }}</option>   
                               @endisset 
                               {{-- @endif --}}
                              @isset($b_name)
                              @foreach($b_name as $key => $value)
                              <option value="{{ $key }}">{{ $value }}</option>
                                 
                              @endforeach
                              @endisset
                              @isset($hos_name)
                              <option value="none">{{ $hos_name }}</option>
                              @endisset
                           </select>
                        </div>
                     </div>
                      @endif
                   {{-- @endisset --}}
              <div class="row form-group">
                 <label class="col-sm-3 col-form-label input-label ml-5" id="r_name_f"> rol </label>
                 <div class="col-sm-6" id="r_name_f_user">
                    <select class="form-control form-control-sm" name="role_id">
                        @isset($user)
                                <option value="{{ $user[0]->rol_id }}" selected >{{ $user[0]->role_name }}</option>   
                        @endisset 
                       {{-- <option value="" disabled selected hidden id="r_name_user"></option> --}}
                       @isset($rol)
                       @foreach($rol as $key => $value)
                       <option value="{{ $value->id }}">{{ $value->role_name }}</option>
                          
                       @endforeach
                       @endisset
                    </select>
                 </div>
              </div>
                  <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label ml-5"> Имя </label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="user_name" required autocomplete="off" @isset($user) value="{{ $user[0]->user_name }}" @endisset />
                     </div>
                  </div>
                  <div class="row form-group">
                    <label class="col-sm-3 col-form-label input-label ml-5"> Adres </label>
                    <div class="col-sm-6">
                       <input type="text" class="form-control form-control-sm" name="adress" required autocomplete="off" @isset($user) value="{{ $user[0]->user_adress }}" @endisset/>
                    </div>
                 </div>
                 <div class="row form-group">
                    <label class="col-sm-3 col-form-label input-label ml-5"> tel nomer </label>
                    <div class="col-sm-6">
                       <input type="text" class="form-control form-control-sm" name="phone" required autocomplete="off" @isset($user) value="{{ $user[0]->user_phone }}" @endisset/>
                    </div>
                 </div>
                  <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label ml-5"> Эмаил </label>
                     <div class="col-sm-6">
                        <input type="email" class="form-control form-control-sm" id="email" name="email" required autocomplete="off" @isset($user) value="{{ $user[0]->email }}" @endisset/>
                     </div>
                  </div>
                  <div class="text-right">
                     <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
 </div>
@endsection
