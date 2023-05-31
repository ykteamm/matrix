<div class="modal-content">
    <style>
        .news-menu-item {
            width: 32.2%;
            padding: 9px 25px;
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            box-sizing: border-box;
            background: #677e97;
            border-top: 1px solid #7fa0b8;
            border-left: 1px solid #7fa0b8;
            border-right: 1px solid #7fa0b8;
        }

        .news-menu-item.active {
            background: #aadff9;
            border-top: 1px solid #74d5ff;
            border-left: 1px solid #74d5ff;
            border-right: 1px solid #74d5ff;
        }

        .news-menu-item a {
            font-size: 13px;
            text-align: center;
            text-shadow: -1px 1px 0 #000,
                1px 1px 0 #000,
                1px -1px 0 #000,
                -1px -1px 0 #000;
        }

        .news-card-left {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
            padding-left: 1.5rem;
        }

        .news-card {
            overflow: hidden;
            margin-bottom: 30px;
            border-radius: 12px;
            box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
            font-size: 18px;
            /* background: #f7eaea; */
            background: #fff;
            color: #333
        }

        #newsBody img {
            width: 100%;
        }

        #newsBody iframe {
            width: 100%;
        }

        @media only screen and (max-width:500px) {
            #newsBody img {
                width: 100%;
            }
        }

        .battleNewsBody img,
        .battleNewsBody iframe {
            width: 100% !important;
        }

        [data-sceditor-emoticon] {
            width: 20px !important;
        }

        #newsBody iframe {
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
                Jang news
            </div>
        </div>
        {{-- <div style="position: absolute; bottom:3px;left:0;right:0">
            <ul class="mx-1 navbar-nav flex-row align-items-center justify-content-between">
                <li class="nav-item news-menu-item active">
                    <a class="nav-link p-0 text-white supercell" href="#">News</a>
                </li>
                <li class="nav-item news-menu-item">
                    <a class="nav-link p-0 text-white supercell" href="#">Tours</a>
                </li>
                <li class="nav-item news-menu-item">
                    <a class="nav-link p-0 text-white supercell" href="#">Moneys</a>
                </li>
            </ul>
        </div>
        <div style="position:absolute;height:1px;top:86px;background:#74d5ff;width:100%"></div> --}}
    </div>
    <div class="d-none">
        @foreach ($newsIds as $n)
            <button id="showNw{{ $n }}" wire:click="$emit('showNw', {{ $n }})"></button>
        @endforeach
    </div>
    @if ($nw)
        <div class="modal-body p-0" style="position: relative; margin-top:-2px">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-center align-items-center"
                            style="width:100%;overflow:hidden">
                            <img class="d-block w-100" src="{{ asset($nw->img) }}" alt="First slide">
                        </div>
                    </div>
                </div>
            </div>
            <div style="position: relative;overflow:hidden">
                <img width="100%" src="{{ asset('news/nwh.png') }}" alt="Img">
                <div style="padding: 10px;background:#9b8c9f;width:100%;margin-top:-10px">
                    <div style="border-radius:16px">
                        <div class="news-card border shadow" style="padding:20px;border-radius:16px">
                            <div class="d-flex align-items-center justify-content-between" style="margin-bottom: 20px;">
                                <div class="d-flex align-items-center justify-content-center">
                                    {{-- <div style="font-size:12px;color:blue;font-weight:500">
                                        News
                                    </div> --}}
                                    <div class="mr-1" style="font-weight:500;font-size:12px;color:#78787c">
                                        {{ getMonthName(date('F', strtotime($nw->created_at))) . ' ' }}
                                        {{ date('d', strtotime($nw->created_at)) }},
                                        {{ date('Y', strtotime($nw->created_at)) }}
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    @foreach ($emojies as $emoji)
                                        @if (isset($emoji->id))
                                            <button onclick="setReaction()"
                                                wire:click="$emit('reaction', {{ $emoji->id }})"
                                                class="d-flex align-items-center mr-1 btn btn-sm py-0 px-1 border border-1 @if ($reaction && $reaction->emoji_id == $emoji->id) btn-primary @endif">
                                                <span style="font-size:13px; font-weight:600">{{ $emoji->count }}</span>
                                                @if ($reaction && $reaction->emoji_id == $emoji->id)
                                                    <span style="font-size:17px"><?php echo htmlspecialchars_decode(htmlentities($emoji->icon)); ?></span>
                                                @else
                                                    <span style="font-size:17px;opacity:0.5"><?php echo htmlspecialchars_decode(htmlentities($emoji->icon)); ?></span>
                                                @endif
                                            </button>
                                        @else
                                            <button onclick="setReaction()"
                                                wire:click="$emit('reaction', {{ $emoji['id'] }})"
                                                class="d-flex align-items-center mr-1 btn btn-sm py-0 px-1 border border-1">
                                                <span
                                                    style="font-size:13px; font-weight:600">{{  $emoji['count'] }}</span>
                                                @if ($reaction && $reaction->emoji_id == $emoji['id'])
                                                    <span style="font-size:17px"><?php echo htmlspecialchars_decode(htmlentities($emoji['icon'])); ?></span>
                                                @else
                                                    <span style="font-size:17px;opacity:0.5"><?php echo htmlspecialchars_decode(htmlentities($emoji['icon'])); ?></span>
                                                @endif
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="supercell"
                                style="font-weight:600;overflow:hidden;font-size:17px;margin-bottom: 20px;">
                                {{ $nw->title }}
                            </div>
                            <div class="battleNewsBody">
                                <?php echo htmlspecialchars_decode(htmlentities($nw->desc)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <img style="margin-top:-33px" width="100%" src="{{ asset('news/nwf.png') }}" alt="Img">
            </div>
        </div>
    @endif
</div>
