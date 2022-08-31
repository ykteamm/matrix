
@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
       <div class="row align-items-center">
          <div class="col-md-6">
             <div class="d-flex align-items-center">
                <ul class="breadcrumb ml-2">
                   <li class="breadcrumb-item"><a href="/main"><i class="fas fa-home"></i></a></li>
                   <li class="breadcrumb-item active">{{__('app.patient_list')}} </li>
                </ul>
             </div>
             
          </div>
          <div class="col-md-3">
         </div>

          <div class="col-md-3">
            <div class="dropdown" data-toggle="dropdown">
               {{-- <a href="javascript:void(0);" class="btn btn-white btn-sm dropdown-toggle" role="button" data-toggle="dropdown">
               This Week
               </a> --}}
               <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" data-toggle="dropdown">  1 </button>
               <div class="dropdown-menu dropdown-menu-right" style="height: 100px;overflow-y:scroll;">
                  @foreach ($patient as $item => $key)
                  <a href="#" onclick="thisClick({{$item}} + 1)" class="dropdown-item"> {{ $item + 1 }} </a>
                      
                  @endforeach
                  {{-- <a href="#" onclick="ageChart('a_today')" class="dropdown-item" id="a_today"> Сегодня </a>
                  <a href="#" onclick="ageChart('a_week')" class="dropdown-item" id="a_week">Неделя </a>
                  <a href="#" onclick="ageChart('a_month')" class="dropdown-item" id="a_month">Месяц  </a>
                  <a href="#" onclick="ageChart('a_year')" class="dropdown-item" id="a_year">Год </a>
                  <a href="#" onclick="ageChart('a_all')" class="dropdown-item" id="a_all">Все </a> --}}
               </div>
               {{-- <div class="form-group">
                  <select class="form-control">
                      <option>Default select1</option>
                      <option>Default select2</option>
                      <option>Default select3</option>
                  </select>
              </div> --}}
            </div>
          </div>
       </div>
    </div>
    @foreach ($patient as $item => $patients)

    <div class="row show-patient" id="show{{$item+1}}"  @if($item != 0) style="display: none" @endif>
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
                            <th>{{__('app.pinfl')}} </th>
                            <th>{{__('app.last_name')}} </th>
                            <th>{{__('app.first_name')}} </th>
                            <th>{{__('app.patient_phone')}} </th>
                            <th>{{__('app.patient_age')}} </th>
                            <th>{{__('app.hospital_date')}} </th>
                            <th>{{__('app.province')}} </th>
                            <th>{{__('app.gender')}} </th>
                            <th class="text-right">Action </th>
                         </tr>
                      </thead>
                      <tbody>
                          @isset($patients)
                          @foreach($patients as $key => $value)
                          <tr>
                            <td>{{ $value->pinfl }}</td>
                            <td><a href="{{ route('patient.show',$value->id) }}">{{ $value->last_name }}</a></td>
                            <td><a href="{{ route('patient.show',$value->id) }}">{{ $value->first_name }}</a></td>
                            <td>{{ $value->phone }} </td>
                            <td>{{ $value->age }} </td>
                            <td>{{ date('d.m.Y', strtotime($value->case_date)); }}</td>
                            <td>{{ $value->province_name }}</td>
                            @if($value->gender == true)
                            <td>{{__('app.male_c')}}</td>
                            @else
                            <td>{{__('app.female_c')}}</td>
                            @endif
                            <td class="text-right">
                              @isset(Session::get('per')['p_read'])
                                 <a href="{{ route('patient.show',$value->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-eye mr-1"></i></a>
                              @endisset
                              @isset(Session::get('per')['p_update'])
                                 <a href="{{ route('patient.edit',$value->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-edit mr-1"></i></a>
                              @endisset
                              @isset(Session::get('per')['p_delete'])
                                <a href="{{ route('patient.delete',$value->id)}}" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i></a>
                              @endisset
                             </td>
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
    @endforeach

 </div>
@endsection
@section('scripts')
<script>
function thisClick(numb) {
   $("#age_button").text(numb);
    $('.show-patient').css('display','none');
   $(`#show${numb}`).css('display','block');

 }
//  $(document).ready(function(){
//    var numb = $("#age_button").text();
//    alert(numb)
//    //  $(`#show${numb}`).css('display','block');

//  });
</script>

@endsection

