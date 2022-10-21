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
                            <form action="{{ route('product-category.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-8 col-sm-12">
                                        <input type="text" placeholder="Sklad nomini kiriting"  name="cat_name" class="form-control form-control-sm"/>
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
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->cat_name}}</td>
                                </tr>
                            @endforeach
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
