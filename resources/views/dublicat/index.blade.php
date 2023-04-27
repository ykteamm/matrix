@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box">
            @include('admin.components.logo')

        </div>
        <div class="row headbot">
            <div class="col-sm-12">
                <div class="card mt-5">
                    <form action="{{ route('dublicat.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0 example1">
                                    <thead>
                                        <tr>
                                            <th>ID </th>
                                            <th>Username </th>
                                            <th>Parol </th>
                                            <th>FIO </th>
                                            <th>Sana</th>
                                            <th>Telefon</th>
                                            <th>Prodaja</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($duplicateUsers as $users)
                                            @for ($i = 0; $i < count($users); $i++)
                                                <tr class="@if ($i == 0)
                                                bg-light
                                            @endif" style="font-weight: @if ($i == 0) 600 @endif">
                                                    <td>{{ $users[$i]->id }}</td>
                                                    <td>{{ $users[$i]->username }}</td>
                                                    <td>{{ $users[$i]->pr }}</td>
                                                    <td>{{ $users[$i]->last_name }} {{ $users[$i]->first_name }}</td>
                                                    <td>{{ date('Y-m-d H:i', strtotime($users[$i]->date_joined)) }}</td>
                                                    <td>{{ $users[$i]->phone_number }}</td>
                                                    <td class="text-center">{{ number_format($users[$i]->prodaja,0 ,'', ' ') }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <input name="dup-{{ $users[$i]->id }}" class="form-check-input"
                                                                type="checkbox" value="{{ $users[$i]->id }}"
                                                               @if ($i == 0 || $users[$i]->prodaja > 0)
                                                                   disabled
                                                               @endif
                                                                >
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endfor
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary w-100">Saqlash</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin_script')
    <script></script>
@endsection
