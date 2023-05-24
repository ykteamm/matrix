@extends('admin.layouts.app')
@section('admin_content')
    <div class="content mt-1 main-wrapper">

        <div class="card flex-fill mt-5">
            <div class="card flex-fill mt-5">
                <div style="border-bottom-radius:30px !important;margin-left:auto">
                    <div class="justify-content-between align-items-center p-2" >
                    <form action="{{route('pro-list-search')}}" method="post">
                        <div class="btn-group">
                        <div class="">
                            <div class="col-md-12 text-center">
                                    Sana
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-outline-primary dropdown-toggle" id="age_buttonMoney"
                                    name="{{ date('Y-m', strtotime($month)) }}" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    {{ date('m.Y', strtotime($month)) }}</button>
                                <div class="dropdown-menu" style="z-index: 100000">

                                    @foreach ($yearMonths as $m)
                                        <a href="#" onclick="selectMonthMoney(`{{ date('Y-m', strtotime('01.' . $m)) }}`,`{{$m}}`)" class="dropdown-item"
                                            >
                                            {{ date('m.Y', strtotime('01.' . $m)) }} </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="btn-group">
                        <div class="">
                            <div class="col-md-12 text-center">
                                    Viloyat
                            </div>
                            <div class="col-md-12">
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle" id="age_button2Money"
                                        name="{{$region_id}}" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ $regText->name }}</button>
                                    <div class="dropdown-menu" style="z-index: 100000">
                                        <a href="#" onclick="selectRegionMoney(`all`,`Hammasi`)" class="dropdown-item"
                                            >
                                            Hammasi </a>
                                        @foreach ($regions as $m)
                                            <a href="#" onclick="selectRegionMoney(`{{$m->id}}`,`{{$m->name}}`)" class="dropdown-item"
                                                {{-- id="{{ date('Y', strtotime('01.' . $m)) . '-' . date('m', strtotime('01.' . $m)) }}" --}}
                                                >
                                                {{ $m->name }} </a>
                                        @endforeach
                                    </div>
                            </div>
                        </div>
                        </div>
                        <div class="btn-group" style="margin-right:30px !important;margin-top:20px;">
                            <div class="row">
                                <div class="col-md-12" align="center">

                                </div>
                                <div class="col-md-12">
                                <button type="button" class="btn btn-block btn-outline-primary" onclick="formButtonMoney()">Qidirish</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
                    @foreach ($data as $region)
                        <div class="card-body mb-5">
                            <div class="d-flex align-items-center justify-content-between mb-3" style="background: darkturquoise;border-radius: 8px;
                            padding: 20px 40px;font-size:20px;">
                                <div style="font-weight:700" class="supercell">{{ $region['name'] }}</div>
                                @php
                                    $s = 0;
                                @endphp
                                @foreach ($region['users'] as $user)
                                    @if ($user['spec'] == 1)
                                        @php
                                            $s = $s + $user['maosh'] - $user['jarima'] + $user['premya'] - $user['shtraf'];
                                        @endphp
                                    @endif
                                @endforeach
                                <div class="supercell">Umumiy oylik (elchi)  {{ number_format($s, 0, '', ' ') }}</div>
                            </div>
                            <div>


                                <div class="table-responsive">

                                    <h2> <span class="badge badge-primary">Elchi</span> </h2>

                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>FIO</th>
                                                <th>Fakt</th>
                                                <th>To'liq oylik</th>
                                                <th>Kesiladigan summa</th>
                                                <th>Premya</th>
                                                <th>Shtraf</th>
                                                <th>Natijaviy oylik</th>
                                                <th>Kechikgan vaqt (minut)</th>
                                                <th>Kechikgan vaqt (soat)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($region['users'] as $user)
                                            @if ($user['spec'] == 1)

                                                <tr>
                                                    <td> <a href="{{route('user-money-profil',['id' => $user['id'],'month' => $month])}}"> {{ $user['name'] }}</a>  </td>
                                                    <td> <span class="badge badge-warning">{{ number_format($user['summa'],0,',',' ') }}</span></td>
                                                    <td style="font-weight:600;font-size:14px">
                                                        <span class="badge badge-primary">
                                                            {{ number_format($user['maosh'],0,',',' ') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-danger">
                                                            {{ number_format($user['jarima'],0,',',' ') }}
                                                        </span>
                                                    </td>
                                                    <td>{{ number_format($user['premya'],0,',',' ') }}</td>
                                                    <td>
                                                        @if ($user['shtraf'] > 0)
                                                            <span class="badge badge-danger">
                                                                {{ number_format($user['shtraf'],0,',',' ') }}
                                                            </span>
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                    <td style="font-weight:600;font-size:14px">
                                                        <span class="badge badge-success">
                                                            {{ number_format(($user['maosh'] - $user['jarima'] + $user['premya'] - $user['shtraf']),0,',',' ') }}
                                                        </span>
                                                    </td>

                                                    <td>{{ number_format($user['time'],0,',',' ') }} minut</td>
                                                    <td>{{ number_format(floor($user['time']/60),0,',',' ') }} soat</td>
                                                </tr>
                                            @endif

                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-responsive mt-5">
                                    <h2> <span class="badge badge-info">Provizor</span> </h2>

                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>FIO</th>
                                                <th>Fakt</th>
                                                <th>Natijaviy oylik</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($region['users'] as $user)
                                            @if ($user['spec'] == 9)

                                                <tr>
                                                    <td> <a href="{{route('user-money-profil',['id' => $user['id'],'month' => $month])}}"> {{ $user['name'] }}</a>  </td>
                                                    <td>{{ number_format($user['summa'],0,',',' ') }}</td>
                                                    <td style="font-weight:600;font-size:14px">

                                                        <span class="badge badge-success">

                                                            {{ number_format($user['summa']*0.1,0,',',' ') }}

                                                        </span>

                                                    </td>
                                                </tr>
                                            @endif

                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer p-0"></div>
                    @endforeach
    </div>
@endsection

<script>
    function selectMonthMoney(month,m) {
        $('#age_buttonMoney').attr('name',month)
        $('#age_buttonMoney').text(m)
    }
    function selectRegionMoney(id,name)
    {
        $('#age_button2Money').attr('name',id)
        $('#age_button2Money').text(name)
    }
    function formButtonMoney()
      {
         var region = $('#age_button2Money').attr('name');
         var tim = $('#age_buttonMoney').attr('name');
         var url = "{{ route('user-money',['region_id' => ':region','month' => ':tim']) }}";

            url = url.replace(':tim', tim);
            url = url.replace(':region', region);
            location.href = url;
      }
</script>
