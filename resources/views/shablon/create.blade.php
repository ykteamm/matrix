@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

        <div class="content container-fluid headbot">
            <div class="row">
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
            </div>
            <div class="row">
                <div class="col-md-10 ml-4 mr-4">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Dori nomi</th>
                            {{-- <th scope="col">O'zgartirish</th> --}}
                        </tr>
                        </thead>
                        <tbody>
        
                        @foreach($shablons as $key => $shablon)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{$shablon->name}}</td>
                                <td>
                                    @if (isset($shablon->price[0]))
                                    <a href="{{route('price-med.edit',$shablon->id)}}">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> </button>
                                    </a>
                                    @else
                                    <a href="{{route('price-med',$shablon->id)}}">
                                        <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> </button>
                                    </a>
                                    @endif
                                </td>
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
