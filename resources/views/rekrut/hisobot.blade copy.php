@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box">
            @include('admin.components.logo')

        </div>
        <div class="row headbot">
            <div class="col-sm-12">
                <div class="card mt-5">
                    <div class="row">
                        @foreach ($reg as $r)
                        <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap delregion">
                            <div class="card detail-box1">
                                <div class="card-body">
                                    <div class="dash-contetnt">
                                        <div class="justify-content-between">
                                            <h3 class="mt-2" style="color:white;height:45px;cursor:pointer;"
                                                data-toggle="modal" data-target="#addmemberwer13">{{$r['region']}}</h3>
                                        </div>
                                        <div class="justify-content-between mt-3">
                                            <div class="row pl-3 pr-3">
                                                @foreach ($r['data'] as $d)
                                                @php
                                                    if ($d->status == 0) {
                                                        $col = '#ffffff';
                                                        $icon = '';
                                                    } elseif($d->status == 1) {
                                                        $col = '#0bf24f';
                                                        $icon = '<i class="fas fa-check"></i>';

                                                    }else{
                                                        $col = '#f20b0b';
                                                        $icon = '<i class="fas fa-window-close"></i>';

                                                    }
                                                @endphp
                                                    <div style="background:#323584;border-radius:8px;box-shadow: 0px 0px 7px 5px {{$col}};
                                                        cursor:pointer"
                                                        class="justify-content-between col-12 col-md-12 col-lg-12 mt-4"
                                                        data-toggle="collapse" data-target="#collapseOne{{$d->id}}" aria-expanded="false" aria-controls="collapseOne{{$d->id}}"
                                                        >

                                                        <div class="accordion" id="accordionExample">

                                                            <div class="d-flex justify-content-between">
                                                                <span
                                                            style="font-size:20px;color:white;"
                                                            class="mt-1"

                                                            >{{$d->fname}}</span>
                                                            <span
                                                                style="font-size:20px;color:white;"
                                                                class="mt-1"

                                                                >
                                                                @if ($d->status == 0)
                                                                @elseif($d->status == 1)
                                                                    <i class="fas fa-check" style="color: rgb(3, 255, 3)"></i>
                                                                @else
                                                                    <i class="fas fa-window-close" style="color: red"></i>
                                                                @endif
                                                            </span>
                                                            </div>

                                                            <div id="collapseOne{{$d->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                                <div class="card-body text-white">
                                                                   {{$d->comment}}
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
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin_script')
    <script>
        function rekrutSuccess(id) {
            var comment = $(`#rekruting${id}`).val();

            if (comment.length > 5) {
                $('.rekrutbutton').addClass('d-none');
                $('.rekrutbutton2').removeClass('d-none');
                $(`.rekrutinput${id}`).val(1);
                $(`#rekrutform${id}`).submit();
            }

        }

        function rekrutCancel(id) {
            var comment = $(`#rekruting${id}`).val();

            if (comment.length > 5) {
                $('.rekrutbutton').addClass('d-none');
                $('.rekrutbutton2').removeClass('d-none');
                $(`.rekrutinput${id}`).val(2);
                $(`#rekrutform${id}`).submit();
            }

        }

        function districts() {
            var region = $('#aioConceptName').find(":selected").val();
            $('.aioConceptNameDist').addClass('d-none');
            $(`.distreg${region}`).removeClass('d-none');
        }
    </script>
@endsection
