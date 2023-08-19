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
               <div class="text-center">
                  <span>
                     Jami:  {{$all_sum}}
                  </span>
               </div>
               <div class="table-responsive">
                  <table class="table mb-0 example1">
                     <thead>
                        <tr>
                           <th>Nomi </th>
                           <th>Soni</th>
                           <th>Summasi</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($rek_product as $value)
                           
                           <tr>
                              <td>
                                 {{$value['product']->name}}
                              </td>
                              <td>
                                 {{$value['number']}}
                              </td>
                              <td>
                                 {{$value['price']}}
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
</div>
@endsection
@section('admin_script')
   <script>
   </script>
@endsection
