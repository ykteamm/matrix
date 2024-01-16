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
                <div class="card-body">
                    <div class="table-responsive">
                       <table class="table mb-0 example1">
                          <thead>
                             <tr>
                                <th>Viloyat</th>
                                <th>Yanvar </th>
                                <th>Fevral</th>
                                <th>Mart</th>
                                <th>Aprel</th>
                                <th>May</th>
                                <th>Iyun</th>
                                <th>Iyul</th>
                                <th>Avgust</th>
                                <th>Sentabr</th>
                                <th>Oktabr</th>
                                <th>Noyabr</th>
                                <th>Dekabr</th>
                             </tr>
                          </thead>
                          <tbody>
                             @foreach ($regions as $k => $elchi)
                             <tr>
                                <td>{{$name[$elchi]}}</td>
                                @for ($i = 0; $i < 12; $i++)
                                <td>
                                    {{$reg[$elchi][$i]}}

                                </td>
                                @endfor

                             </tr>
                             @endforeach

                             {{-- @foreach ($regions as $elchi)
                                @foreach ($reg[$elchi] as $sd)
                                    <tr>
                                        <td>{{$sd}}</td>
                                    </tr>
                                @endforeach
                             @endforeach --}}

                          </tbody>
                       </table>
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
