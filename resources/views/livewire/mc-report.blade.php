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
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="dtBasicExample12333">
                            <thead>
                            <tr>
                                <th>Bron olish
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createBron">
                                        <i class="fas fa-plus" ></i>
                                    </button>
                                </th>
                                <th>Razgavor</th>
                                <th>Bron berish</th>
                                <th>Otgruzka</th>
                                <th>Pul kelishi</th>
                                <th>Zavod qarz</th>
                                <th>Otkaz</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($regions as $reg => $val)
                                {{-- @php
                                    $name = App\Models\Region::find($reg)->name;
                                @endphp --}}
                                    <tr data-toggle="collapse" data-target="#accordion{{$val->id}}" class="clickable">
                                            <td>{{$val->name}}. {{$bron_olish[$val->id]}}</td>
                                            <td>{{$val->name}}. {{$razgavor[$val->id]}}</td>
                                            <td>4</td>
                                            <td>4</td>
                                            <td>4</td>
                                            <td>4</td>
                                            <td>{{$val->name}}. {{$otkaz[$val->id]}}</td>
                                    </tr>

                                    {{-- @if (isset($brons[$reg])) --}}
                                    <div id="accordion{{$val->id}}" class="collapse">

                                                <tr>
                                                    <td>
                                                        @if (isset($brons[$val->id]))
                                                            @foreach ($brons[$val->id] as $d => $t)
                                                                @php
                                                                    $name = App\Models\Pharmacy::find($t->pharmacy_id)->name;
                                                                @endphp
                                                                <p>
                                                                    {{$name}}. {{$t->bron_puli}}
                                                                    <button wire:click="status1({{$t->id}})"> <i class="fas fa-arrow-right"></i> </button>
                                                                    <button wire:click="status3({{$t->id}})"> <i class="fas fa-trash"></i> </button>
                                                                </p>

                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($razgavor_brons[$val->id]))
                                                            @foreach ($razgavor_brons[$val->id] as $d => $t)
                                                                @php
                                                                    $name = App\Models\Pharmacy::find($t->pharmacy_id)->name;
                                                                @endphp
                                                                <p>
                                                                    {{$name}}. {{$t->bron_puli}}
                                                                    <button wire:click="status0({{$t->id}})"> <i class="fas fa-arrow-left"></i> </button>
                                                                    <button wire:click="status3({{$t->id}})"> <i class="fas fa-trash"></i> </button>
                                                                </p>

                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>5</td>
                                                    <td>5</td>
                                                    <td>5</td>
                                                    <td>5</td>
                                                    <td>
                                                        @if (isset($otkaz_brons[$val->id]))
                                                            @foreach ($otkaz_brons[$val->id] as $d => $t)
                                                                @php
                                                                    $name = App\Models\Pharmacy::find($t->pharmacy_id)->name;
                                                                @endphp
                                                                <p>
                                                                    {{$name}}. {{$t->bron_puli}}
                                                                    <button wire:click="status0({{$t->id}})"> <i class="fas fa-arrow-left"></i> </button>
                                                                </p>

                                                            @endforeach
                                                        @endif
                                                    </td>
                                                </tr>
                                    </div>

                                @endforeach



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createBron">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bron yaratish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('report-save') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="pharm-name">Pul miqdorini kiriting</label>
                        <input class="form-control" type="number" name="bron_puli" id="pharm-name">
                        <label>Vaqt kiriting</label>
                        <input class="form-control" type="date" name="date">
                        <ul class="list-group mt-2">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <select class="form-control form-control-sm" name='pharmacy_id' required>
                                        <option value="" disabled selected hidden>Apteka tanlang</option>
                                        @foreach ($pharmacy as $region)
                                            <option value='{{ $region->id }}'>
                                                {{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </ul>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Yaratish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
