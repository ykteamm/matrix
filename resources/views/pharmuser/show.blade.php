@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-header">
                    <h4 class="card-title">Foydalanuvchilarga dorixona ruhsati </h4>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <div class="card-header no-border">
                                        <h5 class="card-title">Dorixonalar ro'yhati </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                <tr>
                                                    <th>No </th>
                                                    <th>Admin nomi </th>
                                                    <th>Dorixonalar ro'yhati </th>
                                                    <th>Tahrirlash</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($arr as $item)
                                                    <tr>
                                                        <td>{{$loop->index+1}} </td>
                                                        <td>{{$item->username}} {{$item->first_name}} {{$item->last_name}}</td>
                                                        <td>
                                                            @foreach($item->admin_pharmacies as $p)
                                                            <div>
                                                                    {{$p->pharmacies->name}}
                                                            </div>
                                                            @endforeach
                                                        </td>
                                                        <td><a href="{{route('pharm.users.edit',['id'=>$item->id])}}" class="btn-primary btn"><i class="text-white fas fa-edit mr-1"></i></a> </td>
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
            </div>
        </div>
    </div>
@endsection
