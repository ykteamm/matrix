@extends('admin.layouts.app')
@section('admin_content')
    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-sm-12 p-5">
                <div class="card p-2">
                    <span class="text-center">Premya</span>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 example1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>FIO </th>
                                        <th>Prodaja</th>
                                        <th>Topshiriq</th>
                                        <th>Premya</th>
                                        <th>Sana</th>
                                        <th>Xolati</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($premyaTasks as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                            <td>{{ number_format($user->prodaja, 0, '', ' ') }}</td>
                                            <td>{{ number_format($user->task, 0, '', ' ') }}</td>
                                            <td>{{ number_format($user->premya, 0, '', ' ') }}</td>
                                            <td>{{ date('d.m.Y',strtotime($user->created_at)) }}</td>
                                            <td>
                                                @if ($user->active == 1)
                                                    <a href="{{route('premya.active',$user->tid)}}">
                                                        <span class="badge badge-success">activ</span>
                                                    </a>
                                                @else
                                                    <a href="{{route('premya.active',$user->tid)}}">
                                                        <span class="badge badge-danger">activ emas</span>
                                                    </a>
                                                @endif
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
@endsection
