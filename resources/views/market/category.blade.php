@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box mt-5">
            {{-- @include('admin.components.logo') --}}
            <div class="container mt-5">
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <strong>
                                <th>Nomi </th>
                                <th>Rasm</th>
                                <th>Saqlash </th>
                                </strong>
                            </tr>
                            </thead>
                            <tbody>
                            <form action="{{route('market-category-save')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                              <tr>
                                <td>
                                    <input type="text" name="text" id="" class="form-control" required>
                                </td>
                                <td>
                                    <input type="file" name="image" id="" class="form-control" required>
                                </td>
                                <td>
                                    <button class="btn btn-primary">Saqlash</button>
                                </td>
                              </tr>
                            </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <strong>
                                <th>NO </th>
                                <th>Nomi </th>
                                <th>Rasm</th>
                                </strong>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $key => $item)

                            <form action="{{route('market-category-update',$item->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <tr>
                                    <td>
                                        {{$key+1}}
                                    </td>
                                    <td>
                                        <input type="text" name="text" id="" class="form-control" value="{{$item->name}}" required>
                                    </td>
                                    <td class="text-center">
                                        <img src="{{asset('market/category/'.$item->image)}}" alt="" width="100px">
                                        <input type="file" name="image" id="" class="form-control" required>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary">Ozgartirish</button>
                                        <a href="{{route('market-category-delete',$item->id)}}"> <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button> </a>
                                    </td>
                                  </tr>
                              
                            </form>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
