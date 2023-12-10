<div class="content main-wrapper ">
    <div class="row gold-box">
       
        <div class="card flex-fill mt-5">
            
            <div class="card-body">
                <div class="text-right">
                    <a href="{{route('mc-money-month',['begin' => '2023-08-01','end' => '2023-08-31'])}}">
                        <button class="btn btn-primary">Avgust</button>
                    </a>
                    <a href="{{route('mc-money-month',['begin' => '2023-09-01','end' => '2023-09-30'])}}">
                        <button class="btn btn-primary">Sentabr</button>
                    </a>
                    <a href="{{route('money-coming')}}">
                        <button class="btn btn-primary">Jami</button>
                    </a>
                </div>
              <div id="dtBasicExample1212333"></div>

                <div class="table-responsive">
                    
                    <table class="table table-striped mb-0" id="dtBasicExample12333">
                        <thead>
                        <tr>
                            <th>Buyurtma raqami</th>
                            <th>Buyurtma vaqti</th>
                            <th>Buyurtma beruvchi</th>
                            <th>Viloyat</th>
                            <th>Skidka</th>
                            <th>Buyurtma Narxi</th>
                            <th>Skidka narxi </th>
                            <th>Otgruzka tovar narxi </th>
                            <th>Kelgan pul </th>
                            <th>Qarz </th>
                            <th onclick="$('.deletemcorder').toggle();">Harakat </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                        <td>{{$order->number}}</td>
                                        <td>{{date('d.m.Y H:i',strtotime($order->order_date))}}</td>
                                        @if ($order->pharmacy != null)
                                            <td>{{$order->pharmacy->name}}</td>
                                        @else
                                            <td>{{$order->user->last_name}} {{$order->user->first_name}}</td>
                                        @endif
                                        <td>
                                            @if (isset($order->pharmacy->region))
                                                {{$order->pharmacy->region->name}}
                                            @endif
                                        </td>

                                        <td>{{$order->discount}}%</td>
                                    
                                        <td>{{number_format($order->price,0,',','.')}}</td>
                                        <td>
                                            {{number_format($order->price - $order->price*$order->discount/100,0,',','.')}}
                                        </td>
                                        <td>
                                            <span class="badge badge-success">
                                                {{-- {{number_format($order->price - $order->price*$order->discount/100,0,',','.')}}</td> --}}
                                                {{-- {{number_format($order_sum[$order->id],0,',','.')}} --}}
                                                {{number_format($order_sum[$order->id] - $order_sum[$order->id]*$order->discount/100,0,',','.')}}

                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{number_format($order_pay[$order->id],0,',','.')}}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger">
                                                @if($order_sum[$order->id] == null)
                                                0
                                                @else
                                                {{number_format($order_sum[$order->id] - $order_sum[$order->id]*$order->discount/100-$order_pay[$order->id]-$return_sum[$order->id],0,',','.')}}
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                                
                                            <a href="{{route('mc-ord-id',['order_id' => $order->id])}}">
                                                <button  class="btn btn-primary" style="padding: 0px 5px;">
                                                    <i class="fas fa-shipping-fast"></i>
                                                </button>
                                            </a>

                                            @if (Session::get('user')->id == 37)
                                                <a href="order-delete/{{$order->id}}" class="deletemcorder" style="display: none;">
                                                    <button  class="btn btn-danger" style="padding: 0px 5px;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </a>
                                            @endif
                                            
                                            
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    
    <script>
        window.addEventListener('refresh-page', event => {
           window.location.reload(false); 
        })
    </script>
</div>
