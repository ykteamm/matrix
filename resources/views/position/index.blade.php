@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <ul class="breadcrumb ml-2">
                        <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item active">{{ __('app.list_position') }}</li>
                    </ul>
                    <div class="ml-auto" > <button type="button" id="toggleButton" class="btn btn-outline-primary"> {{ __('app.add_position')}} </button> </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row" style="display: none;" id="for_toggleButton">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('position.store') }}" method="POST">
                        @csrf
                            {{-- <div class="row"> --}}
                            

                            {{-- <div class="form-group col-md-6">
                                <label class="col-sm-2 col-form-label input-label ml-auto"> Rol </label>   
                                <div class="col-sm-4">

                                   <input type="text" class="form-control form-control-sm" name="rol" required autocomplete="off"/>
                                </div>
                            </div> --}}
                        {{-- </div> --}}

                            <div class="row form-group">
                                <div class="col-md-6 ml-auto">
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label input-label pr-auto"> {{ __('app.position')}} </label>
                                <div class="col-sm-9">
                                   <input type="text" class="form-control form-control-sm" name="rol" required autocomplete="off"/>
                                </div>
                                    </div>
                                    
                                </div>
                                
                             </div>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th> {{__('app.rol_n')}} </th>
                                        <th style="text-align: center;"> {{__('app.create')}} </th>
                                        <th style="text-align: center;"> {{__('app.read')}} </th>
                                        <th style="text-align: center;"> {{__('app.update')}} </th>
                                        <th style="text-align: center;"> {{__('app.delete')}} </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($positions)
                                    @foreach($positions as $key => $position)
                                    <tr>
                                        <td> {{ $position }} </td>
                                        <td style="text-align: center;"> <input style="width: 17px;height: 17px;" type="checkbox" value="create" name="{{$key.'_create'}}" /> </td>
                                        <td style="text-align: center;"> <input style="width: 17px;height: 17px;" type="checkbox" value="read" name="{{$key.'_read'}}" /> </td>
                                        <td style="text-align: center;"> <input style="width: 17px;height: 17px;" type="checkbox" value="update" name="{{$key.'_update'}}" /> </td>
                                        <td style="text-align: center;"> <input style="width: 17px;height: 17px;" type="checkbox" value="delete" name="{{$key.'_delete'}}" /> </td>
                                    </tr>
                                    @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="mt-4 ml-auto mr-2">
                                <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                            </div>
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
                             <th>{{__('app.name_positon')}} </th>
                             {{-- @if(Session::get('pos') == 'branch')
                             <th>{{__('app.pinfl')}} </th>
                             @endif
                             <th>{{__('app.pinfl')}} </th>
                             <th>{{__('app.pinfl')}} </th>
                             <th>{{__('app.pinfl')}} </th>
                             <th>{{__('app.pinfl')}} </th> --}}
                             <th class="text-right">{{__('app.action')}} </th>
                          </tr>
                       </thead>
                       <tbody>
                           @isset($rol)
                           @foreach($rol as $key => $value)
                           <tr>
                             <td>{{ $key+1 }}</td>
                             <td>{{ $value->role_name }}</td>
                             {{-- @if(Session::get('pos') == 'branch')
                             <td>{{ $value->branch_name }}</td>
                             @endif
                             <td>{{ $value->user_name }}</td>
                             <td>{{ $value->user_phone }}</td>
                             <td>{{ $value->email }}</td>
                             <td><span class="badge badge-pill bg-success-light">{{ $value->role_name }}</span></td> --}}
                             <td class="text-right">
                                
                                 {{-- <a class="btn btn-sm btn-white text-success mr-2" data-toggle="modal" data-target="#exampleModalCenter" onclick="editRol($value->id,$value->role_name)"><i class="fas fa-edit mr-1"></i></a> --}}
                                 <a href="{{ route('rol_delete',$value->id) }}" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i> </a>
                                 {{-- <a href="{{ route('rol_delete',$value->id) }}" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1" onclick="return confirm('Are you sure you want to delete this item?');"></i> </a> --}}
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
  <div class="modal fade show" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- <form action="{{ route('position.store') }}" method="POST"> --}}
                <form method="POST">
                @csrf
                <div class="row form-group">
                    <div class="col-md-12 ml-auto">
                        {{-- <div class="row">
                    <div class="col-sm-9"> --}}
                       <input type="text" class="form-control form-control-sm" name="rol" required autocomplete="off"/>
                    {{-- </div>
                        </div> --}}
                        
                    </div>
                    
                 </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

@endsection
