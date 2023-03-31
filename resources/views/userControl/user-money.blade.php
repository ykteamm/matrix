@extends('admin.layouts.app')
@section('admin_content')
    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-sm-12 pt-5">
                <div class="col-md-2 justify-content-end">
                    <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button"
                        name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{ date('m.Y', strtotime($month)) }}</button>
                    <div class="dropdown-menu" style="z-index: 100000">

                        @foreach ($yearMonths as $m)
                            <a onclick="selectMonth(this)" class="dropdown-item"
                                id="{{ date('Y', strtotime('01.' . $m)) . '-' . date('m', strtotime('01.' . $m)) }}">
                                {{ date('m.Y', strtotime('01.' . $m)) }} </a>
                        @endforeach
                    </div>
                </div>
                <div class="card p-2">
                    <span class="text-center">User money</span>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 example1">
                                <thead>
                                    <tr>
                                        <th>FIO</th>
                                        <th>Fakt</th>
                                        <th>To'liq oylik</th>
                                        <th>Jarima</th>
                                        <th>Oylik</th>
                                        <th>Jami(kun,soat, minut)</th>
                                        <th>Ishlamagan(kun,soat, minut)</th>
                                        <th>Ishlagan(kun,soat, minut)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user['name'] }} {{ $user['famname'] }}</td>
                                            <td>{{ $user['fact'] }}</td>
                                            <td>{{ $user['totalMaosh'] }}</td>
                                            <td>{{ $user['jarima'] }}</td>
                                            <td>{{ $user['oylik'] }}</td>
                                            <td>
                                                {{ $user['total']['days'] }}:d-
                                                {{ number_format($user['total']['hours']) }}:h-
                                                {{ number_format($user['total']['minutes']) }}:m
                                            </td>
                                            <td>
                                                {{ $user['minusTotal']['days'] }}:d-
                                                {{ number_format($user['minusTotal']['hours']) }}:h-
                                                {{ number_format($user['minusTotal']['minutes']) }}:m
                                            </td>
                                            <td>
                                                {{ $user['workedTotal']['days'] }}:d-
                                                {{ number_format($user['workedTotal']['hours']) }}:h-
                                                {{ number_format($user['workedTotal']['minutes']) }}:m
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

<script>
    function selectMonth(monthBtn) {
        var month = <?php echo json_encode($month); ?>;
        var url = "{{ route('user-money') }}";
        location.href = url + `?_month=${monthBtn.id}`
    }
</script>
