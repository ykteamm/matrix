@extends('admin.layouts.app')
@section('admin_content')
    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-sm-12 p-5">
                <div class="card p-2">
                    <span class="text-center">New users</span>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 example1">
                                <thead>
                                    <tr>
                                        <th>FIO </th>
                                        <th></th>
                                        <th>Apteka tanlash</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->last_name }} {{ $user->first_name }}</td>
                                            <td>{{ $user->user_region }}</td>
                                            <form action="{{ route('user-bind-pharmacy.store') }}" method="POST">
                                                @csrf
                                                <td>
                                                    <input style="display: none" type="text" value="{{ $user->id }}" name="user_id">
                                                    <ul class="list-group">
                                                        <div class="row">
                                                            <div class="align-items-center d-flex w-100">
                                                                <select class="form-control form-control-sm"
                                                                    name='pharma_id' required>
                                                                    <option value="" disabled selected hidden>
                                                                        Apteka tanlang</option>
                                                                    @foreach ($user->region->pharmacy as $region)
                                                                        <option value='{{ $region->id }}'>
                                                                            {{ $region->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </ul>
                                                </td>
                                                <td>
                                                  <button class="btn btn-sm btn-primary" type="submit">
                                                    Biriktirish
                                                  </button>
                                                </td>
                                            </form>
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
@endsection
