@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

        <div class="content container-fluid headbot">
            @if ($errors->any())
            @foreach ($errors->all() as $error)

                <div class="alert alert-danger" id="message">

                    <div style="text-align: center;">
                            <span >{{ $error }}</span>
                    </div>

                </div>
                @endforeach

            @endif
            @if (Session::has('message'))
            <div class="alert alert-primary" id="message">
                <div style="text-align: center;">

                        <span>{{ Session::get('message') }}</span>
                    </div>
            </div>
            @endif
            @if (Session::has('error'))
            <div class="alert alert-danger" id="message">
                <div style="text-align: center;">

                        <span>{{ Session::get('error') }}</span>
                    </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('product.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-4 col-sm-12">
                                        <input type="text" placeholder="Mahsulot nomini kiriting"  name="p_name" class="form-control form-control-sm"/>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6">
                                        <input type="number" placeholder="Miqdorini kiriting"  name="amount" class="form-control form-control-sm"/>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6">
                                        <input type="number" placeholder="Miqdorini kodini kiriting"  name="code" class="form-control form-control-sm"/>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6">
                                        <select class="form-control form-control-sm" name='product_category_id'>
                                          <option value="" disabled selected hidden>O'lchamni tanlang</option>
                                            @foreach ($categories as $item)
                                                <option value='{{$item->id}}'>{{$item->cat_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6">
                                        <select class="form-control form-control-sm" name='warehouse_id'>
                                          <option value="" disabled selected hidden>Skladni tanlang</option>
                                            @foreach ($warehouses as $item)
                                                <option value='{{$item->id}}'>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4 col-sm-12">
                                            <button type="submit" style="width:100%;" class="btn btn-primary"> Saqlash </button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ml-4 mr-4">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Sklad nomi</th>
                            <th scope="col">Sklad raqami</th>
                        </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($warehouses as $key => $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->code}}</td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
        </div>
        </div>
    </div>

</div>
@endsection
@section('admin_script')
   <script>
    
   </script>
@endsection
