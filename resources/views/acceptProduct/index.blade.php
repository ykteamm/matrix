@extends('admin.layouts.app')
@section('admin_content')
<div class="row calender-col mt-5 pt-5">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
            <div class="dtBasicExamplest"></div>
                <div class="table-responsive">
                    <table class="table mb-0 dtBasicExamplest12">
                        <thead>
                        <tr>
                            <th><strong>No</strong></th>
                            <th> <strong>Slug</strong></th>
                            <th> <strong>Dorixona nomi</strong> </th>
                            <th> <strong>Region</strong> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pharmacy as $key => $p)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td> {{$p->slug}} </td>
                            <td><a href="{{route('accept.med.show',['id'=>$p->id,'time'=>date('Y-m')])}}" class="badge badge-primary">{{$p->name}}</a> </td>
                            <td>{{$p->region->name}}</td>
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


