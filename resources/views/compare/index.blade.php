@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-header">
                    <h4 class="card-title row d-flex justify-content-between">  </h4>
                </div>
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6 ">
                            <div class="form-group">
{{--                                <input style="display:none;" name="created_by" value="{{$id}}">--}}
                                <input type="datetime-local" id="meeting-time"
                                       name="meeting-time" value="{{date("Y-m-d H:i", time())}}"
                                       min="2018-06-07T00:00" >
                            </div>
                        </div>
                    </div>
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
                                                <th>Dorixona nomi </th>
                                                <th>Region </th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pharmacies as $pharm)

                                                    <tr>
                                                        <td>{{$loop->index+1}} </td>
                                                        <td> <a href="{{route('compare.pharm',['id'=>$pharm->id,'time'=>\Carbon\Carbon::now()])}}">{{$pharm->name}}</a> </td>
                                                        <td>{{$pharm->region->name}}</td>
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