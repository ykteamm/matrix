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
                <div id="userMoneys" class="mt-2">
                    @foreach ($data as $region)
                    <div class="card bg-light border border-1 rounded rounded-1 mb-4 collapsed" style=";cursor: pointer" data-toggle="collapse"
                    data-target="#userMoney{{ $region['id'] }}" aria-expanded="false"
                    aria-controls="userMoney{{ $region['id'] }}">
                        <div class="card-header p-0"></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="font-weight:700" class="supercell">{{ $region['name'] }}</div>
                                <div class="supercell">{{ number_format($region['sum'], 0, '', ' ') }}</div>
                            </div>
                            <div id="userMoney{{ $region['id'] }}" data-parent="#userMoneys" class="collapse p-3" aria-labelledby="userMoney{{ $region['id'] }}">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>FIO</th>
                                                <th>Fakt</th>
                                                <th>To'liq oylik</th>
                                                <th>Kesiladigan summa</th>
                                                <th>Natijaviy oylik</th>
                                                <th>Kechikgan vaqt (minut)</th>
                                                <th>Kechikgan vaqt (soat)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($region['users'] as $user)
                                                <tr>
                                                    <td> <a href="{{route('user-money-profil',['id' => $user['id'],'month' => $month])}}"> {{ $user['name'] }}</a>  </td>
                                                    <td>{{ number_format($user['summa'],0,',',' ') }}</td>
                                                    <td style="font-weight:600;font-size:14px">{{ number_format($user['maosh'],0,',',' ') }}</td>
                                                    <td>{{ number_format($user['jarima'],0,',',' ') }}</td>
                                                    <td style="font-weight:600;font-size:14px">{{ number_format(($user['maosh'] - $user['jarima']),0,',',' ') }}</td>
                                                    <td>{{ number_format($user['time'],0,',',' ') }} minut</td>
                                                    <td>{{ number_format(floor($user['time']/60),0,',',' ') }} soat</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-0"></div>
                    </div>
                    @endforeach
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
