<div class="content main-wrapper ">
    <div class="row gold-box">
       
        @if ($page == 1)
        <div class="card flex-fill mt-5">
            <div class="row justify-content-between p-3">
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Buyurtma raqami
                        {{-- <span class="badge badge-primary badge-pill">14</span> --}}
                        <span>{{$orders->number}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Buyurtma xolati
                        <span>{{$orders->status}}</span>

                        {{-- <span class="badge badge-primary badge-pill">2</span> --}}
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Buyurtma vaqti
                        <span>{{$orders->date}}</span>

                        {{-- <span class="badge badge-primary badge-pill">1</span> --}}
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Skidka
                        <span>
                            <input type="text" value="{{$orders->discount}}" placeholder="{{$orders->discount}}" wire:keyup="changeDiscount($event.target.value)">
                            
                            %</span>  

                        {{-- <span class="badge badge-primary badge-pill">14</span> --}}
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Buyurtma summasi
                        <span>{{$orders->summa}}</span>

                        {{-- <span class="badge badge-primary badge-pill">2</span> --}}
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Skidka bilan
                        <span>{{$orders->discount_summa}}</span>

                        {{-- <span class="badge badge-primary badge-pill">1</span> --}}
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
                            <th>Soni</th>
                            <th>Sklad</th>
                        </tr>
                        </thead>
                        <tbody>
                            @isset($order_products)
                            @php
                                $sum_quantity = 0;
                                $sum_price = 0;
                            @endphp
                                @foreach ($order_products as $key => $pro)
                                @php
                                    $sum_quantity += $pro->quantity;
                                @endphp
                                    <tr>
                                        <td>{{$pro->medicine->name}}</td>
                                        <td><input type="text" value="{{$products[$pro->product_id]}}"  wire:keyup="changeQuantity($event.target.value, {{$pro->product_id}})"></td>

                                        <td>{{$warehouses[$pro->id]}}</td>
                                        
                                    </tr>
                                @endforeach
                            @endisset
                            <tr class="secondary">
                                <td>Jami</td>
                                <td>{{$sum_quantity}}</td>
                                <td>{{$sum_price}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else 
            <div class="card flex-fill mt-5">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th>Order number </th>
                                <th>Summa</th>
                                <th>Dsicount summa </th>
                                <th>Dsicount </th>
                                <th>Pharmacy </th>
                                <th>Status </th>
                                <th>Order date </th>
                                <th>Otgruzka </th>
                            </tr>
                            </thead>
                            <tbody>
                                @isset($orders)
                                    
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>{{$order->number}}</td>
                                        <td>{{$order->summa}}</td>
                                        <td>{{$order->discount_summa}}</td>
                                        <td>{{$order->discount}}</td>
                                        <td>{{$order->pharmacy->name}}</td>
                                        <td>{{$order->status}}</td>
                                        <td>{{$order->date}}</td>
                                        <td>
                                            <td><button wire:click="$emit('shipment',{{$order->id}})" class="btn btn-primary" style="padding: 0px 5px;"><i class="fas fa-shipping-fast"></i></button></td>
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
