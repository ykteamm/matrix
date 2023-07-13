<div class="content main-wrapper ">
    <div class="row gold-box">
       
        @if ($active_view == 2)
        <div class="card flex-fill mt-5">
            <div class="row">

                @foreach ($status_array as $key => $item)
                    <div class="col-md-2 mb-1">
                        <button class="btn btn-block 
                        @if($key == $active_status)
                        btn-primary
                        @else
                        btn-secondary
                        @endif
                        " wire:click="$emit('change_Status', {{$key}})">{{$item}}</button>
                    </div>
                @endforeach

            </div>


            <div class="row">
                @foreach ($view_array as $key => $item)
                    <div class="col-md-2 mb-1">
                        <button class="btn btn-block 
                        @if($key == $active_view)
                        btn-primary
                        @else
                        btn-secondary
                        @endif
                        " wire:click="$emit('change_View', {{$key}})">
                            <i class="fa fa-{{$item}}" aria-hidden="true"></i>
                        </button>
                    </div>
                @endforeach
            </div>

            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Dori</th>
                            @isset($orders)
                                

                                    @foreach ($orders as $key => $order)
                                <th>

                                        @if ($order->pharmacy != null)
                                            {{$order->pharmacy->name}}
                                        @else
                                            {{$order->user->last_name}} {{$order->user->first_name}}
                                        @endif
                                        <a href="order/{{$order->id}}">
                                            <button  class="btn btn-primary" style="padding: 0px 5px;">
                                                <i class="fas fa-shipping-fast"></i>
                                            </button>
                                        </a>
                                </th>

                                    @endforeach
                                    

                                
                            @endisset
                            {{-- <th>Buyurtma raqami</th> --}}
                            {{-- <th>Buyurtma narxi</th>
                            <th>Skidka narxi </th>
                            <th>Skidka </th>
                            <th>Buyurtma beruvchi </th>
                            <th>Buyurtma vaqti </th>
                            <th>Otgruzka </th> --}}
                            {{-- @foreach ($medicine as $item)
                                <th>{{$item->name}} </th>
                            @endforeach --}}
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicine as $item)
                                <tr>
                                    <td>{{$item->name}} </td>
                                    @foreach ($orders as $key => $order)
                                        <td>
                                            @if(isset($order_products[$order->id][$item->id]))
                                            <span class="badge badge-primary"> {{$order_products[$order->id][$item->id]}} </span>
                                                @if ($order_debt[$order->id][$item->id] != 0)
                                                    <span class="badge badge-danger"> {{$order_debt[$order->id][$item->id]}} </span>
                                                @endif
                                            @else
                                            0
                                            @endif
                                        </td>
                                        
                                    @endforeach
                                    
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else 
            <div class="card flex-fill mt-5">
                <div class="row">

                    @foreach ($status_array as $key => $item)
                        <div class="col-md-2 mb-1">
                            <button class="btn btn-block 
                            @if($key == $active_status)
                            btn-primary
                            @else
                            btn-secondary
                            @endif
                            " wire:click="$emit('change_Status', {{$key}})">{{$item}}</button>
                        </div>
                    @endforeach
    
                </div>


                <div class="row">
                    @foreach ($view_array as $key => $item)
                        <div class="col-md-2 mb-1">
                            <button class="btn btn-block 
                            @if($key == $active_view)
                            btn-primary
                            @else
                            btn-secondary
                            @endif
                            " wire:click="$emit('change_View', {{$key}})">
                                <i class="fa fa-{{$item}}" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endforeach
                </div>

                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th>Buyurtma raqami</th>
                                <th>Buyurtma narxi</th>
                                <th>Skidka narxi </th>
                                <th>Skidka </th>
                                <th>Kelgan pul </th>
                                <th>Buyurtma beruvchi </th>
                                <th>Buyurtma vaqti </th>
                                <th>Buyurtma Statusi </th>
                                <th>Otgruzka </th>
                            </tr>
                            </thead>
                            <tbody>
                                @isset($orders)
                                    
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>{{$order->number}}</td>
                                        <td>{{number_format($order->price,0,',','.')}}</td>
                                        <td>{{number_format($order->price - $order->price*$order->discount/100,0,',','.')}}</td>
                                        <td>{{$order->discount}}%</td>
                                        <td>{{number_format($order_sum[$order->id],0,',','.')}}</td>
                                        @if ($order->pharmacy != null)
                                            <td>{{$order->pharmacy->name}}</td>
                                        @else
                                            <td>{{$order->user->last_name}} {{$order->user->first_name}}</td>
                                        @endif
                                        <td>{{date('d.m.Y H:i',strtotime($order->order_date))}}</td>
                                        <td>{{$status_array[$order->order_detail_status]}}</td>
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
                                @endisset

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

                
            
        
    </div>
    
    <script>
        window.addEventListener('refresh-page', event => {
           window.location.reload(false); 
        })
      </script>
</div>
