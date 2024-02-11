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
                    <h5 class="text-center">Topshiriqlar</h5>
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
                        <h5 class="modal-title" id="exampleModalLabel">Topshiriq yaratish</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('topshiriq-create')}}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="name">Topshiriq nomi</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Topshiriq nomi" required>
                                </div>

                                <div class="form-group col-4 mt-10">
                                    <label for="son">Soni</label>
                                    <input type="number" name="number" id="son" class="form-control" placeholder="Soni" required>
                                </div>

                                <div class="form-group col-4 mt-10">
                                    <label for="star">Star</label>
                                    <input type="number" name="star" id="star" class="form-control" placeholder="Star" required>
                                </div>

                                <div class="form-group col-4 mt-10">
                                    <label for="key">Key</label>
                                    <input type="text" name="key" id="key" class="form-control" placeholder="Key" required>
                                </div>
                                <div class="form-group col-6 mt-10">
                                    <label for="first_date">Boshlanish sana</label>
                                    <input type="date" name="first_date" id="first_date" class="form-control" placeholder="date" required>
                                </div>

                                <div class="form-group col-6 mt-10">
                                    <label for="end_date">Tugash sana</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" placeholder="date" required>
                                </div>

                                <div class="form-group col-12 mt-10">
                                    <label for="tarif">Ta'rif</label>
                                    <textarea name="description" id="tarif" cols="100" rows="5" required></textarea>
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
                        <th style="border: 1px solid">Nomi</th>
{{--                        <th style="border: 1px solid">Ta'rif</th>--}}
                        <th style="border: 1px solid">First-date</th>
                        <th style="border: 1px solid">End-date</th>
                        <th style="border: 1px solid">Number</th>
                        <th style="border: 1px solid">Star</th>
                        <th style="border: 1px solid">Key</th>
                        <th style="border: 1px solid">Status</th>
                        <th style="border: 1px solid">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($topshiriq as $top)
                    <tr>
                        <td style="border: 1px solid">
                            {{$top->id}}
                        </td>
                        <td style="border: 1px solid">
                            {{$top->name}}
                        </td>
{{--                        <td style="border: 1px solid">--}}
{{--                            {{$top->description}}--}}
{{--                        </td>--}}
                        <td style="border: 1px solid">
                            {{$top->first_date}}
                        </td>
                        <td style="border: 1px solid">
                            {{$top->end_date}}
                        </td>
                        <td style="border: 1px solid">
                            {{$top->number}}
                        </td>
                        <td style="border: 1px solid">
                            {{$top->star}}
                        </td>
                        <td style="border: 1px solid">
                            {{$top->key}}
                        </td>
                        <td style="border: 1px solid">
                            {{$top->status}}
{{--                            <div class="col-md-12" style="text-align: center">--}}
{{--                                <label class="switch">--}}
{{--                                    <input type="checkbox" checked="" id="checkslider" name="true" onchange="check()">--}}
{{--                                    <span class="slider round"></span>--}}
{{--                                </label>--}}
{{--                            </div>--}}
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
                                            <h5 class="modal-title" id="exampleModalLabel">Topshiriq tahrirlash</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{route('topshiriq-update',['id'=>$top->id])}}">
                                                @method('PUT')
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-12">
                                                        <label for="name">Topshiriq nomi</label>
                                                        <input type="text" name="name" value="{{$top->name}}" class="form-control" id="name" placeholder="Topshiriq nomi" required>
                                                    </div>

                                                    <div class="form-group col-4 mt-10">
                                                        <label for="son">Soni</label>
                                                        <input type="number" value="{{$top->number}}" name="number" id="son" class="form-control" placeholder="Soni" required>
                                                    </div>

                                                    <div class="form-group col-4 mt-10">
                                                        <label for="star">Star</label>
                                                        <input type="number" value="{{$top->star}}" name="star" id="star" class="form-control" placeholder="Star" required>
                                                    </div>

                                                    <div class="form-group col-4 mt-10">
                                                        <label for="key">Key</label>
                                                        <input type="text" value="{{$top->key}}" name="key" id="key" class="form-control" placeholder="Key" required>
                                                    </div>
                                                    <div class="form-group col-6 mt-10">
                                                        <label for="first_date">Boshlanish sana</label>
                                                        <input type="date" value="{{$top->first_date}}" name="first_date" id="first_date" class="form-control" placeholder="date" required>
                                                    </div>

                                                    <div class="form-group col-6 mt-10">
                                                        <label for="end_date">Tugash sana</label>
                                                        <input type="date" value="{{$top->end_date}}" name="end_date" id="end_date" class="form-control" placeholder="date" required>
                                                    </div>

                                                    <div class="form-group col-12 mt-10">
                                                        <label for="tarif">Ta'rif</label>
                                                        <textarea name="description" id="tarif" cols="100" rows="5" required>{{$top->description}}</textarea>
                                                    </div>

                                                    <div class="form-group col-4 mt-10">
                                                        <label for="status">Status</label>
                                                        <input type="number" value="{{$top->status}}" name="status" id="status" class="form-control" placeholder="Status" required>
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
