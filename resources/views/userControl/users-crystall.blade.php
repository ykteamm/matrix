@extends('admin.layouts.app')
@section('admin_content')
    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-sm-12 p-5">
                <div class="card p-2">
                    <h2 class="text-center">Elchilar kristalini boshqarish</h2>
                    <div class="card-body">
                        <form action="{{ route('change-users-crystall') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table mb-0 example1">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>FIO </th>
                                            <th>Username</th>
                                            <th>Kristall</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->last_name }} {{ $user->first_name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>
                                                    <input type="number" value="{{ $user->crystall }}"
                                                        class="form-control form-control-sm"
                                                        name="crystall.{{ $user->id }}"
                                                        id="crystall.{{ $user->id }}">
                                                </td>
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
    }
</script>
