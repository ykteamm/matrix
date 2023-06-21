<div class="content main-wrapper ">
    <div class="row gold-box">
        <div class="card flex-fill mt-5">
            <div class="m-3">
                <select name="" id="" class="form-control">
                    <option  selected disabled>Dori tanlang</option>
                    
                    @foreach ($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Dori </th>
                            <th>Telefon</th>
                            <th>RM </th>
                            <th>Viloyat </th>
                            <th>Tuman </th>
                            <th>Xolati </th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
