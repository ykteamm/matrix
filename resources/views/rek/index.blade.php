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
               <div class="row">
                  <div class="col-md-4">
                     <table class="table mb-0 example1">
                        <thead>
                           <tr>
                              <th>Elchi bor,Otgruzka bor</th>
                              <th>Xolat</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($pharmacy_elchi_order as $key => $value)
                              
                              <tr>
                                    @if (isset($value))
                                       <td>
                                          {{$value['ph']->name}}

                                       </td>
                                       <td>
                                          @if ($value['con'] == -1)
                                             <span class="badge badge-secondary">Ostatka yoq</span>
                                          @elseif($value['con'] == 0)
                                                <span class="badge badge-danger">Qizil</span>
                                             <a href="{{route('rek.pharmacy',$value['ph']->id)}}"> 
                                                <i class="fas fa-eye"></i>
                                             </a>
                                          @elseif($value['con'] == 1)
                                                <span class="badge badge-warning">Sariq</span>
                                             <a href="{{route('rek.pharmacy',$value['ph']->id)}}"> 
                                                <i class="fas fa-eye"></i>
                                             </a>
                                          @else
                                                <span class="badge badge-success">Yashil</span>
                                          @endif
                                       </td>
                                       
   
                                    @endif
                              </tr>
                           
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  {{-- <div class="col-md-4">
                     <table class="table mb-0 example1">
                        <thead>
                           <tr>
                              <th>Elchi bor,Otgruzka yoq</th>
                              <th>Xolat</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($pharmacy_elchi as $key => $value)
                              
                              <tr>
                                    @if (isset($value))
                                       <td>
                                          {{$value['ph']->name}}

                                       </td>
                                       <td>
                                          @if ($value['con'] == -1)
                                             <span class="badge badge-secondary">Ostatka yoq</span>
                                          @elseif($value['con'] == 0)
                                                <span class="badge badge-danger">Qizil</span>
                                             <a href="{{route('rek.pharmacy',$value['ph']->id)}}"> 
                                                <i class="fas fa-eye"></i>
                                             </a>
                                          @elseif($value['con'] == 1)
                                                <span class="badge badge-warning">Sariq</span>
                                             <a href="{{route('rek.pharmacy',$value['ph']->id)}}"> 
                                                <i class="fas fa-eye"></i>
                                             </a>
                                          @else
                                                <span class="badge badge-success">Yashil</span>
                                          @endif
                                       </td>
                                       
   
                                    @endif
                              </tr>
                           
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  <div class="col-md-4">
                     <table class="table mb-0 example1">
                        <thead>
                           <tr>
                              <th>Elchi yoq,Otgruzka bor</th>
                              <th>Xolat</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($pharmacy_order as $key => $value)
                              
                              <tr>
                                    @if (isset($value))
                                       <td>
                                          {{$value['ph']->name}}

                                       </td>
                                       <td>
                                          @if ($value['con'] == -1)
                                             <span class="badge badge-secondary">Ostatka yoq</span>
                                          @elseif($value['con'] == 0)
                                                <span class="badge badge-danger">Qizil</span>
                                             <a href="{{route('rek.pharmacy',$value['ph']->id)}}"> 
                                                <i class="fas fa-eye"></i>
                                             </a>
                                          @elseif($value['con'] == 1)
                                                <span class="badge badge-warning">Sariq</span>
                                             <a href="{{route('rek.pharmacy',$value['ph']->id)}}"> 
                                                <i class="fas fa-eye"></i>
                                             </a>
                                          @else
                                                <span class="badge badge-success">Yashil</span>
                                          @endif
                                       </td>
                                       
   
                                    @endif
                              </tr>
                           
                           @endforeach
                        </tbody>
                     </table>
                  </div> --}}
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
