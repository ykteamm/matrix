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
               <form action="{{ route('shogird.date') }}" method="POST">
                  @csrf
                  <div class="table-responsive">
                     <table class="table mb-0 example1">
                        <thead>
                           <tr>
                              <th>FIO</th>
                              <th>Buyurtma summasi</th>
                              <th>Promo summasi</th>
                              <th>Pul kelishi</th>
                              <th>Vaqti </th>
                              <th>Status </th>
                              <th>Holat</th>
                              {{-- <th>Sinov vaqti (Hafta) </th> --}}
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($orders as $elchi)
                              <tr>
                                 <td>{{$elchi['user']['last_name']}} {{$elchi['user']['first_name']}}</td>
                                 <td>{{$elchi['order_price']}}</td>
                                 <td>{{$elchi['promo_price']}}</td>
                                 <td>
                                    @if($elchi['money_arrival'] == null)
                                        0
                                    @else
                                    {{$elchi['money_arrival']}}

                                    @endif
                                 </td>
                                 <td>{{$elchi['created_at']}}</td>
                                 <td>
                                    @if($elchi['status'] == 1)
                                        Buyurtma berildi
                                    @elseif($elchi['status'] == 2)
                                        Buyurtma qabul qilindi
                                    @elseif($elchi['status'] == 3)
                                        Buyurtma yetkazilmoqda
                                    @elseif($elchi['status'] == 5)
                                        Buyurtma bekor qilindi
                                    @else
                                        Buyurtmani mijozda
                                    @endif</td>
                                 <td>
                                    @if($elchi['status'] == 1)
                                        <a href="{{route('orderpro.status',['order_id' => $elchi['id'],'status' => 2])}}" class="mr-2"> <i class="fas fa-check-square" style="color:green;font-size:25px;"></i> </a>
                                        <a href="{{route('orderpro.status',['order_id' => $elchi['id'],'status' => 5])}}" class="mr-2"> <i class="fas fa-window-close" style="color:red;font-size:25px;"></i> </a>
                                    @elseif($elchi['status'] == 2)
                                        <a href="{{route('orderpro.status',['order_id' => $elchi['id'],'status' => 3])}}" class="mr-2"> <i class="fas fa-truck" style="color:blue;font-size:25px;"></i> </a>
                                        <a href="{{route('orderpro.status',['order_id' => $elchi['id'],'status' => 5])}}" class="mr-2"> <i class="fas fa-window-close" style="color:red;font-size:25px;"></i> </a>
                                    @elseif($elchi['status'] == 3)
                                        <a href="{{route('orderpro.status',['order_id' => $elchi['id'],'status' => 5])}}" class="mr-2"> <i class="fas fa-window-close" style="color:red;font-size:25px;"></i> </a>
                                    @elseif($elchi['status'] == 5)

                                    @else

                                    @endif

                                    {{-- <a href="" class="mr-2"> <i class="fas fa-truck" style="color:blue;font-size:25px;"></i> </a> --}}
                                    <a href="{{route('order.product',['order_id' => $elchi['id']])}}" class="mr-2"> <i class="fas fa-eye" style="color:rgb(153, 11, 235);font-size:25px;"></i></a>
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  {{-- <div>
                     <button type="submit" class="btn btn-primary w-100">
                        Saqlash
                     </button>
                  </div> --}}
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('admin_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css"></script>
<script>
    $(function () {
        $("select").select2();
    });
   </script>
@endsection
