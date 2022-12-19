<div>
    Current time: {{ now() }}
    <div class="row">
        <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap">
            <div class="card detail-box1">
                <div class="card-body">
                    <div class="dash-contetnt">
                            <div class="d-flex justify-content-between">
                                <h4 class="text-light" wire:poll.5s="test()">#1</h4>
                            </div>
                            <div class="text-center">
                                <h1 class="text-white">{{number_format($users->users[0]->allprice,0,'','.')}}</h1>
                            </div>
                        
                            <div class="text-center mb-3">
                                <h4 class="text-white">
                                    {{$users->users[0]->last_name}} {{$users->users[0]->first_name}}
                                </h4>
                            </div>
                        <div class="region-hide mb-3">
                                    <table style="width: 100%;text-align:center;color:white;">
                                        <tbody>
                                            @foreach ($users->users as $key => $item)
                                                                 
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
                            <button onclick="arrowDown()" style="padding: 0px 6px;" type="button" class="btn btn-outline-danger arrow-down"><i class="fas fa-arrow-down" aria-hidden="true"></i> </button>
                            <button onclick="arrowUp()" style="padding: 0px 6px;display:none;" type="button" class="btn btn-outline-danger arrow-up"><i class="fas fa-arrow-up" aria-hidden="true"></i> </button>
                            <a href="{{route('rm-region')}}" style="padding: 0px 6px;display:none;" type="button" class="btn btn-outline-danger arrow-up"><i class="fas fa-eye" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>