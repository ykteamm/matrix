@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box mt-5">
            {{-- @include('admin.components.logo') --}}
            <div class="container mt-5">
                @if($banner != null)
                <form action="{{route('mijoz-banner-update',$banner->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <textarea name="text" id="" cols="10" rows="2" class="form-control">{{$banner->text}}</textarea>
                        </div>
                        <div class="col-md-4">
                            <img width="100" src="{{asset('mijoz/banner/'.$banner->image)}}" alt="ddd">
                            <input name="image" type="file" name="" id="" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary">O'zgartirish</button>

                        </div>
                    </div>
                </form>
                @else
                <form action="{{route('mijoz-banner-save')}}" method="POST" enctype="multipart/form-data">
                    @csrf
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
                @endif
            </div>
        </div>
    </div>
@endsection
