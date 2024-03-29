@extends('admin.layouts.app')
@section('admin_content')

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
    <div class="content main-wrapper ">
        <div class="row gold-box">
            @include('admin.components.logo')
            <div class="card flex-fill mt-5">

                <div class="btn-group mr-5 ml-auto">
                    <div class="row">
                        <div class="col-md-12" align="center">
                            Sana
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2"
                                name="a_all" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $dateText }} </button>
                            <div class="dropdown-menu timeclass">
                                <a href="{{ route('pharmacy-users', ['time' => 'today']) }}" class="dropdown-item">Bugun</a>
                                <a href="{{ route('pharmacy-users', ['time' => 'week']) }}" class="dropdown-item">Hafta</a>
                                <a href="{{ route('pharmacy-users', ['time' => 'month']) }}" class="dropdown-item">Oy</a>
                                <a href="{{ route('pharmacy-users', ['time' => 'year']) }}" class="dropdown-item">Yil</a>
                                <a href="{{ route('pharmacy-users', ['time' => 'all']) }}" class="dropdown-item"
                                    id="aftertime">Hammasi</a>
                                <input type="text" name="datetimes" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Add Pharm section --}}
                <div class="btn-group mt-3 mr-5 ml-auto">
                    <div class="row">
                        <div class="col-md-12" align="center">
                            <button class="btn btn-success btn-block" data-toggle="modal" data-target="#createPharm">
                                + Apteka qo'shish
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Add Pharm section --}}
            </div>
        </div>
        <div class="content container-fluid headbot">
            <div class="row">
                @foreach ($pharmacy as $item)
                    @if (isset($item->pharmacy[0]))
                        <div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap">
                            <div class="card detail-box1">
                                <div class="card-body">
                                    <div class="dash-contetnt">
                                        <h4 class="text-white" style="text-align: center"> {{ $item->name }} </h4>
                                        <div class="row">
                                            @foreach ($item->pharmacy as $pharma)
                                                {{-- @if ($pharma->region == $item) --}}
                                                <div class="col-4 col-md-4 col-lg-4 d-flex flex-wrap">
                                                    <div class="card detail-box2">
                                                        <div class="card-body">
                                                            <div class="dash-contetnt">
                                                                <h1 class="text-white" style="text-align: center">
                                                                    <a
                                                                        href="{{ route('pharmacy', ['id' => $pharma->id, 'time' => 'today']) }}">
                                                                        {{ $pharma->name }}
                                                                    </a>
                                                                    {{-- @isset($farm_sold[$pharma->id]) 
                                                        <span class="badge bg-primary">
                                                            {{ number_format($farm_sold[$pharma->id], 0, '', '.') }}
                                                        </span>
                                                        @endisset --}}
                                                                    @php
                                                                        $sum_elchi = 0;
                                                                    @endphp
                                                                    @foreach ($pusers as $user)
                                                                        @if ($user->pharma_id == $pharma->id)
                                                                            @isset($user_sold[$user->pharma_id][$user->user_id])
                                                                                @php
                                                                                    // foreach ($user_sold[$user->pharma_id] as $key => $value) {
                                                                                        $sum_elchi = $sum_elchi + $user_sold[$user->pharma_id][$user->user_id];
                                                                                    // }
                                                                                @endphp
                                                                            @endisset
                                                                        @endif
                                                                    @endforeach
                                                                    <span class="badge bg-primary">
                                                                        {{ number_format($sum_elchi, 0, '', '.') }}
                                                                    </span>

                                                                </h1>
                                                                @foreach ($pusers as $user)
                                                                    @if ($user->pharma_id == $pharma->id)
                                                                        <h2 class="text-white">{{ $user->last_name }}
                                                                            {{ $user->first_name }}
                                                                            @isset($user_sold[$user->pharma_id][$user->user_id])
                                                                                <span class="badge bg-primary">
                                                                                    {{-- @foreach ($user_sold[$user->pharma_id] as $key=>$item) --}}
                                                                                    {{ number_format($user_sold[$user->pharma_id][$user->user_id], 0, '', '.') }}
                                                                                    {{-- @endforeach --}}
                                                                                </span>
                                                                            @endisset
                                                                        </h2>
                                                                    @endif
                                                                @endforeach
                                                                @isset(Session::get('per')['farm_pm'])
                                                                    @if (Session::get('per')['farm_pm'] == 'true')
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <button type="submit" style="width:100%;"
                                                                                    class="btn btn-primary" data-toggle="modal"
                                                                                    data-target="#addmember{{ $pharma->id }}">
                                                                                    <i class="fas fa-plus"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <button type="submit" style="width:100%;"
                                                                                    class="btn btn-danger" data-toggle="modal"
                                                                                    data-target="#minusmember{{ $pharma->id }}">
                                                                                    <i class="fas fa-minus"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endisset
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- @endif --}}
                                            @endforeach
                                        </div>
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

    <div class="modal fade" id="createPharm">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apteka yaratish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('add-new-pharm.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="pharm-name">Apteka nomini kiriting</label>
                        <input class="form-control" type="text" name="pharm_name" id="pharm-name">
                        <ul class="list-group mt-2">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <select class="form-control form-control-sm" name='region_id' required>
                                        <option value="" disabled selected hidden>Viloyatni tanlang</option>
                                        @foreach ($regions as $region)
                                            <option value='{{ $region->id }}'>
                                                {{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </ul>
                        <ul class="list-group mt-2">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <select class="form-control form-control-sm" name='shablon_id' required>
                                        <option value="" disabled selected hidden>Narxni shablonini tanlang</option>
                                        @foreach ($shablons as $shablon)
                                            <option value='{{ $shablon->id }}'>
                                                {{ $shablon->name }}
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


    {{-- @foreach ($teams as $item) --}}
    @foreach ($pharmacy as $item)
        @foreach ($item->pharmacy as $pharma)
            <div class="modal fade" id="addmember{{ $pharma->id }}">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">{{ $pharma->name }}
                                {{-- <button type="submit" class="btn btn-outline-primary btn-sm ml-3"> 
                        <i class="fas fa-plus"></i> 
                    </button> --}}
                            </h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <form action="{{ route('user-add-pharma.store') }}" method="POST">

                            <div class="modal-body">
                                <ul class="list-group">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <select class="form-control form-control-sm" name='user_id' required>
                                                <option value="" disabled selected hidden>Elchini tanlang</option>
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}"">{{ $item->last_name }}
                                                        {{ $item->first_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12" style="display: none">
                                            <input type="number" value="{{ $pharma->id }}" name="team_id">
                                        </div>

                                    </div>

                                </ul>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Saqlash</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
            <div class="modal fade" id="minusmember{{ $pharma->id }}">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ $pharma->name }}
                            </h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form action="{{ route('user-delete-pharma.store') }}" method="POST">

                            <div class="modal-body">
                                <ul class="list-group">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <select class="form-control form-control-sm" name='user_id' required>
                                                <option value="" disabled selected hidden>Elchini tanlang</option>
                                                @foreach ($pusers as $user)
                                                    @if ($user->pharma_id == $pharma->id)
                                                        <option value='{{ $user->user_id }}'>{{ $user->last_name }}
                                                            {{ $user->first_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12" style="display: none">
                                            <input type="number" value="{{ $pharma->id }}" name="team_id">
                                        </div>

                                    </div>

                                </ul>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Saqlash</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
    {{-- @endforeach --}}
@endsection
@section('admin_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css"></script>
    <script>
        $(function () {
            $("select").select2();
        });
   $(function() {
  $('input[name="datetimes"]').daterangepicker({
    locale: {
      format: 'DD.MM.YY'
    }
  });
  $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
         window.location = $(this).data("href");
         var tim = picker.startDate.format('YYYY-MM-DD')+'_'+picker.endDate.format('YYYY-MM-DD');
         var id = <?php echo json_encode($pharma->id); ?>;
            var url = "{{ route('pharmacy-users',['time' => ':tim']) }}";
            url = url.replace(':tim', tim);
            url = url.replace(':id', id);
            location.href = url;

  });

});
</script>
@endsection
