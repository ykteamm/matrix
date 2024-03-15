@extends('admin.layouts.app')
@section('admin_content')
    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-sm-12 pt-5">
                @if (count($blocked) > 0)
                    <div class="card p-2">
                        <div class="card-header text-center">
                            <h5>Bloklanganlar</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('blacklist.remove') }}" method="POST">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table mb-0 example1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Id</th>
                                                <th class="text-center">FIO</th>
                                                <th class="text-center">Hozirgi (sotuv)</th>
                                                <th class="text-center">Bir oy oldin (sotuv)</th>
                                                <th class="text-center">Ikki oy oldin (sotuv)</th>
                                                <th class="text-center">Imkon berish</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($blocked as $key => $user)
                                                <tr>
                                                    <td class="text-center">{{ $user->id }}</td>
                                                    <td class="text-center">{{ $user->f }} {{ $user->l }}</td>
                                                    <td class="text-center">
                                                        {{ number_format($user->nowmonth, 0, ',', ' ') }}
                                                    </td>
                                                    <td class="text-center">
                                                        <button
                                                            class="btn @if ($user->onemonthago > 10000000) btn-success @else btn-danger @endif">
                                                            {{ number_format($user->onemonthago, 0, ',', ' ') }}
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button
                                                            class="btn @if ($user->twomonthago > 10000000) btn-success @else btn-danger @endif">
                                                            {{ number_format($user->twomonthago, 0, ',', ' ') }}
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <input name="{{ $user->id }}" value="{{ $user->id }}"
                                                            type="checkbox">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <button class="btn btn-primary" type="submit">
                                        Saqlash
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                @if (count($other) > 0)
                    <div class="card p-2">
                        <div class="card-header text-center">
                            <h5>Imkon berilganlar va o'nglanganlar</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0 example1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Id</th>
                                            <th class="text-center">FIO</th>
                                            <th class="text-center">Hozirgi (sotuv)</th>
                                            <th class="text-center">Bir oy oldin (sotuv)</th>
                                            <th class="text-center">Ikki oy oldin (sotuv)</th>
                                            <th class="text-center">Holat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($other as $key => $user)
                                            <tr>
                                                <td class="text-center">{{ $user->id }}</td>
                                                <td class="text-center">{{ $user->f }} {{ $user->l }}</td>
                                                <td class="text-center">{{ number_format($user->nowmonth, 0, ',', ' ') }}
                                                </td>
                                                <td class="text-center">
                                                    <button
                                                        class="btn @if ($user->onemonthago > 10000000) btn-success @else btn-danger @endif">
                                                        {{ number_format($user->onemonthago, 0, ',', ' ') }}
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <button
                                                        class="btn @if ($user->twomonthago > 10000000) btn-success @else btn-danger @endif">
                                                        {{ number_format($user->twomonthago, 0, ',', ' ') }}
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    @if ($user->onemonthago < 10000000 && $user->twomonthago < 10000000)
                                                        <button class="btn btn-danger">Imkon berildi</button>
                                                    @else
                                                        <button class="btn btn-success">Yaxshi</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
