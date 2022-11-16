@extends('admin.layouts.app')
@section('admin_content')
    <div class="container mt-5 pt-5">
{{--        <a href="" class="btn btn-danger my-2 w-100">Orqaga</a>--}}
        <form  method="post" action="{{route('plan.store',['id'=>$user_id])}}">
            @csrf
                <select class="form-select p-2 mb-2" aria-label="Default select example" name="shablon_id" required>
                    <option value="" selected>Open this select menu</option>
                @php $i=1 @endphp
                @foreach($shablons as $m)
                        <option value="{{$m->id}}">{{$m->name}}</option>
                @endforeach
                </select>

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
            <div class="text-right " style="position: fixed;right: 1rem;top: 95vh; width: 100%"  >
                <button type="submit" style="width: 83.5%;" class="btn btn-primary">Saqlash </button>
            </div>
{{--            <button type="submit" href="" class="btn btn-primary my-2 w-100">Saqlash</button>--}}
        </form>

    </div>
@endsection
