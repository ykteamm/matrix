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
                            <a href="{{route('user-money-profil',['id' => $id,'month' => $m])}}" class="dropdown-item">
                                {{ date('m.Y', strtotime($m.'-01')) }} </a>
                        @endforeach
                    </div>
                </div>
                <div class="card p-2">
                    {{-- <span class="text-center">User money</span> --}}
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 example1">
                                <thead>
                                    <tr>
                                        <th>Kun</th>
                                        <th>Maosh</th>
                                        <th>Kesiladigan summa</th>
                                        <th>Kechikgan vaqt (minut)</th>
                                        <th>Kechikgan vaqt (soat)</th>
                                        {{-- <th>Jami(kun,soat, minut)</th>
                                        <th>Ishlamagan(kun,soat, minut)</th>
                                        <th>Ishlagan(kun,soat, minut)</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userData as $key => $user)
                                        <tr>
                                            {{-- <td> <a href="{{route('user-money-profil',['id' => $user['id'],'month' => $month])}}"> {{ $user['name'] }}</a>  </td> --}}
                                            <td> {{$key }}</td>
                                            <td>{{ number_format($user['maosh'],0,',',' ') }}</td>
                                            <td>{{ number_format($user['jarima'],0,',',' ') }}</td>
                                            <td>{{ number_format($user['minut'],0,',',' ') }} minut</td>
                                            <td>{{ number_format(floor($user['minut']/60),0,',',' ') }} soat</td>
                                            {{-- <td>
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
                                            </td> --}}
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
