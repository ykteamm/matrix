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
                                @foreach($regions as $region)
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
              <div class="card-body">
                <div class="table-responsive">
                    <div class="text-left mb-2">
                        <h3>Garb</h3>
                    </div>
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr class="table-secondary">
                            <th>Apteka</th>
                            <th>Yangi kelgan pul</th>
                            <th>Eski kelgan pul</th>
                            <th>Yangi qolgan pul</th>
                            <th>Eski qolgan pul</th>
                            <th>Otgan oy predoplata</th>
                            <th>Vozvrat</th>
                            {{-- <th>Kelgan pul</th>
                            <th>Otgruzka</th>
                            <th>Eski qarz yopildi</th>
                            <th>Eski qarz qoldi</th>
                            <th>Yangi qarz yopildi</th>
                            <th>Yangi qarz qoldi</th>
                            <th>Umumiy qarz</th>
                            <th>Tovar qarz</th>
                            <th>Predoplata</th> --}}

                        </tr>
                        </thead>
                        <tbody>

                            @foreach ($pharmacy as $phar)
                            <tr>
                                <td>{{$phar->name}}</td>
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
                                <td>{{$vozvrat[$phar->id]}}</td>
                            </tr>

                            @endforeach

                            <tr>
                                <td>Jami</td>
                                <td>{{array_sum($yangi_kelgan_pul)}}</td>
                                <td>{{array_sum($eski_kelgan_pul)}}</td>
                                <td>{{array_sum($yangi_qolgan_pul)}}</td>
                                <td>{{array_sum($eski_qolgan_pul)}}</td>
                                <td>{{array_sum($otgan_oy_predoplata)}}</td>
                                <td>{{array_sum($vozvrat)}}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
              </div>
           </div>
        </div>
    </div>
</div>
