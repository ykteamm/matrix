@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <ul class="breadcrumb ml-2">
                <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{ __('app.province_add') }} </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-md-12">
           <div class="card">
              <div class="card-body">
                 <form action="{{ route('province.store') }}" method="POST">
                    @csrf
                   <div class="row">
                    <div class="form-group col-md-6">
                        <label> {{ __('app.province') }} </label>
                        <input type="text" name="province" class="form-control form-control-sm" />
                     </div>
                     <div class="form-group col-md-3 mt-4">
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
              <div class="card-body">
                 <div class="table-responsive">
                    <table class="table mb-0">
                       <thead>
                          <tr>
                             <th> № </th>
                             <th> {{ __('app.province') }} </th>
                             <th class="text-right"> {{ __('app.action') }} </th>
                          </tr>
                       </thead>
                       <tbody>
                           @foreach($province as $key => $value)
                           <tr>
                            <td> {{ $key+1 }} </td>
                            <td> {{ $value->province_name }} </td>
                            <td class="text-right">
                               <a href="#" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-eye mr-1"></i> {{ __('app.update') }} </a>
                               <a href="#" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i> {{ __('app.delete') }} </a>
                            </td>
                         </tr> 
                           @endforeach
                       </tbody>
                    </table>
                 </div>
              </div>
           </div>
        </div>
     </div>
</div>
@endsection