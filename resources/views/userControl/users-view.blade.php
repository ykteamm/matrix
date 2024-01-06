<?php
use Illuminate\Support\Facades\DB;
?>
@extends('admin.layouts.app')
@section('admin_content')
    @if (in_array(Session::get('user')->id,[37]))
    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-sm-12 p-5">
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
                <div class="card p-2">
                    <h3 class="text-center">View user</h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h5 class="text-center">Create</h5>
                                <br>
                                <form action="{{ url('create_users_start_work')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$users->id}}">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="start_date">Start Date</label>
                                            <input type="date" name="start_date"  class="form-control" id="start_date">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="start_work">Start Work</label>
                                            <input type="time" name="start_work" class="form-control"  id="start_work">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="finish_work">Finish Work</label>
                                            <input type="time" name="finish_work"  class="form-control" id="finish_work">
                                        </div>

                                    </div>
                                    <button type="submit" id="SaveStartWorkDate" class="btn btn-primary">Save</button>
                                </form>

                            </div>
                            <div class="col-md-8">
                                <h5 class="text-center">Ish vaqti</h5>

                                    <table class="table mb-0 example1">
                                        <thead>
                                            <tr>
                                                <th>Work ID</th>
                                                <th>Start Date</th>
                                                <th>Start Work</th>
                                                <th>Finish Work</th>
                                                <th>Finish Date</th>
                                                <th>Active</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($daily_works as $works)
                                            <tr>
                                                <td>{{$works->id}}</td>
                                                <td>{{$works->start}}</td>
                                                <td>{{$works->start_work}}</td>
                                                <td>{{$works->finish_work}}</td>
                                                <td>@if($works->finish ==null) today @else {{$works->finish}} @endif</td>
                                                <td>{{$works->active}}</td>
                                                <td>
                                                    <a type="button" class="btn btn-primary" style="color: white" data-toggle="modal" data-target="#exampleModal{{$works->id}}Work">
                                                        <i class="fas fa-user-edit"></i>
                                                        Edit
                                                    </a>

                                                    <div class="modal fade" id="exampleModal{{$works->id}}Work" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Update Work Time</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{url('update_users_start_work/'. $works->id)}}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input class='text-input' id='user_id' name='user_id' type='hidden' value="{{$works->user_id}}">

                                                                        <div class="mb-3">
                                                                            <label for="start_date" class="form-label">Start Date</label>
                                                                            <input type="date"  name="start_date" value="{{$works->start}}" class="form-control" id="start_date" aria-describedby="start_date">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="start_work" class="form-label">Start Work</label>
                                                                            <input type="time"  name="start_work" class="form-control" value="{{$works->start_work}}" id="start_work" aria-describedby="start_work">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="finish_work" class="form-label">Finish Work</label>
                                                                            <input type="time"  name="finish_work" class="form-control" id="finish_work" value="{{$works->finish_work}}" aria-describedby="finish_work">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="finish_date" class="form-label">Finish Date</label>
                                                                            <input type="date"  name="finish_date" class="form-control" id="finish_date" value="{{$works->finish}}" aria-describedby="finish_date">
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-primary">
                                                                                <i class="fas fa-user-edit"></i>
                                                                                Update Work Time
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
                        <br>
                        <hr>

                        <form action="{{ url('users-update/'.$users->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="id">ID</label>
                                    <input type="hidden" name="id" value="{{$users->id}}" class="form-control" id="id">
                                    <h5>{{$users->id}}</h5>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status">Status</label>
                                    <input type="number" name="status" class="form-control" value="{{$users->status}}" id="status" placeholder="Status">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" value="{{$users->first_name}}" class="form-control" id="first_name" placeholder="Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" value="{{$users->last_name}}" id="last_name" placeholder="Surname">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="region_id">Region ID</label><br>
                                    <select class="custom-select custom-select-lg mb-3 col-md-12" name="region_id" id="region_id" aria-label=".form-select-lg example">
                                        <option >Select Region</option>
                                        @foreach($region as $reg)
                                        <option @if($users->region_id ==$reg->id) selected @else @endif value="{{$reg->id}}">{{$reg->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="district_id">District ID</label><br>
                                    <select class="custon-select custom-select-lg mb-3 col-md-12" name="district_id" id="district_id" aria-label=".form-select-lg example">
                                        <option selected value="">Select District</option>
                                        @php
                                            $dist = DB::table('tg_district')->where('region_id',$users->region_id)->get();
                                        @endphp
                                        @foreach($dist as $dis)
                                            <option @if($users->district_id == $dis->id) selected @else @endif value="{{$dis->id}}">{{$dis->name}}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                            <button type="submit" id="UpdateRegionDistrict" class="btn btn-primary">Update</button>
                        </form>
                        <br>
                        <hr>
                        <div class="row">
                            <div class="form-group mt-5 col-md-6">
                                <h2>Pharmacy</h2>
                                <form action="{{url('create_users_pharm')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$users->id}}" name="user_id">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="select2Multiple">Pharm name</label><br>
                                            <select class="select2-multiple form-control" name="pharma_id"
                                                    id="select2Multiple">
                                                <option value="">Select Pharm</option>
                                                @foreach($pharmacy_name as $pharm_name)
                                                    <option value="{{$pharm_name->id}}">{{$pharm_name->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>

                            <div class="form-group mt-5 col-md-6">
                                <h2>Pharm Name</h2><br>

                                @foreach($pharmacyId as $pharma)
                                    @php
                                        $pharmacy = DB::table('tg_pharmacy')->where('id', $pharma)->get();
                                       // var_dump($pharmacyIds)
                                    @endphp

                                    @foreach($pharmacy as $pharm)
                                        <form action="{{ url('delete_users_pharm/'.$pharm->id) }}" id="Deleteform" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="row align-items-center justify-content-around">
                                                <div id="pharm_ids{{$pharm->id}}" class="col-md-9 alert alert-success alert-dismissible fade show" style="margin-bottom: 0px !important;" role="alert">
                                                    <input type="hidden" value="{{$pharm->id}}" name="pharm_id">
                                                    <input type="hidden" value="{{$users->id}}" name="user_id">
                                                    <strong>{{$pharm->name}}</strong>
                                                    <div  class="close">
                                                        <input type="checkbox" name="checkbox" id="{{$pharm->id}}" class="checkbox_ids">
                                                    </div>
                                                </div>
                                                <button type="submit" style="display: none;" class="col-md-2  btn btn-danger" id="delete-button{{$pharm->id}}">
                                                    Delete
                                                </button>
                                            </div>
                                        </form>
                                        <br>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <h2>Order</h2>

                                <table class="table mb-0 example1">
                                    <thead>
                                    <tr>
                                        <th>Order ID</th>

{{--                                        <th>Number</th>--}}
{{--                                        <th>Price</th>--}}

                                        <th>Total</th>
                                        <th>Pharm Name</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product_sold as $order)
                                        <tr>
                                        <td>{{$order->order_id}}</td>

{{--                                        <td>{{$order->number}}</td>--}}
{{--                                        <td>{{$order->price_product}}</td>--}}

                                        <td>{{$order->total}}</td>
                                        <td>{{$order->pharmacy_name}}</td>
                                        <td>{{$order->created_at}}</td>
                                        <td>
                                            <a type="button" class="btn btn-primary" style="color: white" data-toggle="modal" data-target="#exampleModal{{$order->order_id}}">
                                                <i class="fas fa-user-edit"></i>
                                                Edit
                                            </a>
                                            <a type="button" class="btn btn-danger" style="color: white" data-toggle="modal" data-target="#exampleModal{{$order->order_id}}delete">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </a>

                                            <div class="modal fade" id="exampleModal{{$order->order_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update your  Order</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{url('users-order-update/'.$order->order_id)}}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input class='text-input' id='user_id' name='user_id' type='hidden' value="{{$order->user_id}}">
                                                                <div class="mb-3">
                                                                    <label for="select2Multiple">Pharm Name</label><br>
                                                                    <select class="select2-multiple form-control" name="pharm_id"
                                                                            id="select2Multiple">
                                                                        <option value="">Select Pharm</option>
                                                                        @foreach($pharmacy_name as $pharm_name)
                                                                            <option @if($order->pharmacy_name == $pharm_name->name) selected @else @endif value="{{$pharm_name->id}}">{{$pharm_name->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
{{--                                                                <div class="mb-3">--}}
{{--                                                                    <label for="pharm_id" class="form-label">Pharm name</label>--}}
{{--                                                                    <input type="text" value="{{$order->pharmacy_name}}" name="pharm_id" class="form-control" id="pharm_id" aria-describedby="pharm_id">--}}
{{--                                                                </div>--}}

                                                                <div class="mb-3">
                                                                    <label for="created_at" class="form-label">Created_at</label>
                                                                    <input type="datetime-local" value="{{$order->created_at}}" name="created_at" class="form-control" id="created_at" aria-describedby="created_at">
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


                                            <div class="modal fade" id="exampleModal{{$order->order_id}}delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete your {{$order->order_id}} Order</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{url('users-order-delete/'.$order->order_id)}}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input class='text-input' id='user_id' name='user_id' type='hidden' value="{{$order->user_id}}">
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

                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
