@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <ul class="breadcrumb ml-2">
                <li class="breadcrumb-item"><a href="/main"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{ __('app.ekg') }} </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-md-12">
           <div class="card">
              <div class="card-body">
                <form action="{{ route('ekg.store') }}" method="POST" autocomplete="off">
                    @csrf
                 <div class="row">
                    @isset($ekg_add)
                    <div class="col-md-7 container-fluid">
                        <input id="for_id_ekg_add" type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" />
                     </div>
           
                     <div class="form-group col-md-5 container-fluid" style="">
                        <input id="for_diagnos_ekg_add" onmouseleave="$('#to_diagnos_ekg_add').css('display','none')" onmouseenter="$('#to_diagnos_ekg_add').css('display','')" type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" onkeyup="filterFunctionEkg2()" required/>
                        
                        <div style="border:1px solid #ddd;display:none;overflow-y: scroll;height:80%;"  class="ml-3 ml-auto rounded" onmouseleave="$(this).css('display','none')" id="to_diagnos_ekg_add">
                           @foreach($ekg_add as $key => $value)
                           <div class="row">
                              <div class="col-md-12">
                                 
                           <a href="#" id="for_diagnos_ekg_add" onmouseleave="$('#to_diagnos_ekg_add').css('display','none')" onmouseenter="$('#to_diagnos_ekg_add').css('display','')" onclick="$('#for_id_ekg_add').val({{$value->id}}),$('#for_diagnos_ekg_add').val(this.text),$('#to_diagnos_ekg_add').css('display','none')" style="display:block;" class="pt-1 pl-2 float-left">{{ $value->last_name }} {{ $value->first_name }} {{ $value->full_name }} ({{ $value->pinfl }})</a>
                              </div>
                           </div>
           
                           @endforeach
                        </div>
                     </div>
                    @endisset
                    <div class="form-group col-md-2">
                     <div class="checkbox col-md-12">
                        <label>
                           <h6>{{__('app.ritm')}}:</h6>
                        </label>
                     </div>
                     <div class="col-md-12">
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.norma" name="ritm" /> {{__('app.norma')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.sinus" name="ritm" /> {{__('app.sinus')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.fp" name="ritm" /> {{__('app.fp')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.tp" name="ritm" /> {{__('app.tp')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.jt" name="ritm" /> {{__('app.jt')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.fj" name="ritm" required/> {{__('app.fj')}}
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group col-md-2">
                     <div class="checkbox col-md-12">
                        <label>
                           <h6>{{__('app.st')}}:</h6>
                        </label>
                     </div>
                     <div class="col-md-12">
                         <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.norma" name="ritm_st" /> {{__('app.norma')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label id="label_st_12">
                           <input type="radio" value="app.elevation" name="ritm_st" onclick="rEkg('label_st_12')" required/> {{__('app.elevation')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label id="label_st_22">
                           <input type="radio" value="app.depression" name="ritm_st" onclick="rEkg('label_st_22')"/> {{__('app.depression')}}
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group col-md-2">
                     <div class="checkbox col-md-12">
                        <label>
                           <h6>{{__('app.zubec_t')}}:</h6>
                        </label>
                     </div>
                     <div class="col-md-12">
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.norma" name="zubec_t" /> {{__('app.norma')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.smoot" name="zubec_t" /> {{__('app.smoot')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.negativ" name="zubec_t" /> {{__('app.negativ')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.pointed" name="zubec_t" required/> {{__('app.pointed')}}
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group col-md-2">
                     <div class="checkbox col-md-12">
                        <label>
                           <h6>{{__('app.zubec_q')}}:</h6>
                        </label>
                     </div>
                     <div class="col-md-12">
                        <label>
                        <input type="radio" value="app.norma" name="zubec_q" /> {{__('app.norma')}}
                        </label>
                     </div>
                     <div class="col-md-12">
                        <label>
                        <input type="radio" value="app.front_wall" name="zubec_q" /> {{__('app.front_wall')}}
                        </label>
                     </div>
                     <div class="col-md-12">
                        <label>
                        <input type="radio" value="app.lateral_wall" name="zubec_q" /> {{__('app.lateral_wall')}}
                        </label>
                     </div>
                     <div class="col-md-12">
                        <label>
                        <input type="radio" value="app.bottom_wall" name="zubec_q" required/> {{__('app.bottom_wall')}}
                        </label>
                     </div>
                  </div>
                  <div class="form-group col-md-2">
                     <div class="checkbox col-md-12">
                        <label>
                           <h6>{{__('app.blockade')}}:</h6>
                        </label>
                     </div>
                     <div class="col-md-12">
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.norma" name="blockade" /> {{__('app.norma')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.blockade_l" name="blockade" /> {{__('app.blockade_l')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.blockade_p" name="blockade" required/> {{__('app.blockade_p')}}
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group col-md-2">
                     <div class="checkbox col-md-12">
                        <label>
                           <h6>{{__('app.av_blockade')}}:</h6>
                        </label>
                     </div>
                     <div class="col-md-12">
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.norma" name="av_blockade" /> {{__('app.norma')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.stepen_1" name="av_blockade" /> {{__('app.stepen_1')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.stepen_2" name="av_blockade" /> {{__('app.stepen_2')}}
                           </label>
                        </div>
                        <div class="col-md-12">
                           <label>
                           <input type="radio" value="app.stepen_3" name="av_blockade" required/> {{__('app.stepen_3')}}
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group col-md-12">
                     <div class="checkbox col-md-12">
                        <label>
                           <h6>{{__('app.marker')}}:</h6>
                        </label>
                     </div>
                     <div class="col-md-12">
                        <div class="col-md-12 mb-3">
                           <div class="row">
                              <label class="col-md-2" id="for_troponin_t2"><input type="radio" value="app.troponin_t" name="ekg_marker" onclick="rMarker('for_troponin_t2')"/> {{__('app.troponin_t')}}</label>
                           </div>
                        </div>
                        <div class="col-md-12 mb-3">
                           <div class="row">
                              <label class="col-md-2" id="for_troponin_i2"><input type="radio" value="app.troponin_i" name="ekg_marker" onclick="rMarker('for_troponin_i2')"/> {{__('app.troponin_i')}}</label>
                           </div>
                        </div>
                        <div class="col-md-12 mb-3">
                           <div class="row">
                              <label class="col-md-2" id="for_kfk2"><input type="radio" value="app.kfk" name="ekg_marker" onclick="rMarker('for_kfk2')"/> {{__('app.kfk')}}</label>
                           </div>
                        </div>
                     </div>
                  </div>
                       <div class="mt-4 ml-auto mr-2">
                          <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                      </div>
                 </div>
                </form>
              </div>
           </div>
        </div>
     </div>
</div>
@endsection