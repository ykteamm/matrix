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


    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-md-12 p-5">
                <h3 class="text-center">Jamoalar</h3>

                <table class="table mb-0 example1">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Teacher ID</th>
                        <th>Members</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($jamoaUsers as $jamoa)
                        <tr>
{{--                            @dd($jamoaUsers)--}}
                            <td>{{ $jamoa['id']}}</td>
                            <td>
                                {{$jamoa['first_name']}} {{$jamoa['last_name']}}
                                <br><br>
                                @foreach($jamoa['teacher_id'] as $total)
                                    {{$total['date']}}<br>
                                    {{ $total['totalsum'] }}
                                @endforeach
                            </td>
                            <td>
                                @foreach($teacherUsers as $users)
{{--                                    @dd($users)--}}
                                    @if($users['teacher_id'] == $jamoa['id'])
                                        <div class="row">
                                            <div class="col-md-4">
                                                {{$users['first_name']}} {{$users['last_name']}}
                                            </div>
                                            <div class="col-md-2">
                                                @foreach($users['user_id'] as $total)
                                                    @if($total['totalsum'])
                                                            Total
                                                            <br>
                                                        {{$total['totalsum']}}
                                                    @else
                                                        <p>Null</p>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="col-md-4">
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
                                        <br>
                                        <hr>
                                    @else
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
