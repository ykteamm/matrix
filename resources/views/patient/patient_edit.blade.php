
@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
       <div class="row align-items-center">
          <div class="col-md-12">
             <div class="d-flex align-items-center">
                <ul class="breadcrumb ml-2">
                   <li class="breadcrumb-item"><a href="/main"><i class="fas fa-home"></i></a></li>
                   <li class="breadcrumb-item active">{{__('app.update_user')}} </li>
                </ul>
             </div>
          </div>
       </div>
    </div>
 </div>
 <div class="row">
   <div class="col-md-12">
      <div class="card bg-white">
         <div class="card-body">
            <form action="{{ route('patient.update',$id) }}" method="POST" autocomplete="off">
               {{ method_field('PATCH') }}
               @csrf
               <div class="row">
                  <div class="form-group col-md-3">
               <div id="success"></div>
                  <label> {{ __('app.pinfl') }}  </label>
                     <input type="text" name="pinfl"  maxlength="14" class="form-control form-control-sm" value="{{$patient->pinfl}}"/>
                  </div>
                  <div class="form-group col-md-3">
                     <label> {{ __('app.last_name') }} </label>
                     <input type="text" name="last_name" class="form-control form-control-sm" value="{{$patient->last_name}}" required/>
                  </div>
                  <div class="form-group col-md-3">
                     <label> {{ __('app.first_name') }} </label>
                     <input type="text" name="first_name" class="form-control form-control-sm" value="{{$patient->first_name}}" required/>
                  </div>
                  
                  <div class="form-group col-md-3">
                     <label> {{ __('app.fio') }} </label>
                     <input type="text" name="full_name" class="form-control form-control-sm" value="{{$patient->full_name}}" required/>
                  </div>
                  <div class="form-group col-md-3">
                     <label> {{ __('app.pasport') }}  </label>
                     <input style="text-transform: uppercase;" type="text" name="passport" value="{{$patient->passport}}" id="passport" class="form-control form-control-sm" placeholder="AB1234567"/>
                  </div>
                  <div class="form-group col-md-3">
                     <label> {{__('app.patient_phone')}} </label>
                     <input type="text" id="phone" name="phone" class="form-control form-control-sm" value="{{$patient->phone}}"/>
                  </div>
                  @if($patient->birth_day == NULL)
                  <div class="form-group col-md-2">
                     <label> {{ __('app.patient_date') }} </label>
                     <input type="text" id="date" name="birth_date" class="form-control form-control-sm" placeholder="дд.мм.гггг"/>
                  </div>
                  @else
                  <div class="form-group col-md-2">
                     <label> {{ __('app.patient_date') }} </label>
                     <input type="text" id="date" name="birth_date" class="form-control form-control-sm" placeholder="дд.мм.гггг" value="{{ date('d.m.Y', strtotime($patient->birth_day)) }}"/>
                  </div>
                  @endif
                  <div class="form-group col-md-2">
                     <label> {{__('app.patient_age')}} </label>
                     <input type="number" name="age" class="form-control form-control-sm" id="age" value="{{$patient->age}}" readonly/>
                  </div>
                  <div class="form-group col-md-2">
                              <label> {{ __('app.patient_temp') }} </label>
                              <input type="text" name="temp" class="form-control form-control-sm"  value="{{$patient->temp}}" required/>
                           </div>
                  <div class="form-group col-md-2">
                     <label> {{ __('app.province') }} </label>
                     <select class="form-control form-control-sm" name="province_id" class="form-control form-control-sm" id="province" required>
                        {{-- <option value="" disabled selected hidden></option> --}}
                        @foreach($province as $key => $value)
                        @if($value->id == $patient->province_id)
                        <option selected value="{{ $value->id }}">{{ $value->province_name }}
                        </option>
                        @endif
                        <option value="{{ $value->id }}">{{ $value->province_name }}
                        </option>
                        @endforeach
                     </select>
                  </div>
                  <div class="form-group col-md-2" id="for_district">
                     <label id="add_select"> {{ __('app.district') }} </label>
                     <select class="form-control form-control-sm" name="district_id" id="place_dist">
                        @foreach($district as $key => $value)
                        @if($value->id == $patient->district_id)
                        <option selected value="{{ $value->id }}">{{ $value->district_name }}
                        </option>
                        @endif
                        <option value="{{ $value->id }}">{{ $value->district_name }}
                        </option>
                        @endforeach
                     </select>
                  </div>
                  {{-- <div class="form-group col-md-2" id="for_district">
                     <label> {{ __('app.district') }} </label>
                     <input type="number" class="form-control form-control-sm" disabled/>
                  </div> --}}
                  <div class="form-group col-md-2" style="display: none" id="district">
                     <label id="add_select2"> {{ __('app.district') }} </label>
                     <select class="form-control form-control-sm" name="district_id" id="place_dist2">
                        <option value="" disabled selected hidden id="add_option"></option>
                     </select>
                  </div>
                  <div class="form-group col-md-2" id="div_rost">
                     <label> {{ __('app.patient_rost') }} </label>   
                     <div class="input-group">
                        <input class="form-control form-control-sm" id="rost" name="height" type="text" step="any" id="rost" value="{{$patient->height}}" required/>
                        <div class="input-group-prepend">
                           <span class="input-group-text"> метр </span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group col-md-2">
                     <label> {{ __('app.patient_ves') }} </label>
                     <div class="input-group">
                        <input class="form-control form-control-sm" name="weight" type="number" id="ves" value="{{$patient->weight}}" required/>
                        <div class="input-group-prepend">
                           <span class="input-group-text"> кг </span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group col-md-2">
                     <label> {{ __('app.patient_imt') }} </label>
                     <input type="number" class="form-control form-control-sm" name="bmi" step="any" id="imt" value="{{$patient->bmi}}" readonly/>
                  </div>
                  <div class="form-group col-md-2">
                     <label class="d-block"> {{__('app.gender')}} </label>
                     @if($patient->gender == true)
                     <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="radio" name="gender" id="gender_male" checked value="true" required/>
                        <label class="form-check-label" for="gender_male"> {{__('app.male')}} </label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="gender_female" value="false" />
                        <label class="form-check-label" for="gender_female"> {{__('app.female')}} </label>
                     </div>
                     @endif
                     @if($patient->gender == false)
                     <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="radio" name="gender" id="gender_male" value="true" required/>
                        <label class="form-check-label" for="gender_male"> {{__('app.male')}} </label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="gender_female" checked value="false" />
                        <label class="form-check-label" for="gender_female"> {{__('app.female')}} </label>
                     </div>
                     @endif
                  </div>
               </div>
               <div class="card-header mb-3">
                  <h5 class="card-title">{{__('app.hospital')}}</h5>
               </div>
               <div class="row">
                  <div class="form-group col-md-3">
                     <label> {{__('app.hospital_number')}} </label>
                     <input type="number" value="{{ $patient->case_number }}" name="case_number" class="form-control form-control-sm" readonly/>
                  </div>
                  <div class="form-group col-md-3">
                     <label> {{__('app.hospital_date')}} </label>
                     <input type="text" name="case_date" class="form-control form-control-sm" placeholder="дд.мм.гггг" value="{{ date('d.m.Y i:s', strtotime($patient->case_date)) }}" required/>
                  </div>
                  {{-- <div class="form-group col-md-3">
                     <label> {{__('app.hospital_time')}} </label>
                     <input type="text" id="case_time" name="case_time" class="form-control form-control-sm" placeholder="чч:мм" required/>
                  </div> --}}
                  <div class="form-group col-md-6">
                     <label class="d-block"> {{__('app.admission')}} </label>
                     @if($patient->admission == true)
                     <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="radio" name="amb" id="gender_male" value="true" checked required/>
                        <label class="form-check-label" for="gender_male"> {{__('app.samotek')}} </label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="amb" id="gender_female" value="false" />
                        <label class="form-check-label" for="gender_female"> {{__('app.ambulance')}} </label>
                     </div>
                     @endif
                     @if($patient->admission == false)
                     <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="radio" name="amb" id="gender_male" value="true" checked required/>
                        <label class="form-check-label" for="gender_male"> {{__('app.samotek')}} </label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="amb" id="gender_female" value="false" />
                        <label class="form-check-label" for="gender_female"> {{__('app.ambulance')}} </label>
                     </div>
                     @endif
                  </div>
                  <div class="mt-4 ml-auto mr-2">
                     <button type="submit" class="btn btn-primary" id="add_data"> {{ __('app.update') }} </button>
                 </div>
                 {{-- </div> --}}
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
