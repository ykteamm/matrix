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
                            <th>Kelgan pul </th>
                            <th>Qarz </th>
                            <th>Harakat </th>
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
                                            <span class="badge badge-success">
                                                {{number_format($order->price - $order->price*$order->discount/100,0,',','.')}}</td>
                                            </span>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{number_format($order_pay[$order->id],0,',','.')}}</td>
                                            </span>
                                        <td>
                                            <span class="badge badge-danger">
                                                {{number_format($order->price - $order->price*$order->discount/100-$order_pay[$order->id],0,',','.')}}</td>
                                            </span>
                                        <td>
                                                
                                            <a href="order/{{$order->id}}">
                                                {{-- <button  wire:click="$emit('shipment',{{$order->id}})" class="btn btn-primary" style="padding: 0px 5px;">
                                                    <i class="fas fa-shipping-fast"></i>
                                                </button> --}}
                                                <button  class="btn btn-primary" style="padding: 0px 5px;">
                                                    <i class="fas fa-shipping-fast"></i>
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
    
    <script>
        window.addEventListener('refresh-page', event => {
           window.location.reload(false); 
        })
    </script>
</div>
