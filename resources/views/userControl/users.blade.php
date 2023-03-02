@extends('admin.layouts.app')
@section('admin_content')
    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-sm-12 p-5">
                <div class="card p-2">
                    <span class="text-center">All users</span>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 example1">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Parol</th>
                                        <th>FIO </th>
                                        <th>Viloyat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      // dd($users[0]);
                                  @endphp
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->pr }}</td>
                                            <td>{{ $user->last_name }} {{ $user->first_name }}</td>
                                            <td>{{ $user->region_name }}</td>
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
