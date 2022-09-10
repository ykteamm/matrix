@extends('admin.layouts.app')
@section('admin_content')
<div class="content container-fluid">
   <div class="row calender-col" style="background-color: rgb(246, 246, 246);position:inherit;z-index:1000;margin-top:-15px;top:0">
      <div class="col-xl-12 d-flex">
      <div class="card flex-fill">
      <div class="card-header">
         <h5 class="card-title" style="text-align: center">                  
            <img src="{{asset('nvt/logo2.png')}}" style="height: 100px;" class="img-fluid" alt="" />
         </h5>
      </div>
      </div>
      </div>
   </div>
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table mb-0" id="dtBasicExample">
                     <thead>
                        <tr>
                           <th>Username</th>
                           <th>FIO </th>
                           {{-- <th>Yoshi </th> --}}
                           <th>Viloyat </th>
                           {{-- <th>Telefon raqami </th> --}}
                           {{-- <th>Email </th>
                           <th class="text-right">Action </th> --}}
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($elchi as $item)
                        
                        <tr 
                        onmouseover="$(this).css('background','#2e8b57').css('cursor','pointer')
                        .css('color','white');" 
                        onmouseleave="$(this).css('background','white').css('color','black');"
                           class='clickable-row' data-href='{{route('elchi',['id' => $item->id,'time' => 'today'])}}'
                           
                           >
                           
                           <td>{{$item->username}} </td>
                           <td>{{$item->last_name}} {{$item->first_name}}</td>
                           {{-- <td>{{date('Y',(strtotime ( today()) )) - date('Y',(strtotime ( $item->birthday) ))}} </td> --}}
                           <td>{{$item->v_name}}</td>
                           {{-- <td>{{$item->phone_number}}</td> --}}
                           {{-- <td>Brandon  <a href="../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="de8daab1b0bb9ebba6bfb3aeb2bbf0bdb1b3">[email&#160;protected] </a></td>
                           <td class="text-right">
                              <a href="patients-profile.html" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-eye mr-1"></i> View </a>
                              <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i>Delete </a>
                           </td> --}}
                        </tr>
                        
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
