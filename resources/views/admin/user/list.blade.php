
@extends('admin.layouts.app')

@section('admin_content')
<div class="content container-fluid">
   @if ($errors->any())
   <div class="alert alert-danger" id="message">
       <ul>
           @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
   </div>
   @endif
   @if (Session::has('message'))
   <div class="alert alert-primary" id="message">
       <ul>
            <li>{{ Session::get('message') }}</li>
       </ul>
   </div>
   @endif
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
                            <th>{{__('app.first_name')}}</th>
                            <th>{{__('app.patient_phone')}}</th>
                            <th>{{__('app.position')}}</th>
                            <th>{{__('app.hospital')}}</th>
                            <th>{{__('app.filial')}}</th>
                            @if(isset(Session::get('per')['user_update']) || isset(Session::get('per')['user_read']))
                            <th class="text-right">{{__('app.action')}}</th>
                            @endif
                         </tr>
                      </thead>
                      <tbody>
                          @isset($users)
                          @foreach($users as $key => $value)
                          <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $value->user_name }}</td>
                            <td>{{ $value->user_phone }}</td>
                            @if(isset($value->rol->rol_name))
                            <td><span class="badge badge-pill bg-success-light">{{ $value->rol->rol_name }}</span></td>
                            @endif
                            @if($value->branch == NULL)
                              @if(isset($value->hospital->hospital_name))
                              <td>{{ $value->hospital->hospital_name }}</td>
                              @endif
                            
                            <td>-</td>
                            @else
                            <td>-</td>
                            @if(isset($value->branch->branch_name))
                            <td>{{ $value->branch->branch_name }}</td>
                              @endif
                            
                            @endif
                            <td class="text-right">
                                {{-- <a href="{{ route('patient.show',$value->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-eye mr-1"></i></a> --}}
                              @isset(Session::get('per')['user_update'])
                                <a href="{{ route('a_e_user',$value->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-edit mr-1"></i></a>
                              @endisset

                              @isset(Session::get('per')['user_delete'])
                                <a href="{{ route('a_d_user',$value->id)}}" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i></a>
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
 </div>
@endsection
