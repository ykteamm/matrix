<div class="modal-content">
    <style>
        .battleVideoBody img,
        .battleVideoBody iframe {
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
                Video
            </div>
        </div>
    </div>
    <div class="d-none">
        @foreach ($videoIds as $vidid)
            <button id="showVid{{ $vidid }}" wire:click="$emit('showVid', {{ $vidid }})"></button>
        @endforeach
    </div>
    @if ($video)
        <div class="modal-body p-0" style="position: relative; margin-bottom:5px">
            <div>
                <iframe style="width: 100%;height:260px" frameborder="0" allowfullscreen=""
                src="https://www.youtube-nocookie.com/embed/{{ substr($video->url, 32) }}?wmode=opaque&amp;start=0"
                data-youtube-id="{{ substr($video->url, 32) }}"></iframe>
            </div>
            <div style="position: relative;margin-top:-5px;overflow:hidden">
                <div style="margin: 0 5px;background:#f5f7fe" class="pt-4 px-1">
                    <div>
                        <div class="d-flex align-items-center justify-content-between" style="margin-bottom: 20px;">
                            <div class="d-flex align-items-center justify-content-center">
                                <div style="font-size:12px;color:blue;font-weight:500">
                                    Video
                                </div>
                                <div class="ml-3" style="font-weight:500;font-size:12px;color:#78787c">
                                    {{ getMonthName(date('F', strtotime($video->created_at))) . ' ' }}
                                    {{ date('d', strtotime($video->created_at)) }},
                                    {{ date('Y', strtotime($video->created_at)) }}
                                </div>
                            </div>
                        </div>
                        <div class="supercell"
                            style="font-weight:600;overflow:hidden;font-size:17px;margin-bottom: 20px;">
                            {{ $video->title }}
                        </div>
                        <div class="battleVideoBody">
                            <?php echo htmlspecialchars_decode(htmlentities($video->desc)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
