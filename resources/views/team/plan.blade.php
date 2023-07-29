@extends('admin.layouts.app')
@section('admin_content')
        <div class="mt-5">
            <div class="mt-5">
                <div class="card-body mt-3">
                    <div class="table-responsive">

                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <strong>
                                <th>Jamoa </th>
                                <th>Plan (mln)</th>
                                <th>Galaba bonusi</th>
                                <th>Mag'lubiyat bonusi</th>
                                </strong>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($teams as $key => $item)

                            <form action="{{route('team-plan-update',$item->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <tr>
                                    <td>
                                        <input type="text" name="name" id="" class="form-control" value="{{$item->name}}">
                                    </td>
                                    <td>
                                        <input type="number" name="plan" id="" class="form-control" value="{{$item->plan}}">
                                    </td>
                                    <td>
                                        <input type="number" name="win_bonus" id="" class="form-control" value="{{$item->win_bonus}}">
                                    </td>
                                    <td>
                                        <input type="number" name="lose_bonus" id="" class="form-control" value="{{$item->lose_bonus}}">
                                    </td>
                                    <td>
                                        <button class="btn btn-primary">Ozgartirish</button>
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
