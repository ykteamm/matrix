@extends('admin.layouts.app')
@section('admin_content')
    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-sm-12 pt-5">
                <div class="card p-2">
                    <div class="card-body">
                        <form action="{{ route('kingliga.update') }}" method="POST">
                            @csrf
                            <div class="my-4">
                                <h3 class="text-center">
                                    Elchilarni ligasini boshqarish
                                </h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Id</th>
                                            <th class="text-center">FIO</th>
                                            @foreach ($ligas as $liga)
                                                <th class="text-center">{{ $liga->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="text-center">{{ $user->id }}</td>
                                                <td class="text-center">{{ $user->f }} {{ $user->l }}</td>
                                                @foreach ($ligas as $liga)
                                                    <td class="text-center">
                                                        <input name="{{ $user->id }}" value="{{ $liga->id }}"
                                                            @if($liga->id == $user->ligaid) checked @endif type="radio">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary w-100" type="submit">
                                    Saqlash
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
