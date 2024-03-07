<?php
$t_r = 1;
?>
@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box">
            <div class="mt-4 card flex-fill">

                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th>T/r</th>
                                <th>FIO</th>
                                <th>Viloyat</th>
                                <th>Shahar yoki Tuman</th>
                                <th>Telefon</th>
                                <th>Username</th>
                                <th>Parol</th>
                                <th>Tug'ilgan kuni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{$t_r++}}</td>
                                    <td>{{$item->first_name}} {{$item->last_name}}</td>
                                    <td>
                                        {{$item->region_name}}
                                    </td>
                                    <td>
                                        {{$item->district_name}}
                                    </td>
                                    <td>{{$item->phone_number}}</td>
                                    <td>{{$item->username}}</td>
                                    <td>{{$item->pr}}</td>
                                    <td>
                                        @php $date = \Carbon\Carbon::now()->format('Y'); $user_date = \Carbon\Carbon::parse($item->birthday)->isoFormat('Y'); @endphp
                                        {{$date - $user_date}}
{{--                                        {{$item->birthday}}--}}
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
@endsection

