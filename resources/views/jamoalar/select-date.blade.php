<?php
?>
@extends('admin.layouts.app')
@section('admin_content')

    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-md-12 p-5">
                <a href="{{url('jamoalar')}}" class="btn btn-primary">
                    <i class="fas fa-backward"></i>
                    Back
                </a>
                <h3 class="text-center">Jamoalar</h3>
                <br>
                <h5 class="text-center">{{$start_date}} - {{$end_date}}</h5>
                <table class="table mb-0 example1">
                    <thead>
                    <tr>
                        <th style="border: 1px solid">ID</th>
                        <th style="border: 1px solid">Teacher ID</th>
                        <th style="border: 1px solid">Members</th>
                        <th style="border: 1px solid">Total</th>
                    </tr>
                    </thead>
                    <tbody>
{{--                    @dd($SelectJamoaUsers)--}}
                    @foreach($SelectJamoaUsers as $jamoa)
                        <tr>
                            <td style="border: 1px solid">{{ $jamoa['id']}}</td>
                            <td style="border: 1px solid">
                                {{$jamoa['first_name']}} {{$jamoa['last_name']}}
                                <br><br>
                                @if($jamoa['teacher_id'] == null)
                                     <p>{{date('Y-m-d')}}</p>
                                    <p>Hozircha savdo yo'q</p>
                                @else
                                    @php
                                        $TeacherSum = 0;
                                    @endphp
                                    @foreach($jamoa['teacher_id'] as $sum)
                                        @php
                                            $TeacherSum += $sum['totalsum'];
                                           $teacher_sum = number_format($TeacherSum, 0, '.', ' ');
                                        @endphp
{{--                                        {{$total['date']}}--}}
{{--                                        <br>--}}
                                    @endforeach
                                    {{ $teacher_sum }}
                                        <br>
                                        <hr>
                                @endif
                            </td>
                            <td style="border: 1px solid">
{{--                            @dd($SelectTeacherUsers)--}}
                            @foreach($SelectTeacherUsers as $users)
                                    @if($users['teacher_id'] == $jamoa['id'])
                                        <div class="row">
                                            <div class="col-md-4">
                                                {{$users['first_name']}} {{$users['last_name']}}
                                            </div>
                                            <div class="col-md-5">
                                                @if($users['user_id'] == null)
                                                    <p>Hozircha savdo yo'q</p>
                                                @else
                                                    @php
                                                        $ShogirdSum = 0;
                                                    @endphp
                                                    @foreach($users['user_id'] as $total)
                                                            @php
                                                                $ShogirdSum += $total['totalsum'];
                                                                $shogird_sum = number_format($ShogirdSum, 0, '.', ' ');
                                                            @endphp
                                                    @endforeach
                                                    <p>Total</p>
                                                    {{ $shogird_sum }}
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                    @else
                                    @endif
                                @endforeach
                            </td>
                            <td style="border: 1px solid">
                                @php
                                    $totalShoird = 0;
                                    $totalTeacher = 0;
                                @endphp
                                @foreach($jamoa['teacher_id'] as $total)
                                    @php
                                        $totalTeacher += $total['totalsum'];
                                    @endphp
                                @endforeach
                                @foreach($SelectTeacherUsers as $total_shogird)
                                    @if($total_shogird['teacher_id'] == $jamoa['id'])
                                        @foreach($total_shogird['user_id'] as $shogird)
                                            @php
                                                $totalShoird += $shogird['totalsum'];
                                            @endphp
                                        @endforeach
                                    @endif
                                @endforeach
                                @php
                                    $jamoa_total_sum = $totalShoird + $totalTeacher;
                                    $jamoa_sum_all = number_format($jamoa_total_sum, 0, '.', ' ');
                                @endphp
                                {{$jamoa_sum_all}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
