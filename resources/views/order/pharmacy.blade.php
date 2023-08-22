@extends('admin.layouts.app')
@section('admin_content')
<div class="row gold-box">
       
   <div class="card flex-fill mt-5">
  
       <div class="card-body">
           <div class="table-responsive">
               <table class="table table-striped mb-0">
                   <thead>
                   <tr>
                       <th>ID</th>
                       <th>Barchasi</th>
                       <th>Provizor</th>
                       <th>Pul kelishi</th>
                       <th>Sotuv</th>
                       <th>Elchi</th>
                       <th>Ostatka</th>
                   </tr>
                   </thead>
                   <tbody>
                     @foreach ($all_ids as $key=>$item)
                        <tr>
                           <td>
                              {{$item}}
                           </td>
                           <td>
                              {{$key}}
                           </td>
                           <td>
                              <span style="color:blue">
                                 @if(isset($use_order[$item]))
                                 {{$use_order[$item]->name}}
                                 @else
                                    
                                 @endif
                              </span>

                              <span style="color:red">
                                 @if(isset($use_no_order[$item]))
                                 {{$use_no_order[$item]->name}}
                                 @else
                                    
                                 @endif
                              </span>

                           </td>
                           <td>
                              <span style="color:blue">
                                 @if(isset($mc_order[$item]))
                                 {{$mc_order[$item]->name}}
                                 @else
                                    
                                 @endif
                              </span>

                           </td>
                           <td>
                              <span style="color:blue">
                                 @if(isset($sold[$item]))
                                 {{$sold[$item]->name}}
                                 @else
                                    
                                 @endif
                              </span>

                           </td>
                           <td>
                              <span style="color:blue">
                                 @if(isset($elchi[$item]))
                                 {{$elchi[$item]->name}}
                                 @else
                                    
                                 @endif
                              </span>

                           </td>
                           <td>
                              <span style="color:rgb(176, 13, 241)">
                                 @if(isset($ostatka[$item]))
                                 {{$ostatka[$item]->name}}
                                 @else
                                    
                                 @endif
                              </span>

                           </td>
                           <td>
                              <a href="{{route('pharmacy-delete',$item)}}">
                                 <button class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                 </button>
                              </a>
                           </td>
                        </tr>
                     @endforeach
                   </tbody>
               </table>
           </div>
       </div>
   </div>
</div>

   {{-- <div style="margin-top: 130px;">
      <div class="row mt-5">
         <div class="col-md-3" style="background: rgb(196, 240, 183)">
            <div class="card-body" style="border-radius: 5px">
               @foreach ($provizor as $item)
                  <p class="mcrang{{$item->id}}">({{$item->id}}) {{$item->name}}</p>
               @endforeach
            </div>
         </div>
         <div class="col-md-3" style="background: rgb(183, 212, 240)">
            <div class="card-body" style="border-radius: 5px">
               @foreach ($order as $item)
                  <p class="mcrang{{$item->id}}">({{$item->id}}) {{$item->name}}</p>
               @endforeach
            </div>
         </div>
         <div class="col-md-3" style="background: rgb(240, 194, 183)">
            <div class="card-body" style="border-radius: 5px">
               @foreach ($sold as $item)
                  <p class="mcrang{{$item->id}}">({{$item->id}}) {{$item->name}}</p>
               @endforeach
            </div>
         </div>
         <div class="col-md-3" style="background: rgb(212, 183, 240)">
            <div class="card-body" style="border-radius: 5px">
               @foreach ($other as $item)
                  <p class="mcrang{{$item->id}}">({{$item->id}}) {{$item->name}}</p>
               @endforeach
            </div>
         </div>
      </div>
   </div> --}}
@endsection
