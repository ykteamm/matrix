<div>
    <style>
        .mc-danger{
            background: rgb(250, 137, 137)
        }
        .mc-danger-top{
            background: rgb(238, 79, 79)
        }
        .allmcbg{
            background: rgb(142, 204, 245)
        }
        
    </style>
    <div class="content container-fluid main-wrapper mt-5">
        <div class="row gold-box">
           @include('admin.components.logo')
           <div class="card flex-fill">
              <div style="border-bottom-radius:30px !important;margin-left:auto">
                 <div class="justify-content-between align-items-center p-2 mr-5 mt-3" >
                      <div class="btn-group">
                       <div class="row">
                          <div class="col-md-12" align="center">
                                   Viloyat
                          </div>
                          <div class="col-md-12">
                             <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{$active_region}}
                            </button>
                             <div class="dropdown-menu" style="left:150px !important">
                             <a href="#" wire:click="$emit('change_Region','all')"  class="dropdown-item"> Hammasi </a>
                                @foreach($regions_all as $region)
                                <a href="#" wire:click="$emit('change_Region',{{$region->id}})"  class="dropdown-item"> {{$region->name}} </a>
                                @endforeach
                             </div>
                          </div>
                       </div>
                      </div>
                      <div class="btn-group">
                           <div class="row">
                             <div class="col-md-12" align="center">
                                      Oy
                             </div>
                             <div class="col-md-12">
                                <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{date('m.Y',strtotime($active_month))}} </button>
                                <div class="dropdown-menu" style="left:150px !important">
                                       @foreach($months as $month)
                                       <a href="#" wire:click="$emit('change_McMonth',`{{$month}}`)"  class="dropdown-item"> {{$month}} </a>
                                       @endforeach
                                </div>
                             </div>
                          </div>
                      </div>
                 </div>
              </div>

            @php
                $sum_all_money1 = 0;
                $sum_otgruzka1 = 0;
                $sum_last_close_money1 = 0;
                $sum_last_accept_money1 = 0;
                $sum_new_close_money1 = 0;
                $sum_new_accept_money1 = 0;
                $sum_all_accept_money1 = 0;

                $sum_all_money2 = 0;
                $sum_otgruzka2 = 0;
                $sum_last_close_money2 = 0;
                $sum_last_accept_money2 = 0;
                $sum_new_close_money2 = 0;
                $sum_new_accept_money2 = 0;
                $sum_all_accept_money2 = 0;
            @endphp
              {{-- @if( count($regions) > 1 && $regions[0]->side == 1) --}}

              <div class="card-body">
                <div class="table-responsive">
                    <div class="text-left mb-2">
                        <h3>Garb</h3>
                    </div>
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr class="table-secondary">
                            <th>Viloyat</th>
                            <th>Kelgan pul</th>
                            <th>Otgruzka</th>
                            <th>Eski qarz yopildi</th>
                            <th>Eski qarz qoldi</th>
                            <th>Yangi qarz yopildi</th>
                            <th>Yangi qarz qoldi</th>
                            <th>Umumiy qarz</th>
                        </tr>
                        </thead>
                        <tbody>
                                
                            @foreach ($regions as $item)

                                

                                @if ($item->side ==1)
                                
                                @php
                                    $sum_all_money1 += $all_money[$item->id];
                                    $sum_otgruzka1 += $otgruzka[$item->id];
                                    $sum_last_close_money1 += $last_close_money[$item->id];
                                    $sum_last_accept_money1 += $last_accept_money[$item->id];
                                    $sum_new_close_money1 += $new_close_money[$item->id];
                                    $sum_new_accept_money1 += $new_accept_money[$item->id];
                                    $sum_all_accept_money1 += $new_accept_money[$item->id]+$last_accept_money[$item->id];
                                @endphp

                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>{{number_format($all_money[$item->id],0,',','.')}}</td>
                                        <td>{{number_format($otgruzka[$item->id],0,',','.')}}</td>
                                        <td>{{number_format($last_close_money[$item->id],0,',','.')}}</td>
                                        <td>{{number_format($last_accept_money[$item->id],0,',','.')}}</td>
                                        <td>{{number_format($new_close_money[$item->id],0,',','.')}}</td>
                                        <td>{{number_format($new_accept_money[$item->id],0,',','.')}}</td>
                                        <td>{{number_format($new_accept_money[$item->id]+$last_accept_money[$item->id],0,',','.')}}</td>
                                    </tr>
                                    
                                @endif

                            @endforeach
                                    
                                    <tr class="table-primary">
                                        <td>Jami</td>
                                        <td>{{number_format($sum_all_money1,0,',','.')}}</td>
                                        <td>{{number_format($sum_otgruzka1,0,',','.')}}</td>
                                        <td>{{number_format($sum_last_close_money1,0,',','.')}}</td>
                                        <td>{{number_format($sum_last_accept_money1,0,',','.')}}</td>
                                        <td>{{number_format($sum_new_close_money1,0,',','.')}}</td>
                                        <td>{{number_format($sum_new_accept_money1,0,',','.')}}</td>
                                        <td class="mc-danger-top">{{number_format($sum_all_accept_money1,0,',','.')}}</td>
                                    </tr>
                            
                        </tbody>
                    </table>
                </div>
              </div>

              {{-- @endif --}}

              {{-- @if( count($regions) > 1 && $regions[0]->side == 2) --}}

              <div class="card-body">
                <div class="table-responsive">
                    <div class="text-left mb-2">
                        <h3>Sharq</h3>
                    </div>
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr class="table-secondary">
                            <th>Viloyat</th>
                            <th>Kelgan pul</th>
                            <th>Otgruzka</th>
                            <th>Eski qarz yopildi</th>
                            <th>Eski qarz qoldi</th>
                            <th>Yangi qarz yopildi</th>
                            <th>Yangi qarz qoldi</th>
                            <th>Umumiy qarz</th>
                        </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($regions as $item)
                                @if ($item->side == 2)
                                @php
                                    $sum_all_money2 += $all_money[$item->id];
                                    $sum_otgruzka2 += $otgruzka[$item->id];
                                    $sum_last_close_money2 += $last_close_money[$item->id];
                                    $sum_last_accept_money2 += $last_accept_money[$item->id];
                                    $sum_new_close_money2 += $new_close_money[$item->id];
                                    $sum_new_accept_money2 += $new_accept_money[$item->id];
                                    $sum_all_accept_money2 += $new_accept_money[$item->id]+$last_accept_money[$item->id];
                                @endphp
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{number_format($all_money[$item->id],0,',','.')}}</td>
                                    <td>{{number_format($otgruzka[$item->id],0,',','.')}}</td>
                                    <td>{{number_format($last_close_money[$item->id],0,',','.')}}</td>
                                    <td>{{number_format($last_accept_money[$item->id],0,',','.')}}</td>
                                    <td>{{number_format($new_close_money[$item->id],0,',','.')}}</td>
                                    <td>{{number_format($new_accept_money[$item->id],0,',','.')}}</td>
                                    <td>
                                            {{number_format($new_accept_money[$item->id]+$last_accept_money[$item->id],0,',','.')}}
                                    </td>
                                </tr>

                                @endif
                            @endforeach
                            <tr class="table-primary">
                                <td>Jami</td>
                                <td>{{number_format($sum_all_money2,0,',','.')}}</td>
                                <td>{{number_format($sum_otgruzka2,0,',','.')}}</td>
                                <td>{{number_format($sum_last_close_money2,0,',','.')}}</td>
                                <td>{{number_format($sum_last_accept_money2,0,',','.')}}</td>
                                <td>{{number_format($sum_new_close_money2,0,',','.')}}</td>
                                <td>{{number_format($sum_new_accept_money2,0,',','.')}}</td>
                                <td>
                                    {{-- <span class="badge badge-danger"> --}}
                                        {{number_format($sum_all_accept_money2,0,',','.')}}
                                    {{-- </span> --}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              </div>

              {{-- @endif --}}

              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr class="table-secondary">
                            <th>Viloyat</th>
                            <th>Kelgan pul</th>
                            <th>Otgruzka</th>
                            <th>Eski qarz yopildi</th>
                            <th>Eski qarz qoldi</th>
                            <th>Yangi qarz yopildi</th>
                            <th>Yangi qarz qoldi</th>
                            <th>Umumiy qarz</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr class="table-info">
                                <td>Umumiy</td>
                                <td>{{number_format($sum_all_money2 + $sum_all_money1,0,',','.')}}</td>
                                <td>{{number_format($sum_otgruzka2 + $sum_otgruzka1,0,',','.')}}</td>
                                <td>{{number_format($sum_last_close_money2 + $sum_last_close_money1,0,',','.')}}</td>
                                <td>{{number_format($sum_last_accept_money2 + $sum_last_accept_money1,0,',','.')}}</td>
                                <td>{{number_format($sum_new_close_money2 + $sum_new_close_money1,0,',','.')}}</td>
                                <td>{{number_format($sum_new_accept_money2 + $sum_new_accept_money1,0,',','.')}}</td>
                                <td>{{number_format($sum_all_accept_money2 + $sum_all_accept_money1,0,',','.')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              </div>

           </div>
        </div>
    </div>
</div>
