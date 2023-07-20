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
                                <th>Categoriya tanlang </th>
                                <th>Nomi </th>
                                <th>Rasm</th>
                                <th>Saqlash </th>
                                </strong>
                            </tr>
                            </thead>
                            <tbody>
                            <form action="{{route('market-slider-save')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                              <tr>
                                
                                <td>
                                    <select name="category_id" class="form-control">
                                        <option disabled selected ></option>

                                        @foreach ($categories as $item)
                                            <option value="{{$item->id}}">
                                                {{$item->name}}
                                            </option>
                                        @endforeach 
                                    </select>
                                </td>
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
                                <th>Categoriyasi </th>
                                <th>Nomi </th>
                                <th>Rasm</th>
                                </strong>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($sliders as $key => $item)

                            <form action="{{route('market-slider-update',$item->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <tr>
                                    <td>
                                        {{$key+1}}
                                    </td>
                                    <td>
                                        {{$item->category->name}}
                                    </td>
                                    <td>
                                        <input type="text" name="text" id="" class="form-control" value="{{$item->name}}" required>
                                    </td>
                                    <td class="text-center">
                                        <img src="{{asset('market/slider/'.$item->image)}}" alt="" width="100px">
                                        <input type="file" name="image" id="" class="form-control" required>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary">Ozgartirish</button>
                                        <a href="{{route('market-slider-delete',$item->id)}}"> <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button> </a>
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
