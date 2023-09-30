<div class="mt-4 card flex-fill">
    <div style="border-bottom-radius:30px !important;margin-left:auto">
        <div class="justify-content-between align-items-center p-2 mr-5 mt-3 mr-5" >

            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{$region_name}}
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" wire:click="$emit('change_Region','all')" >Barchasi</a>

                    @foreach ($regions as $region)
                        <a class="dropdown-item" href="#" wire:click="$emit('change_Region',{{$region->id}})" >{{$region->name}}</a>
                    @endforeach
                <div class="dropdown-divider"></div>
                </div>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{$xolat_name}}
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" wire:click="$emit('change_Xolat','all')" >Barchasi</a>

                    @foreach ($xolat as $k => $x)
                        <a class="dropdown-item" href="#" wire:click="$emit('change_Xolat',{{$k}})">{{$x}}</a>
                    @endforeach
                <div class="dropdown-divider"></div>
                </div>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Yosh
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">20 yoshgacha</a>
                    <a class="dropdown-item" href="#">20 - 30</a>
                    <a class="dropdown-item" href="#">30 - 40</a>
                    <a class="dropdown-item" href="#">40 - 50</a>
                    <a class="dropdown-item" href="#">50 dan katta</a>
                <div class="dropdown-divider"></div>
                </div>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Sana
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Bugun</a>
                    <a class="dropdown-item" href="#">Kecha</a>
                    <a class="dropdown-item" href="#">Shu hafta</a>
                    <a class="dropdown-item" href="#">Shu Oy</a>
                    <a class="dropdown-item" href="#">
                        <input type="date" value="">
                    </a>
                <div class="dropdown-divider"></div>
                </div>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Guruh
                </button>
                <div class="dropdown-menu">
                    @foreach ($gurux as $g)
                        <a class="dropdown-item" href="#">{{$g->title}} 
                            <p>( {{date('d.m',strtotime($g->begin))}} - {{date('d.m',strtotime($g->end))}})</p>
                        </a>
                    @endforeach
                <div class="dropdown-divider"></div>
                </div>
            </div>


        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>FIO</th>
                        <th>Viloyat</th>
                        <th>Telefon</th>
                        <th>Xolat</th>
                        <th>Yosh</th>
                        <th>Grafik</th>
                        <th>Gurux</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekruts as $item)
                        <tr>
                            <td>{{$item->full_name}}</td>
                            <td>
                                @if (isset($item->region->name))
                                    {{$item->region->name}}
                                @else
                                @endif
                            </td>
                            <td>{{$item->phone}}</td>
                            <td>
                                @if ($item->xolat == 1)
                                    O'ylab koradi
                                @elseif($item->xolat == 2)
                                    Telefon ko'tarmadi
                                @elseif($item->xolat == 3)
                                    O'qishga keladi
                                @elseif($item->xolat == 4)
                                    Ustoz bilan gaplashadi
                                @elseif($item->xolat == 5)
                                    Uyi uzoq
                                @elseif($item->xolat == 6)
                                    O'qishga kelolmaydi lekin ishlaydi
                                @elseif($item->xolat == 7)
                                    Ishlamaydi
                                @endif  
                            </td>
                            <td>{{$item->age}}</td>
                            <td>
                                @if ($item->grafik == 1)
                                    Toliq smena
                                @elseif($item->grafik == 2)
                                    Yarim smena
                                @else

                                @endif
                            </td>
                            <td>
                                @if (isset($item->group->title))
                                    {{$item->group->title}}
                                @else
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>
