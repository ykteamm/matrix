<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
</div>
<div class="content main-wrapper ">
    <div class="row gold-box">
       
        @if ($page == 1)
        <div class="card flex-fill mt-5">
            <div class="row justify-content-between p-3">
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Buyurtma raqami
                            <span>{{$orders->number}}</span>
                        </li>

                        
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Buyurtma xolati
                        <span>{{$orders->status}}</span>

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Buyurtma vaqti
                        <span>{{date('d.m.Y',strtotime($orders->order_date))}}</span>

                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Buyurtmachi
                                @if ($orders->pharmacy != null)
                                    <span>{{$orders->pharmacy->name}}</span>
                                @else
                                    <span>{{$orders->user->last_name}} {{$orders->user->first_name}}</span>
                                @endif
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Vositachi
                                <span>{{$orders->employe->last_name}} {{$orders->employe->first_name}}</span>
                        </li>

                    </ul>
                </div>
                <div class="col-md-4">
                    <button class="text-center btn-primary mb-1 ml-3" wire:click="$emit('order_List')">Buyurtmalar ro'yxatiga o'tish</button>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Skidka
                        <span>
                            @if($this->discount == 1)
                            <input type="text" value="{{$discount}}"  wire:keyup="changeDiscount($event.target.value)">
                            @else
                            {{$discount}}
                            @endif
                            %</span>  

                        {{-- <span class="badge badge-primary badge-pill">14</span> --}}
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Buyurtma summasi
                        <span>{{number_format($orders->price,0,',','.')}}</span>

                        {{-- <span class="badge badge-primary badge-pill">2</span> --}}
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Skidka bilan
                        <span>{{number_format($orders->price - $orders->price*$discount/100,0,',','.')}}</span>

                        {{-- <span class="badge badge-primary badge-pill">1</span> --}}
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Yetkazuvchi
                            @if($orders->delivery == null)
                                <select class="form-control form-control-sm" wire:change="selectDelivery($event.target.value)">
                                    <option selected disabled></option>
                                    @foreach ($delivery as $item)
                                        <option value="{{$item->id}}">{{$item->full_name}}</option>
                                    @endforeach
                                </select>
                            @else
                                <span> {{$orders->delivery->full_name}} </span>
                            @endif

                          </li>

                    </ul>
                </div>
                
                            
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Dori</th>
                            <th>Buyurtma</th>
                            @if($orders->order_detail_status != 3)
                                <th>Otgruzka</th>

                                <th>Sklad  
                                    <select class="form-control-sm" wire:change="selectWarehouse($event.target.value)">
                                        <option selected disabled></option>
                                            @foreach ($warehouses as $ware)
                                                <option value="{{$ware->id}}">{{$ware->name}}</option>
                                            @endforeach
                                    </select>
                                </th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                            @isset($order_products)
                            @php
                                $sum_order = 0;
                                $sum_quantity = 0;
                                $sum_sklad = 0;
                            @endphp
                                @foreach ($order_products as $key => $pro)
                                @php
                                    $sum_order += $pro->quantity;
                                    $sum_quantity += $pro->quantity;
                                        if(isset($ware_products[$pro->product_id]))
                                            {
                                                $sum_sklad += $ware_products[$pro->product_id];
                                            }
                                @endphp
                                    <tr>
                                        <td>{{$pro->medicine->name}}</td>
                                        <td>{{$products[$pro->product_id]}}</td>

                                        @if($orders->order_detail_status != 3)
                                            
                                            <td><input type="text" value="{{$products[$pro->product_id]}}"  wire:keyup="changeQuantity($event.target.value,{{$pro->product_id}})"></td>


                                            @if(isset($ware_products[$pro->product_id]) > 0)
                                                <td>{{$ware_products[$pro->product_id]}}</td>
                                            @else
                                                <td>0</td>
                                            @endif
                                        
                                        @endif
                                        
                                    </tr>
                                @endforeach
                            @endisset
                            <tr class="table-primary">
                                <td>Jami</td>
                                <td>{{$sum_order}}</td>
                                @if($orders->order_detail_status != 3)
                                    <td>{{$sum_quantity}}</td>

                                    <td>{{$sum_sklad}}</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($saved == 2 && $delivery_id > 0)
                <div class="m-3">
                    <button wire:click="$emit('save')" type="button" class="btn btn-block btn-primary">Saqlash</button>
                </div>
            @endif
            @if($orders->order_detail_status != 1)

                <div class="container m-auto text-center" style="background: #a5bcd9;padding:10px 20px;">
                    <h4>Pul kelishi</h4>
                    <div class="row">
                        <div class="col-md-4">
                            
                                <select class="form-control-lg" wire:change="selectPayment($event.target.value)">
                                    <option selected disabled>To'lov shaklini tanlang</option>
                                    @foreach ($payments as $item)
                                        <option value="{{$item->id}}">{{$item->type}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control-lg" wire:change="addPayAmount($event.target.value)">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success btn-lg" wire:click="$emit('saveMoney_Coming')">Saqlash</button>
                        </div>

                    </div>
                            


                </div>

            @endif
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th>Buyurtma raqami</th>
                                <th>Buyurtma narxi</th>
                                <th>Skidka narxi </th>
                                <th>Skidka </th>
                                <th>Buyurtma beruvchi </th>
                                <th>Buyurtma vaqti </th>
                                <th>Otgruzka </th>
                            </tr>
                            </thead>
                            <tbody>
                                @isset($orders)
                                    
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>{{$order->number}}</td>
                                        <td>{{number_format($order->price,0,',','.')}}</td>
                                        <td>{{number_format($order->price - $order->price*$order->discount/100),0,',','.'}}</td>
                                        <td>{{$order->discount}}</td>
                                        @if ($order->pharmacy != null)
                                            <td>{{$order->pharmacy->name}}</td>
                                        @else
                                            <td>{{$order->user->last_name}} {{$order->user->first_name}}</td>
                                        @endif
                                        <td>{{date('d.m.Y',strtotime($order->order_date))}}</td>
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
