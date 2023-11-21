@extends('admin.layouts.app')
@section('admin_content')
    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-sm-12 p-5">
                <div class="card p-2">
                    <span class="text-center">All users</span>
                    <div class="card-body">

                        <form action="{{ route('assign-daily-work-time') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table mb-0 example1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Parol</th>
                                            <th>Phone number</th>
                                            <th>Status</th>
                                            <th>FIO </th>
                                            <th>Viloyat</th>
                                            <th>Ish boshlash</th>
                                            <th>Ish tugatish</th>
                                            <th>Ishdan ketish</th>
                                            <th>Yangilash</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // dd($users[0]);
                                        @endphp
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->pr }}</td>
                                                <td>{{$user->phone_number}}</td>
                                                <td>{{$user->status}}</td>
                                                <td class="hover"><a href="{{url('users-view/'.$user->id)}}">{{ $user->last_name }} {{ $user->first_name }}</a></td>
                                                <td>{{ $user->region_name }}</td>
                                                <td>
                                                    @if ($user->start_work)
                                                        <div id="startTime{{ $user->id }}">
                                                            {{ $user->start_work }}
                                                        </div>
                                                        <div id="startInput{{ $user->id }}" class="d-none">
                                                            <input id="timepicker" value="{{ $user->start_work }}"
                                                                type="time" timeformat="24h" class="form-control form-control-sm"
                                                                name="start.{{ $user->id }}">
                                                        </div>
                                                    @else
                                                        <div>
                                                            <input id="timepicker" value="{{ $user->start_work }}"
                                                                type="time" timeformat="24h" class="form-control form-control-sm"
                                                                name="start.{{ $user->id }}">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($user->finish_work)
                                                        <div id="finishTime{{ $user->id }}">
                                                            {{ $user->finish_work }}
                                                        </div>
                                                        <div id="finishInput{{ $user->id }}" class="d-none">
                                                            <input value="{{ $user->finish_work }}" type="time"
                                                                class="form-control form-control-sm"
                                                                name="finish.{{ $user->id }}">
                                                        </div>
                                                    @else
                                                        <div class="">
                                                            <input value="{{ $user->finish_work }}" type="time"
                                                                class="form-control form-control-sm"
                                                                name="finish.{{ $user->id }}"
                                                                id="finish.{{ $user->id }}">
                                                        </div>
                                                    @endif
                                                </td>
{{--                                    Ishdan ketish            --}}

                                                <td>
                                                    @if ($user->work_end)
                                                        <div id="endWork{{ $user->id }}">
                                                            {{ $user->work_end }}
                                                        </div>
                                                        <div id="endWorkInput{{ $user->id }}" class="d-none">
                                                            <input value="{{ $user->work_end }}" type="date"
                                                                class="form-control form-control-sm"
                                                                name="endwork.{{ $user->id }}">
                                                        </div>
                                                    @else
                                                        <div class="">
                                                            <input value="{{ $user->work_end }}" type="date"
                                                                class="form-control form-control-sm"
                                                                name="endwork.{{ $user->id }}"
                                                                id="endwork.{{ $user->id }}">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input onchange="change(this, {{ $user->id }})" type="checkbox"
                                                            class="form-check-input" name="change.{{ $user->id }}"
                                                            id="change.{{ $user->id }}" value="change">
                                                        <label for="change.{{ $user->id }}">Change</label>
                                                    </div>
                                                </td>

{{--                                    End   Yangilash         --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <button type="submit" class="w-100 btn btn-primary">Saqlash</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    $('#timepicker').timepicker({
        minuteStep: 60,
        showMeridian: false,
        defaultTime: '00:00'
    });

    function change(item, id) {
        if ($("#startInput" + id).hasClass('d-none')) {
            $("#startInput" + id).removeClass('d-none')
            $("#startTime" + id).addClass('d-none');
        } else {
            $("#startInput" + id).addClass('d-none');
            $("#startTime" + id).removeClass('d-none');
        }
        if ($("#finishInput" + id).hasClass('d-none')) {
            $("#finishInput" + id).removeClass('d-none')
            $("#finishTime" + id).addClass('d-none');
        } else {
            $("#finishInput" + id).addClass('d-none');
            $("#finishTime" + id).removeClass('d-none');
        }

        if ($("#endWorkInput" + id).hasClass('d-none')) {
            $("#endWorkInput" + id).removeClass('d-none')
            $("#endWork" + id).addClass('d-none');
        } else {
            $("#endWorkInput" + id).addClass('d-none');
            $("#endWork" + id).removeClass('d-none');
        }
    }
</script>
