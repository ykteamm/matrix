@extends('layouts.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
       <div class="row align-items-center">
          <div class="col-md-12">
             <div class="d-flex align-items-center">
                <ul class="breadcrumb ml-2">
                   <li class="breadcrumb-item"><a href="/main"><i class="fas fa-home"></i></a></li>
                   <li class="breadcrumb-item active">{{__('app.list_user')}} </li>
                </ul>
                <div class="ml-auto" > <button type="button" id="toggleButton" class="btn btn-outline-primary"> {{ __('app.add_user')}} </button> </div>
             </div>
          </div>
       </div>
    </div>
   <div class="row" style="display: none;" id="for_toggleButton">
      <div class="col-xl-12 col-md-12">
         <div class="card">
            <div class="card-header">
               <h5 class="card-title">{{ __('app.basic_info') }}</h5>
            </div>
            <div class="card-body">
               <form action="{{ route('s_user') }}" method="POST" autocomplete="off">
                   @csrf
              @if ($h_name == 'none')
              <div class="row form-group">
                 <label class="col-sm-3 col-form-label input-label ml-5" id="b_name_f"> {{ __('app.filial') }} </label>
                 <div class="col-sm-6" id="b_name_f_user">
                    <select id='select_branch' class="form-control form-control-sm" name="branch" required>
                       <option value="{{ $db }}"  selected hidden>{{ $hos_name }}</option>
                    </select>
                 </div>
                 </div>
             @else
             <div class="row form-group">
               <label class="col-sm-3 col-form-label input-label ml-5">{{ __('app.hospital_a') }}</label>
              
               <div class="col-sm-6">
                  <select class="form-control form-control-sm" name="hospital" id="h_name_f_user" required>
                     <option value="{{ $db }}"  selected hidden>{{ $hos_name }}</option>
                 </select>
               </div>
            </div>
            <div class="row form-group">
               <label class="col-sm-3 col-form-label input-label ml-5" id="b_name_f"> {{ __('app.filial') }} </label>
               <div class="col-sm-6" id="b_name_f_user">
                  <select id='select_branch' class="form-control form-control-sm" name="branch" required>

                     @isset($h_name)
                     <option value="" disabled selected hidden></option>


                     @foreach($h_name as $key => $value)
                     <option value="{{ $key }}">{{ $value }}
                     </option>
                     @endforeach
                     @endisset
                  </select>
               </div>
            </div>
             @endif
              <div class="row form-group">
                 <label class="col-sm-3 col-form-label input-label ml-5" id="r_name_f"> {{ __('app.position') }} </label>
                 <div class="col-sm-6" id="r_name_f_user">
                    <select class="form-control form-control-sm" name="rol_id" required>
                       <option value="" disabled selected hidden id="r_name_user"></option>
                       @isset($rol_name)
                        <option value="" disabled selected hidden></option>

                        @foreach($rol_name as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->role_name }}
                        </option>
                        @endforeach
                        @endisset
                    </select>
                 </div>
              </div>
                  <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.first_name') }} </label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="user_name" required/>
                     </div>
                  </div>
                  <div class="row form-group">
                    <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.adres') }}  </label>
                    <div class="col-sm-6">
                       <input type="text" class="form-control form-control-sm" name="adress" required/>
                    </div>
                 </div>
                 <div class="row form-group">
                    <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.patient_phone') }}  </label>
                    <div class="col-sm-6">
                       <input type="text" id="phone" class="form-control form-control-sm" name="phone" required/>
                    </div>
                 </div>
                  <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.email') }}</label>
                     <div class="col-sm-6">
                        <input type="email" class="form-control form-control-sm for_email" id="email" name="email" required/>
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
                  @if ($h_name == 'none')
              {{-- <div class="row form-group"> --}}
                 {{-- <label class="col-sm-3 col-form-label input-label ml-5" id="b_name_f"> {{ __('app.filial') }} </label> --}}
                 <div class="col-sm-6" style="display: none;">
                  <input type="text" class="form-control form-control-sm" name="hospital" value="{{ $h_db }}"/>
                 </div>
                 {{-- </div> --}}
                @endif
                  <div class="text-right">
                     <button type="submit" class="btn btn-primary for_email_button"> {{ __('app.add_data') }} </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            {{-- <div class="card-header">
               <h4 class="card-title">Default Datatable </h4>
               <p class="card-text">
                  This is the most _____ example of the datatables ____ zero configuration. Use the  <code>.datatable </code> class to initialize __________.
               </p>
            </div> --}}
            <div class="card-body">
               <div class="table-responsive">
                  <table class="datatable table table-stripped">
                     <thead>
                        <tr>
                           <th>№</th>
                           {{-- <th>{{__('app.hospital_a')}}</th> --}}
                           <th>{{__('app.first_name')}}</th>
                           <th>{{__('app.patient_phone')}}</th>
                           <th>{{__('app.position')}}</th>
                           {{-- <th class="text-right">{{__('app.action')}}</th> --}}
                        </tr>
                     </thead>
                     <tbody>
                         @isset($users)
                         @foreach($users as $key => $value)
                         <tr>
                           <td>{{ $key+1 }}</td>
                           {{-- @if($value->branch_name == 'none')
                           <td>{{ $value->hospital_name }}</td>
                           @else
                           <td>{{ $value->branch_name }}</td>
                           @endif --}}
                           <td>{{ $value->user_name }}</td>
                           <td>{{ $value->user_phone }}</td>
                           <td><span class="badge badge-pill bg-success-light">{{ $value->rol->role_name }}</span></td>
                           {{-- <td class="text-right">
                               <a href="{{ route('patient.show',$value->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-eye mr-1"></i></a>
                               <a href="{{ route('a_e_user',$value->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-edit mr-1"></i></a>
                               <a href="{{ route('a_d_user',$value->id)}}" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i></a>
                            </td> --}}
                        </tr>
                         @endforeach
                         @endisset
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
 </div>
@endsection


