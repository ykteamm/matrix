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
                <form action="{{ route('rekrut-group.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-4">
                            <input type="text"  name="title" class="form-control form-control-sm" required placeholder="Nomi"/>
                        </div>

                        <div class="form-group col-md-3">
                            <input type="date"  name="begin" class="form-control form-control-sm" required/>
                        </div>

                        <div class="form-group col-md-3">
                            <input type="date"  name="end" class="form-control form-control-sm" required/>
                        </div>

                       

                        <div class="form-group col-md-3 reksave">
                                <button type="submit" class="btn btn-primary" onclick="$('#reksave').addClass('d-none');$('#reksave2').removeClass('d-none')"> Saqlash </button>
                        </div>

                        <div class="form-group col-md-2 reksave2 d-none">
                            <button type="button" class="btn btn-primary"> Biroz kuting </button>
                        </div>

                    </div>
                </form>

            </div>
         </div>
         <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mb-0" id="dtBasicExample12">
                    <thead>
                        <tr>
                            <th> Nomi </th>
                            <th> Boshlanishi </th>
                            <th> Tugashi </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $item)
                            
                            <tr>
                                <td>{{$item->title}}</td>
                                <td>{{$item->begin}}</td>
                                <td>{{$item->end}}</td>
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
    function districts()
    {
       var region = $('#aioConceptName').find(":selected").val();
       $('.aioConceptNameDist').addClass('d-none');
       $(`.distreg${region}`).removeClass('d-none');
    }
   </script>
@endsection
