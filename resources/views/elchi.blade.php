@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table mb-0" id="dtBasicExample">
                     <thead>
                        <tr>
                           <th class="d-none">id</th>
                           <th>Username</th>
                           <th>FIO </th>
                           {{-- <th>Yoshi </th> --}}
                           <th>Viloyat </th>
                           <th>Ish kuni </th>
                           <th>Fakt </th>
                           <th>Prognoz </th>
                           {{-- <th>Telefon raqami </th> --}}
                           {{-- <th>Email </th>
                           <th class="text-right">Action </th> --}}
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($elchi as $item)
                        @if($item->admin == TRUE)
                        <tr
                           >
                           
                           <td class="d-none">{{$item->rid}} </td>
                           <td></td>
                           <td style="text-align: center">{{$item->last_name}} {{$item->first_name}} ( RM )</td>
                           {{-- <td>{{date('Y',(strtotime ( today()) )) - date('Y',(strtotime ( $item->birthday) ))}} </td> --}}
                           <td style="color:white;">{{$item->v_name}}</td>
                           
                           {{-- <td>{{$item->phone_number}}</td> --}}
                           {{-- <td>Brandon  <a href="../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="de8daab1b0bb9ebba6bfb3aeb2bbf0bdb1b3">[email&#160;protected] </a></td>
                           <td class="text-right">
                              <a href="patients-profile.html" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-eye mr-1"></i> View </a>
                              <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i>Delete </a>
                           </td> --}}
                        </tr>
                        @else
                        <tr 
                        onmouseover="$(this).css('background','#2e8b57').css('cursor','pointer')
                        .css('color','white');" 
                        onmouseleave="$(this).css('background','white').css('color','black');"
                           class='clickable-row' data-href='{{route('elchi',['id' => $item->id,'time' => 'today'])}}'
                           
                           >
                           
                           <td class="d-none">{{$item->rid}} </td>
                   <td>  {{$item->username}} </td>
                   <td> <img class="mr-2" src="{{asset('assets/img/'.$item->image)}}" style="border-radius:50%" height="20px"> {{$item->last_name}} {{$item->first_name}}</td>
                           {{-- <td>{{date('Y',(strtotime ( today()) )) - date('Y',(strtotime ( $item->birthday) ))}} </td> --}}
                           <td>{{$item->v_name}}</td>
                           <td>{{$elchi_work[$item->id]}}</td>
                           <td> <span class="badge bg-warning-light">{{$elchi_fact[$item->id]}}</span></td>
                           <td> <span class="badge bg-success-light">{{$elchi_prognoz[$item->id]}}</span></td>
                           {{-- <td>{{$elchi_prognoz[$item->id]}}</td> --}}
                           {{-- <td>{{$item->phone_number}}</td> --}}
                           {{-- <td>Brandon  <a href="../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="de8daab1b0bb9ebba6bfb3aeb2bbf0bdb1b3">[email&#160;protected] </a></td>
                           <td class="text-right">
                              <a href="patients-profile.html" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-eye mr-1"></i> View </a>
                              <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i>Delete </a>
                           </td> --}}
                        </tr>
                        @endif
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('admin_script')
   <script>
      jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});

      function tdhover()
      {
         $(this).css('display','none');
      }
   </script>
@endsection
