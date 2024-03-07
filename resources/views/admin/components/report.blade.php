<div class="card-body bg-card-b mb-5 mt-2">
    <style>
        .btn-none-color{
            background-color: #323584;
            color: white;
        }
        .btn-none-color:hover{
            color: white;
        }
        .bg-card-b{
            background: #323584;
            border-radius: 5px;
        }
    </style>
    <div class="container">
        <div class="row">
            @isset(Session::get('per')['rekrut-atchot'])
                @if (Session::get('per')['rekrut-atchot'] == 'true')
                    <div class="col-auto">
                        <a href="{{ route('rekrut-hisobot') }}">
                            <button class="btn btn-none-color">
                                Rekrut
                            </button>
                        </a>
                    </div>
                @endif
            @endisset

            @isset(Session::get('per')['provizor-atchot'])
                @if (Session::get('per')['provizor-atchot'] == 'true')
                    <div class="col-auto">
                        <a href="{{ route('provizor-hisobot') }}">
                            <button class="btn btn-none-color">
                                Provizor
                            </button>
                        </a>
                    </div>
                @endif
            @endisset

            @isset(Session::get('per')['user_pharmacy'])
                @if (Session::get('per')['user_pharmacy'] == 'true')
                    <div class="col-auto">
                        <a href="{{ route('pharmacy-users', 'today') }}">
                            <button class="btn btn-none-color">
                                Dorixona
                            </button>
                        </a>
                    </div>
                @endif
            @endisset

            @isset(Session::get('per')['pro'])
                @if (Session::get('per')['pro'] == 'true')
                    <div class="col-auto">
                        <a href="{{ route('pro-list', ['time' => 'today', 'region' => 'all', 'pharm' => 'all']) }}">
                            <button class="btn btn-none-color">
                                Mahsulotlar
                            </button>
                        </a>
                    </div>
                @endif
            @endisset

            @isset(Session::get('per')['show_purchase'])
                @if (Session::get('per')['show_purchase'] == 'true')
                    <div class="col-auto">
                        <a href="{{ route('purchase.journal') }}">
                            <button class="btn btn-none-color">
                                Taxrirlash tarixi
                            </button>
                        </a>
                    </div>
                @endif
            @endisset

            @isset(Session::get('per')['oylik'])
                @if (Session::get('per')['oylik'] == 'true')
                    <div class="col-auto">
                        <a href="{{ route('user-money', ['region_id' => 5, 'month' => date('Y-m')]) }}">
                            <button class="btn btn-none-color">
                                Oylik
                            </button>
                        </a>
                    </div>
                @endif
            @endisset

{{--            @isset(Session::get('per')['now_work'])--}}
{{--               @if (Session::get('per')['now_work'] == 'true')--}}
                  <div class="col-auto">
                        <a href="{{ route('now_work')}}">
                            <button class="btn btn-none-color">
                                Hozir ishlayotganlar
                            </button>
                        </a>
                  </div>
{{--               @endif--}}
{{--            @endisset--}}

            @isset(Session::get('per')['trend'])
                @if (Session::get('per')['trend'] == 'true')
                    <div class="col-auto">
                        <div class="dropdown">
                            <button class="btn btn-none-color dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Trend
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('trend.region', 'three') }}">Viloyat</a>
                            <a class="dropdown-item" href="{{ route('trend.product', 'three') }}">Mahsulot</a>
                            <a class="dropdown-item" href="{{ route('trend.user', 'three') }}">Elchi</a>
                            <a class="dropdown-item" href="{{ route('trend.pharmacy', 'three') }}">Dorixona</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endisset

        </div>
    </div>

</div>
