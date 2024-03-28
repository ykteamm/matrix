<?php

?>

@extends('admin.layouts.app')
@section('admin_content')

    <div class="card p-5">
        <div class="card-body">
            <div class="row">
                <div class="container">
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{session('success')}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="col-12">
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{$error}}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-md-12">
                    <h5 class="text-center">Create Jamoa</h5>
                    <br>
                    <form action="{{url('create_jamoa')}}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="">
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="select2-multipleTeacher">Teacher ID</label><br>
                                <select class="select2-multiple form-control" name="teacher_id"
                                        id="select2-multipleTeacher">
                                    <option value="">Select Teachers</option>
                                    @foreach($teachers as $teach)
                                        <option value="{{$teach->user_id}}">{{$teach->user_first_name}} {{$teach->user_last_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="select2-multipleMember">Members ID</label><br>
                                <select class="select2-multiple form-control" name="member_id"
                                        id="select2-multipleMember">
                                    <option value="">Select Members</option>
                                    @foreach($members as $teach)
                                        <option value="{{$teach->id}}">{{$teach->user_first_name}} {{$teach->user_last_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <button type="submit" id="SaveStartWorkDate" class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="card p-5">
        <div class="card-body">
            <div class="col-md-12">
                <h5 class="text-center">Create Plan</h5>
                <br>
                <form action="{{url('create_plan')}}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="select2-multipleUser">User ID</label><br>
                            <select class="select2-multiple form-control" name="user_id"
                                    id="select2-multipleUser">
                                <option value="">Select User</option>
                                @foreach($user_id as $user)
                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="start_date">Start Date</label><br>
                            <input type="date" id="start_date" class="form-control" name="start_date">
                        </div>


                        <div class="form-group col-md-3">
                            <label for="end_date">End Date</label><br>
                            <input type="date" id="end_date" class="form-control" name="end_date">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="plan_pul">Plan Summa</label><br>
                            <input type="number" id="plan_pul" class="form-control" name="plan_pul">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>

            </div>
        </div>
    </div>


    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-md-12 p-5">
                <h3 class="text-center">Select Date</h3>
                <br>
                <form action="{{url('select_date')}}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">Start Date</label><br>
                            <input type="date" class="form-control" name="start_date">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="end_date">End Date</label><br>
                            <input type="date" class="form-control" name="end_date">
                        </div>
                    </div>

                    <button type="submit"  class="btn btn-primary">Submit</button>
                </form>
                <br><br>
                <h3 class="text-center">Jamoalar</h3>

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
                        @foreach($jamoaUsers as $jamoa)
                            <tr>
    {{--                            @dd($jamoaUsers)--}}
                                <td style="border: 1px solid">
                                    <a href="{{ route('jamoalar-report',['id' => $jamoa['id']]) }}">{{ $jamoa['id']}}</a>
                                </td>
                                <td style="border: 1px solid">
                                    <a href="{{ route('jamoalar-report',['id' => $jamoa['id']]) }}">{{$jamoa['first_name']}} {{$jamoa['last_name']}}</a>
                                    <br><br>
                                    @if($jamoa['teacher_id'] == null)
    {{--                                    <p>{{date('Y-m-d')}}</p>--}}
                                        <p>Hozircha savdo yo'q</p>
                                    @else
                                        @foreach($jamoa['teacher_id'] as $total)
                                            @php $totalsum = number_format($total['totalsum'], 0, '.', ' '); @endphp
                                            {{$total['date']}}<br>
                                            {{ $totalsum }}
                                        @endforeach
                                    @endif
                                    <br>
                                    @foreach($plan_jamoa as $plan)
                                        @if($plan->user_id == $jamoa['id'])

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h6>Plan</h6>
                                                </div>
                                                <div class="col-md-8">
                                                    <a type="button" class="btn btn-primary" style="color: white" data-toggle="modal" data-target="#examplePlan{{$plan->id}}">
                                                        <i class="fas fa-edit"></i>
                                                        Edit Plan
                                                    </a>
                                                </div>

                                                <div class="modal fade" id="examplePlan{{$plan->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Update Plan</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{url('update_plan/'.$plan->id)}}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input class='text-input' id='user_id' name='user_id' type='hidden' value="{{$plan->user_id}}">
                                                                    <div class="mb-3">
                                                                        <label for="start_day" class="form-label">Start Date</label>
                                                                        <input type="date" value="{{$plan->start_day}}" name="start_day" class="form-control" id="start_day" aria-describedby="start_day">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="end_day" class="form-label">End Date</label>
                                                                        <input type="date" value="{{$plan->end_day}}" name="end_day" class="form-control" id="end_day" aria-describedby="end_day">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="plan_pul" class="form-label">Plan Summa</label>
                                                                        <input type="number" value="{{$plan->plan_pul}}" name="plan_pul" class="form-control" id="plan_pul" aria-describedby="plan_pul">
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">
                                                                            <i class="fas fa-user-edit"></i>
                                                                            Update Order
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>{{$plan->start_day}}</p>
                                            <p>{{$plan->end_day}}</p>
                                            <p>{{$plan->plan_pul}}</p>
                                        @else
                                        @endif
                                    @endforeach
                                </td>
                                <td style="border: 1px solid">
                                    @foreach($teacherUsers as $users)
{{--                                        @dd($users)--}}
                                        @if($users['teacher_id'] == $jamoa['id'])
                                            <div class="row">
                                                <div class="col-md-3">
                                                    {{$users['first_name']}} {{$users['last_name']}}
                                                </div>
                                                <div class="col-md-3">
    {{--                                                @dd($users['user_id'])--}}
                                                    @if($users['user_id'] ==null)
                                                        <p>Hozircha savdo yo'q</p>
                                                    @else
                                                        @foreach($users['user_id'] as $total)
                                                            @if($total['totalsum'])
                                                                @php $shogird_total_sum = number_format($total['totalsum'], 0, '.', ' '); @endphp
                                                                Total
                                                                <br>
                                                                {{$shogird_total_sum}}
                                                            @else
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    @foreach($plan_jamoa as $plan)
                                                        @if($plan->user_id == $users['id'])
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <h6>Plan</h6>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <a type="button" class="btn btn-primary" style="color: white" data-toggle="modal" data-target="#examplePlan{{$plan->id}}">
                                                                        <i class="fas fa-edit"></i>
                                                                        Edit Plan
                                                                    </a>
                                                                </div>

                                                                <div class="modal fade" id="examplePlan{{$plan->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Update Plan</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{url('update_plan/'.$plan->id)}}" method="POST">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <input class='text-input' id='user_id' name='user_id' type='hidden' value="{{$plan->user_id}}">
                                                                                    <div class="mb-3">
                                                                                        <label for="start_day" class="form-label">Start Date</label>
                                                                                        <input type="date" value="{{$plan->start_day}}" name="start_day" class="form-control" id="start_day" aria-describedby="start_day">
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label for="end_day" class="form-label">End Date</label>
                                                                                        <input type="date" value="{{$plan->end_day}}" name="end_day" class="form-control" id="end_day" aria-describedby="end_day">
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label for="plan_pul" class="form-label">Plan Summa</label>
                                                                                        <input type="number" value="{{$plan->plan_pul}}" name="plan_pul" class="form-control" id="plan_pul" aria-describedby="plan_pul">
                                                                                    </div>

                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                        <button type="submit" class="btn btn-primary">
                                                                                            <i class="fas fa-user-edit"></i>
                                                                                            Update Order
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <p>{{$plan->start_day}}</p>
                                                            <p>{{$plan->end_day}}</p>
                                                            <p>{{$plan->plan_pul}}</p>
                                                        @else
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="col-md-3">
                                                    <a type="button" class="btn btn-danger" style="color: white" data-toggle="modal" data-target="#exampleJamoa{{$users['id']}}delete">
                                                        <i class="fas fa-trash"></i>
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="exampleJamoa{{$users['id']}}delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete your User ID {{$users['id']}}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{url('delete_jamoa/'.$users['id'] )}}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
    {{--                                                            <input class='text-input' id='user_id' name='user_id' type='hidden' value="{{$users->user_id}}">--}}
                                                                <h1>Are you sure?</h1>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="fas fa-trash"></i>
                                                                        Delete Order
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
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
                                    @foreach($teacherUsers as $total_shogird)
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
