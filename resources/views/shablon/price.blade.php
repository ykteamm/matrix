@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

        <div class="content container-fluid headbot">
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('shablon.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <input type="text" placeholder="Shablon nomini kiriting"  name="name" class="form-control form-control-sm" required/>
                                    </div>

                                    <div class="form-group col-md-2" style="margin-left:auto">
                                            <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}
            <form action="{{route('price-medic.store')}}" method="POST">
                @csrf
            <div class="row" style="overflow-x: scroll;height:700px">
                <div class="col-md-10 ml-4 mr-4">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Dori nomi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $key => $pro)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{$pro->name}}</td>
                                <td><input type="number" value="0" class="form-control form-control-sm" name="{{$pro->id}}"></td>

                                {{-- <td>  
                                    <a href="{{route('price-med',$shablon->id)}}">
                                       <span class="badge bg-info-light">Narxlar</span> 
                                    </a>
                                </td> --}}

                            </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
                </div>
            </div>
            <input style="display: none;" type="text" value="{{$id}}" name="shablon_id">
            <div class="col-md-2 m-auto">
                <button type="submit" class="btn btn-primary"> Qo'shish </button>
            </div>
            </form>
        </div>
    </div>

</div>
@endsection
@section('admin_script')
   <script>
    
   </script>
@endsection
