<?php
use Carbon\Carbon;
?>

@extends('admin.layouts.app')
@section('admin_content')

    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-md-12 p-5">

                <h3 class="text-center">Jamoalar</h3>
@php
    $monday_dushanba = Carbon::parse($monday)->locale('uz_UZ')->isoFormat('dddd');
    $sana_monday =  Carbon::parse($monday)->locale('uz_UZ')->isoFormat('D MMMM');
    $sunday_yakshanba = Carbon::parse($sunday)->locale('uz_UZ')->isoFormat('dddd');
    $sana_sunday = Carbon::parse($sunday)->locale('uz_UZ')->isoFormat('D MMMM');

@endphp
                <h5> {{$monday_dushanba}} - {{$sunday_yakshanba}} </h5>
                <h6> {{$sana_monday}} - {{$sana_sunday}} </h6>
                <table class="table mb-0 example1">
                    <thead>
                    <tr>
                        <th style="border: 1px solid">Ustozlar</th>
                        <th style="border: 1px solid">Shogirdlar</th>
                        <th style="border: 1px solid">Haftalik savdo</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($teachers_sales as $jamoa)
                        <tr>
{{--                            <td style="border: 1px solid">--}}
{{--                                {{ $jamoa->id }}--}}
{{--                            </td>--}}
                            <td style="border: 1px solid">
                                {{$jamoa->first_name}} {{$jamoa->last_name}}
                                <br><br>
                                @php $formattedNumber = number_format($jamoa->total_savdo, 0, '.', ' '); @endphp
                                {{$formattedNumber}}
                            </td>
                            @php $total = 0; @endphp
                            <td style="border: 1px solid">
                                @foreach($jamoa->members_savdo as $shogird)
                                    @php $total += $shogird['shogird_savdo']; @endphp
{{--                                    <span style="margin-right: 30px"> {{$shogird['user_id']}} </span>--}}
                                    {{$shogird['first_name']}} {{$shogird['last_name']}}
                                    <br>
                                    <span style="padding-left: 50px">
                                         @php $shogird_format = number_format($shogird['shogird_savdo'], 0, '.', ' '); @endphp
                                        {{$shogird_format}}
                                    </span>
                                    <br><br>
                                @endforeach
                            </td>
                            <td style="border: 1px solid">
                                @php
                                    $total_savdo = $total +  $jamoa->total_savdo;
                                    $total_format = number_format($total_savdo, 0, '.', ' ');
                                @endphp
                                    {{$total_format}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
