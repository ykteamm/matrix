@extends('admin.layouts.admin-app')
@section('super_admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table mb-0" id="adminexample1">
                     <thead>
                        <tr>
                           <th>FIO </th>
                           <th>Viloyat </th>
                           <th>Rol nomi </th>
                           <th>Holati </th>
                           <th>vaqti</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($elchi as $item)
                        @if($item->pid)
                        <tr>
                           <td>{{$item->last_name}} {{$item->first_name}}</td>
                           <td>{{$item->v_name}}</td>
                           @if ($item->pid)
                           <td> 
                              
                              <span class="badge bg-info-light">
                                 {{$item->rol_name}}</span> 
                              <a href="{{ route('super-admin-list-edit',$item->pid) }}"> 
                              <button class="btn btn-primary btn-sm"> <i class="fas fa-edit"></i> </button>
                           </a> 


                           </td>
                           @else
                           <td>  <span class="badge bg-info-light">{{$item->rol_name}}</span> </td>
                           @endif
                           @if(Cache::has('user-is-online-' . $item->id))
                           <td><span class="text-success">Online</span></td>
                           
                           @else
                           <td><span class="text-secondary">Offline</span></td>
                           @endif
                           <td>{{ date('Y.m.d H:i:s',(strtotime ( '-5 hours' , strtotime ( $item->last_seen) ) )) }}</td>
                           
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
