@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <ul class="breadcrumb ml-2">
                <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="index.html">{{ __('app.province') }} </a></li>
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
                        <label> {{ __('app.province') }} {{ Session::get('db') }}</label>
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
</div>
@endsection