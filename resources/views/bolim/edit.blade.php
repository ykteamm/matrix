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
                            <form action="{{ route('bolim.update',$dep->id) }}" method="POST">
                                {{ method_field('PATCH') }}
                        @csrf
                                
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="text" value="{{$dep->name}}"  name="bname" class="form-control form-control-sm" required/>
                                    </div>
                                    <div class="form-group col-md-4">
                                    </div>
                                    <div class="form-group col-md-2">
                                            <button type="submit" class="btn btn-primary"> O'zgartirish</button>
                                    </div>
                                    
                                </div>
                            </form>
                                
                        </div>
                    </div>
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
