<div class="content main-wrapper ">
    <div class="row gold-box">
        <div class="card flex-fill mt-5">
            <div class="row">

                @foreach ($warehouses as $item)
                    <div class="col-md-6">
                        <button class="btn @if($ware_id == $item->id) btn-primary @else btn-secondary @endif btn-block" wire:click="$emit('select_Warehouse', {{$item->id}})">{{$item->name}}</button>
                    </div>
                @endforeach

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Dori </th>
                            <th>Soni </th>
                            <th>Qo'shish </th>
                            {{-- <th>Bekor qilish </th> --}}
                        </tr>
                        </thead>
                        <tbody>
                            @isset($products)
                                
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{$product->medicine->name}}</td>
                                    <td>{{$product->quantity}}</td>
                                    <td><input type="text" value="{{$prod_count[$product->product_id]}}"  wire:keyup="addQuantity($event.target.value, {{$product->product_id}})"></td>
                                    {{-- <td>
                                        <button class="btn btn-danger" wire:click="$emit('delete', {{$product->product_id}})">-</button>
                                        <button class="btn btn-primary" wire:click="$emit('add', {{$product->product_id}})">+</button>
                                    </td> --}}

                                    {{-- <td><input type="text" value="{{$prod_count[$product['id']]}}"  wire:keyup="input($event.target.value, {{$product['id']}})"></td>
                                    <td>{{$product['price'][0]['price']}}</td>
                                    <td>
                                        @if (isset($prod_count[$product['id']]))
                                            {{$product['price'][0]['price']*$prod_count[$product['id']]}}</td>
                                        @else   
                                            {{$product['price'][0]['price']}}</td>
                                        @endif --}}
                                    {{-- <td><button wire:click="$emit('delete_prod', {{ $key }},{{$product['id']}})" class="btn btn-danger" style="padding: 0px 5px;"><i class="fas fa-window-close"></i></button></td> --}}
                                
                                </tr>
                            @endforeach
                            @endisset

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="m-3">
                @if ($ware_id > 0)
                    <button wire:click="$emit('save')" type="button" class="btn btn-block btn-primary">Saqlash</button>
                @endif
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('refresh-page', event => {
           window.location.reload(false); 
        })
      </script>
</div>
