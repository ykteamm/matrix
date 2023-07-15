@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box mt-5">
            {{-- @include('admin.components.logo') --}}
            <div class="container mt-5">
                <ul>
                    @foreach ($users as $key => $item)
                        <li>{{$key+1}} {{$item->l}} {{$item->f}} {{$item->allprice}}</li>
                    @endforeach
                </ul>
                <form action="">
                    <div class="row">
                        <div class="col-md-4">
                            <textarea name="text" id="" cols="10" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="col-md-4">
                            <input name="image" type="file" name="" id="" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary">Saqlash</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
