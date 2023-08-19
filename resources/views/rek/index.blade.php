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
                                    {{$pharmacy_elchi_order[$i]['ph']->name}}

                                    @if ($pharmacy_elchi_order[$i]['con'] == -1)
                                       <span class="badge badge-secondary">Ostatka yoq</span>
                                    @elseif($pharmacy_elchi_order[$i]['con'] == 0)
                                       <a href="{{route('rek.pharmacy',$pharmacy_elchi_order[$i]['ph']->id)}}"> 
                                          <span class="badge badge-danger">Qizil</span>
                                       </a>
                                    @elseif($pharmacy_elchi_order[$i]['con'] == 1)
                                       <a href="{{route('rek.pharmacy',$pharmacy_elchi_order[$i]['ph']->id)}}"> 
                                          <span class="badge badge-warning">Sariq</span>
                                       </a>
                                    @else
                                       <a href="{{route('rek.pharmacy',$pharmacy_elchi_order[$i]['ph']->id)}}"> 
                                          <span class="badge badge-success">Yashil</span>
                                       </a>
                                    @endif

                                 @endif
                              </td>
                              <td>
                                 @if (isset($pharmacy_elchi[$i]))
                                    {{$pharmacy_elchi[$i]['ph']->name}}
                                    <a href="{{route('rek.pharmacy',$pharmacy_elchi[$i]['ph']->id)}}"> <i class="fas fa-eye"></i> </a>
                                    
                                    @if ($pharmacy_elchi[$i]['con'] == -1)
                                       <span class="badge badge-secondary">Ostatka yoq</span>
                                    @elseif($pharmacy_elchi[$i]['con'] == 0)
                                       <a href="{{route('rek.pharmacy',$pharmacy_elchi[$i]['ph']->id)}}"> 
                                          <span class="badge badge-danger">Qizil</span>
                                       </a>
                                    @elseif($pharmacy_elchi[$i]['con'] == 1)
                                       <a href="{{route('rek.pharmacy',$pharmacy_elchi[$i]['ph']->id)}}"> 
                                          <span class="badge badge-warning">Sariq</span>
                                       </a>
                                    @else
                                       <a href="{{route('rek.pharmacy',$pharmacy_elchi[$i]['ph']->id)}}"> 
                                          <span class="badge badge-success">Yashil</span>
                                       </a>
                                    @endif

                                 @endif
                              </td>
                              <td>
                                 @if (isset($pharmacy_order[$i]))
                                    {{$pharmacy_order[$i]['ph']->name}}
                                    <a href="{{route('rek.pharmacy',$pharmacy_order[$i]['ph']->id)}}"> <i class="fas fa-eye"></i> </a>
                                    
                                    @if ($pharmacy_order[$i]['con'] == -1)
                                       <span class="badge badge-secondary">Ostatka yoq</span>
                                    @elseif($pharmacy_order[$i]['con'] == 0)
                                       <a href="{{route('rek.pharmacy',$pharmacy_order[$i]['ph']->id)}}"> 
                                          <span class="badge badge-danger">Qizil</span>
                                       </a>
                                    @elseif($pharmacy_order[$i]['con'] == 1)
                                       <a href="{{route('rek.pharmacy',$pharmacy_order[$i]['ph']->id)}}"> 
                                          <span class="badge badge-warning">Sariq</span>
                                       </a>
                                    @else
                                       <a href="{{route('rek.pharmacy',$pharmacy_order[$i]['ph']->id)}}"> 
                                          <span class="badge badge-success">Yashil</span>
                                       </a>
                                    @endif

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
