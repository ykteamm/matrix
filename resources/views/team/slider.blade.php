@extends('admin.layouts.app')
@section('admin_content')
        <div class="mt-5">
            <div class="mt-5">
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <strong>
                                <th>Tartibi </th>
                                <th>Rasm</th>
                                <th>Saqlash </th>
                                </strong>
                            </tr>
                            </thead>
                            <tbody>
                            <form action="{{route('team-slider-save')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                              <tr>
                                <td>
                                    <input type="number" name="sort" id="" class="form-control" required>
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
            <div class="mt-5">
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <strong>
                                <th>Tartibi </th>
                                <th>Rasm</th>
                                </strong>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($sliders as $key => $item)

                            <form action="{{route('team-slider-update',$item->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <tr>
                                    <td>
                                        <input type="number" name="sort" id="" class="form-control" value="{{$item->sort}}">
                                    </td>
                                    <td class="text-center">
                                        <img src="{{asset('market/slider/'.$item->image)}}" alt="" width="100px">
                                        <input type="file" name="image" id="" class="form-control">
                                    </td>
                                    <td>
                                        <button class="btn btn-primary">Ozgartirish</button>
                                        <a href="{{route('team-slider-delete',$item->id)}}"> <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button> </a>
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
@endsection
