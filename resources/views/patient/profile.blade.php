@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
       <div class="row align-items-center">
          <div class="col-md-12">
             <div class="d-flex align-items-center">
                <ul class="breadcrumb ml-2">
                   <li class="breadcrumb-item"><a href="/main"><i class="fas fa-home"></i></a></li>
                   <li class="breadcrumb-item active"> {{ $patient->last_name }} {{ $patient->first_name }} {{ $patient->full_name }} </li>
                </ul> 
             </div>
          </div>
       </div>
    </div>
    <div class="row">
       <div class="col-12 col-xl-4 d-flex flex-wrap">
          {{-- <div class="card">
             <div class="card-body">
                <div class="general-details text-center">
                   <img src="/assets/img/profiles/avatar-18.jpg" class="img-fluid" alt="" />
                   <h4>Frances Runnels </h4>
                   <h6><a href="../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="0f697d6e616c4f6a776e627f636a216c6062">[email&#160;protected] </a></h6>
                   <a href="chat.html" class="btn-chat">Send Message </a>
                </div>
             </div>
          </div> --}}
          <div class="card">
            <div class="card-header">
               <h4 class="card-title">{{__('app.patient')}} </h4>
            </div>
            <div class="card-body">
               <h2 style="text-align: center;">{{ $patient->last_name }} {{ $patient->first_name }} {{ $patient->full_name }}</h2>
            </div>
         </div>
       </div>
       <div class="col-12 col-xl-8 d-flex flex-wrap">
          <div class="card">
             <div class="card-body pb-0">
                <div class="patient-details d-block">
                   <div class="details-list">
                      <div>
                         <h6>{{ __('app.pinfl') }}</h6>
                         <span class="ml-auto">{{ $patient->pinfl }} </span>
                      </div>
                      <div>
                        <h6>{{ __('app.pasport') }} </h6>
                        <span class="ml-auto">{{ Str::upper($patient->passport)}}  </span>
                     </div>
                      <div>
                         <h6>{{ __('app.patient_date') }} </h6>
                         <span class="ml-auto">{{ date('d.m.Y', strtotime($patient->birth_day)); }} </span>
                      </div>
                      <div>
                         <h6>{{ __('app.gender') }} </h6>
                         @if($patient->gender == true)
                         <span class="ml-auto"> {{ __('app.male') }} </span>
                         @else
                         <span class="ml-auto"> {{ __('app.female') }} </span>
                         @endif
                      </div>
                      <div>
                         <h6>{{ __('app.province') }}  </h6>
                         <span class="ml-auto">{{ $patient->province_name }} </span>
                      </div>
                      <div>
                         <h6>{{ __('app.patient_age') }}  </h6>
                         <span class="ml-auto">{{ $patient->age }} </span>
                      </div>
                      <div>
                         <h6>{{ __('app.patient_rost') }}  </h6>
                         <span class="ml-auto">{{ $patient->height }}м </span>
                      </div>
                      <div>
                        <h6>{{ __('app.patient_ves') }}  </h6>
                        <span class="ml-auto">{{ $patient->weight }}кг </span>
                     </div>
                     <div>
                        <h6>{{ __('app.patient_phone') }}  </h6>
                        <span class="ml-auto">{{ $patient->phone}} </span>
                     </div>
                     <div>
                        <h6>{{ __('app.hospital_date') }}  </h6>
                        <span class="ml-auto">{{ date('d.m.Y', strtotime($patient->case_date));}} </span>
                     </div>
                     <div>
                        <h6>{{ __('app.admission') }} </h6>
                        @if($patient->admission == true)
                        <span class="ml-auto"> {{ __('app.ambulance') }} </span>
                        @else
                        <span class="ml-auto"> {{ __('app.samotek') }} </span>
                        @endif
                     </div>
                     <div>
                        <h6>{{ __('app.hospital_number') }}  </h6>
                        <span class="ml-auto">{{ $patient->case_number}} </span>
                     </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="row">
       <div class="col-lg-4">
          {{-- <div class="card">
             <div class="card-header">
                <h4 class="card-title">Clinical Reminders </h4>
             </div>
             <div class="card-body">
                <ul class="clinical-rem">
                   <li><b>Measurment </b> of  <b>Blood Pressure </b> need to be _____ </li>
                   <li><b>Bloog Sugar </b> must have  <b>Average </b> value </li>
                   <li><b>Measurment </b> of  <b>Blood Sugar </b> need to be _____ </li>
                </ul>
             </div>
          </div> --}}
          <div class="card">
            <div class="card-header">
               <h4 class="card-title">{{__('app.diagnos')}} </h4>
            </div>
            <div class="card-body">
               <ul class="p-0 med-prb">
                 @isset($diagnos)
                 {{-- @foreach($diagnos as $key => $value) --}}
                 <li><i class="fas fa-file-medical-alt"></i>{{ __($diagnos['diagnos']) }} ({{ __($diagnos['time']) }}) </li>
                     
                 {{-- @endforeach --}}
                 @endisset
               </ul>
            </div>
         </div>
          <div class="card">
             <div class="card-header">
                <h4 class="card-title">{{__('app.add_diagnos')}} </h4>
             </div>
             <div class="card-body">
                <ul class="p-0 med-prb">
                  @isset($illness)
                  @foreach($illness as $key => $value)
                  @if($key == '_token' || $key == 'patient_id' || $key == 'diagnos' || $key == 'time')
                     
                  @else
                  @if ($value == 'app.oks_pod' || $value == 'app.oks_bez_pod' || $value == 'app.oks_bez_infarct' || $value == 'app.angina' || $value == 'app.oks_infarct' || $value == '' || $value == 'app.other')
                      
                  @else
                  @if ($key == 'other_name_d')
                  @isset($value)

                  <li><i class="fas fa-file-medical-alt"></i> {{__('app.other')}} {{ __($value) }} </li>
                  @endisset
                      
                  @else
                  <li><i class="fas fa-file-medical-alt"></i> {{ __($value) }} </li>
                      
                  @endif
                  @endif

                  @endif
                  @endforeach
                  @endisset
                </ul>
             </div>
          </div>
          <div class="card">
            <div class="card-header">
               <h4 class="card-title">{{__('app.examination')}} </h4>
            </div>
            <div class="card-body">
               <ul class="p-0 med-prb">
                 @isset($patient_exam)
                 @foreach($patient_exam as $key => $value)
                 @if($key == '_token' || $key == 'patient_id' || $key == 'radio' || $value == 'app.other')
                    
                 @else
                 @if ($key == 'check_other2_e')
                 @isset($value)
                 <li><i class="fas fa-file-medical-alt"></i> {{__('app.other')}} {{ __($value) }} </li>
                     
                 @endisset
                     
                 @else

                 @if($key == 'ad')

                 <li><i class="fas fa-file-medical-alt"></i> {{__('app.ad')}} {{ __($value) }} </li>
                  @elseif($key == 'pulse')
                  <li><i class="fas fa-file-medical-alt"></i> {{__('app.pulse')}} {{ __($value) }} </li>
                  @elseif($key == 'rate')
                  <li><i class="fas fa-file-medical-alt"></i> {{__('app.rate')}} {{ __($value) }} </li>
                  @elseif($key == 'saturation')
                  <li><i class="fas fa-file-medical-alt"></i> {{__('app.saturation')}} {{ __($value) }} </li>
                  @elseif($key !== 'ad' || $key !== 'pulse' || $key !== 'rate' || $key !== 'saturation')
                  <li><i class="fas fa-file-medical-alt"></i>  {{ __($value) }} </li>
                 @endif
                 @endif

                 @endif
                 @endforeach
                 @endisset
               </ul>
            </div>
         </div>
          {{-- <div class="card">
             <div class="card-header">
                <h4 class="card-title float-left">Medications </h4>
             </div>
             <div class="card-body">
                <div class="d-flex mb-4">
                   <div class="medicne d-flex">
                      <i class="fas fa-pills"></i>
                      Desmopressin tabs
                   </div>
                </div>
                <div class="d-flex mb-4">
                   <div class="medicne d-flex">
                      <i class="fas fa-syringe"></i>
                      Abciximab-injection
                   </div>
                </div>
                <div class="d-flex mb-4">
                   <div class="medicne d-flex">
                      <i class="fas fa-pills"></i>
                      Kevzara sarilumab
                   </div>
                </div>
                <div class="d-flex mb-4">
                   <div class="medicne d-flex">
                      <i class="fas fa-pills"></i>
                      Paliperidone palmitate
                   </div>
                </div>
                <div class="d-flex mb-4">
                   <div class="medicne d-flex">
                      <i class="fas fa-syringe"></i>
                      Sermorelin-injectable
                   </div>
                </div>
                <div class="d-flex mb-4">
                   <div class="medicne d-flex">
                      <i class="fas fa-syringe"></i>
                      Abciximab-injection
                   </div>
                </div>
                <div class="d-flex">
                   <div class="medicne d-flex">
                      <i class="fas fa-pills"></i>
                      Kevzara sarilumab
                   </div>
                </div>
             </div>
          </div> --}}
          
       </div>
       <div class="col-lg-8">
          <div class="row">
             <div class="col-xl-4 col-lg-6 d-flex flex-wrap">
                <div class="card details-box">
                   <div class="card-body">
                      <div class="mb-3 pt-icon1 pt-icon">
                         <img src="/assets/img/icons/stethoscope.svg" alt="" width="26" class="m-auto" />
                      </div>
                      <h5>BP </h5>
                      <span class="mt-0">120/80 mmHg (Average) </span>
                      <div class="progress progress-md mt-2">
                         <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-xl-4 col-lg-6 d-flex flex-wrap">
                <div class="card details-box">
                   <div class="card-body">
                      <div class="mb-3 pt-icon2 pt-icon">
                         <img src="/assets/img/icons/pulse.svg" alt="" width="26" class="m-auto" />
                      </div>
                      <h5>Pulse </h5>
                      <span class="mt-0">73/min (Low) </span>
                      <div class="progress progress-md mt-2">
                         <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                   </div>
                </div>
             </div>
             <!--<div class="col-xl-4 col-lg-6 d-flex flex-wrap">-->
             <!--   <div class="card details-box">-->
             <!--      <div class="card-body">-->
             <!--         <div class="mb-3 pt-icon3 pt-icon">-->
             <!--            <img src="/assets/img/icons/egg-and-bacon.svg" alt="" width="26" class="m-auto" />-->
             <!--         </div>-->
             <!--         <h5>Cholesterol </h5>-->
             <!--         <span class="mt-0">230 mg/dL (High) </span>-->
             <!--         <div class="progress progress-md mt-2">-->
             <!--            <div class="progress-bar bg-danger" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>-->
             <!--         </div>-->
             <!--      </div>-->
             <!--   </div>-->
             <!--</div>-->
             <div class="col-xl-4 col-lg-6 d-flex flex-wrap">
                <div class="card details-box">
                   <div class="card-body">
                      <div class="mb-3 pt-icon4 pt-icon">
                         <img src="/assets/img/icons/thermometer.svg" alt="" width="26" class="m-auto" />
                      </div>
                      <h5>Temperature </h5>
                      <span class="mt-0">{{ $patient->temp}} C </span>
                      <div class="progress progress-md mt-2">
                         <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-xl-4 col-lg-6 d-flex flex-wrap">
                <div class="card details-box">
                   <div class="card-body">
                      <div class="mb-3 pt-icon5 pt-icon">
                         <img src="/assets/img/icons/breath-in.svg" alt="" width="26" class="m-auto" />
                      </div>
                      <h5>Respiration </h5>
                      <span class="mt-0">20/min (Average) </span>
                      <div class="progress progress-md mt-2">
                         <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-xl-4 col-lg-6 d-flex flex-wrap">
                <div class="card details-box">
                   <div class="card-body">
                      <div class="mb-3 pt-icon6 pt-icon">
                         <img src="/assets/img/icons/bathroom-scale.svg" alt="" width="26" class="m-auto" />
                      </div>
                      <h5>BMI </h5>
                      <span class="mt-0">{{ $patient->bmi}} kg/m^2 </span>
                      <div class="progress progress-md mt-2">
                         <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-xl-6">
                {{-- <div class="card"> --}}
                   
                   <div class="card flex-fill">
                     <div class="card-header">
                        <h4 class="card-title"> {{ __('app.ekg') }} </h4>
                     </div>
                     <div class="card-body">
                        <ul class="activity-feed">
                              @isset($ekg)
                              @foreach($ekg as $key => $value)
                           <li class="feed-item">
        
                              <div class="feed-date">{{ $value->created_at->format('d.m.Y') }} <a href="" class="btn btn-sm text-success"><i class="fas fa-eye mr-1"></i></a></div>
                              
                              <span class="feed-text"> ЕКГ {{ $value->created_at->format('l jS \of h:i') }} </span>
                              
                           </li>
                           
        
                              @endforeach
                              @endisset
                              
                              
                        </ul>
                     </div>
                  </div>
                {{-- </div> --}}
             </div>
             <div class="col-xl-6">
               {{-- <div class="card"> --}}
                  
                  <div class="card flex-fill">
                    <div class="card-header">
                       <h4 class="card-title">{{ __('app.exo') }} </h4>
                    </div>
                    <div class="card-body">
                       <ul class="activity-feed">
                             @isset($exo)
                             @foreach($exo as $key => $value)
                             <li class="feed-item">
        
                              <div class="feed-date">{{ $value->created_at->format('d.m.Y') }}</div>
                              
                              <span class="feed-text"> ЕХО {{ $value->created_at->format('l jS \of h:i') }} </span>
                           </li>
       
                             @endforeach
                             @endisset
                             
                             
                       </ul>
                    </div>
                 </div>
               {{-- </div> --}}
            </div>
             {{-- <div class="col-lg-12">
                <div class="card">
                   <div class="card-header pb-0">
                      <ul class="nav nav-tabs nav-tabs-bottom">
                         <li class="nav-item"><a class="nav-link active" href="#solid-tab3" data-toggle="tab">Choices </a></li>
                         <li class="nav-item"><a class="nav-link" href="#solid-tab4" data-toggle="tab">Employer </a></li>
                         <li class="nav-item"><a class="nav-link" href="#solid-tab5" data-toggle="tab">Stats </a></li>
                         <li class="nav-item"><a class="nav-link" href="#solid-tab7" data-toggle="tab">Guardian </a></li>
                      </ul>
                   </div>
                   <div class="card-body">
                      <div class="tab-content pt-0">
                         <div class="tab-pane show active" id="solid-tab3">
                            <div class="tab-data">
                               <div class="tab-left">
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Desmopressin
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>Billy Smith </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        HIPAA Notice Received
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p class="text-success">Yes </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Leave Message With
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>Phil </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Allow SMS
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p class="text-danger">No </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Allow Health Information Exchange
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p class="text-danger">No </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Allow Health Information Exchange
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p class="text-success">Yes </p>
                                     </div>
                                  </div>
                               </div>
                               <div class="tab-right">
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Allow Voice Message
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p class="text-danger">No </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Allow Mail Message
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p class="text-success">Yes </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Allow Email
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p class="text-success">Yes </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Allow Patient Portal
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p class="text-danger">No </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Publicity Code Effective Date
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>25/11/2019 </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Publicity Code
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>ADS54SS5 </p>
                                     </div>
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="tab-pane" id="solid-tab4">
                            <div class="tab-data">
                               <div class="tab-left">
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Occupation
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>Pen User </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Employer Address
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>Watchahee Road </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        State
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>Florida </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Country
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>USA </p>
                                     </div>
                                  </div>
                               </div>
                               <div class="tab-right">
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Employer Name
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p> Using Pens Inc. </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        City
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>Longview </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Postal Code
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>444333 </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Industry
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p />
                                     </div>
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="tab-pane" id="solid-tab5">
                            <div class="tab-data">
                               <div class="tab-left">
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Desmopressin
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>Billy </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        HIPAA
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p class="text-success">Yes </p>
                                     </div>
                                  </div>
                               </div>
                               <div class="tab-right">
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Allow
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p class="text-danger">No </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Allow
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p class="text-success">Yes </p>
                                     </div>
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="tab-pane" id="solid-tab7">
                            <div class="tab-data">
                               <div class="tab-left">
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Name
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p> Kirsten Deleon </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Sex
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>Female </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        City
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>Orland Park </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Postal Code
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>60462 </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Phone
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>708-873-0628 </p>
                                     </div>
                                  </div>
                               </div>
                               <div class="tab-right">
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Relationship
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>Father </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Address
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>3071 John Calvin Drive </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        State
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>IL </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Country
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p>England </p>
                                     </div>
                                  </div>
                                  <div class="d-flex mb-3">
                                     <div class="medicne d-flex">
                                        Email
                                     </div>
                                     <div class="medicne-time ml-auto">
                                        <p><a href="../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="e192829797a18c80888dcf8f8495">[email&#160;protected] </a></p>
                                     </div>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div> --}}
             {{-- <div class="col-lg-12">
                <div class="card flex-fill">
                   <div class="card-header no-border">
                      <h4 class="card-title">Upcoming Appointments </h4>
                   </div>
                   <div class="card-body">
                      <div class="table-responsive">
                         <table class="table mb-0">
                            <thead>
                               <tr>
                                  <th>ID </th>
                                  <th>Doctor Name </th>
                                  <th>Department </th>
                                  <th>Date </th>
                                  <th>Time </th>
                                  <th>Disease </th>
                                  <th>Status </th>
                               </tr>
                            </thead>
                            <tbody>
                               <tr>
                                  <td>APT0001 </td>
                                  <td>Dr.Jay Soni </td>
                                  <td>Cardiology </td>
                                  <td>11 Dec 2019 </td>
                                  <td>10:00am-12:00am </td>
                                  <td>Cold </td>
                                  <td class="text-success">Approved </td>
                               </tr>
                               <tr>
                                  <td>APT0002 </td>
                                  <td>Dr.Sarah Smith </td>
                                  <td>Gynaecology </td>
                                  <td>5 Dec 2019 </td>
                                  <td>10:00am-12:00am </td>
                                  <td>Fever </td>
                                  <td class="text-danger">Canceled </td>
                               </tr>
                               <tr>
                                  <td>APT0003 </td>
                                  <td>Dr.John Deo </td>
                                  <td>Neurology </td>
                                  <td>6 Jan 2020 </td>
                                  <td>10:00am-12:00am </td>
                                  <td>heart </td>
                                  <td class="text-success">Approved </td>
                               </tr>
                            </tbody>
                         </table>
                      </div>
                   </div>
                </div>
             </div> --}}
             {{-- <div class="col-lg-12">
                <div class="card flex-fill">
                   <div class="card-header no-border">
                      <h4 class="card-title">Disclosures </h4>
                   </div>
                   <div class="card-body">
                      <div class="table-responsive">
                         <table class="table mb-0">
                            <thead>
                               <tr>
                                  <th>Type </th>
                                  <th>Provider </th>
                                  <th class="text-right">Summary </th>
                               </tr>
                            </thead>
                            <tbody>
                               <tr>
                                  <td>Payment </td>
                                  <td>Donna Lee </td>
                                  <td class="text-right"><a href="#">View Summary </a></td>
                               </tr>
                               <tr>
                                  <td>Treatment </td>
                                  <td>Gavin </td>
                                  <td class="text-right"><a href="#">View Summary </a></td>
                               </tr>
                               <tr>
                                  <td>HealthCare </td>
                                  <td>Gavin </td>
                                  <td class="text-right"><a href="#">View Summary </a></td>
                               </tr>
                               <tr>
                                  <td>Payment </td>
                                  <td>Donna Lee </td>
                                  <td class="text-right"><a href="#">View Summary </a></td>
                               </tr>
                            </tbody>
                         </table>
                      </div>
                   </div>
                </div>
             </div> --}}
          </div>
       </div>
    </div>
 </div>
@endsection
