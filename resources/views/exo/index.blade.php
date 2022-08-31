@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <ul class="breadcrumb ml-2">
                <li class="breadcrumb-item"><a href="/main"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{ __('app.exo') }} </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-md-12">
           <div class="card">
              <div class="card-body">
                <form action="{{ route('exo.store') }}" method="POST" autocomplete="off">
                    @csrf
                 <div class="row">
                    @isset($exo_add)
                    <div class="col-md-7 container-fluid">
                        <input id="for_id_exo_add" type="text" style="width:40%;visibility:hidden;" name="patient_id" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" />
                     </div>
           
                     <div class="form-group col-md-5 container-fluid" style="">
                        <input id="for_diagnos_exo_add" onmouseleave="$('#to_diagnos_exo_add').css('display','none')" onmouseenter="$('#to_diagnos_exo_add').css('display','')" type="text" class="form-control form-control-sm ml-3 ml-auto" placeholder="Поиск" onkeyup="filterFunctionExo2()" required/>
                        
                        <div style="border:1px solid #ddd;display:none;overflow-y: scroll;height:80%;"  class="ml-3 ml-auto rounded" onmouseleave="$(this).css('display','none')" id="to_diagnos_exo_add">
                           @foreach($exo_add as $key => $value)
                           <div class="row">
                              <div class="col-md-12">
                                 
                           <a href="#" id="for_diagnos_exo_add" onmouseleave="$('#to_diagnos_exo_add').css('display','none')" onmouseenter="$('#to_diagnos_exo_add').css('display','')" onclick="$('#for_id_exo_add').val({{$value->id}}),$('#for_diagnos_exo_add').val(this.text),$('#to_diagnos_exo_add').css('display','none')" style="display:block;" class="pt-1 pl-2 float-left">{{ $value->last_name }} {{ $value->first_name }} {{ $value->full_name }} ({{ $value->pinfl }})</a>
                              </div>
                           </div>
           
                           @endforeach
                        </div>
                     </div>
                    @endisset
                    <div class="col-md-12">
                     <div class="col-md-12 mb-3 ml-3">
                           <div class="row">
                              <label class="col-md-2">{{__('app.kdo')}}</label>
                              <div class="form-group col-md-6">
                              <input type="text" name="kdo" style="border:solid 1px #ddd;padding:5px 5px;" class="ml-2 w-100 rounded" required/>
                              </div>
                           </div>
                     </div>
                     <div class="col-md-12 mb-3 ml-3">
                           <div class="row">
                              <label class="col-md-2">{{__('app.kso')}}</label>
                              <div class="form-group col-md-6">
                              <input type="text" name="kso" style="border:solid 1px #ddd;padding:5px 5px;" class="ml-2 w-100 rounded" required/>
                              </div>
                           </div>
                     </div>
                     <div class="col-md-12 mb-3 ml-3">
                           <div class="row">
                              <label class="col-md-2">{{__('app.uo')}}</label>
                              <div class="form-group col-md-6">
                              <input type="text" name="uo" style="border:solid 1px #ddd;padding:5px 5px;" class="ml-2 w-100 rounded" required/>
                              </div>
                           </div>
                     </div>
                     <div class="col-md-12 mb-3 ml-3">
                           <div class="row">
                              <label class="col-md-2">{{__('app.fb')}}</label>
                              <div class="form-group col-md-6">
                              <input type="text" name="fb" style="border:solid 1px #ddd;padding:5px 5px;" class="ml-2 w-100 rounded" required/>
                              </div>
                           </div>
                     </div>
                  </div>
                  {{-- <div class="row"> --}}
                  <div class="form-group col-md-6">
                     <div class="col-md-12">
                           <label><h6>{{__('app.kinetika')}}:</h6></label>
                     </div>
                     <div class="form-group col-md-12">
                           <div class="col-md-12">
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.norma" name="exo_kinetik" onclick="rKinetika('none_label')"/> {{__('app.norma')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label id="label_gipokinez">
                                 <input type="radio" value="app.gipokinez" name="exo_kinetik" onclick="rKinetika('label_gipokinez')"/> {{__('app.gipokinez')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label id="label_akinez">
                                 <input type="radio" value="app.akinez" name="exo_kinetik" onclick="rKinetika('label_akinez')"/> {{__('app.akinez')}}
                                 </label>
                              </div>
                              <div class="col-md-12">
                                 <label id="label_diskinez">
                                 <input type="radio" value="app.diskinez" name="exo_kinetik" onclick="rKinetika('label_diskinez')" required/> {{__('app.diskinez')}}
                                 </label>
                              </div>
                           </div>
                     </div>
                  </div>
                  <div class="form-group col-md-6">
                     <div class="col-md-12">
                           <label><h6>{{__('app.klapan')}}:</h6></label>
                     </div>
                     <div class="form-group col-md-12">
                           <div class="col-md-12">
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.nak" name="klapan"/> {{__('app.nak')}}
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.nmk" name="klapan"/> {{__('app.nmk')}}
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="col-md-12">
                                 <label>
                                 <input type="radio" value="app.ntk" name="klapan"/> {{__('app.ntk')}}
                                 </label>
                              </div>
                           </div>
                     </div>
                  </div>
                  <div class="form-group col-md-12">
                     <div class="col-md-12">
                           <label>
                           <input type="checkbox" name="app.other" id="check_other3"/> {{__('app.other')}}
                           </label>
                           <input type="text" name="other_exo" style="border: none;border-bottom:solid 1px black;display:none" class="ml-2 w-50" id="other3"/>
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