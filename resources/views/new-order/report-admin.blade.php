@extends('admin.layouts.app')
@section('admin_content')
   <div class="mt-5">
      <div class="card-body">
         <div class="table-responsive">
             <table class="table table-striped mb-0">
                 <thead>
                 <tr class="table-secondary">
                     <th>Number</th>
                     <th>Dorixona</th>
                     <th>Price</th>
                     <th>Discount</th>
                     <th>Date</th>
                     <th>Qarzdorlik</th>
                     {{-- <th>Otgruzka</th>
                     <th>Eski qarz yopildi</th>
                     <th>Eski qarz qoldi</th>
                     <th>Yangi qarz yopildi</th>
                     <th>Yangi qarz qoldi</th>
                     <th>Umumiy qarz</th> --}}
                 </tr>
                 </thead>
                 <tbody>
                     
                     @foreach ($orders as $item)
                         <tr>
                             <td>{{$item->number}}</td>
                             <td>{{$item->pharmacy->name}}</td>
                             <td>{{number_format($item->price,0,',','.')}}</td>
                             <td>{{$item->discount}}</td>
                             <td>{{date('d.m.Y',strtotime($item->order_date))}}</td>
                             <td>
                                 @if ($item->order_detail_status == 2)
                                    <a href="{{route('mc-admin-restore',$item->id)}}"><button class="btn btn-danger"><i class="fas fa-trash-restore-alt"></i></button></a>
                                 @endif
                             </td>
                             {{-- <td>{{number_format($all_money[$item->id],0,',','.')}}</td>
                             <td>{{number_format($otgruzka[$item->id],0,',','.')}}</td>
                             <td>{{number_format($last_close_money[$item->id],0,',','.')}}</td>
                             <td>{{number_format($last_accept_money[$item->id],0,',','.')}}</td>
                             <td>{{number_format($new_close_money[$item->id],0,',','.')}}</td>
                             <td>{{number_format($new_accept_money[$item->id],0,',','.')}}</td>
                             <td>
                                     {{number_format($new_accept_money[$item->id]+$last_accept_money[$item->id],0,',','.')}}
                             </td> --}}
                         </tr>

                     @endforeach
                 </tbody>
             </table>
         </div>
       </div>
   </div>
@endsection
