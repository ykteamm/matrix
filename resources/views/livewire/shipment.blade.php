<div class="content main-wrapper ">
    <div class="row gold-box">
        <div class="card flex-fill mt-5">

            <div>
                <div class="row justify-content-between p-3">
                    {{-- <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Buyurtma raqami
                              <span>P{{$code+1}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Buyurtma xolati
                              <span>Ochiq</span>

                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Buyurtma vaqti
                              <span>{{date('d.m.Y')}}</span>
                            </li>
                          </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Skidka
                              <span>

                                <input type="text" value="{{$skidka}}"  wire:model="skidka">
                                
                                 %</span>  

                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Buyurtma summasi
                              <span>{{array_sum($summa_array)}}</span>

                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Skidka bilan
                              <span>{{array_sum($summa_array)-array_sum($summa_array)*intval($skidka)/100}}</span>

                            </li>
                          </ul>
                    </div> --}}
                </div>
            </div>
            <div class="m-3">
                <select class="form-control" wire:change="selectOrder($event.target.value)">
                    <option selected disabled>Orderni tanlang</option>
                    
                    @foreach ($orders as $order)
                        <option value="{{$order->id}}">{{$order->number}}</option>
                    @endforeach
                </select>
            </div>
            {{-- <div class="card-body">
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
                                    <td>{{$product['price'][0]['price']}}</td>
                                    <td>
                                        @if (isset($prod_count[$product['id']]))
                                            {{$product['price'][0]['price']*$prod_count[$product['id']]}}</td>
                                        @else   
                                            {{$product['price'][0]['price']}}</td>
                                        @endif
                                    <td><button wire:click="$emit('delete_prod', {{ $key }},{{$product['id']}})" class="btn btn-danger" style="padding: 0px 5px;"><i class="fas fa-window-close"></i></button></td>
                                </tr>
                            @endforeach
                            @endisset

                        </tbody>
                    </table>
                </div>
            </div> --}}
            {{-- <div class="m-3">
                @if (count($order_product) > 0 && $pharmacy_id >= 1)
                    <button wire:click="$emit('save')" type="button" class="btn btn-block btn-primary">Saqlash</button>
                @endif
            </div> --}}
        </div>
    </div>
    <script>
        window.addEventListener('refresh-page', event => {
           window.location.reload(false); 
        })
      </script>
</div>
