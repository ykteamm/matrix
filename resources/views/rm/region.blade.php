@extends('admin.layouts.app')
@section('admin_content')
@isset(Session::get('per')['dash'])
    @if(Session::get('per')['dash'] == 'true')
    <div class="content mt-1 main-wrapper ">
        <div class="row gold-box">
        @include('admin.components.logo')
        </div>
        <div class="card headbot">
            <div class="card-header no-border">
            <h5 class="card-title"> Viloyatlar reytingi </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead>
                            <tr>
                            <th># </th>
                            <th>Viloyat </th>
                            <th>Summa </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>1 </td>
                            <td>Anna </td>
                            <td>Pitt </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
@endisset
@endsection
@section('admin_script')
  
@endsection
