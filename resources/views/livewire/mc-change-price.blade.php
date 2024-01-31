<div class="content main-wrapper ">
    <div class="row gold-box mt-3">

        {{-- <div style="text-align: center" class="mt-3 mb-2">
            <a href="{{route('mc-yanvar')}}">
                Yanvar narxalrni avtomat yangilash
            </a>
        </div> --}}

            <select class="form-control mt-5" wire:model="med_id" wire:change="change">
                @foreach ($medicine as $item)
                    <option value="{{$item->id}}">
                        {{$item->name}}
                    </option>
                @endforeach
            </select>

            <div class="card-body">

                <form action="{{route('mc-update-price')}}" method="POSt">
                    @csrf

                <div class="row">
                    <div class="col-md-6">
                        <input class="form-control" type="number" placeholder="Narx.." name="price">
                        <input class="form-control" type="number" name="prd" value="{{$med_id}}" style="display: none">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                            Saqlash
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    
                    <table class="table table-striped mb-0" id="dtBasicExample12333">
                        <thead>
                        <tr>
                            <th>Buyurtma raqami</th>
                            <th>Dorixona</th>
                            <th>Viloyat</th>
                            <th>Soni</th>
                            <th>Narxi</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $item)

                            <tr>
                                <td>
                                    {{$item->number}}
                                </td>
                                <td>
                                    {{$item->pharmacy->name}}
                                </td>
                                <td>
                                    {{$item->pharmacy->region->name}}
                                </td>
                                <td>
                                    {{$item->order_detail[0]->quantity}}
                                </td>
                                <td>
                                    {{$item->order_detail[0]->price}}
                                    <input type="checkbox" name="orders_id[{{$item->id}}][]">
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </form>

            </div>
    </div>
    
    <script>
        window.addEventListener('refresh-page', event => {
           window.location.reload(false); 
        })
    </script>
</div>
