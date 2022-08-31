
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
                            <th>{{__('app.pinfl')}} </th>
                            <th>{{__('app.hospital')}} </th>
                            
                            <th class="text-right">Запрос </th>
                            {{-- <th class="text-right">Ответ </th> --}}
                         </tr>
                      </thead>
                      <tbody>
                          @isset($patient_hospital)
                          @foreach($patient_hospital as $key => $value)
                          <tr>
                            <td>{{ $value->pinfl }}</td>
                            <td>{{ $value->hospital_name }}</td>
                            
                            <td class="text-right">
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider round"></span>
                                  </label>
                             </td>
                         </tr>
                          @endforeach
                          @endisset
                          @isset($patient_branch)
                          @foreach($patient_branch as $key => $value)
                          <tr>
                            <td>{{ $value->pinfl }}</td>
                            <td>{{ $value->hospital_name }} <p>{{ $value->branch_name }}</p></td>
                            
                            <td class="text-right">
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider round"></span>
                                  </label>
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

