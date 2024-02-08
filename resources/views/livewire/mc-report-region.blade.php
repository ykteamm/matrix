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
                                @foreach($all_regions as $region)
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
              {{-- @foreach ($regions as $item) --}}


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
                            <th>Yangi qarz yopildi</th>
                            <th>Yangi qarz qoldi</th>
                            <th>Eski qarz yopildi</th>
                            <th>Eski qarz qoldi</th>
                            <th>Umumiy qarz</th>

                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $yangi_qarz_yopildi = [];
                                $yangi_qarz_qoldi = [];
                                $eski_qarz_yopildi = [];
                                $eski_qarz_qoldi = [];
                                $otgan_oy_predoplata_bolgan = [];
                                $shu_oy_predoplata_bolgan = [];
                                $shu_oy_vozvrat_bolgan = [];
                            @endphp
                            @foreach ($regions as $item)

                                @if (in_array($item->id,[5,3,13,1,14,23,9,11,10,6]))
                                    <tr>
                                        <td>
                                            {{ $item->name}}
                                        </td>
                                        @php
                                            $yangi_qarz_yopildi[$item->id] = 0;
                                            $yangi_qarz_qoldi[$item->id] = 0;
                                            $eski_qarz_yopildi[$item->id] = 0;
                                            $eski_qarz_qoldi[$item->id] = 0;
                                            $otgan_oy_predoplata_bolgan[$item->id] = 0;
                                            $shu_oy_predoplata_bolgan[$item->id] = 0;
                                            $shu_oy_vozvrat_bolgan[$item->id] = 0;
                                        @endphp
                                        @foreach ($pharmacy as $phr)
                                            @if ($phr->region_id == $item->id)
                                                @php
                                                    $yangi_qarz_yopildi[$item->id] += $yangi_kelgan_pul[$phr->id]??0;
                                                    $yangi_qarz_qoldi[$item->id] += $yangi_qolgan_pul[$phr->id]??0;
                                                    $eski_qarz_yopildi[$item->id] += $eski_kelgan_pul[$phr->id]??0;
                                                    $eski_qarz_qoldi[$item->id] += $eski_qolgan_pul[$phr->id]??0;
                                                    $otgan_oy_predoplata_bolgan[$item->id] += $otgan_oy_predoplata[$phr->id]??0;
                                                    $shu_oy_predoplata_bolgan[$item->id] += $shu_oy_predoplata[$phr->id]??0;
                                                    $shu_oy_vozvrat_bolgan[$item->id] += $shu_oy_vozvrat[$phr->id]??0;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <td>
                                            {{ $yangi_qarz_yopildi[$item->id] + $eski_qarz_yopildi[$item->id]}}
                                        </td>
                                        <td>
                                            {{ $yangi_qarz_yopildi[$item->id] + $yangi_qarz_qoldi[$item->id] + $shu_oy_vozvrat_bolgan[$item->id] + $otgan_oy_predoplata_bolgan[$item->id] - $shu_oy_predoplata_bolgan[$item->id]}}
                                        </td>
                                        <td>
                                            {{ $yangi_qarz_yopildi[$item->id] }}
                                        </td>
                                        <td>
                                            {{ $yangi_qarz_qoldi[$item->id] }}
                                        </td>
                                        <td>
                                            {{ $eski_qarz_yopildi[$item->id] }}
                                        </td>
                                        <td>
                                            {{ $eski_qarz_qoldi[$item->id] }}
                                        </td>
                                        <td>
                                            {{ $eski_qarz_qoldi[$item->id] + $yangi_qarz_qoldi[$item->id] }}

                                        </td>
                                    </tr>

                                @endif

                            @endforeach
                            <tr>
                                <td>
                                    Jami
                                </td>
                                <td>
                                    {{array_sum($yangi_qarz_yopildi) + array_sum($eski_qarz_yopildi)}}
                                </td>
                                <td>
                                    {{array_sum($yangi_qarz_yopildi) + array_sum($yangi_qarz_qoldi) + array_sum($shu_oy_vozvrat_bolgan) + array_sum($otgan_oy_predoplata_bolgan) -array_sum($shu_oy_predoplata_bolgan)}}

                                </td>
                                <td>
                                    {{array_sum($yangi_qarz_yopildi)}}

                                </td>
                                <td>
                                    {{array_sum($yangi_qarz_qoldi)}}

                                </td>
                                <td>
                                    {{array_sum($eski_qarz_yopildi)}}

                                </td>
                                <td>
                                    {{array_sum($eski_qarz_qoldi)}}

                                </td>
                                <td>
                                    {{array_sum($eski_qarz_qoldi) + array_sum($yangi_qarz_qoldi)}}

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              </div>
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
                            <th>Yangi qarz yopildi</th>
                            <th>Yangi qarz qoldi</th>
                            <th>Eski qarz yopildi</th>
                            <th>Eski qarz qoldi</th>
                            <th>Umumiy qarz</th>

                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $yangi_qarz_yopildi = [];
                                $yangi_qarz_qoldi = [];
                                $eski_qarz_yopildi = [];
                                $eski_qarz_qoldi = [];
                                $otgan_oy_predoplata_bolgan = [];
                                $shu_oy_predoplata_bolgan = [];
                                $shu_oy_vozvrat_bolgan = [];
                            @endphp
                            @foreach ($regions as $item)

                                @if (in_array($item->id,[2,7,12,19]))
                                    <tr>
                                        <td>
                                            {{ $item->name}}
                                        </td>
                                        @php
                                            $yangi_qarz_yopildi[$item->id] = 0;
                                            $yangi_qarz_qoldi[$item->id] = 0;
                                            $eski_qarz_yopildi[$item->id] = 0;
                                            $eski_qarz_qoldi[$item->id] = 0;
                                            $otgan_oy_predoplata_bolgan[$item->id] = 0;
                                            $shu_oy_predoplata_bolgan[$item->id] = 0;
                                            $shu_oy_vozvrat_bolgan[$item->id] = 0;
                                        @endphp
                                        @foreach ($pharmacy as $phr)
                                            @if ($phr->region_id == $item->id)
                                                @php
                                                    $yangi_qarz_yopildi[$item->id] += $yangi_kelgan_pul[$phr->id]??0;
                                                    $yangi_qarz_qoldi[$item->id] += $yangi_qolgan_pul[$phr->id]??0;
                                                    $eski_qarz_yopildi[$item->id] += $eski_kelgan_pul[$phr->id]??0;
                                                    $eski_qarz_qoldi[$item->id] += $eski_qolgan_pul[$phr->id]??0;
                                                    $otgan_oy_predoplata_bolgan[$item->id] += $otgan_oy_predoplata[$phr->id]??0;
                                                    $shu_oy_predoplata_bolgan[$item->id] += $shu_oy_predoplata[$phr->id]??0;
                                                    $shu_oy_vozvrat_bolgan[$item->id] += $shu_oy_vozvrat[$phr->id]??0;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <td>
                                            {{ $yangi_qarz_yopildi[$item->id] + $eski_qarz_yopildi[$item->id]}}
                                        </td>
                                        <td>
                                            {{ $yangi_qarz_yopildi[$item->id] + $yangi_qarz_qoldi[$item->id] + $shu_oy_vozvrat_bolgan[$item->id] + $otgan_oy_predoplata_bolgan[$item->id] - $shu_oy_predoplata_bolgan[$item->id]}}
                                        </td>
                                        <td>
                                            {{ $yangi_qarz_yopildi[$item->id] }}
                                        </td>
                                        <td>
                                            {{ $yangi_qarz_qoldi[$item->id] }}
                                        </td>
                                        <td>
                                            {{ $eski_qarz_yopildi[$item->id] }}
                                        </td>
                                        <td>
                                            {{ $eski_qarz_qoldi[$item->id] }}
                                        </td>
                                        <td>
                                            {{ $eski_qarz_qoldi[$item->id] + $yangi_qarz_qoldi[$item->id] }}

                                        </td>
                                    </tr>

                                @endif

                            @endforeach
                            <tr>
                                <td>
                                    Jami
                                </td>
                                <td>
                                    {{array_sum($yangi_qarz_yopildi) + array_sum($eski_qarz_yopildi)}}
                                </td>
                                <td>
                                    {{array_sum($yangi_qarz_yopildi) + array_sum($yangi_qarz_qoldi) + array_sum($shu_oy_vozvrat_bolgan) + array_sum($otgan_oy_predoplata_bolgan) -array_sum($shu_oy_predoplata_bolgan)}}

                                </td>
                                <td>
                                    {{array_sum($yangi_qarz_yopildi)}}

                                </td>
                                <td>
                                    {{array_sum($yangi_qarz_qoldi)}}

                                </td>
                                <td>
                                    {{array_sum($eski_qarz_yopildi)}}

                                </td>
                                <td>
                                    {{array_sum($eski_qarz_qoldi)}}

                                </td>
                                <td>
                                    {{array_sum($eski_qarz_qoldi) + array_sum($yangi_qarz_qoldi)}}

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                    <div class="text-left mb-2">
                        <h3>Yangi UZB</h3>
                    </div>
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr class="table-secondary">
                            <th>Viloyat</th>
                            <th>Kelgan pul</th>
                            <th>Otgruzka</th>
                            <th>Yangi qarz yopildi</th>
                            <th>Yangi qarz qoldi</th>
                            <th>Eski qarz yopildi</th>
                            <th>Eski qarz qoldi</th>
                            <th>Umumiy qarz</th>

                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $yangi_qarz_yopildi = [];
                                $yangi_qarz_qoldi = [];
                                $eski_qarz_yopildi = [];
                                $eski_qarz_qoldi = [];
                                $otgan_oy_predoplata_bolgan = [];
                                $shu_oy_predoplata_bolgan = [];
                                $shu_oy_vozvrat_bolgan = [];
                            @endphp
                            @foreach ($regions as $item)

                                @if (in_array($item->id,[8,17]))
                                    <tr>
                                        <td>
                                            {{ $item->name}}
                                        </td>
                                        @php
                                            $yangi_qarz_yopildi[$item->id] = 0;
                                            $yangi_qarz_qoldi[$item->id] = 0;
                                            $eski_qarz_yopildi[$item->id] = 0;
                                            $eski_qarz_qoldi[$item->id] = 0;
                                            $otgan_oy_predoplata_bolgan[$item->id] = 0;
                                            $shu_oy_predoplata_bolgan[$item->id] = 0;
                                            $shu_oy_vozvrat_bolgan[$item->id] = 0;
                                        @endphp
                                        @foreach ($pharmacy as $phr)
                                            @if ($phr->region_id == $item->id)
                                                @php
                                                    $yangi_qarz_yopildi[$item->id] += $yangi_kelgan_pul[$phr->id]??0;
                                                    $yangi_qarz_qoldi[$item->id] += $yangi_qolgan_pul[$phr->id]??0;
                                                    $eski_qarz_yopildi[$item->id] += $eski_kelgan_pul[$phr->id]??0;
                                                    $eski_qarz_qoldi[$item->id] += $eski_qolgan_pul[$phr->id]??0;
                                                    $otgan_oy_predoplata_bolgan[$item->id] += $otgan_oy_predoplata[$phr->id]??0;
                                                    $shu_oy_predoplata_bolgan[$item->id] += $shu_oy_predoplata[$phr->id]??0;
                                                    $shu_oy_vozvrat_bolgan[$item->id] += $shu_oy_vozvrat[$phr->id]??0;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <td>
                                            {{ $yangi_qarz_yopildi[$item->id] + $eski_qarz_yopildi[$item->id]}}
                                        </td>
                                        <td>
                                            {{ $yangi_qarz_yopildi[$item->id] + $yangi_qarz_qoldi[$item->id] + $shu_oy_vozvrat_bolgan[$item->id] + $otgan_oy_predoplata_bolgan[$item->id] - $shu_oy_predoplata_bolgan[$item->id]}}
                                        </td>
                                        <td>
                                            {{ $yangi_qarz_yopildi[$item->id] }}
                                        </td>
                                        <td>
                                            {{ $yangi_qarz_qoldi[$item->id] }}
                                        </td>
                                        <td>
                                            {{ $eski_qarz_yopildi[$item->id] }}
                                        </td>
                                        <td>
                                            {{ $eski_qarz_qoldi[$item->id] }}
                                        </td>
                                        <td>
                                            {{ $eski_qarz_qoldi[$item->id] + $yangi_qarz_qoldi[$item->id] }}

                                        </td>
                                    </tr>

                                @endif

                            @endforeach
                            <tr>
                                <td>
                                    Jami
                                </td>
                                <td>
                                    {{array_sum($yangi_qarz_yopildi) + array_sum($eski_qarz_yopildi)}}
                                </td>
                                <td>
                                    {{array_sum($yangi_qarz_yopildi) + array_sum($yangi_qarz_qoldi) + array_sum($shu_oy_vozvrat_bolgan) + array_sum($otgan_oy_predoplata_bolgan) -array_sum($shu_oy_predoplata_bolgan)}}

                                </td>
                                <td>
                                    {{array_sum($yangi_qarz_yopildi)}}

                                </td>
                                <td>
                                    {{array_sum($yangi_qarz_qoldi)}}

                                </td>
                                <td>
                                    {{array_sum($eski_qarz_yopildi)}}

                                </td>
                                <td>
                                    {{array_sum($eski_qarz_qoldi)}}

                                </td>
                                <td>
                                    {{array_sum($eski_qarz_qoldi) + array_sum($yangi_qarz_qoldi)}}

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                    <div class="text-left mb-2">
                        <h3>Garb</h3>
                    </div>
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr class="table-secondary">
                            <th>Apteka</th>
                            <th>Otgruzka</th>
                            <th>Yangi kelgan pul</th>
                            <th>Eski kelgan pul</th>
                            <th>Yangi qolgan pul</th>
                            <th>Eski qolgan pul</th>
                            <th>Otgan oy predoplata</th>
                            <th>Shu oy predoplata</th>
                            <th>Vozvrat</th>
                            <th>Shu oy vozvrat</th>

                        </tr>
                        </thead>
                        <tbody>

                            @foreach ($pharmacy as $phar)
                            <tr>
                                <td>{{$phar->name}}</td>
                                <td>{{$yangi_kelgan_pul[$phar->id] + $yangi_qolgan_pul[$phar->id] + $shu_oy_vozvrat[$phar->id]??0 + $otgan_oy_predoplata[$phar->id] - $shu_oy_predoplata[$phar->id]}}</td>
                                <td>{{$yangi_kelgan_pul[$phar->id]}}</td>
                                <td>{{$eski_kelgan_pul[$phar->id]}}</td>
                                <td>{{$yangi_qolgan_pul[$phar->id]}}</td>
                                <td>{{$eski_qolgan_pul[$phar->id]}}</td>
                                <td>
                                    @if (isset($otgan_oy_predoplata[$phar->id]))
                                        {{$otgan_oy_predoplata[$phar->id]}}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if (isset($shu_oy_predoplata[$phar->id]))
                                        {{$shu_oy_predoplata[$phar->id]}}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>{{$vozvrat[$phar->id]}}</td>
                                <td>{{$shu_oy_vozvrat[$phar->id]}}</td>
                            </tr>

                            @endforeach

                            <tr>
                                <td>Jami</td>
                                <td>{{array_sum($yangi_kelgan_pul) + array_sum($yangi_qolgan_pul) + array_sum($shu_oy_vozvrat) + array_sum($otgan_oy_predoplata)}}</td>
                                <td>{{array_sum($yangi_kelgan_pul)}}</td>
                                <td>{{array_sum($eski_kelgan_pul)}}</td>
                                <td>{{array_sum($yangi_qolgan_pul)}}</td>
                                <td>{{array_sum($eski_qolgan_pul)}}</td>
                                <td>{{array_sum($otgan_oy_predoplata)}}</td>
                                <td>{{array_sum($shu_oy_predoplata)}}</td>
                                <td>{{array_sum($vozvrat)}}</td>
                                <td>{{array_sum($shu_oy_vozvrat)}}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
              </div>
           </div>
        </div>
    </div>
</div>
