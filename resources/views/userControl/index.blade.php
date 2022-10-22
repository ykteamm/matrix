@extends('admin.layouts.app')
@section('admin_content')
    <div class="row d-flex  justify-content-center">
        <div class="col-md-6">
            <div class="card bg-white">
                <div class="card-header">
                    <h5 class="card-title">Solid justified </h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                        <li class="nav-item"><a class="nav-link active" href="#solid-justified-tab1" data-toggle="tab">Ishchilar </a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-justified-tab2" data-toggle="tab">Ishdan ketganlar </a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-justified-tab3" data-toggle="tab">Yangilar</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="solid-justified-tab1">
                            <form  method="post" action="{{route('user-delete',['action'=>2])}}">
                                @csrf
                            <table class="table table-striped " style="height: 100px;overflow-y: scroll">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ismi</th>
                                    <th scope="col">Familiyasi</th>
                                    <th scope="col">Ishdan olish</th>
                                    <th scope="col">Test qilish</th>
                                </tr>
                                </thead>
                                <tbody style="height: 50px!important;  overflow-y: scroll!important;">
                                @php $t2=0 @endphp
                                @foreach($users as $user)
                                @if($user->status==1 || $user->status==3)
                                    @php $t2++; @endphp

                                    <tr @if($user->status==3) class="bg-danger text-white" @endif>
                                        <th scope="row">{{$t2}}</th>
                                        <td>{{$user->first_name}}</td>
                                        <td>{{$user->last_name}}</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="check1.{{$user->id}}" name="id.{{$user->id}}" value="id" >
                                                <label class="form-check-label" for="check1.{{$user->id}}">Ishdan olish</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" @if($user->status==3) checked @endif id="check1test.{{$user->id}}" name="test.{{$user->id}}" value="test" >
                                                <label class="form-check-label" for="check1test.{{$user->id}}">Test qilish</label>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @endforeach


                                </tbody>
                            </table>
                                <div>
                                    <button type="submit" class="w-100 btn btn-primary">Saqlash</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="solid-justified-tab2">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $t3=0 @endphp
                                @foreach( $users as $user)
                                    @if($user->status==2)
                                        @php $t3++; @endphp
                                <tr>
                                    <th scope="row">{{$t3}}</th>
                                    <td>{{$user->first_name}}</td>
                                    <td>{{$user->last_name}}</td>
                                </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="solid-justified-tab3">
                            <form  method="post" action="{{route('user-add')}}">
                                @csrf
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Ismi</th>
                                        <th scope="col">Familiyasi</th>
                                        <th scope="col">Ishga Qo'shish</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $t1=0; @endphp
                                    @foreach($arr as $item)
                                            @php $t1++; @endphp
                                            <tr>
                                                <th scope="row">{{$t1}}</th>
                                                <td>{{$item['data']->first_name}}</td>
                                                <td>{{$item['data']->last_name}}</td>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="check1.{{$user->id}}" name="id.{{$item['tg_id']}}" value="something" >
                                                        <label class="form-check-label" for="check1">Ishga Qo'shish</label>
                                                    </div>
                                                </td>
                                            </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                                <div>
                                    <button type="submit" class="w-100 btn btn-primary">Saqlash</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
