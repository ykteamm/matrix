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
                                                <tr class="fw-bold">
                                                    <th><strong>No</strong> </th>
                                                    <th><strong>Dorixona nomi</strong> </th>
                                                    <th><strong>Region</strong> </th>
                                                    <th><strong>Biriktirilgan Adminlar</strong> </th>
                                                    <th><strong>Tahrirlash</strong> </th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($arr as $item)
                                                    <tr>
                                                        <td>{{$loop->index+1}} </td>
                                                        <td>{{$item->slug}} {{$item->name}} {{$item->last_name}}</td>
                                                        <td> {{$item->region->name}}</td>
                                                        <td>
                                                            @if(isset($item->pharm_users[0]))
                                                            @foreach($item->pharm_users as $p)
                                                            <div>
                                                                    {{$p->users->username}}
                                                                    {{$p->users->first_name}}
                                                                    {{$p->users->last_name}}
                                                            </div>
                                                            @endforeach
                                                            @else Hech kim
                                                            @endif
                                                        </td>
                                                        <td><a href="{{route('pharm.users.editby',['id'=>$item->id])}}" class="btn-primary btn"><i class="text-white fas fa-edit mr-1"></i></a> </td>
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
