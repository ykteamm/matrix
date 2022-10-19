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
                           <th>Nomi</th>
                           <th>Rasmi</th>
                           <th>Telefon raqami</th>
                           <th>Joyi m<sup>2</sup></th>
                           {{-- <th>Ish kuni </th> --}}
                           {{-- <th>Fakt </th> --}}
                           {{-- <th>Prognoz </th> --}}
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($pharmacy as $item)
                        <tr
                           >
                           
                           <td><a href="{{route('pharmacy',$item->id)}}">{{$item->name}}</a></td>
                           <td> <img src="https://telegra.ph/file/a9d999c0cd458d44ce655.jpg" height="80px" alt=""> </td>
                           <td>{{$item->phone_number}}</td>
                           <td>{{$item->volume}}</td>
                           {{-- <td style="text-align: center">{{$item->last_name}} {{$item->first_name}} ( RM )</td> --}}
                           {{-- <td style="color:white;">{{$item->v_name}}</td> --}}
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
