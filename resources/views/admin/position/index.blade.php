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
                        <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item active">{{ __('app.position') }} </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('position.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                {{-- <label> {{ __('app.hospital') }} </label> --}}
                                <label> Rol </label>
                                <input type="text" name="rol_name" class="form-control form-control-sm"/>
                            </div>
                            <div class="form-group col-md-4">
                            </div>
                            <div class="form-group col-md-2">
                                <label> All </label>
                                <input type="checkbox" style="width: 17px;height: 17px;" id="checkAll" class="form-control form-control-sm"/>
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
                                        <td style="text-align: center;"> <input style="width: 17px;height: 17px;" type="checkbox" value="true" name="{{$key.'_create'}}" /> </td>
                                        <td style="text-align: center;"> <input style="width: 17px;height: 17px;" type="checkbox" value="true" name="{{$key.'_read'}}" /> </td>
                                        <td style="text-align: center;"> <input style="width: 17px;height: 17px;" type="checkbox" value="true" name="{{$key.'_update'}}" /> </td>
                                        <td style="text-align: center;"> <input style="width: 17px;height: 17px;" type="checkbox" value="true" name="{{$key.'_delete'}}" /> </td>
                                    </tr>
                                    @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 ml-auto mr-2">
                            <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
