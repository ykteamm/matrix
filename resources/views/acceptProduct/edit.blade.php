@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-body">
                    <form action="{{route('accept.med.update',['id'=>$pharmacy_id])}}" method="post">
                        @csrf

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
                                                    <tr>
                                                        <td>{{1}} </td>
                                                        <td>{{$accept->medicine->name}} </td>
                                                        <td><input name="number" value="{{$accept->number}}"><input name="id" style="display: none" value="{{$accept->id}}">  </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right " style="position: fixed;right: 1rem;top: 95vh; width: 100%"  >
                            <button type="submit" style="width: 83.5%;
                            " class="btn btn-primary">Update </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
