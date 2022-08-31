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
                <form action="{{ route('exchange-request') }}" method="POST" autocomplete="off">
                    @csrf
                 <div class="row">
                    <div class="col-md-6">
                        <input  type="text" class="form-control form-control-sm ml-3 ml-auto" maxlength="14" name="pinfl" placeholder="ПИНФЛ" required/>
                    </div>
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary"> Поиск </button>
                    </div>
                 </div>
                </form>
              </div>
           </div>
        </div>
     </div>
</div>
@endsection