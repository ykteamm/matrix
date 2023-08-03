@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box">
            @include('admin.components.logo')

        </div>
        <div class="row headbot">
            <div class="col-sm-12">
                <div class="card mt-5">
                    <div class="row">
                        @foreach ($regions as $r)
                        <div class="col-4 col-md-12 col-lg-3 d-flex flex-wrap delregion">
                            <div class="card detail-box1">
                                <div class="card-body">
                                    <div class="dash-contetnt">
                                        <div class="justify-content-between">
                                            <h3 class="mt-2" style="color:white;height:45px;cursor:pointer;"
                                                data-toggle="modal" data-target="#addmemberwer13">{{$r->name}}</h3>
                                        </div>
                                        <div class="justify-content-between mt-3">
                                            <div class="row pl-3 pr-3">
                                                @php
                                                $all_price = 0;
                                                $pul = 0;
                                            @endphp
                                                @foreach ($orders as $ord)
                                                @if ($r->id == $ord['region_id'])

                                                     @foreach ($ord['order'] as $o)
                                                        @php
                                                        $all_price += $o['order_price'];
                                                        $pul += $o['money_arrival'];
                                                        @endphp
                                                    @endforeach



                                                @endif
                                                @endforeach
                                                <div style="background:#27a841;border-radius:8px;box-shadow: 0px 0px 7px 5px #ffffff;
                                                    cursor:pointer"
                                                    class="col-12 col-md-12 col-lg-12 mt-4 pul{{$r->id}}" onclick="ASD({{$r->id}})"
                                                    >
                                                    <div class="d-flex justify-content-between ">
                                                        <span
                                                        style="font-size:20px;color:white;"
                                                        class="mt-1"

                                                        >Jami buyurtma</span>

                                                        <span
                                                        style="font-size:20px;color:white;"
                                                        class="mt-1"

                                                        >Jami pul</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between ">
                                                        <span
                                                        style="font-size:20px;color:white;"
                                                        class="mt-1"

                                                        >{{number_format($all_price,0,',','.')}}</span>

                                                        <span
                                                        style="font-size:20px;color:white;"
                                                        class="mt-1"

                                                        >{{number_format($pul,0,',','.')}}</span>
                                                    </div>


                                                </div>

                                                @foreach ($orders as $ord)
                                                @if ($r->id == $ord['region_id'])
                                                    @php
                                                        $all_price = 0;
                                                        $pul = 0;
                                                    @endphp
                                                     @foreach ($ord['order'] as $o)
                                                        @php
                                                        $all_price += $o['order_price'];
                                                        $pul += $o['money_arrival'];
                                                        @endphp
                                                    @endforeach

                                                    @if($all_price > 0)
                                                    <div style="background:#181a49;border-radius:8px;box-shadow: 0px 0px 7px 5px #ffffff;
                                                        cursor:pointer;display: none;"
                                                        class="col-12 col-md-12 col-lg-12 mt-4 pulkelishi{{$r->id}}"
                                                        >
                                                        <div class="text-center">
                                                            <span
                                                            style="font-size:20px;color:white;"
                                                            class="mt-1"

                                                            >{{$ord['first_name']}} {{$ord['last_name']}}</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between ">
                                                            <span
                                                            style="font-size:20px;color:white;"
                                                            class="mt-1"

                                                            >{{number_format($all_price,0,',','.')}}</span>

                                                            <span
                                                            style="font-size:20px;color:white;"
                                                            class="mt-1"

                                                            >{{number_format($pul,0,',','.')}}</span>
                                                        </div>


                                                    </div>
                                                    @endif


                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin_script')
    <script>
        function ASD(id)
        {
            // $("button").click(function(){
                $(`.pulkelishi${id}`).toggle();
            // });
        }

    </script>
@endsection
