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
               <div class="table-responsive">
                  <table class="table mb-0 example1">
                     <thead>
                        <tr>
                           <th>Elchi bor </th>
                           <th>Elchi yoq</th>
                           <th>Faqat Otgruzka</th>
                        </tr>
                     </thead>
                     <tbody>
                        @for ($i = 0; $i < $max; $i++)
                           
                           <tr>
                              <td>
                                 @if (isset($pharmacy_elchi_order[$i]))
                                    {{$pharmacy_elchi_order[$i]->name}}
                                    <a href="{{route('rek.pharmacy',$pharmacy_elchi_order[$i]->id)}}"> <i class="fas fa-eye"></i> </a>
                                 @endif
                              </td>
                              <td>
                                 @if (isset($pharmacy_elchi[$i]))
                                    {{$pharmacy_elchi[$i]->name}}
                                    <a href="{{route('rek.pharmacy',$pharmacy_elchi[$i]->id)}}"> <i class="fas fa-eye"></i> </a>
                                 @endif
                              </td>
                              <td>
                                 @if (isset($pharmacy_order[$i]))
                                    {{$pharmacy_order[$i]->name}}
                                    <a href="{{route('rek.pharmacy',$pharmacy_order[$i]->id)}}"> <i class="fas fa-eye"></i> </a>
                                 @endif
                              </td>
                           </tr>
                        
                        @endfor
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
