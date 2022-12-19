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
                    <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Barchasi </button>
                    <div class="dropdown-menu timeclass">
                        @foreach ($regions as $key => $item)
                            <a type="button" onclick="getRegion(`{{$item->name}}`,{{$item->id}})" class="dropdown-item">{{$item->name}}</a>
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
                      <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$users->dateText}} </button>
                      <div class="dropdown-menu timeclass">
                         <a href="{{route('rm-user',['date' => 'today'])}}" class="dropdown-item">Bugun</a>
                         <a href="{{route('rm-user',['date' => 'week'])}}" class="dropdown-item">Hafta</a>
                         <a href="{{route('rm-user',['date' => 'month'])}}" class="dropdown-item">Oy</a>
                         <a href="{{route('rm-user',['date' => 'year'])}}" class="dropdown-item">Yil</a>
                         <a href="{{route('rm-user',['date' => 'all'])}}" class="dropdown-item" id="aftertime">Hammasi</a>
                         <input type="text" name="datetimes" class="form-control"/>
                      </div>
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
                            <th>Elchi </th>
                            <th>Summa </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users->users as $key => $item)
                            <tr class="rm-user rm-user{{$item->region_id}}">
                                <td>#{{$key+1}}</td>
                                <td>{{$item->last_name}} {{$item->first_name}}</td>
                                <td>{{$item->allprice}}</td>
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
function getRegion($text,$id)
    {
        $('#age_button2').text($text);
        $('.rm-user').css('display','none');
        $(`.rm-user${$id}`).css('display','');
    }
$(function() {
    
    $('input[name="datetimes"]').daterangepicker({
      locale: {
        format: 'DD.MM.YY'
      }
    });
    $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
           window.location = $(this).data("href");
           var tim = picker.startDate.format('YYYY-MM-DD')+'_'+picker.endDate.format('YYYY-MM-DD');
              var url = "{{ route('rm-user',['date' => ':tim']) }}";
              url = url.replace(':tim', tim);
              location.href = url;
  
    });
  
  });
</script>

@endsection
