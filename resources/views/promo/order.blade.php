@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card mt-5">
            <div class="text-center">
                <h4><span class="badge badge-primary">{{$name}}</span></h4>
            </div>
            <div class="card-body">
               <form action="{{ route('order.update',$order_id) }}" method="POST">
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

                                $proId = [36,37,38,39,29,47];

                                $spe_order = $orders;
                                    $sum_q = 0;
                                    $sum_p = 0;
                                    // $i = 0;
                                    // $count = count($spe_order);
                                @endphp
                                @for ($i = 0; $i < $count; $i++)
                                @if(isset($spe_order[$i]))
                                    @php
                                        $sum_q = $sum_q + $spe_order[$i]['quantity'];
                                        $sum_p = $sum_p + $spe_order[$i]['quantity']*$spe_order[$i]['product_price'];
                                    @endphp
                                    <tr>
                                        <td>{{$spe_order[$i]['product']['name']}}</td>
                                        <td>

                                            @if(in_array($spe_order[$i]['product_id'],$proId))

                                            <input type="text" value="{{$spe_order[$i]['quantity']}}" id="pro{{$spe_order[$i]['id']}}" class="allpro"
                                                name="product[{{$spe_order[$i]['product_id']}}][]"
                                                style="display:none;"

                                                >
                                                {{$spe_order[$i]['quantity']}}
                                            @else

                                                <input type="text" value="{{$spe_order[$i]['quantity']}}" id="pro{{$spe_order[$i]['id']}}" class="allpro"
                                                name="product[{{$spe_order[$i]['product_id']}}][]"
                                                onkeyup="upOrder(`{{$spe_order[$i]['product_price']}}`,`{{$spe_order[$i]['id']}}`)"

                                                >
                                            @endif

                                            </td>
                                        <td id="proprice{{$spe_order[$i]['id']}}">

                                            <input type="text" disabled value="{{$spe_order[$i]['quantity']*$spe_order[$i]['product_price']}}" class="allprosum">

                                            {{-- {{number_format($spe_order[$i]['quantity']*$spe_order[$i]['product_price'],0,',',' ')}} --}}

                                        </td>
                                    </tr>

                                @endif
                                @endfor
                         <tr>
                            <td>Jami</td>
                            <td id="allprosoni">{{$sum_q}}</td>
                            <td id="allprosoni2">{{number_format($sum_p,0,',',' ')}}</td>
                         </tr>
                        </tbody>
                     </table>

                  </div>
                  <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">
                        O'zgartirish
                    </button>
               </div>
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
    function upOrder(narxi,id)
    {

        var proId = [36,37,38,39,29,47];

        var pro = $(`#pro${id}`).val();
        $(`#proprice${id}`).text(pro*narxi);

        var sumpor = 0
        $('.allpro').each(function(){
            sumpor += parseInt(this.value)
        });
        $('#allprosoni').text(sumpor);

        var sumpor2 = 0
        $('.allprosum').each(function(){
            sumpor2 += parseInt(this.value)
        });
        sumpor2 = sumpor2 + pro*narxi;

        $('#allprosoni2').text(sumpor2);
    }
   </script>
@endsection
