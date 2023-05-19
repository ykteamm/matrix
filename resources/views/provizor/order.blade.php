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
                              <th>Mahsulot nomi</th>
                              <th>Buyurtma miqdori</th>
                              <th>Buyurtma summasi</th>
                           </tr>
                        </thead>
                        <tbody>
                            @php
                                $sum_q = 0;
                                $sum_p = 0;
                            @endphp
                           @foreach ($orders as $order)
                              <tr>
                                @php
                                    $sum_q = $sum_q + $order['quantity'];
                                    $sum_p = $sum_p + $order['quantity']*$order['product_price'];
                                @endphp
                                 <td>{{$order['premya']->name}}</td>
                                 <td>{{$order['quantity']}}</td>
                                 <td>{{number_format($order['quantity']*$order['product_price'],0,',',' ')}}</td>
                              </tr>
                           @endforeach
                           <tr>
                            <td>Jami</td>
                            <td>{{$sum_q}}</td>
                            <td>{{number_format($sum_p,0,',',' ')}}</td>
                         </tr>
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
