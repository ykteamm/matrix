@extends('admin.layouts.admin-app')
@section('super_admin_content')
<style>
    .copa{
        background: linear-gradient( 313deg, hsl(196.62deg 100% 55%) 0%, hsl(196.62deg 58% 28%) 30%, hsl(265.85deg 95% 8%) 65% );
    }
    .copabtn{
        background: linear-gradient( 15deg, hsl(155.6deg 24.67% 46.23%) 0%, hsl(168.92deg 29.61% 20.16%) 30%, hsl(202.67deg 61.57% 27.87%) 65% );
    }
    .regionmc{
        background: linear-gradient( 0deg, hsl(216.52deg 16.82% 27.09%) 0%, hsl(350deg 16.82% 24.39%) 30%, hsl(224deg 21.41% 36.44%) 65% );
    }
    .copaoq{
        color:white;
    }
    .copaoq:hover{
        color:white;
    }
</style>
    <div class="content container-fluid mt-5">
        {{-- <div class="text-right">
            <button class="btn copabtn copaoq">Hammasi</button>
            <button class="btn copabtn copaoq">Shu oy</button>
            <button class="btn copabtn copaoq">O'tgan oy</button>
        </div> --}}
        <div class="page-header mt-5">
            <div class="row">

                <div class="col-12 col-md-12 col-lg-8 d-flex flex-wrap delcat">
                    <div style="border-radius:26px;" class="card copa">
                        <div class="d-flex">

                        <div class="card-body">
                            <div class="dash-contetnt">
                            <h2 style="color:#ffffff;text-align:left;font-size:30px;font-family:Gilroy;">Pul kelishi</h2>
                            <h3 style="color:#ffffff;text-align:left;margin-left:0px;">
                                <span title="{{number_format($arrive_monay,0,',','.')}}">
                                <span class="numberpr">{{bmk($arrive_monay)}} <span style="font-size:15px">sentabr</span></span>
                                </span>
                            </h3>
                            <h3 style="color:#ffffff;text-align:left;margin-left:0px;">
                                <span title="{{number_format($arrive_monay_day,0,',','.')}}">
                                <span class="numberpr">{{bmk($arrive_monay_day)}} <span style="font-size:15px">bugun</span></span>
                                </span>
                            </h3>
                            <h3 style="color:#ffffff;text-align:left;margin-left:0px;">
                                <span title="{{number_format($arrive_monay_week,0,',','.')}}">
                                <span class="numberpr">{{bmk($arrive_monay_week)}} <span style="font-size:15px">hafta</span></span>
                                </span>
                            </h3>
                            </div>
                        </div>
                        <div class="card-body text-right">
                            <div class="dash-content">
                                <h2 style="color:#ffffff;font-size:30px;font-family:Gilroy;">Qarzdorlik</h2>
                                <h3 style="color:#ffffff;margin-left:0px;">
                                    <span title="{{number_format($qizil_yangi_sum + $sariq_yangi_sum + $yashil_yangi_sum + $qizil_eski_sum + $sariq_eski_sum + $yashil_eski_sum,0,',','.')}}">
                                    <span class="numberpr">{{bmk($qizil_yangi_sum + $sariq_yangi_sum + $yashil_yangi_sum + $qizil_eski_sum + $sariq_eski_sum + $yashil_eski_sum)}} <span style="font-size:15px"></span></span>
                                    </span>
                                </h3>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">

                                </div>
                                <div class="col-md-4">
                                    <h5 style="color:#ffffff;font-size:30px;font-family:Gilroy;">Yangi</h5>
                                </div>
                                <div class="col-md-4">
                                    <h5 style="color:#ffffff;font-size:30px;font-family:Gilroy;">Eski</h5>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <h3 style="color:#f17979;margin-left:0px;">
                                        <span title="{{number_format($qizil_yangi_sum+$qizil_eski_sum,0,',','.')}}">
                                        <span class="numberpr">{{bmk($qizil_yangi_sum+$qizil_eski_sum)}}</span>
                                        </span>
                                        
                                        
                                    </h3>
                                </div>
                                <div class="col-md-4">
                                    <h3 style="color:#f17979;margin-left:0px;">
                                        <span title="{{number_format($qizil_yangi_sum,0,',','.')}}">
                                        <span class="numberpr">{{bmk($qizil_yangi_sum)}}</span>
                                        </span>
                                        
                                        
                                    </h3>
                                </div>
                                <div class="col-md-4">
                                    <h3 style="color:#f17979;margin-left:0px;">
                                        <span title="{{number_format($qizil_eski_sum,0,',','.')}}">
                                        <span class="numberpr">{{bmk($qizil_eski_sum)}}</span>
                                        </span>
                                        
                                        
                                    </h3>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <h3 style="color:#fbf728;margin-left:0px;">
                                        <span title="{{number_format($sariq_yangi_sum+$sariq_eski_sum,0,',','.')}}">
                                        <span class="numberpr">{{bmk($sariq_yangi_sum+$sariq_eski_sum)}}</span>
                                        </span>
                                        
                                        
                                    </h3>
                                </div>
                                <div class="col-md-4">
                                    <h3 style="color:#fbf728;margin-left:0px;">
                                        <span title="{{number_format($sariq_yangi_sum,0,',','.')}}">
                                        <span class="numberpr">{{bmk($sariq_yangi_sum)}}</span>
                                        </span>
                                        
                                        
                                    </h3>
                                </div>
                                <div class="col-md-4">
                                    <h3 style="color:#fbf728;margin-left:0px;">
                                        <span title="{{number_format($sariq_eski_sum,0,',','.')}}">
                                        <span class="numberpr">{{bmk($sariq_eski_sum)}}</span>
                                        </span>
                                        
                                        
                                    </h3>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <h3 style="color:#16fd2a;margin-left:0px;">
                                        <span title="{{number_format($yashil_yangi_sum+$yashil_eski_sum,0,',','.')}}">
                                        <span class="numberpr">{{bmk($yashil_yangi_sum+$yashil_eski_sum)}}</span>
                                        </span>
                                        
                                        
                                    </h3>
                                </div>
                                <div class="col-md-4">
                                    <h3 style="color:#16fd2a;margin-left:0px;">
                                        <span title="{{number_format($yashil_yangi_sum,0,',','.')}}">
                                        <span class="numberpr">{{bmk($yashil_yangi_sum)}}</span>
                                        </span>
                                        
                                        
                                    </h3>
                                </div>
                                <div class="col-md-4">
                                    <h3 style="color:#16fd2a;margin-left:0px;">
                                        <span title="{{number_format($yashil_eski_sum,0,',','.')}}">
                                        <span class="numberpr">{{bmk($yashil_eski_sum)}}</span>
                                        </span>
                                        
                                        
                                    </h3>    
                                </div>
                            </div>
                            <div class="row" style="border-top: 2px solid white;">
                                <div class="col-md-4">
                                    <h3 style="color:#ffffff;margin-left:0px;">
                                        <span title="{{number_format($qizil_yangi_sum + $sariq_yangi_sum + $yashil_yangi_sum + $qizil_eski_sum + $sariq_eski_sum + $yashil_eski_sum,0,',','.')}}">
                                        <span class="numberpr">{{bmk($qizil_yangi_sum + $sariq_yangi_sum + $yashil_yangi_sum + $qizil_eski_sum + $sariq_eski_sum + $yashil_eski_sum)}}</span>
                                        </span>
                                        
                                        
                                    </h3>
                                </div>
                                <div class="col-md-4">
                                    <h3 style="color:#ffffff;margin-left:0px;">
                                        <span title="{{number_format($qizil_yangi_sum + $sariq_yangi_sum + $yashil_yangi_sum,0,',','.')}}">
                                        <span class="numberpr">{{bmk($qizil_yangi_sum + $sariq_yangi_sum + $yashil_yangi_sum)}}</span>
                                        </span>
                                        
                                        
                                    </h3>
                                </div>
                                <div class="col-md-4">
                                    <h3 style="color:#ffffff;margin-left:0px;">
                                        <span title="{{number_format($qizil_eski_sum + $sariq_eski_sum + $yashil_eski_sum,0,',','.')}}">
                                        <span class="numberpr">{{bmk($qizil_eski_sum + $sariq_eski_sum + $yashil_eski_sum)}}</span>
                                        </span>
                                        
                                        
                                    </h3>    
                                </div>
                            </div>
                            
                            {{-- <div class="dash-contetnt text-right">
                            <h2 style="color:#ffffff;font-size:30px;font-family:Gilroy;">Qarzdorlik</h2>
                            <h3 style="color:#ffffff;margin-left:0px;">
                                <span title="{{number_format($yashil_all,0,',','.')}}">
                                <span class="numberpr">{{bmk($yashil_all)}}</span>
                                </span>
                            </h3>
                            <h3 style="color:#f17979;margin-left:0px;">
                                <span title="{{number_format($qizil_all,0,',','.')}}">
                                <span class="numberpr">{{bmk($qizil_all)}}</span>
                                </span>
                                
                                
                            </h3>
                            <h3 style="color:#b7ca4b;margin-left:0px;">
                                <span title="{{number_format($sariq_all,0,',','.')}}">
                                <span class="numberpr">{{bmk($sariq_all)}}</span>
                                </span>
                            </h3>
                            <i style="cursor: pointer" class="fas fa-eye" data-toggle="modal"
                                data-target="#mcregion"></i>
                            </div> --}}
                        </div>

                        </div>

                        
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-4 d-flex flex-wrap delcat">
                    <div style="border-radius:26px;" class="card copa">
                        <div class="d-flex">

                        <div class="card-body">
                            <div class="dash-contetnt">
                            <h2 style="color:#ffffff;text-align:left;font-size:30px;font-family:Gilroy;">Otgruzka</h2>
                            <h3 style="color:#ffffff;text-align:left;margin-left:0px;">
                                <span title="{{number_format($shipment,0,',','.')}}">
                                <span class="numberpr">{{bmk($shipment)}} <span style="font-size:15px">oy</span> </span>
                                </span>
                            </h3>
                            <h3 style="color:#ffffff;text-align:left;margin-left:0px;">
                                <span title="110.000">
                                <span class="numberpr">{{bmk($shipment_day)}} <span style="font-size:15px">bugun</span></span>
                                </span>
                            </h3>
                            <h3 style="color:#ffffff;text-align:left;margin-left:0px;">
                                <span title="110.000">
                                <span class="numberpr">{{bmk($shipment_week)}} <span style="font-size:15px">hafta</span></span>
                                </span>
                            </h3>
                            </div>
                        </div>
                        <div class="card-body text-right">
                            <div class="dash-contetnt text-right">
                            <h2 style="color:#ffffff;font-size:30px;font-family:Gilroy;">Zagruzka minimum</h2>
                            <h3 style="color:#ffffff;margin-left:0px;">
                                <span title="{{number_format($yashil_rek_sum,0,',','.')}}">
                                <span class="numberpr">{{bmk($yashil_rek_sum)}}</span>
                                </span>
                            </h3>
                            <h3 style="color:#f17979;margin-left:0px;">
                                <span title="{{number_format($qizil_rek_sum,0,',','.')}}">
                                <span class="numberpr">{{bmk($qizil_rek_sum)}}</span>
                                </span>
                                
                                
                            </h3>
                            <h3 style="color:#b7ca4b;margin-left:0px;">
                                <span title="{{number_format($sariq_rek_sum,0,',','.')}}">
                                <span class="numberpr">{{bmk($sariq_rek_sum)}}</span>
                                </span>
                            </h3>
                            <i style="cursor: pointer" class="fas fa-eye" data-toggle="modal"
                                data-target="#rekregion"></i>
                            </div>
                        </div>

                        </div>

                        
                    </div>
                </div>
            
            </div>

        </div>
    </div>

    <div class="modal fade" id="mcregion">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 95%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Viloyatlat boyicha</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            @foreach ($sitafor as $key => $item)
                                
                            <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap delcat">
                                <div style="border-radius:26px;" class="card regionmc">
                                  <div class="card-body">
                                    <div class="dash-contetnt">
                                      <h2 style="color:#ffffff;text-align:left;font-size:30px;font-family:Gilroy;">{{$regions[$key]}}</h2>
                                        @if (isset($yashil[$key]))
                                            <h3 style="color:#ffffff;text-align:left;margin-left:0px;">
                                                <span title="110.000">
                                                <span class="numberpr">
                                                    
                                                    {{bmk(array_sum($yashil[$key]))}}
                                                </span>
                                                </span>
                                            </h3>
                                        @endif
                                        @if (isset($qizil[$key]))
                                            <h3 style="color:#f17979;text-align:left;margin-left:0px;">
                                                <span title="110.000">
                                                <span class="numberpr">
                                                    
                                                    {{bmk(array_sum($qizil[$key]))}}
                                                </span>
                                                <i style="cursor: pointer;font-size:20px" class="fas fa-eye" data-toggle="modal"
                                                    data-target="#mcpharqizil{{$key}}"></i>
                                                </span>
                                            </h3>
                                        @endif
                                        @if (isset($sariq[$key]))
                                            <h3 style="color:#b7ca4b;text-align:left;margin-left:0px;">
                                                <span title="110.000">
                                                <span class="numberpr">
                                                    
                                                    {{bmk(array_sum($sariq[$key]))}}
                                                </span>
                                                <i style="cursor: pointer;font-size:20px" class="fas fa-eye" data-toggle="modal"
                                                    data-target="#mcpharsariq{{$key}}"></i>
                                                </span>
                                            </h3>
                                        @endif
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

    @foreach ($sitafor as $key => $item)

    <div class="modal fade" id="mcpharqizil{{$key}}">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 90%;">
            <div class="modal-content" style="background: linear-gradient( 350deg, hsl(216.52deg 19.34% 79.68%) 0%, hsl(350deg 16.58% 69.97%) 30%, hsl(141.75deg 45.13% 94.53%) 65% );
        }">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">{{$regions[$key]}}dagi dorixonalar boyicha</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="row">
                                @foreach ($item as $i => $v)
                                @if (isset($qizil_p[$i]) && $qizil_p[$i] != 0)
                                
                                    <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap delcat">
                                        <div style="border-radius:26px;" class="card regionmc">
                                        <div class="card-body">
                                            <div class="dash-contetnt">
                                            <h4 style="color:#ffffff;text-align:left;font-size:30px;font-family:Gilroy;">{{$pharmacy[$i]}}</h4>
                                                    <h5 style="color:#f17979;text-align:left;margin-left:0px;">
                                                        <span title="110.000">
                                                        <span class="numberpr">
                                                            
                                                            {{bmk($qizil_p[$i])}}
                                                        </span>
                                                        <i style="cursor: pointer;font-size:20px" class="fas fa-eye" data-toggle="modal"
                                                            data-target="#mcorderqizil{{$i}}"></i>
                                                        </span>
                                                    </h5>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                @endif

                                @endforeach


                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mcpharsariq{{$key}}">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 90%;">
            <div class="modal-content" style="background: linear-gradient( 350deg, hsl(216.52deg 5.11% 70.28%) 0%, hsl(69.75deg 24.09% 59.74%) 30%, hsl(224deg 100% 97.24%) 65% );">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">{{$regions[$key]}}dagi dorixonalar boyicha</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="row">
                                @foreach ($item as $i => $v)
                                @if (isset($sariq_p[$i]) && $sariq_p[$i] != 0)
                                
                                    <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap delcat">
                                        <div style="border-radius:26px;" class="card regionmc">
                                        <div class="card-body">
                                            <div class="dash-contetnt">
                                            <h4 style="color:#ffffff;text-align:left;font-size:30px;font-family:Gilroy;">{{$pharmacy[$i]}}</h4>
                                                    <h5 style="color:#b7ca4b;text-align:left;margin-left:0px;">
                                                        <span title="110.000">
                                                        <span class="numberpr">
                                                            
                                                            {{bmk($sariq_p[$i])}}
                                                        </span>
                                                        <i style="cursor: pointer;font-size:20px" class="fas fa-eye" data-toggle="modal"
                                                            data-target="#mcordersariq{{$i}}"></i>
                                                        </span>
                                                    </h5>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                @endif

                                @endforeach


                        </div>
                    </div>
            </div>
        </div>
    </div>

    @foreach ($item as $it => $ite)
        <div class="modal fade" id="mcorderqizil{{$it}}">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 85%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">{{$pharmacy[$it]}} dorixonasidagi zagruzkalar bo'yicha</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">
                            <div class="row">
                                    @foreach ($ite as $l => $w)
                                    @if (isset($w[3]))
                                        @foreach ($w[3] as $z => $n)
                                            @if ($n['xolat'] == 2 && $n['qarz'] !=0 )
                                                <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap delcat">
                                                    <div style="border-radius:26px;" class="card regionmc">
                                                    <div class="d-flex">
                                                        <div class="card-body">
                                                            <div class="dash-contetnt">
                                                            <h5 style="color:#ffffff;text-align:left;font-size:30px;font-family:Gilroy;">{{$orders[$l]}}</h5>
                                                                    <h6 style="color:#f17979;text-align:left;margin-left:0px;">
                                                                        <span title="110.000">
                                                                        <span class="numberpr">
                                                                            
                                                                            {{bmk($n['qarz'])}}
                                                                        </span>
                                                                        </span>
                                                                    </h6>
                                                            </div>
                                                        </div>
                                                        <div class="card-body text-right">
                                                            <div class="dash-contetnt text-right">
                                                                <h5 style="color:#ffffff;font-size:30px;font-family:Gilroy;">
                                                                    {{date('d.m.Y',strtotime($z))}}
                                                                </h5>
                                                                <h6 style="color:#f17979;margin-left:0px;">
                                                                    <span class="numberpr">
                                                                        
                                                                        {{($n['kun'])}} kun
                                                                    </span>
                                                                    </span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>

                                            @endif
                                        @endforeach
                                    @endif
                                    {{-- <h2>{{$l}}</h2> --}}
                                    {{-- @if (isset($qizil_mc[$l]))

                                        @foreach ($w as $m => $x)
                                        @if (isset($qizil_mc[$m]))

                                            <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap delcat">
                                                <div style="border-radius:26px;" class="card regionmc">
                                                <div class="card-body">
                                                    <div class="dash-contetnt">
                                                    <h2 style="color:#ffffff;text-align:left;font-size:30px;font-family:Gilroy;">{{$orders[$l]}}</h2>
                                                            <h3 style="color:#f17979;text-align:left;margin-left:0px;">
                                                                <span title="110.000">
                                                                <span class="numberpr">
                                                                    
                                                                    {{($qizil_mc[$m])}}
                                                                </span>
                                                                </span>
                                                            </h3>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        @endif
                                        @endforeach

                                        
                                    @endif --}}

                                    @endforeach


                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="mcordersariq{{$it}}">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 85%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">{{$pharmacy[$it]}} dorixonasidagi zagruzkalar bo'yicha</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">
                            <div class="row">
                                    @foreach ($ite as $l => $w)
                                    @if (isset($w[3]))
                                        @foreach ($w[3] as $z => $n)
                                            @if ($n['xolat'] == 1 && $n['qarz'] !=0 )
                                                <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap delcat">
                                                    <div style="border-radius:26px;" class="card regionmc">
                                                    <div class="d-flex">
                                                        <div class="card-body">
                                                            <div class="dash-contetnt">
                                                            <h5 style="color:#ffffff;text-align:left;font-size:30px;font-family:Gilroy;">{{$orders[$l]}}</h5>
                                                                    <h6 style="color:#b7ca4b;text-align:left;margin-left:0px;">
                                                                        <span title="110.000">
                                                                        <span class="numberpr">
                                                                            
                                                                            {{bmk($n['qarz'])}}
                                                                        </span>
                                                                        </span>
                                                                    </h6>
                                                            </div>
                                                        </div>
                                                        <div class="card-body text-right">
                                                            <div class="dash-contetnt text-right">
                                                                <h5 style="color:#ffffff;font-size:30px;font-family:Gilroy;">
                                                                    {{date('d.m.Y',strtotime($z))}}
                                                                </h5>
                                                                <h6 style="color:#b7ca4b;margin-left:0px;">
                                                                    <span class="numberpr">
                                                                        
                                                                        {{($n['kun'])}} kun
                                                                    </span>
                                                                    </span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>

                                            @endif
                                        @endforeach
                                    @endif
                                    {{-- <h2>{{$l}}</h2> --}}
                                    {{-- @if (isset($qizil_mc[$l]))

                                        @foreach ($w as $m => $x)
                                        @if (isset($qizil_mc[$m]))

                                            <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap delcat">
                                                <div style="border-radius:26px;" class="card regionmc">
                                                <div class="card-body">
                                                    <div class="dash-contetnt">
                                                    <h2 style="color:#ffffff;text-align:left;font-size:30px;font-family:Gilroy;">{{$orders[$l]}}</h2>
                                                            <h3 style="color:#f17979;text-align:left;margin-left:0px;">
                                                                <span title="110.000">
                                                                <span class="numberpr">
                                                                    
                                                                    {{($qizil_mc[$m])}}
                                                                </span>
                                                                </span>
                                                            </h3>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        @endif
                                        @endforeach

                                        
                                    @endif --}}

                                    @endforeach


                            </div>
                        </div>
                </div>
            </div>
        </div>
    @endforeach


    @endforeach

    <div class="modal fade" id="rekregion">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 95%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Viloyatlat boyicha</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            @foreach ($regions as $key => $item)
                            @php
                                if(isset($yashil_region[$key]))
                                {
                                    $y = array_sum($yashil_region[$key]);
                                }else{
                                    $y = 0;
                                }
                                if(isset($sariq_region[$key]))
                                {
                                    $s = array_sum($sariq_region[$key]);
                                }else{
                                    $s = 0;
                                }
                                if(isset($qizil_region[$key]))
                                {
                                    $q = array_sum($qizil_region[$key]);
                                }else{
                                    $q = 0;
                                }
                            @endphp
                            @if( ($y + $s + $q) != 0)
                                <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap delcat">
                                    <div style="border-radius:26px;" class="card regionmc">
                                    <div class="card-body">
                                        <div class="dash-contetnt">
                                        <h2 style="color:#ffffff;text-align:left;font-size:30px;font-family:Gilroy;">{{$item}}</h2>
                                            @if (isset($yashil_region[$key]))
                                                <h3 style="color:#ffffff;text-align:left;margin-left:0px;">
                                                    <span title="110.000">
                                                    <span class="numberpr">
                                                        
                                                        {{bmk(array_sum($yashil_region[$key]))}}
                                                    </span>
                                                    </span>
                                                </h3>
                                            @endif
                                            @if (isset($qizil_region[$key]))
                                                <h3 style="color:#f17979;text-align:left;margin-left:0px;">
                                                    <span title="110.000">
                                                    <span class="numberpr">
                                                        
                                                        {{bmk(array_sum($qizil_region[$key]))}}
                                                    </span>
                                                    {{-- <i style="cursor: pointer;font-size:20px" class="fas fa-eye" data-toggle="modal"
                                                        data-target="#mcpharqizil{{$key}}"></i> --}}
                                                    </span>
                                                </h3>
                                            @endif
                                            @if (isset($sariq_region[$key]))
                                                <h3 style="color:#b7ca4b;text-align:left;margin-left:0px;">
                                                    <span title="110.000">
                                                    <span class="numberpr">
                                                        
                                                        {{bmk(array_sum($sariq_region[$key]))}}
                                                    </span>
                                                    {{-- <i style="cursor: pointer;font-size:20px" class="fas fa-eye" data-toggle="modal"
                                                        data-target="#mcpharsariq{{$key}}"></i> --}}
                                                    </span>
                                                </h3>
                                            @endif
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @endif
                             

                            @endforeach


                        </div>
                    </div>
            </div>
        </div>
    </div>

@endsection