<?php

?>

@extends('admin.layouts.app')
@section('admin_content')
    <div class="card" style="margin-top: 60px;">
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
                <div class="col-md-12 col-12 m-t-30">
                    <h5 class="text-center">Topshiriq darajalari</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-plus"></i>
            Yaratish
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Daraja yaratish</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('topshiriq-level-create')}}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="name">Daraja soni</label>
                                    <input type="number" name="daraja" class="form-control" id="daraja" placeholder="Daraja soni" required>
                                </div>

                                <div class="form-group col-4">
                                    <label for="son">Daraja nomi</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Daraja nomi" required>
                                </div>

                                <div class="form-group col-4 ">
                                    <label for="star">Daraja Star limit</label>
                                    <input type="number" name="number_star" id="number_star" class="form-control" placeholder="Daraja Star limit" required>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                    Yaratish
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-md-12 col-12 p-2">
                <table class="table mb-0 example1">
                    <thead>
                    <tr>
                        <th style="border: 1px solid">ID</th>
                        <th style="border: 1px solid">Daraja</th>
                        <th style="border: 1px solid">Name</th>
                        <th style="border: 1px solid">Number star</th>
                        <th style="border: 1px solid">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($level as $top)
                    <tr>
                        <td style="border: 1px solid">
                            {{$top->id}}
                        </td>
                        <td style="border: 1px solid">
                            {{$top->daraja}}
                        </td>
                        <td style="border: 1px solid">
                            {{$top->name}}
                        </td>
                        <td style="border: 1px solid">
                            {{$top->number_star}}
                        </td>
                        <td style="border: 1px solid">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#Modal{{$top->id}}">
                                <i class="fas fa-edit"></i>
                                Tahrirlash
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="Modal{{$top->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Daraja tahrirlash</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{route('topshiriq-level-update',['id'=>$top->id])}}">
                                                @method('PUT')
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-4">
                                                        <label for="name">Daraja soni</label>
                                                        <input type="number" value="{{$top->daraja}}" name="daraja" class="form-control" id="daraja" placeholder="Daraja soni" required>
                                                    </div>

                                                    <div class="form-group col-4">
                                                        <label for="son">Daraja nomi</label>
                                                        <input type="text" name="name" value="{{$top->name}}" id="name" class="form-control" placeholder="Daraja nomi" required>
                                                    </div>

                                                    <div class="form-group col-4 ">
                                                        <label for="star">Daraja Star limit</label>
                                                        <input type="number" name="number_star" value="{{$top->number_star}}" id="number_star" class="form-control" placeholder="Daraja Star limit" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-info">
                                                        <i class="fas fa-edit"></i>
                                                        Tahrirlash
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('admin_script')

@endsection
