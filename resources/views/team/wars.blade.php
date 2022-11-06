@extends('admin.layouts.app')
@section('admin_content')
    <form action="{{route('team.wars.store')}}" method="post">
        @csrf
    <div class="row mt-5 pt-5 d-flex justify-content-between">
        <select class="col-3 form-select form-select-lg mb-3 p-2" aria-label=".form-select-lg example" name="team1">
            <option selected>Open this select menu</option>
            @foreach($teams as $t)
            <option class="cl{{$t->id}}"  onclick="func({{$t->id}})" value="{{$t->id}}" > {{$t->name}} </option>
            @endforeach
        </select>
        <select class="col-3 form-select form-select-lg mb-3 p-2" aria-label=".form-select-lg example" name="team2">
            <option selected>Open this select menu</option>
            @foreach($teams as $t)
                <option class="cl{{$t->id}}"  onclick="func({{$t->id}})" value="{{$t->id}}" > {{$t->name}} </option>
            @endforeach
        </select>
        <div class="col-md-3 mb-2  justify-content-end">
            <button type="submit" class="btn btn-primary">Saqlash</button>
        </div>
    </div>
    </form>

@endsection
