<div class="content main-wrapper ">
    <div class="row gold-box">
        <div class="card flex-fill mt-5">
            <div>
                <div class="row justify-content-between p-3">
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Buyurtma raqami
                              {{-- <span class="badge badge-primary badge-pill">14</span> --}}
                              <span>P000001</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Buyurtma xolati
                              <span>Ochiq</span>

                              {{-- <span class="badge badge-primary badge-pill">2</span> --}}
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Buyurtma vaqti
                              <span>{{date('d.m.Y')}}</span>

                              {{-- <span class="badge badge-primary badge-pill">1</span> --}}
                            </li>
                          </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Skidka
                              <span>10%</span>  

                              {{-- <span class="badge badge-primary badge-pill">14</span> --}}
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Buyurtma summasi
                              <span>23 345 555</span>

                              {{-- <span class="badge badge-primary badge-pill">2</span> --}}
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Skidka bilan
                              <span>22 345 555</span>

                              {{-- <span class="badge badge-primary badge-pill">1</span> --}}
                            </li>
                          </ul>
                    </div>
                </div>
            </div>
            <div class="m-3">
                <select class="form-control" wire:change="addProd($event.target.value)">
                    <option selected disabled>Dori tanlang</option>
                    
                    @foreach ($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <p><?php 
                        // echo '<pre>';
                        // print_r($order_product);
                        // echo '</pre>';

                        ?></p>
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
                                    <td><input type="number" value="1" wire:keyup="input($event.target.value, {{$product['id']}})"></td>
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
            </div>
            <div class="m-3">
                <button class="btn btn-block btn-success">Saqlash</button>
                
            </div>
        </div>
    </div>
</div>
