@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-header">
                    <h4 class="card-title"> Dorixonaga foydalanuvchi ruhsati tahrirlash </h4>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <div class="card-header no-border">
                                        <h5 class="card-title"> {{$pharmacy->slug}} {{$pharmacy->name}} </h5>
                                    </div>
                                    <form action="{{route('pharm.users.updateby',['id'=>$pharmacy->id])}}" method="post">
                                        @csrf
                                    <div class="card-body">
                                        <div class="table-responsive">

                                            <table class="table table-striped mb-0">
                                                <thead>
                                                <tr><strong>
                                                    <th>No </th>
                                                    <th>Username</th>
                                                    <th>Adminlar FIO</th>
                                                    <th>Tahrirlash</th>
                                                    </strong>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                    @csrf
                                                @foreach($users as $item)
                                                    <tr>
                                                        <td>{{$loop->index+1}} </td>
                                                        <td>{{$item->username}}</td>
                                                        <td>
                                                            {{$item->first_name}}
                                                            {{$item->last_name}}
                                                        </td>
                                                        <td>
                                                            <div class="form-check">

                                                                    <input type="checkbox" class="form-check-input"
                                                                           @foreach($pharm_user as $p)
                                                                           @if($item->id==$p->user_id))
                                                                           checked
                                                                           @endif
                                                                           @endforeach
                                                                           name="user_id[]" value="{{$item->id}}">


                                                            </div>
                                                        </td  >
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                        <div class="text-right " style="position: fixed;right: 1rem;top: 95vh; width: 100%"  >
                                            <button type="submit" style="width: 83.5%;" class="btn btn-primary">Update </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection
