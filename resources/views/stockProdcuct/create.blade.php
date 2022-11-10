@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-header">
                    <h4 class="card-title">Dorixonada qolgan dorilar sonini kiriting </h4>
                </div>
                <div class="card-body">
                    <form action="{{route('stock.med.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input style="display:none;" name="created_by" value="{{$id}}">
                                    <select class="select" name="pharmacy_id" required >
                                        <option value="">Select</option>
                                        @foreach($pharmacies as $p)
                                            <option value="{{$p->pharmacy_id}}" />{{$p->slug}}  {{$p->name}} {{$p->region}}
                                        @endforeach
                                    </select>
                                </div>
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
                                                @foreach($medicines as $med)
                                                    <tr>
                                                        <td>{{$loop->index+1}} </td>
                                                        <td>{{$med->name}} </td>
                                                        <td><input name="med{{$med->id}}"></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right " style="position: fixed;right: 1rem;top: 95vh; width: 100%"  >
                            <button type="submit" style="width: 83.5%;
                            " class="btn btn-primary">Save </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


