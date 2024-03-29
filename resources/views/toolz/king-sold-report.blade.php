@extends('admin.layouts.app')
@section('admin_content')
    <div class="content mt-1 main-wrapper">
        <div class="row gold-box">
            @include('admin.components.logo')

            <div class="card flex-fill">

                <div class="card flex-fill">
                    <div style="border-bottom-radius:30px !important;margin-left:auto">
                        <div class="justify-content-between align-items-center p-2">
                            <form action="{{ route('pro-list-search') }}" method="post">
                                <div class="btn-group">
                                    <div class="row">
                                        <div class="col-md-12" align="center">
                                            Viloyat
                                        </div>
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle"
                                                id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"> {{ $regText }}</button>
                                            <div class="dropdown-menu" style="left:150px !important">
                                                <a href="#" onclick="region('Hammasi','all')" class="dropdown-item"
                                                    id="tgregion"> Hammasi </a>
                                                @foreach ($regions as $region)
                                                    <a href="#" onclick="region(`{{ $region->name }}`,`{{ $region->id }}`)"
                                                        class="dropdown-item" id="tgregion"> {{ $region->name }} </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <div class="row">
                                        <div class="col-md-12" align="center">
                                            Elchi
                                        </div>
                                        <div class="col-md-12" style="">
                                            <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle"
                                                id="age_button3" name="{{ $pkey }}" data-toggle="dropdown"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ $pText }}</button>
                                            <div class="dropdown-menu"
                                                style="left:150px !important;overflow-y:scroll; height:400px;">
                                                <input type="search" onkeyup="filterKSB(this.value)" style="border:1px solid blue;border-radius:8px;" class="mr-3 ml-3 pr-2 pl-2">
                                                <a href="#" onclick="pharm('Hammasi','all')" class="dropdown-item"
                                                    id="tgregion"> Hammasi </a>
                                                @foreach ($users as $keyd => $p)
                                                    @if ($regkey == 'all')
                                                        <a href="#"
                                                            onclick="pharm(`{{ $p->last_name . '' . $p->first_name }}`,`{{ $p->id }}`)"
                                                            class="dropdown-item pharm{{ $p->region_id }} allpharm filter-ksb-name">
                                                            <span>{{ $p->last_name }} {{ $p->first_name }}</span> </a>
                                                    @else
                                                        <?php $pa = $p->region_id; ?>
                                                        @if ($regkey == $p->region_id)
                                                            <a href="#"
                                                                onclick="pharm(`{{ $p->last_name . '' . $p->first_name }}`,`{{ $p->id }}`)"
                                                                class="dropdown-item pharm{{ $p->region_id }} allpharm filter-ksb-name">
                                                                <span>{{ $p->last_name }} {{ $p->first_name }}</span> </a>
                                                        @else
                                                            <a style="display:none;" href="#"
                                                                onclick="pharm(`{{ $p->last_name . '' . $p->first_name }}`,`{{ $p->id }}`)"
                                                                class="dropdown-item pharm{{ $p->region_id }} allpharm filter-ksb-name">
                                                                <span>{{ $p->last_name }} {{ $p->first_name }}</span> </a>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <div class="row">
                                        <div class="col-md-12" align="center">
                                            Sana
                                        </div>
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle"
                                                id="age_button2" name="{{ $dateTexte }}" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"> {{ $dateText }} </button>
                                            <div class="dropdown-menu timeclass">
                                                <a href="#" onclick="dates('today','Bugun')"
                                                    class="dropdown-item">Bugun</a>
                                                <a href="#" onclick="dates('week','Hafta')"
                                                    class="dropdown-item">Hafta</a>
                                                <a href="#" onclick="dates('month','Oy')" class="dropdown-item">Oy</a>
                                                <a href="#" onclick="dates('year','Yil')"
                                                    class="dropdown-item">Yil</a>
                                                <a href="#" onclick="dates('all','Hammasi')" class="dropdown-item"
                                                    id="aftertime">Hammasi</a>
                                                <input type="text" name="datetimes" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group" style="margin-right:30px !important;margin-top:20px;">
                                    <div class="row">
                                        <div class="col-md-12" align="center">

                                        </div>
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-block btn-outline-primary"
                                                onclick="formButton()">Qidirish</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="row headbot">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div></div>
                        <div class="mb-0 mt-3">
                            {{-- <div class="table mb-0 " id="dtBasicExample12"> --}}
                            <div class="mt-5 mb-3">
                                <div class="mx-4 d-flex justify-content-between">
                                    <h4>Viloyat</h4>
                                    <h4>Soni </h4>
                                </div>
                            </div>  
                            <div class="bodyyyy">
                                @php
                                    $idd = 0;
                                    $totalSum = 0;
                                @endphp
                                @if ($region_id != 'all' ||  $user_id != 'all')
                                    <div class="table-responsive">
                                    <table class="table mb-0 " id="dtBasicExample12">
                                        <thead>
                                            <tr>
                                                <th>Ismi</th>
                                                <th>Familiyasi </th>
                                                <th>Soni </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            {{-- @php
                                                dd($total);
                                            @endphp --}}
                                            @foreach ($total as $item)
                                                @php
                                                    $totalSum += $item['count'];
                                                @endphp
                                                <tr>
                                                    <td>{{ $item['f'] }} </td>
                                                    <td>{{ $item['l'] }} </td>
                                                    <td>{{ $item['count'] }} </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                @else
                                @foreach ($total as $key => $regions)
                                    @php
                                        $idd += 1;
                                    @endphp
                                    <div class="accordion" id="accordionEx{{ $idd }}">
                                        <div class="card">
                                            <div class="card-header" id="headingItem{{ $idd }}">
                                                <div class="btn btn-block text-left collapsed d-flex justify-content-between"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#collapseThree{{ $idd }}" aria-expanded="false"
                                                    aria-controls="collapseThree{{ $idd }}">
                                                    <h5 class="mb-0">
                                                        {{ $key }}
                                                    </h5>
                                                    @php
                                                        $sum = 0;
                                                    @endphp
                                                    @foreach ($regions as $item)
                                                        @php
                                                            $sum += $item['count'];
                                                        @endphp
                                                    @endforeach
                                                    @php
                                                        $totalSum += $sum;
                                                    @endphp
                                                    <h5>
                                                        {{ $sum }}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div id="collapseThree{{ $idd }}" class="collapse"
                                                aria-labelledby="headingItem{{ $idd }}"
                                                data-parent="#accordionEx{{ $idd }}">
                                                <div class="card-body">

                                                    <div class="table-responsive">
                                                        <table class="table mb-0 " id="dtBasicExample12">
                                                            <thead>
                                                                <tr>
                                                                    <th>Ismi</th>
                                                                    <th>Familiyasi </th>
                                                                    <th>Soni </th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                @foreach ($regions as $item)
                                                                    <tr>
                                                                        <td>{{ $item['f'] }} </td>
                                                                        <td>{{ $item['l'] }} </td>
                                                                        <td>{{ $item['count'] }} </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-end">
                                <h5 class="mr-1">
                                    Jami:
                                </h5>
                                <h4>
                                    {{ $totalSum }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin_script')
    <script>
        function filterKSB(value)
        {
            $('.filter-ksb-name').each(function() {
               

               var str = $(this).text();
            //    console.log(str);

               if(str.toLowerCase().includes(value.toLowerCase()))
               {
                //   console.log(str);
                  $(this).css('display','');

               }else{
                  $(this).css('display','none');
               }
            });
        }
        function dates(key, text) {
            $('#age_button2').text(text);
            $('#age_button2').attr('name', key);
        }

        function formButton() {
            var region = $('#age_button').attr('name');
            var tim = $('#age_button2').attr('name');
            var pharm = $('#age_button3').attr('name');
            var url = "{{ route('king-sold', ['user_id' => ':pharm', 'region_id' => ':region', 'date' => ':tim']) }}";
            url = url.replace(':tim', tim);
            url = url.replace(':region', region);
            url = url.replace(':pharm', pharm);
            location.href = url;
        }

        function region(text, id) {
            $('#age_button').text(text);
            $('#age_button').attr('name', id);

            $('#age_button3').text('Hammasi');
            $('#age_button3').attr('name', 'all');
            if (id == 'all') {
                $('.allpharm').css('display', '');
            } else {
                $('.allpharm').css('display', 'none');
                $(`.pharm${id}`).css('display', '');
            }

        }

        function pharm(text, id) {
            $('#age_button3').text(text);
            $('#age_button3').attr('name', id);
        }

        function koproq(name) {
            $(`.${name}`).css('display', '');
            $(this).css('display', 'none');
        }
        $(function() {
            $('input[name="datetimes"]').daterangepicker({
                locale: {
                    format: 'DD.MM.YYYY'
                }
            });
            $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
                var tim2 = picker.startDate.format('DD.MM.YYYY') + '-' + picker.endDate.format(
                    'DD.MM.YYYY');
                var tim = picker.startDate.format('YYYY-MM-DD') + '_' + picker.endDate.format('YYYY-MM-DD');
                $('#age_button2').text(tim2);
                $('#age_button2').attr('name', tim);
            });
        });
    </script>
@endsection
