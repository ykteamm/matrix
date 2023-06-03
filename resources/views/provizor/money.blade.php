@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box">
            @include('admin.components.logo')

            <div class="content container-fluid headbot">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('pro-money.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        @if (Session::has('msg_pro'))
                                            <h4>{{Session::get('msg_pro')}}</h4>
                                        @endif
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-3">
                                            <select class="form-control form-control-sm" name='provizor_id' required>
                                            <option value="" disabled selected hidden></option>
                                                @foreach ($provizors as $provizor)
                                                    <option value='{{$provizor['id']}}'>{{$provizor['last_name']}} {{$provizor['first_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="number" class="form-control form-control-sm" name="money" required placeholder="Pul miqdori">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="date" class="form-control form-control-sm" name="date" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                                <button type="submit" class="btn btn-primary"> Saqlash </button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            @foreach ($moneys as $elchi)


                            <div class="card-body">
                                   <div class="table-responsive">
                                      <table class="table mb-0 example1">
                                         <thead>
                                            <tr>
                                               <th>FIO</th>
                                               <th>Viloyat</th>
                                               <th>Dorixona</th>
                                               <th>Buyurtma summasi</th>
                                               <th>Pul kelishi</th>
                                               @foreach ($elchi['user']['history_money'] as $h)
                                                  <th>{{date('d.m.Y',strtotime($h['add_date']))}}</th>
                                               @endforeach
                                               <th>Qarz</th>

                                            </tr>
                                         </thead>
                                         <tbody>
                                               <tr>
                                                  <td>{{$elchi['user']['last_name']}} {{$elchi['user']['first_name']}}</td>
                                                  <td>{{getRegionByid($elchi['user']['region_id'])}}</td>
                                                  <td>{{getPharmacy($elchi['user']['pharmacy'][0]['pharmacy_id'])}}</td>
                                                  <td>
                                                    <span class="badge badge-primary">{{number_format($elchi['order_price'],0,',',' ')}}</span>
                                                    </td>
                                                  <td>
                                                     @if($elchi['money_arrival'] == null)
                                                         0
                                                     @else
                                                    <span class="badge badge-success">{{number_format($elchi['money_arrival'],0,',',' ')}}</span>


                                                     @endif
                                                  </td>
                                                    @foreach ($elchi['user']['history_money'] as $h)
                                                        <td>
                                                        <span class="badge badge-info">{{number_format($h['money'],0,',',' ')}}</span>

                                                        </td>
                                                    @endforeach



                                                    <td>

                                                        <span class="badge badge-danger">{{number_format($elchi['order_price']-$elchi['money_arrival'],0,',',' ')}}</span>

                                                    </td>
                                                  {{-- <td>{{date('d.m.Y',strtotime($elchi['created_at']))}}</td> --}}
                                               </tr>
                                         </tbody>
                                      </table>
                                   </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('admin_script')
    <script>
    </script>
@endsection
