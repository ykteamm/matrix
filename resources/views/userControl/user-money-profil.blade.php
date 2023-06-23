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
                            <a href="{{route('user-money-profil',['id' => $id,'month' => date('Y-m', strtotime($m.'-01'))])}}" class="dropdown-item">
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
                                        <th>Smena ochilgan vaqt</th>
                                        <th>Smena yopilgan vaqt</th>
                                        <th>Maosh</th>
                                        <th>Premya</th>
                                        <th>Shtraf</th>
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
                                    @if ($user['id'] == 269)
                                    <tr>
                                        {{-- <td> <a href="{{route('user-money-profil',['id' => $user['id'],'month' => $month])}}"> {{ $user['name'] }}</a>  </td> --}}
                                        <td>
                                            {{date('d.m.Y',strtotime($key)) }}
                                            <p> <span class="badge badge-success"> {{ $user['hafta_kuni'] }} </span> </p>
                                        </td>
                                        <td>
                                            @if ($user['shift'])
                                                @if ($user['shift']->pharmacy_id == 42)
                                                    Tashqi Savdo
                                                @else
                                                    @if ($user['shift']->open_date)
                                                        {{date('H:i',strtotime($user['shift']->open_date))}}
                                                    @else
                                                        ---
                                                    @endif

                                                @endif
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user['shift'])
                                                @if ($user['shift']->pharmacy_id == 42)
                                                    Tashqi Savdo
                                                @else
                                                    @if ($user['shift']->close_date)
                                                        {{date('H:i',strtotime($user['shift']->close_date))}}
                                                    @else
                                                        ---
                                                    @endif
                                                @endif
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>{{ number_format($user['maosh'],0,',',' ') }}</td>

                                        <td style="width: 50px;">
                                            @if ($user['premya'] == null)
                                                ---
                                            @else
                                            <span class="badge badge-primary">
                                                {{ number_format($user['premya']->price,0,',',' ') }}
                                            </span>
                                            <p >{{ $user['premya']->message }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- @if ($user['shtraf'] == null) --}}
                                                ---
                                            {{-- @else
                                            <span class="badge badge-danger">
                                                {{ number_format($user['shtraf']->price,0,',',' ') }}
                                            </span>
                                            <p >{{ $user['shtraf']->message }}</p>

                                            @endif --}}
                                        </td>
                                        @if ($user['jarima'] == 123123)
                                            <td style="color:red;">Oy oxirida qoshiladi</td>
                                            <td>-</td>
                                            <td>-</td>
                                        @else
                                        <td>0</td>

                                        <td>0 minut</td>
                                        <td>0 soat</td>
                                        @endif

                        
                                    </tr>
                                    @else
                                    <tr>
                                        {{-- <td> <a href="{{route('user-money-profil',['id' => $user['id'],'month' => $month])}}"> {{ $user['name'] }}</a>  </td> --}}
                                        <td>
                                            {{date('d.m.Y',strtotime($key)) }}
                                            <p> <span class="badge badge-success"> {{ $user['hafta_kuni'] }} </span> </p>
                                        </td>
                                        <td>
                                            @if ($user['shift'])
                                                @if ($user['shift']->pharmacy_id == 42)
                                                    Tashqi Savdo
                                                @else
                                                    @if ($user['shift']->open_date)
                                                        {{date('H:i',strtotime($user['shift']->open_date))}}
                                                    @else
                                                        ---
                                                    @endif

                                                @endif
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user['shift'])
                                                @if ($user['shift']->pharmacy_id == 42)
                                                    Tashqi Savdo
                                                @else
                                                    @if ($user['shift']->close_date)
                                                        {{date('H:i',strtotime($user['shift']->close_date))}}
                                                    @else
                                                        ---
                                                    @endif
                                                @endif
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>{{ number_format($user['maosh'],0,',',' ') }}</td>

                                        <td style="width: 50px;">
                                            @if ($user['premya'] == null)
                                                ---
                                            @else
                                            <span class="badge badge-primary">
                                                {{ number_format($user['premya']->price,0,',',' ') }}
                                            </span>
                                            <p >{{ $user['premya']->message }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user['shtraf'] == null)
                                                ---
                                            @else
                                            <span class="badge badge-danger">
                                                {{ number_format($user['shtraf']->price,0,',',' ') }}
                                            </span>
                                            <p >{{ $user['shtraf']->message }}</p>

                                            @endif
                                        </td>
                                        @if ($user['jarima'] == 123123)
                                            <td style="color:red;">Oy oxirida qoshiladi</td>
                                            <td>-</td>
                                            <td>-</td>
                                        @else
                                        <td>{{ number_format($user['jarima'],0,',',' ') }}</td>

                                        <td>{{ number_format($user['minut'],0,',',' ') }} minut</td>
                                        <td>{{ number_format(floor($user['minut']/60),0,',',' ') }} soat</td>
                                        @endif

                        
                                    </tr>
                                    @endif
                                       
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


