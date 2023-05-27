<div class="modal-content">
    <style>
        .battleInfoBody img,
        .battleInfoBody iframe {
            width: 100% !important;
        }
    </style>
    <div class="modal-header p-0" style="position:relative;height:50px;background:#384b5e">
        <button type="button" class="close" data-dismiss="modal" aria-label="allNews"
            style="opacity: 5;position:absolute;top:8px;right:10px;z-index:20">
            <img src="{{ asset('news/close.png') }}" width="30px">
        </button>
        <div class="supercell d-flex align-items-center justify-content-center"
            style="position:absolute;top:0px;left:0;right:0;font-size:22px">
            <div class="text-white pt-1 pl-0"
                style="text-shadow: -1px 4px 0 #000, 3px 1px 0 #000, 3px -1px 0 #000, -1px -1px 0 #000">
                <div class="pl-0">Informatsiya</div>
            </div>
        </div>
    </div>
    <div class="d-none">
        @foreach ($infoIds as $inf)
            <button id="showInfo{{ $inf }}" wire:click="$emit('showInfo', {{ $inf }})"></button>
        @endforeach
    </div>
    @if ($info)
        <div class="modal-body p-0" style="position: relative;">
            {{-- @if ($info->img)
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="d-flex justify-content-center align-items-center"
                                style="width:100%;height:300px;overflow:hidden">
                                <img class="d-block w-100" src="{{ asset($info->img) }}" alt="First slide">
                            </div>
                        </div>
                    </div>
                </div>
            @endif --}}
            <div style="position: relative;overflow:hidden">
                <div style="margin: 0 5px;background:#f5f7fe" class="py-4 px-1">
                    <div>
                        <div class="d-flex align-items-center justify-content-between" style="margin-bottom: 20px;">
                            <div class="d-flex align-items-center justify-content-center">
                                <div style="font-size:12px;color:blue;font-weight:500">
                                    Info
                                </div>
                                <div class="ml-3" style="font-weight:500;font-size:12px;color:#78787c">
                                    {{ getMonthName(date('F', strtotime($info->created_at))) . ' ' }}
                                    {{ date('d', strtotime($info->created_at)) }},
                                    {{ date('Y', strtotime($info->created_at)) }}
                                </div>
                            </div>
                        </div>
                        <div class="supercell"
                            style="font-weight:600;overflow:hidden;font-size:17px;margin-bottom: 20px;">
                            {{ $info->title }}
                        </div>
                        <div class="battleInfoBody">
                            <?php echo htmlspecialchars_decode(htmlentities($info->desc)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
