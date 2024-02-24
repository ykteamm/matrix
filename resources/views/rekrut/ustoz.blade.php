@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">

         <div class="card-body">
            <div class="text-center">
                <span>{{date('d.m.Y',strtotime($date1))}}</span>
                <span>-</span>
                <span>{{date('d.m.Y',strtotime($date2))}}</span>
            </div>
            <div id="dtBasicExample1212"></div>

            <div class="table-responsive">
                <table class="table table-striped mb-0" id="dtBasicExample12">
                    <thead>
                    <tr>
                        <th>Ism </th>
                        <th>Familiya </th>
                        <th>Yosh </th>
                        <th>Telefon</th>
                        <th>Viloyat </th>
                        <th>Tuman </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rekruts as $rekrut)
                        <tr>
                            <td>{{$rekrut->full_name}}</td>
                            <td>{{$rekrut->last_name}} </td>
                            <td>{{$rekrut->age}} </td>
                            <td>{{$rekrut->phone}} </td>
                            <td>{{$rekrut->region->name}} </td>
                             <td>
                              @if(isset($district[$rekrut->district_id]))
                              {{$district[$rekrut->district_id]}}
                              @else
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
    function districts()
    {
       var region = $('#aioConceptName').find(":selected").val();
       $('.aioConceptNameDist').addClass('d-none');
       $(`.distreg${region}`).removeClass('d-none');
    }
   </script>
@endsection
