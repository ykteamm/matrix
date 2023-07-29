<div class="content main-wrapper ">
    <div class="row gold-box">
       
        <div class="card flex-fill mt-5">
            <div class="row justify-content-between pr-3">
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="d-flex justify-content-between align-items-center">
                            <span>
                                <a href="{{route('orders')}}">
                                    <button class="text-center btn-primary mb-1 ml-3">
                                        <i class="fas fa-arrow-left"> Buyurtmalar ro'yxatiga o'tish</i>
                                    </button>
                                </a>
                            </span>
                            <span></span>
                        </li>
                    </ul>
                </div>
                @if ($orders->payment_status != 2)
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="d-flex justify-content-between align-items-center">
                            <span></span>
                            <span>
                                <button class="text-center btn-primary mb-1 ml-3" wire:click="moneyView">
                                    Pul kelishi <i class="fas fa-hand-holding-usd"></i>
                                </button>
                            </span>
                            </li>
                        </ul>
                    </div>
                @endif
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
                        <span>{{$status_array[$order_datail_status]}}</span>

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Buyurtma vaqti
                        <span>{{date('d.m.Y H:i',strtotime($orders->order_date))}}</span>

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
                @if ($orders->price == null)

                <div class="col-md-4">
                    
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Skidka
                        <span>
                            <input type="text" value="{{$discount}}"  wire:keyup="changeDiscount($event.target.value)">
                            %</span>  

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Buyurtma summasi
                        <span>{{number_format(array_sum($summa_array),0,',','.')}}</span>

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Skidka bilan
                        <span>{{number_format(array_sum($summa_array)-array_sum($summa_array)*intval($skidka)/100,0,',','.')}}</span>

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
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Kelgan pul

                                <span>{{number_format($payment_sum,0,',','.')}}</span>
    
                            </li>
                    </ul>
                </div>
                @else
                <div class="col-md-4">
                    
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Skidka
                        <span>
                            @if ($orders->payment_status != 2)
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
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Kelgan pul

                                <span>{{number_format($payment_sum,0,',','.')}} (qarz {{$order_sum  - $order_sum*$discount/100-$payment_sum}})</span>
    
                            </li>
                    </ul>
                </div>
                @endif
                @if ($money_view == 2)
                    <div class="col-md-4">
                        
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                To'lov shaklini tanlang
                            <span>
                                <select class="form-control-sm" wire:change="selectPayment($event.target.value)">
                                    <option selected disabled></option>
                                    @foreach ($payments as $item)
                                        <option value="{{$item->id}}">{{$item->type}}</option>
                                    @endforeach
                                </select>
                            </span>  
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                            To'lov summasi
                            <span>
                                <input type="text" class="form-control-sm" wire:change="addPayAmount($event.target.value)">
                            </span>

                            </li>

                            <li class="list-group-item   text-center justify-content-between align-items-center">
                                <button class="btn btn-success btn-sm mcorderpaysave" wire:click="$emit('saveMoney_Coming')">Saqlash</button>
                                <button class="btn btn-success btn-sm mcorderpaysavenone d-none">Biroz kuting..</button>

                            </li>
                            <script>
                                document.querySelector('.mcorderpaysave').addEventListener('click', () => {
                                    document.querySelector('.mcorderpaysave').classList.add('d-none');
                                    document.querySelector('.mcorderpaysavenone').classList.remove('d-none');
                                }); 
                            </script>
                        </ul>
                    </div>
                @endif

                
                            
            </div>
            @if ($orders->price == null)

                <div class="m-3">
                    <input type="text" class="form-control" placeholder="Dorini qidiring" wire:keyup="findMedicine($event.target.value)">
                    <ul class="list-group">
                        @isset($medicines)
                            @foreach ($medicines as $pu)
                            <li class="list-group-item" wire:click="addProd({{$pu->id}})">
                                {{$pu->name}}
                                </li>
                            @endforeach
                        @endisset
                        
                    </ul>
                </div>
                
            @endif

            @if (count($order_product) > 0)
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th>Dori </th>
                                <th>Soni</th>
                                <th>Narxi </th>
                                <th>Summa </th>
                                <th>Bekor qilish </th>
                            </tr>
                            </thead>
                            <tbody>
                                @isset($order_product)
                                    
                                @foreach ($order_product as $key => $product)
                                    <tr>
                                        <td>{{$product['name']}}</td>
                                        <td><input type="text" value="{{$prod_count[$product['id']]}}"  wire:keyup="input($event.target.value, {{$product['id']}})"></td>
                                        <td>{{number_format($product['price'][0]['price'],0,',','.')}}</td>
                                        <td>
                                            @if (isset($prod_count[$product['id']]))
                                                {{number_format($product['price'][0]['price']*$prod_count[$product['id']],0,',','.')}}</td>
                                            @else   
                                                {{number_format($product['price'][0]['price'],0,',','.')}}</td>
                                            @endif
                                        <td><button wire:click="$emit('delete_prod', {{ $key }},{{$product['id']}})" class="btn btn-danger" style="padding: 0px 5px;"><i class="fas fa-window-close"></i></button></td>
                                    </tr>
                                @endforeach
                                @endisset

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="m-3">
                        <button wire:click="$emit('saveOrder_Detail')" 
                        type="button" class="btn btn-block btn-primary mcordersave">Saqlash</button>
                        <button wire:click="$emit('save')" type="button" class="btn btn-block btn-primary mcordersavenonne d-none">Biroz kuting</button>
                </div>
                <script>
                    document.querySelector('.mcordersave').addEventListener('click', () => {
                        document.querySelector('.mcordersave').classList.add('d-none');
                        document.querySelector('.mcordersavenonne').classList.remove('d-none');
                    }); 
                </script>
            @endif

            @if ($orders->price != null)

            <div class="card-body p-1 mb-2" style="border: 2px solid #6180b9;border-radius: 8px;">

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
                        </tbody>
                    </table>
                </div>


                @if ($saved != 2 && $error == 1)
                <div class="m-3">
                    <button class="btn btn-block btn-danger">Malumotlar to'liq emas <i wire:click="$emit('delete_Error')" class="fas fa-window-close"></i> </button>
                </div>
                @endif
            @endif

            @if($orders->order_detail_status != 3)

                @if ($delivery_id > 0)
                    <div class="m-3">
                        <button wire:click="$emit('save')" type="button" class="btn btn-block btn-primary mcorderdelsave">Saqlash</button>
                        <button type="button" class="btn btn-block btn-primary mcorderdelsavenone d-none">Biroz kuting...</button>
                    </div>

                    <script>
                        document.querySelector('.mcorderdelsave').addEventListener('click', () => {
                            document.querySelector('.mcorderdelsave').classList.add('d-none');
                            document.querySelector('.mcorderdelsavenone').classList.remove('d-none');
                        }); 
                    </script>
                @endif

            @endif
            </div>
            
            
            @if(count($payment_history) > 0)
                <div class="card-body p-1" style="border: 2px solid #6180b9;border-radius: 8px;">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th>Tolov turi</th>
                                @foreach ($payment_date as $item)
                                    <th>{{date('d.m.Y H:i',strtotime($item))}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                                    @foreach ($payments as $item)
                                        <tr>
                                            <td>{{$item->type}}</td>

                                            @foreach ($payment_history as $key => $item2)
                                                    @if (isset($payment_history[$key][$item->id]))
                                                        <td>
                                                            {{number_format($payment_history[$key][$item->id],0,',','.')}}
                                                        </td>
                                                    @else
                                                        <td>-</td>
                                                    @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
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