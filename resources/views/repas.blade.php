@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box">
            @include('admin.components.logo')

            <div class="content container-fluid headbot">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{route('change-pass-phone')}}">
                            <button class="btn btn-primary">Telefonga jonatish</button>
                        </a>
                        <a href="{{route('change-pass')}}">
                            <button class="btn btn-primary">Parolni almashtirish</button>
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped dtBasicExamplest12">
                            <thead>
                            <tr>
                                <th><strong>Ism</strong> </th>
                                <th><strong>Familiya</strong> </th>
                                <th><strong>Login</strong> </th>
                                <th><strong>Parol</strong> </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <td>{{$item->first_name}}</td>
                                        <td>{{$item->last_name}}</td>
                                        <td>{{$item->username}}</td>
                                        <td>{{$item->pr}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
@endsection
@section('admin_script')

@endsection
