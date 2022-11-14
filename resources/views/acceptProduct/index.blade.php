@extends('admin.layouts.app')
@section('admin_content')
    <div class="row calender-col">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header no-border">
                    <h4 class="card-title">Dorixonalardan birini tanlang </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th><strong>No</strong></th>
                                <th> <strong>Slug</strong></th>
                                <th> <strong>Dorixona nomi</strong> </th>
                                <th> <strong>Region</strong> </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pharmacies[0]->admin_pharmacies as $p)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$p->pharmacies->slug}} </td>
                                <td><a href="{{route('accept.med.show',['id'=>$p->pharmacies->id])}}">{{$p->pharmacies->name}}</a> </td>
                                <td>{{$p->pharmacies->region->name}}</td>
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

