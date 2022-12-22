@extends('admin.layouts.app')
@section('admin_content')
@isset(Session::get('per')['dash'])
    @if(Session::get('per')['dash'] == 'true')
    <div class="content mt-1 main-wrapper ">
        <div class="row gold-box">
        @include('admin.components.logo')
        </div>
        <div class="main-wrapper headbot">
            <div class="content">
                <div class="col-xl-12 mt-3">
                    <h1 style="margin-top:100px;">                  
                        Hush kelibsiz!  <span style="font-weight:bold;color:rgb(8, 175, 28)">{{Session::get('user')->last_name}} {{Session::get('user')->first_name}}</span>
                    </h1>
                </div>
            </div>
            <div class="card" style="background-color: rgb(98, 161, 233);padding: 0px 40px;">
                <div class="col-xl-12 mt-3">
                    <h3>      
                        <span>
                            Kechagi kungi hisobot
                        </span>
                    </h3>
                </div>
                <div class="row">
                    <livewire:countert />
                    <div class="col-12 col-md-6 col-lg-3 flex-wrap">
                        <div class="card detail-box1">
                            <div class="card-body">
                                @if(count($users) > 0)
                                <div class="dash-contetnt">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="text-light">#1</h4>
                                        </div>
                                        <div class="text-center">
                                            <h1 class="text-white">{{number_format($users[0]->allprice,0,'','.')}}</h1>
                                        </div>
                                    
                                        <div class="text-center mb-3">
                                            <h4 class="text-white">
                                                {{$users[0]->last_name}} {{$users[0]->first_name}}
                                            </h4>
                                        </div>
                                    <div style="display:none;" class="user-hide mb-3">
                                        <table style="width: 100%;text-align:center;color:white;">
                                            <tbody>
                                                @foreach ($users as $key => $item)
                                                                    
                                                @if ($key < 5)

                                                    <tr style="border-bottom: 1px solid white;" class="mb-4">
                                                    <td>#{{$key+1}}</td>
                                                    <td style="padding:0px 2px;">{{$item->last_name}} {{$item->first_name}}</td>
                                                    <td>{{number_format($item->allprice,0,'','.')}}</td>
                                                    </tr>
                                                @endif
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button onclick="arrowDown('user')" style="padding: 0px 6px;" type="button" class="btn btn-outline-danger arrow-down-user"><i class="fas fa-arrow-down" aria-hidden="true"></i> </button>
                                        <button onclick="arrowUp('user')" style="padding: 0px 6px;display:none;" type="button" class="btn btn-outline-danger arrow-up-user"><i class="fas fa-arrow-up" aria-hidden="true"></i> </button>
                                        <a href="{{route('rm-user',['region' => 'all','time' => 'last'])}}" style="padding: 0px 6px;display:none;" type="button" class="btn btn-outline-danger arrow-up-user"><i class="fas fa-eye" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                @else
                                <span style="text-align: center;color:white">No data</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 flex-wrap">
                        <div class="card detail-box1">
                            <div class="card-body">
                                @if(count($pharmacy) > 0)
                                <div class="dash-contetnt">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="text-light">#1</h4>
                                        </div>
                                        <div class="text-center">
                                            <h1 class="text-white">{{number_format($pharmacy[0]->allprice,0,'','.')}}</h1>
                                        </div>
                                    
                                        <div class="text-center mb-3">
                                            <h4 class="text-white">
                                                {{$pharmacy[0]->name}}
                                            </h4>
                                        </div>
                                    <div style="display:none;" class="pharmacy-hide mb-3">
                                                <table style="width: 100%;text-align:center;color:white;">
                                                    <tbody>
                                                        @foreach ($pharmacy as $key => $item)
                                                                            
                                                        @if ($key < 5)

                                                            <tr style="border-bottom: 1px solid white;" class="mb-4">
                                                            <td>#{{$key+1}}</td>
                                                            <td style="padding:0px 2px;">{{$item->name}}</td>
                                                            <td>{{number_format($item->allprice,0,'','.')}}</td>
                                                            </tr>
                                                        @endif
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button onclick="arrowDown('pharmacy')" style="padding: 0px 6px;" type="button" class="btn btn-outline-danger arrow-down-pharmacy"><i class="fas fa-arrow-down" aria-hidden="true"></i> </button>
                                        <button onclick="arrowUp('pharmacy')" style="padding: 0px 6px;display:none;" type="button" class="btn btn-outline-danger arrow-up-pharmacy"><i class="fas fa-arrow-up" aria-hidden="true"></i> </button>
                                        <a href="{{route('rm-pharmacy',['region' => 'all','time' => 'last'])}}" style="padding: 0px 6px;display:none;" type="button" class="btn btn-outline-danger arrow-up-pharmacy"><i class="fas fa-eye" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                @else
                                <span style="text-align: center;color:white">No data</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 flex-wrap">
                        <div class="card detail-box1">
                            <div class="card-body">
                                @if(count($pharmacy) > 0)
                                <div class="dash-contetnt">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="text-light">#1</h4>
                                        </div>
                                        <div class="text-center">
                                            <h1 class="text-white">{{number_format($medicine[0]->allprice,0,'','.')}}</h1>
                                        </div>
                                    
                                        <div class="text-center mb-3">
                                            <h4 class="text-white">
                                                {{$medicine[0]->name}}
                                            </h4>
                                        </div>
                                    <div style="display:none;" class="medicine-hide mb-3">
                                                <table style="width: 100%;text-align:center;color:white;">
                                                    <tbody>
                                                        @foreach ($medicine as $key => $item)
                                                                            
                                                        @if ($key < 5)

                                                            <tr style="border-bottom: 1px solid white;" class="mb-4">
                                                            <td>#{{$key+1}}</td>
                                                            <td style="padding:0px 2px;">{{$item->name}}</td>
                                                            <td>{{number_format($item->allprice,0,'','.')}}</td>
                                                            </tr>
                                                        @endif
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button onclick="arrowDown('medicine')" style="padding: 0px 6px;" type="button" class="btn btn-outline-danger arrow-down-medicine"><i class="fas fa-arrow-down" aria-hidden="true"></i> </button>
                                        <button onclick="arrowUp('medicine')" style="padding: 0px 6px;display:none;" type="button" class="btn btn-outline-danger arrow-up-medicine"><i class="fas fa-arrow-up" aria-hidden="true"></i> </button>
                                        <a href="{{route('rm-medicine',['region' => 'all','time' => 'last'])}}" style="padding: 0px 6px;display:none;" type="button" class="btn btn-outline-danger arrow-up-medicine"><i class="fas fa-eye" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                @else
                                <span style="text-align: center;color:white">No data</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" style="background-color: rgb(233, 98, 98);padding: 0px 40px;">

            <div class="content">
                <div class="col-xl-12 mt-3">
                    <h3>      
                        <span>
                            Bugungi kun hozirgacha hisobot
                        </span>
                    </h3>
                </div>
                
            </div>
            <div class="row">
                <livewire:counter />
                <livewire:liveuser />
                <livewire:livepharmacy />
                <livewire:livemedicine />
            </div>
            </div>
    </div>
    </div>
    @endif
@endisset
@endsection
@section('admin_script')
    <script>
        function arrowDown($t)
        {
            $(`.${$t}-hide`).css('display','');
            $(`.arrow-up-${$t}`).css('display','');
            $(`.arrow-down-${$t}`).css('display','none');
        }
        function arrowUp($t)
        {
            $(`.${$t}-hide`).css('display','none');
            $(`.arrow-up-${$t}`).css('display','none');
            $(`.arrow-down-${$t}`).css('display','');
        }
    </script>
@endsection
