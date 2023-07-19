<div class="content main-wrapper ">
    <div class="row gold-box">
       
        <div class="card flex-fill mt-5">
       
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Buyurtma raqami</th>
                            <th>Buyurtma beruvchi</th>
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
                                        @if ($order->pharmacy != null)
                                            <td>{{$order->pharmacy->name}}</td>
                                        @else
                                            <td>{{$order->user->last_name}} {{$order->user->first_name}}</td>
                                        @endif
                                        <td>{{$order->discount}}%</td>
                                    
                                        <td>{{number_format($order->price,0,',','.')}}</td>
                                        <td>
                                            {{number_format($order->price - $order->price*$order->discount/100,0,',','.')}}
                                        </td>
                                        <td>
                                            <span class="badge badge-success">
                                                {{-- {{number_format($order->price - $order->price*$order->discount/100,0,',','.')}}</td> --}}
                                                {{number_format($order_sum[$order->id],0,',','.')}}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{number_format($order_pay[$order->id],0,',','.')}}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger">
                                                {{number_format($order_sum[$order->id] - $order_sum[$order->id]*$order->discount/100-$order_pay[$order->id],0,',','.')}}
                                            </span>
                                        </td>
                                        <td>
                                                
                                            <a href="order/{{$order->id}}">
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
