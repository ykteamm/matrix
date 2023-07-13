<div class="content main-wrapper ">
    <div class="row gold-box">
        <div class="card flex-fill mt-5">
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
                </div>
            </div>
            @if ($outer == 1)
                <div class="m-3">
                    <select class="form-control" wire:change="selectPharmacyOrUser($event.target.value)">
                        <option selected disabled>Dorixona tanlang</option>
                        
                        @foreach ($pharmacy_or_user as $pu)
                            <option value="{{$pu->id}}">{{$pu->name}} <span style="color:cornflowerblue">({{$pu->region->name}})</span></option>
                        @endforeach

                        @foreach ($pharmacy_pro as $pu)
                            <option value="{{$pu->id}}" style="color: blue">{{$pu->name}} ({{$pu->region->name}})</option>
                        @endforeach

                        @foreach ($pharmacy_no as $pu)
                            <option value="{{$pu->id}}" style="color: rgb(238, 39, 12)">{{$pu->name}} ({{$pu->region->name}})</option>
                        @endforeach
                    </select>
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
                    <select class="form-control" wire:change="addProd($event.target.value)">
                        {{-- <select class="form-control dorit" id="users-dropdown"> --}}
                        <option selected disabled></option>
                        
                        @foreach ($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                <script>
                        $('#users-dropdown').select2();

                    $(document).ready(function () {
                        $('#users-dropdown').select2();
                        $('#users-dropdown').on('change', function (e) {
                            var data = $('#users-dropdown').select2("val");
                            livewire.emit('addProd', data)
                        });
                    });
                </script> --}}
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
