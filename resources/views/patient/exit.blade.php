@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
       <div class="row align-items-center">
          <div class="col-md-12">
             <div class="d-flex align-items-center">
                <ul class="breadcrumb ml-2">
                   <li class="breadcrumb-item"><a href="/main"><i class="fas fa-home"></i></a></li>
                   <li class="breadcrumb-item active"> {{__('app.exodus')}} </li>
                </ul> 
             </div>
          </div>
       </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
           <div class="card">
              <div class="card-body">
                 {{-- <div class="table-responsive"> --}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <form action="{{ url('patient/store_exit') }}" method="POST" autocomplete="off">
                                @csrf
                            <input id="for_patient" onmouseleave="$('#to_patient').css('display','none')" onmouseenter="$('#to_patient').css('display','')" type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="{{__('app.search')}}" onkeyup="filterFunctionExit()" required/>
                            
                            <div style="border:1px solid #ddd;display:none;" class="ml-3 ml-auto rounded" onmouseleave="$(this).css('display','none')" id="to_patient">
                               @foreach($patient as $key => $value)
                               
                         <div class="row">
                            <div class="col-md-12">
                               <a href="#" onmouseleave="$('#to_patient').css('display','none')" onmouseenter="$('#to_patient').css('display','')" onclick="$('#for_id').val({{$value->id}}),$('#for_patient').val(this.text),$('#to_patient').css('display','none')" style="display:block;" class="pt-1 pl-2 float-left">{{ $value->first_name }} {{ $value->last_name }} {{ $value->full_name }}({{ $value->pinfl }})</a>
                            </div>
                         </div>
                
                               @endforeach
                            </div>
                            {{-- <select class="form-control form-control-sm" name="hospital" id="h_name_f_user" required>
                              @isset($patient)
                              <option value="" disabled selected hidden></option>
      
                              @foreach($patient as $key => $value)
                              <option value="{{ $value->id }}">{{ $value->first_name }}</option>
                              @endforeach
                              @endisset
                              
                          </select> --}}
                         </div>
                         <div class="form-group col-md-1">
                            <input id="for_id" type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" placeholder="{{__('app.search')}}" />
                         </div>
                         <div class="form-group col-md-5">
                            <div class="form-check form-check-inline mt-2">
                               <input class="form-check-input" type="radio" name="isxod" value="true" required/>
                               <label class="form-check-label" for="gender_male"> {{__('app.no_dead')}} </label>
                            </div>
                            <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="isxod" value="false" />
                               <label class="form-check-label" for="gender_female"> {{__('app.dead')}} </label>
                            </div>
                         </div>
                         <div class="mt-4 ml-auto mr-2">
                            <button type="submit" class="btn btn-primary"> {{ __('app.save') }} </button>
                        </div>
                    </form>

                    </div>
                 {{-- </div> --}}
              </div>
           </div>
        </div>
     </div>
 </div>
@endsection
