@extends('admin.layouts.app')
@section('admin_content')
    <div class="container pt-5">
{{--        <a href="" class="btn btn-danger my-2 w-100">Orqaga</a>--}}
        <form  method="post" action="{{route('plan.store',['id'=>$user_id])}}">
            @csrf
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Dori nomi</th>
                    <th scope="col">Soni</th>
                </tr>
                </thead>
                <tbody>

                @foreach($medicines as $medicine)
                    <tr>
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{$medicine->name}}</td>

                        <td>
                            <input type="number" name="numbers.{{$medicine->id}}" value="0">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <button type="submit" href="" class="btn btn-primary my-2 w-100">Saqlash</button>
        </form>

    </div>
@endsection