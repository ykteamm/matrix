<div class="col-12 col-md-6 col-lg-3 flex-wrap">
    <div class="card detail-box1">
        <div class="card-body">
            <div class="dash-contetnt">
                @if ($index == 2)
                        @foreach ($region as $key => $item)
                        @if ($item['id'] == Session::get('user')->region_id)
                        <div class="d-flex justify-content-between">
                            {{-- <h4 class="text-light">{{ $item['allprice']; }}</h4> --}}
                            <h4 class="text-light"> {{number_format($item['allprice'],0,'','.')}}</h4>
                            <button type="button" class="btn btn-rounded btn-danger" wire:click="increment({{$index}})">{{ $factor[$index] }}</button>
                        </div>
                        <div class="text-center">
                            <h1 class="text-white" wire:poll.5s="test()">#{{count($region)-$key}}</h1>
                        </div>
                    
                        <div class="text-center mb-3">
                            <h4 class="text-white">
                                {{$item['name']}}
                            </h4>
                        </div>
                        @endif
                    @endforeach
                    <div style="display:none;" class="region-hide mb-3">
                                <table style="width: 100%;text-align:center;color:white;">
                                    <tbody>
                                    @foreach ($region as $key => $item)
                                                        
                                    @if ($key + 1 <= 5)

                                        <tr style="border-bottom: 1px solid white;" class="mb-4">
                                        <td>#{{$key + 1}} </td>
                                        <td style="padding:0px 2px;">{{$region[count($region)-$key-1]['name']}} </td>
                                        <td>{{number_format($region[count($region)-$key-1]['allprice'],0,'','.')}}</td>
                                        </tr>
                                    @endif
                                    @endforeach

                                    </tbody>
                                </table>
                    </div>
                @else
                @foreach ($region as $key => $item)
                @if ($item->id == Session::get('user')->region_id)
                <div class="d-flex justify-content-between">
                    <h4 class="text-light"> {{number_format($item->allprice,0,'','.')}}</h4>
                    <button type="button" class="btn btn-rounded btn-danger" wire:click="increment({{$index}})">{{ $factor[$index] }}</button>
                </div>
                <div class="text-center">
                    <h1 class="text-white" wire:poll.5s="test()">#{{$key+1}}</h1>
                </div>
            
                <div class="text-center mb-3">
                    <h4 class="text-white">
                        {{$item->name}}
                    </h4>
                </div>
                @endif
            @endforeach
        <div style="display:none;" class="region-hide mb-3">
                    <table style="width: 100%;text-align:center;color:white;">
                        <tbody>
                        @foreach ($region as $key => $item)
                                    {{-- h2         --}}
                        @if ($key < 5)

                            <tr style="border-bottom: 1px solid white;" class="mb-4">
                            <td>#{{$key+1}} </td>
                            <td style="padding:0px 2px;">{{$item->name}} </td>
                            <td>{{number_format($item->allprice,0,'','.')}}</td>
                            </tr>
                        @endif
                        @endforeach

                        </tbody>
                    </table>
        </div>
                @endif
                    
                <div class="d-flex justify-content-between">
                    <button onclick="arrowDown('region')" style="padding: 0px 6px;" type="button" class="btn btn-outline-danger arrow-down-region"><i class="fas fa-arrow-down" aria-hidden="true"></i> </button>
                    <button onclick="arrowUp('region')" style="padding: 0px 6px;display:none;" type="button" class="btn btn-outline-danger arrow-up-region"><i class="fas fa-arrow-up" aria-hidden="true"></i> </button>
                    <a href="{{route('rm-region',['region' => 'all','time' => 'last','action' => $index])}}" style="padding: 0px 6px;display:none;" type="buttont" class="btn btn-outline-danger arrow-up-region"><i class="fas fa-eye" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</div> 