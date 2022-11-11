@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-header">
                    <h4 class="card-title row d-flex justify-content-between"> <span>{{$pharm->name}} {{$pharm->region}}</span>  </h4>
                </div>
                <div class="card-body">
                    <div class="row d-flex justify-content-between">

                        <div class="col-md-1 ">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header no-border">
                                    <h5 class="card-title">Dorilar ro'yhati </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <thead>
                                            <tr>
                                                <th>No </th>
                                                <th>Dori nomi </th>
                                                <th>Soni </th>
                                                <th>Qoldiq </th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pharmacy as $med)
                                                @if($med->pharmacy_id==$pharmacy_id)

                                                    <tr>
                                                        <td>{{$loop->index+1}} </td>
                                                        <td>{{$med->name}} </td>
                                                        <td>{{$med->amount}}</td>
                                                        @php $i=0;@endphp
                                                        @foreach($stocks as $stock)
                                                            @if($stock->medicine_id==$med->medicine_id)
                                                                @php $i++;@endphp
                                                                <td>{{$stock->number}}</td>
                                                            @endif
                                                        @endforeach
                                                        @if($i==0)
                                                            <td>Stock olinmagan</td>
                                                        @endif
                                                    </tr>

                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function yashir(){
            let a=document.querySelectorAll('.yashir');
            a.forEach(e=>{
                if(e.style.display=='none') {
                    e.style.display = ''
                }else{
                    e.style.display='none';
                }
            })

        }
    </script>
@endsection

