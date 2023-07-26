@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-striped mb-0">
                        <tbody>
                        <form action="{{route('market-product-save')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                          <tr>
                            <td>
                                <input type="text" name="name" placeholder="Nomi" class="form-control" required>
                            </td>
                            <td>
                                <input type="number" name="crystall" placeholder="Crystal" class="form-control" required>
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
            <div class="table-responsive">

                <table class="table">
                    <thead>
                    <tr>
                        <strong>
                        <th>Nomi </th>
                        <th>Crystal </th>
                        <th>Rasm</th>
                        </strong>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $key => $product)

                    <form action="{{route('market-product-update',$product->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <tr>
                            <td>
                                {{$key+1}}
                            </td>
                            <td>
                                <input type="text" name="name" id="" class="form-control" value="{{$product->name}}" required>
                            </td>
                            <td>
                                <input type="number" name="crystal" id="" class="form-control" value="{{$product->crystall}}" required>
                            </td>
                            <td class="text-center">
                                <img src="{{asset('outermarket/'.$product->image)}}" alt="" width="100px">
                                <input type="file" name="image" id="" class="form-control">
                            </td>
                            <td>
                                <button class="btn btn-primary">Ozgartirish</button>
                                <a href="{{route('market-product-delete',$product->id)}}"> <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button> </a>
                            </td>
                            </tr>
                        
                    </form>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
