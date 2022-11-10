@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-header">
                    <h4 class="card-title row d-flex justify-content-between"> <span>{{$pharm->name}} {{$pharm->region}}</span>  </h4>
                </div>
                <div class="card-body">
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-1 ">
                                <a href="{{route('accept.med.create',['id'=>$pharmacy_id])}}" class="btn btn-primary" ><span>+ create</span></a>
                            </div>
                            <div class="col-md-1 ">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header no-border">
                                        <h5 class="card-title">Dorilar ro'yhati </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                <tr>
                                                    <th>No </th>
                                                    <th>Dori nomi </th>
                                                    <th>Soni </th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($pharmacy as $med)
                                                    @if($med->pharmacy_id==$pharmacy_id)
                                                    <tr>
                                                        <td>{{$loop->index+1}} </td>
                                                        <td>{{$med->name}} </td>
                                                        <td>{{$med->amount}}</td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <a href=""class="btn btn-primary w-100 ">Har bitta kiritilganni alohida ko'rish</a>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header no-border">
                                    <h5 class="card-title">Dorilar ro'yhati </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <thead>
                                            <tr>
                                                <th>No </th>
                                                <th>Dori nomi </th>
                                                <th>Soni </th>
                                                <th>Kim kiritdi </th>
                                                <th>Qachon kiritdi</th>
                                                <th>Kim o'zgartirdi </th>
                                                <th>Qachon o'zgartirdi </th>
                                                <th>Tahrirlash </th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($accepts as $med)
                                                    <tr>
                                                        <td>{{$loop->index+1}} </td>
                                                        <td>{{$med->medicine->name}} </td>
                                                        <td>{{$med->number}}</td>
                                                        <td>{{$med->user_created->first_name}} {{$med->user_created->last_name}}</td>
                                                        <td>{{$med->created_at}}</td>
                                                        <td>{{$med->user_updated->first_name}} {{$med->user_updated->last_name}}</td>
                                                        <td>{{$med->updated_at}}</td>

                                                        <td>
                                                            <form action="{{route('accept.med.edit',['id'=>$pharmacy_id])}}">
                                                                <button ty ><i class="fas fa-edit text-primary"></i></button>
                                                            </form>
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
            </div>
        </div>
    </div>
@endsection

