<div class="content main-wrapper ">
    <div class="row gold-box">
       
        <div class="card flex-fill mt-5">
            <div class="justify-content-between">
                <div class="mt-2">
                    <a href="{{route('orders')}}">
                        <button class="text-center btn-primary mb-1 ml-3">
                            <i class="fas fa-arrow-left"> Buyurtmalar ro'yxatiga o'tish</i>
                        </button>
                    </a>
                </div>
                {{-- <div class="mt-2">
                    <a href="{{route('orders')}}">
                        <button class="text-center btn-primary mb-1 ml-3">
                            <i class="fas fa-arrow-left"> Buyurtmalar ro'yxatiga o'tish</i>
                        </button>
                    </a>
                </div> --}}
            </div>
                
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

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Buyurtma summasi
                        <span>{{number_format($orders->price,0,',','.')}}</span>

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Skidka bilan
                        <span>{{number_format($orders->price - $orders->price*$discount/100,0,',','.')}}</span>

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
                                @if($order_datail_status != 1)

                                    @foreach ($detail_delivery_date as $item)
                                        <th>{{date('d.m.Y H:i',strtotime($item))}}</th>
                                    @endforeach

                                @endif
                            @if($orders->order_detail_status != 3)
                                <th>Otgruzka</th>

                                <th>Sklad  
                                    <select class="form-control-sm" wire:change="selectWarehouse($event.target.value)">
                                        <option selected disabled></option>
                                            @foreach ($warehouses as $ware)
                                            
                                                <option @if ($ware_id == $ware->id)
                                                    selected
                                                @endif value="{{$ware->id}}">{{$ware->name}}</option>
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
                                        <td>{{$default_orders[$pro->product_id]}}</td>
                                        
                                        @if($order_datail_status != 1)
                                            @foreach ($detail_delivery_date as $key => $item)
                                                <td>{{$detail_delivery[$key][$pro->product_id]}}</td>
                                            @endforeach
                                        @endif
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
                            {{-- <tr class="table-primary">
                                <td>Jami</td>
                                <td>{{$sum_order}}</td>
                                @if($orders->order_detail_status != 3)
                                    <td>{{$sum_quantity}}</td>

                                    <td>{{$sum_sklad}}</td>
                                @endif
                            </tr> --}}
                        </tbody>
                    </table>
                    {{-- <p>{{$saved}}</p> --}}
                </div>
            </div>
            @if ($saved != 2 && $error == 1)
                <div class="m-3">
                    <button class="btn btn-block btn-danger">Malumotlar to'liq emas <i wire:click="$emit('delete_Error')" class="fas fa-window-close"></i> </button>
                </div>
            @endif
            @if($orders->order_detail_status != 3)

                @if ($delivery_id > 0)
                    <div class="m-3">
                        <button wire:click="$emit('save')" type="button" class="btn btn-block btn-primary">Saqlash</button>
                    </div>
                @endif

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

    </div>
    
    <script>
        window.addEventListener('refresh-page', event => {
           window.location.reload(false); 
        })
      </script>
</div>
