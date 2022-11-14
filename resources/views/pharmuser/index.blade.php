@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-header">
                    <h4 class="card-title">Foydalanuvchilarga dorixona ruhsati </h4>
                </div>
                <div class="card-body">
                    <form action="{{route('pharm.users.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="select" name="user_id" required >
                                        <option value="">Select</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" />{{$user->username}} {{$user->first_name}} {{$user->last_name}}
                                        @endforeach
                                    </select>
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
                                                    <th>Slug </th>
                                                    <th>Dorixona nomi </th>
                                                    <th>Region </th>
                                                    <th>Ruxsat berish </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($pharmacies as $pharmacy)
                                                <tr>
                                                    <td>{{$loop->index+1}} </td>
                                                    <td>{{$pharmacy->slug}} </td>
                                                    <td>{{$pharmacy->name}} </td>
                                                    <td>{{$pharmacy->region->name}} </td>
                                                    <td> <input type="checkbox" id="horns" name="pharmacy_id[]" value="{{$pharmacy->id}}"></td>
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
