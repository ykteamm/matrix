@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card mt-5">
            <div class="card-body">
                <form action="{{ route('group-state.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-2">
                            <input type="date" value="{{date('Y-m').'-01'}}"  name="month" class="form-control form-control-sm" required/>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="date"  name="begin_date" class="form-control form-control-sm" required/>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="integer"  name="day" placeholder="Jang kuni" class="form-control form-control-sm" required/>
                        </div>
                        <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-primary"> Saqlash </button>
                        </div>

                    </div>
                </form>

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
