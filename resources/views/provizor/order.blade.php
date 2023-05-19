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
                            $spe_order = $orders;
                                $sum_q = 0;
                                $sum_p = 0;
                                $i = 0;
                            @endphp
                           @foreach ($spe_order as $key => $order)
                                @php
                                    $sum_q = $sum_q + $spe_order[$i]['quantity'];
                                    $sum_p = $sum_p + $spe_order[$i]['quantity']*$spe_order[$i]['product_price'];
                                @endphp
                              <tr>
                                 <td>{{$spe_order[$i]['product']->name}}</td>
                                 <td>{{$spe_order[$i]['quantity']}}</td>
                                 <td>{{number_format($spe_order[$i]['quantity']*$spe_order[$i]['product_price'],0,',',' ')}}</td>
                              </tr>
                              @php
                                $i = $i + 1;
                            @endphp
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
