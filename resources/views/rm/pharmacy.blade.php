@extends('admin.layouts.app')
@section('admin_content')
@isset(Session::get('per')['dash'])
    @if(Session::get('per')['dash'] == 'true')
    <div class="content mt-1 main-wrapper ">
        <div class="row gold-box">
        @include('admin.components.logo')
        <div class="card flex-fill">
         <div style="border-bottom-radius:30px !important;margin-left:auto">
    
          <div class="justify-content-between align-items-center p-2" >
    
            <div class="btn-group mr-5 ml-auto">
              <div class="row">
                 <div class="col-md-12" align="center">
                          Viloyat
                 </div>
                 <div class="col-md-12">
                    <button type="button" id="reg_user" name="{{$region}}" class="btn btn-block btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$region_name}} </button>
                    <div class="dropdown-menu timeclass">
                        <a type="button" onclick="region(`all`,`Barchasi`)" class="dropdown-item">Barchasi</a>

                        @foreach ($regions as $key => $item)
                            <a type="button" onclick="region(`{{$item->id}}`,`{{$item->name}}`)" class="dropdown-item">{{$item->name}}</a>
                        @endforeach
                    </div>
                 </div>
              </div>
            </div>
            <div class="btn-group mr-5 ml-auto">
                <div class="row">
                   <div class="col-md-12" align="center">
                            Sana
                   </div>
                   <div class="col-md-12">
                      <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="time_user" name="{{$time}}"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$time_text}} </button>
                      <div class="dropdown-menu timeclass">
                         <a type="button" onclick="times('last','Kecha')" class="dropdown-item">Kecha</a>
                         <a type="button" onclick="times('today','Bugun')" class="dropdown-item">Bugun</a>
                         <a type="button" onclick="times('week','Hafta')" class="dropdown-item">Hafta</a>
                         <a type="button" onclick="times('month','Oy')" class="dropdown-item">Oy</a>
                         <a type="button" onclick="times('year','Yil')" class="dropdown-item">Yil</a>
                         <a type="button" onclick="times('all','Hammasi')" class="dropdown-item" id="aftertime">Hammasi</a>
                         <input type="text" name="datetimes" class="form-control"/>
                      </div>
                   </div>
                </div>
            </div>
            <div class="btn-group mr-5 ml-auto">
                <div class="row">
                   <div class="col-md-12 mt-4">
                      <button type="button" onclick="search()" class="btn btn-block btn-outline-primary"> Qidirish </button>
                   </div>
                </div>
            </div>
        </div>
    </div>  
         </div>
        </div>
        <div class="card headbot">
            <div class="card-header no-border">
            <h5 class="card-title"> Elchilar reytingi </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead>
                            <tr>
                            <th># </th>
                            <th>Dorixona </th>
                            <th>Summa </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $item)
                            <tr>
                                <td>#{{$key+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{number_format($item->allprice,0,'','.')}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    @endif
@endisset
@endsection
@section('admin_script')
    <script>
        function region(id,name)
        {
            $('#reg_user').text(name);
            $('#reg_user').attr('name',id);
        }
        function times(id,name)
        {
            $('#time_user').text(name);
            $('#time_user').attr('name',id);
        }
        function search()
        {
            var region = $('#reg_user').attr('name');
            var time = $('#time_user').attr('name');

            var url = "{{ route('rm-pharmacy',['region' => ':region','time' => ':time']) }}";
            url = url.replace(':time', time);
            url = url.replace(':region', region);
            location.href = url;
        }
        $(function() {
        $('input[name="datetimes"]').daterangepicker({
            locale: {
            format: 'DD.MM.YY'
            }
        });
        $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
                var tim = picker.startDate.format('YYYY-MM-DD')+'_'+picker.endDate.format('YYYY-MM-DD');
                $('#time_user').text(tim);
                $('#time_user').attr('name',tim);
        });

        });
    </script>
@endsection
