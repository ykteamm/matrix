<div class="content main-wrapper ">
    <div class="row gold-box">
        <div class="card flex-fill mt-5">
            {{-- @if($pharmacy_or_user_id) --}}
            <div class="row justify-content-between pr-3">
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="d-flex justify-content-between align-items-center">
                            <span>
                            </span>
                            <span></span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="d-flex justify-content-between align-items-center">
                        <span></span>
                        <span>
                            <button class="text-center btn-primary mb-1 ml-3" wire:click="predoplataF">
                                Predoplata <i class="fas fa-hand-holding-usd"></i>
                            </button>
                        </span>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- @endif --}}
            <div>
                <div class="row justify-content-between p-3">
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Buyurtma raqami
                              <span>P{{$code+1}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Buyurtma vaqti
                                <span>{{date('d.m.Y H:i')}}</span>
                              </li>
                            
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Viloyat
                                <select class="form-control form-control-sm" wire:change="selectRegion($event.target.value)">
                                    <option selected disabled></option>
                                    @foreach ($regions as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </li> 

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Buyurtmachi
                                <select class="form-control form-control-sm" wire:change="selectType($event.target.value)">
                                    <option selected disabled></option>
                                        <option value="1">Dorixona</option>
                                        <option value="2">Elchi (tashqi)</option>
                                </select>
                            </li> 
                          </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Skidka
                              <span>{{$skidka}}     %</span>  
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Buyurtma summasi
                              <span>{{number_format(array_sum($summa_array),0,',','.')}}</span>
                            </li>
                            
                              
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              Skidka bilan
                              <span>{{number_format(array_sum($summa_array)-array_sum($summa_array)*intval($skidka)/100,0,',','.')}}</span>
                            </li>
                          </ul>
                    </div>
                    {{-- @if ($predoplata == 2) --}}
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

                            {{-- <li class="list-group-item   text-center justify-content-between align-items-center">
                                <button class="btn btn-success btn-sm mcorderpaysave" wire:click="$emit('saveMoney_Coming')">Saqlash</button>
                                <button class="btn btn-success btn-sm mcorderpaysavenone d-none">Biroz kuting..</button>

                            </li>
                            <script>
                                document.querySelector('.mcorderpaysave').addEventListener('click', () => {
                                    document.querySelector('.mcorderpaysave').classList.add('d-none');
                                    document.querySelector('.mcorderpaysavenone').classList.remove('d-none');
                                }); 
                            </script> --}}
                        </ul>
                    </div>
                {{-- @endif --}}
                </div>
            </div>
            @if ($outer == 1)
                <div class="m-3">
                    <input type="text" class="form-control" 
                    @if (isset($pharmacy_selected))
                        value="{{$pharmacy_selected->name}}"
                    @endif
                    placeholder="Dorixona nomini yozing" wire:keyup="findPharmacy($event.target.value)">
                        <ul class="list-group">
                            @isset($pharmacy_or_user)
                                @foreach ($pharmacy_or_user as $pu)
                                <li class="list-group-item" wire:click="selectPharmacyOrUser({{$pu->id}})">
                                    {{$pu->name}} <span style="color:cornflowerblue">({{$pu->region->name}})
                                    </li>
                                @endforeach
                                @foreach ($pharmacy_pro as $pu)
                                <li class="list-group-item" wire:click="selectPharmacyOrUser({{$pu->id}})" style="color:rgb(5, 90, 248)">
                                    {{$pu->name}} <span style="color:cornflowerblue">({{$pu->region->name}})
                                    </li>
                                @endforeach
                                @foreach ($pharmacy_no as $pu)
                                <li class="list-group-item" wire:click="selectPharmacyOrUser({{$pu->id}})" style="color:rgb(236, 76, 13)">
                                    {{$pu->name}} <span style="color:cornflowerblue">({{$pu->region->name}})
                                    </li>
                                @endforeach
                            @endisset
                            
                        </ul>
                </div>
            @endif
            @if ($outer == 2)
                <div class="m-3">
                    
                    <select class="form-control" wire:change="selectPharmacyOrUser($event.target.value)">
                        <option selected disabled>Elchi tanlang</option>
                        
                        @foreach ($pharmacy_or_user as $pu)
                            <option value="{{$pu->id}}">{{$pu->last_name}} {{$pu->first_name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            
            @if ($pharmacy_or_user_id > 1)

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
                    {{-- <div>
                        @foreach ($shablons as $item)
                            <p>{{$item->name}}</p>
                        @endforeach
                    </div> --}}
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
                        <button wire:click="$emit('save')" 
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

            
        </div>
    </div>
    <script>
        window.addEventListener('refresh-page', event => {
           window.location.reload(false); 
        })
      </script>
</div>
