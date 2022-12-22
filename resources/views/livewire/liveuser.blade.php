<div class="col-12 col-md-6 col-lg-3 flex-wrap">
            <div class="card detail-box1">
                <div class="card-body">
                    @if(count($users) > 0)
                    <div class="dash-contetnt">
                            <div class="d-flex justify-content-between">
                                <h4 class="text-light" wire:poll.5s="test()">#1</h4>
                            </div>
                            <div class="text-center">
                                <h1 class="text-white">{{number_format($users[0]->allprice,0,'','.')}}</h1>
                            </div>
                        
                            <div class="text-center mb-3">
                                <h4 class="text-white">
                                    {{$users[0]->last_name}} {{$users[0]->first_name}}
                                </h4>
                            </div>
                        <div class="user-live-hide mb-3" style="display: none;">
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
                            <button onclick="arrowDown('user-live')" style="padding: 0px 6px;" type="button" class="btn btn-outline-danger arrow-down-user-live"><i class="fas fa-arrow-down" aria-hidden="true"></i> </button>
                            <button onclick="arrowUp('user-live')" style="padding: 0px 6px;display:none;" type="button" class="btn btn-outline-danger arrow-up-user-live"><i class="fas fa-arrow-up" aria-hidden="true"></i> </button>
                            <a href="{{route('rm-user',['region' => 'all','time' => 'today'])}}" style="padding: 0px 6px;display:none;" type="button" class="btn btn-outline-danger arrow-up-user-live"><i class="fas fa-eye" aria-hidden="true"></i></a>
                            
                            {{-- <a href="{{route('rm-region')}}" style="padding: 0px 6px;display:none;" type="button" class="btn btn-outline-danger arrow-up-user-live"><i class="fas fa-eye" aria-hidden="true"></i></a> --}}
                        </div>
                    </div>
                    @else
                    <span style="text-align: center;color:white">No data</span>
                    @endif
                </div>
            </div>
</div>