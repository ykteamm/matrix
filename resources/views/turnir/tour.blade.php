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
                <form action="{{ route('turnir-tour-store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="mon">Hozirgi oy</label>
                            <input id="mon" type="date" value="{{date('Y-m').'-01'}}"  name="month" class="form-control form-control-sm" required/>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="mon">Turning boshlanishi</label>
                            <input type="date"  name="date_begin" class="form-control form-control-sm" required/>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="mon">Turning tugashi</label>
                            <input type="date"  name="date_end" class="form-control form-control-sm" required/>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="mon">Nechanchi tur ?</label>
                            <input type="number"  name="tour" placeholder="Tur" class="form-control form-control-sm" required/>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="mon">Title </label>
                            <input type="number"  name="title" placeholder="Title" class="form-control form-control-sm" required/>
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
