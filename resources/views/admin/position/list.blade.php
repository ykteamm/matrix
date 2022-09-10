
@extends('admin.layouts.app')

@section('admin_content')
<div class="content container-fluid">
   {{-- @if (Session::has('message'))
   <div class="alert alert-primary" id="message">
       <ul>
            <li>{{ Session::get('message') }}</li>
       </ul>
   </div>
   @endif --}}
    {{-- <div class="page-header">
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
    </div> --}}
    <div class="row calender-col" style="margin-top: 45px">
      <div class="col-xl-12 d-flex">
      <div class="card flex-fill">
      <div class="card-header">
         <h5 class="card-title" style="text-align: center">                  
            <img src="{{asset('nvt/logo2.png')}}" style="height: 100px;" class="img-fluid" alt="" />
         </h5>
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
                            <th>Rol nomi</th>
                            @if(isset(Session::get('per')['rol_update']) || isset(Session::get('per')['rol_delete']))
                            <th class="text-right">Action</th>
                            @endif
                         </tr>
                      </thead>
                      <tbody>
                          @isset($positions)
                          @foreach($positions as $key => $value)
                          <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $value->rol_name }}</td>
                            <td class="text-right">
                                {{-- <a href="{{ route('patient.show',$value->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-eye mr-1"></i></a> --}}
                              {{-- @isset(Session::get('per')['rol_update']) --}}
                                <a href="{{ route('position.edit',$value->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-edit mr-1"></i></a>
                              {{-- @endisset --}}
                              {{-- @isset(Session::get('per')['rol_delete']) --}}
                                {{-- <a href="{{ route('position.delete',$value->id)}}" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i></a> --}}
                              {{-- @endisset --}}
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
