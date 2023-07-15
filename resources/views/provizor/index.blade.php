@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
    <div class="col-sm-12">
        <div class="card mt-5">
            <div class="row">
                @foreach ($regions as $r)
                <div class="col-4 col-md-12 col-lg-3 d-flex flex-wrap delregion">
                    <div class="card detail-box1">
                        <div class="card-body">
                            <div class="dash-contetnt">
                                <div class="justify-content-between">
                                    <h3 class="mt-2" style="color:white;height:45px;cursor:pointer;"
                                        data-toggle="modal" data-target="#addmemberwer13">{{$r->name}}</h3>
                                </div>
                                <div class="justify-content-between mt-3">
                                    <div class="row pl-3 pr-3">
                                        @php
                                        $all_price = 0;
                                        $pul = 0;
                                    @endphp
                                        @foreach ($orders222 as $ord)
                                        @if ($r->id == $ord['region_id'])

                                             @foreach ($ord['order'] as $o)
                                                @php
                                                $all_price += $o['order_price'];
                                                $pul += $o['money_arrival'];
                                                @endphp
                                            @endforeach



                                        @endif
                                        @endforeach
                                        <div style="background:#27a841;border-radius:8px;box-shadow: 0px 0px 7px 5px #ffffff;
                                            cursor:pointer"
                                            class="col-12 col-md-12 col-lg-12 mt-4 pul{{$r->id}}" onclick="ASD({{$r->id}})"
                                            >
                                            <div class="d-flex justify-content-between ">
                                                <span
                                                style="font-size:20px;color:white;"
                                                class="mt-1"

                                                >Jami buyurtma</span>

                                                <span
                                                style="font-size:20px;color:white;"
                                                class="mt-1"

                                                >Jami pul</span>
                                            </div>
                                            <div class="d-flex justify-content-between ">
                                                <span
                                                style="font-size:20px;color:white;"
                                                class="mt-1"

                                                >{{number_format($all_price,0,',','.')}}</span>

                                                <span
                                                style="font-size:20px;color:white;"
                                                class="mt-1"

                                                >{{number_format($pul,0,',','.')}}</span>
                                            </div>


                                        </div>

                                        @foreach ($orders222 as $ord)
                                        @if ($r->id == $ord['region_id'])
                                                    @php
                                                        $all_price = 0;
                                                        $pul = 0;
                                                    @endphp
                                                     @foreach ($ord['order'] as $o)
                                                        @php
                                                        $all_price += $o['order_price'];
                                                        $pul += $o['money_arrival'];
                                                        @endphp
                                                    @endforeach

                                                    @if($all_price > 0)
                                                    <div style="background:#181a49;border-radius:8px;box-shadow: 0px 0px 7px 5px #ffffff;
                                                        cursor:pointer;display: none;"
                                                        class="col-12 col-md-12 col-lg-12 mt-4 pulkelishi{{$r->id}}"
                                                        >
                                                        <div class="text-center">
                                                            <span
                                                            style="font-size:20px;color:white;"
                                                            class="mt-1"

                                                            >{{$ord['first_name']}} {{$ord['last_name']}}</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between ">
                                                            <span
                                                            style="font-size:20px;color:white;"
                                                            class="mt-1"

                                                            >{{number_format($all_price,0,',','.')}}</span>

                                                            <span
                                                            style="font-size:20px;color:white;"
                                                            class="mt-1"

                                                            >{{number_format($pul,0,',','.')}}</span>
                                                        </div>


                                                    </div>
                                                    @endif


                                                @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
      <div class="col-sm-12">
         <div class="card mt-5">
            <div class="card-body">
               <form action="{{ route('shogird.date') }}" method="POST">
                  @csrf
                  <div class="table-responsive">
                     <table class="table mb-0 example1">
                        <thead>
                           <tr>
                              <th onclick="$('.pass').toggle();">FIO</th>
                              <th class="pass" style="display: none;">PASS</th>
                              <th onclick="$('.money_com').toggle();">Buyurtma summasi</th>
                              <th class="money_com" style="display: none;">Promo summasi</th>
                              <th>Pul kelishi</th>
                              <th>Viloyat</th>
                              <th>Dorixona</th>
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
                                 <td class="pass" style="display: none;">{{$elchi['user']['pass']}}</td>
                                 <td>{{number_format($elchi['order_price'],0,',',' ')}}</td>
                                 <td class="money_com" style="display: none;">{{number_format($elchi['promo_price'],0,',',' ')}}</td>
                                 <td>
                                    @if($elchi['money_arrival'] == null)
                                        0
                                    @else
                                    {{number_format($elchi['money_arrival'],0,',',' ')}}

                                    @endif
                                 </td>
                                 <td>{{getRegionByid($elchi['user']['region_id'])}}</td>
                                 <td>{{getPharmacy($elchi['user']['pharmacy'][0]['pharmacy_id'])}}</td>
                                 <td>{{date('d.m.Y',strtotime($elchi['created_at']))}}</td>
                                 <td>
                                    @if($elchi['status'] == 1)
                                    <span class="badge badge-warning">Buyurtma berildi</span>


                                    @elseif($elchi['status'] == 2)
                                    <span class="badge badge-info"> Buyurtma qabul qilindi</span>


                                    @elseif($elchi['status'] == 3)
                                    <span class="badge badge-success">Buyurtma yetkazilmoqda</span>


                                    @elseif($elchi['status'] == 5)
                                    <span class="badge badge-danger">Buyurtma bekor qilindi</span>

                                    @else
                                    <span class="badge badge-primary">Buyurtmani mijozda</span>


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
                                    @php
                                        $ff = $elchi['id'];
                                    @endphp
                                    <a href="{{route('order.product',['order_id' => $elchi['id']])}}" class="mr-2"> <i class="fas fa-eye" style="color:rgb(153, 11, 235);font-size:25px;"></i></a>
                                    <span onclick="$('.eeee{{$ff}}').toggle();" class="mr-2 btn btn-primary btn-sm"> <i class="fas fa-plus"></i></span>
                                    
                                    @if (Session::get('user')->id == 37)
                                        <button style="background:#d32f13;color:#ffffff" onclick="myFunction3333({{$elchi['id']}})"> <i class="fas fa-trash"></i></button>
                                    @endif
                                    
                                    <p id="demo234"></p>
                                   
                                        <script>
                                            function myFunction3333(id) {
                                            let text = "Haqiqattan ham ushbu orderni ochirmoqchimisiz!\nIshonchingiz komilmi balki qayta tekshirib korarsiz.";
                                            if (confirm(text) == true) {
                                                text = "You pressed OK!";
                                                delid = id;
                                                
                                            } else {
                                                text = "You canceled!";
                                                delid = 1231212312;
                                            }
                                            var url = <?php echo json_encode(getProvizorUrl()); ?>;
                                            var url = url + '/api/order-delete';

                                                fetch(url, {
                                                    method: "POST",
                                                    body: JSON.stringify({
                                                        order_id: delid,
                                                    }),
                                                    headers: {
                                                        "Content-type": "application/json; charset=UTF-8"
                                                    }
                                                    });
                                            }
                                        </script>

                                    
                                 
                                </td>
                              </tr>
                              <tr class="eeee{{$elchi['id']}}" style="display: none;">
                                <td colspan="8">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Dori</th>
                                                <th>Zakaz</th>
                                                <th>Sotildi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($elchi['order_product'] as $item)
                                                <tr>
                                                    <td>{{$item['product']['name']}}</td>
                                                    <td>{{$item['quantity']}}</td>
                                                    @foreach ($elchi['order_stock'] as $e)
                                                        @if ($e['product_id'] == $item['product_id'])
                                                            @php
                                                                $stock = $e['quantity'];
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    <td>{{$stock??0}}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
    function ASD(id)
        {
                $(`.pulkelishi${id}`).toggle();
        }

    $(function () {
        $("select").select2();
    });
   </script>
@endsection
