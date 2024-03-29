@extends('admin.layouts.app')
@section('admin_content')
@isset(Session::get('per')['dash'])
             @if(Session::get('per')['dash'] == 'true')
<div class="content mt-1 main-wrapper ">
    <div class="row gold-box">
        @include('admin.components.logo')

      <div class="card flex-fill">

        <div class="btn-group mr-5 ml-auto">
           <div class="row">
                 <div class="col-md-12" align="center">
                          Sana
                 </div>
                 <div class="col-md-12">
                    <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Bugun </button>
                    <div class="dropdown-menu timeclass">
                    <a href="#" onclick="timeElchi('a_month')" class="dropdown-item" id="a_all">Oy</a>

                       <a href="#" onclick="timeElchi('a_today')" class="dropdown-item" id="a_today"> Bugun </a>
                       <a href="#" onclick="timeElchi('a_week')" class="dropdown-item" id="a_week">Hafta </a>
                       <a href="#" onclick="timeElchi('a_month')" class="dropdown-item" id="a_month">Oy  </a>
                       <a href="#" onclick="timeElchi('a_year')" class="dropdown-item" id="a_year">Yil </a>
                       {{-- <input type="date" class="form-control" id="date-input" onchange="getDate()"> --}}
                       <input type="text" name="datetimes" class="form-control"/>

                    </div>
                 </div>
           </div>

        </div>



     </div>
    </div>
    {{-- <div class="page-header"> --}}
        <div class="main-wrapper headbot">
            <div class="content">
                   <div class="col-xl-12 mt-3">
                       <h3 style="text-align: center">
                        Hush kelibsiz!  <span style="font-weight:bold;color:rgb(8, 175, 28)">{{Session::get('user')->first_name}}</span>
                       </h3>
                    </div>
                    <div class="row align-items-center justify-content-center" id="myregionid">
                    </div>
                    <div class="row" id="catid">
                    </div>
                    <div class="card flex-fill">

                        <div class="btn-group mr-5 ml-auto">
                           <div class="row">
                                 <div class="col-md-12" align="center">
                                          Viloyat
                                 </div>
                                <div class="col-md-12" style="text-align: center">

                                    <label class="switch">
                                        <input type="checkbox" checked id="checkslider" name="true" onchange="check()">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                        </div>

                        </div>

                     </div>
                        <div class="row" id="regionid">
                        </div>
                    <div class="row calender-col">
                      <div class="col-xl-12" id="forvil">
                         <div class="card" style="height: 62%">

                            <div class="row" id="myregionid">
                            </div>
                            <div class="row" id="catid">
                            </div>
                            <div class="row" id="regionid">
                            </div>
                            <div id="dchart">
                            <div id="rchart_del"></div>

                                <div id="rchart">
                                </div>
                            </div>

                            <div class="row calender-col">
                                <div class="col-xl-12" id="forvil">
                                    <div class="card">

                                        <div class="card-header">
                                        <div class="card bg-white">
                                                <div class="card-header">
                                                <h5 class="card-title">Viloyat </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="col-md-4">
                                                        <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                                            <li class="nav-item"><a class="nav-link active" href="#solid-tab1" data-toggle="tab">Tartiblanmagan </a></li>
                                                            <li class="nav-item"><a class="nav-link" href="#solid-tab2" data-toggle="tab">Tartiblangan </a></li>
                                                        </ul>
                                                    </div>
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="solid-tab1">
                                                                <div id="regionchart_del"></div>
                                                                <div id="regionchart"></div>
                                                            </div>
                                                            <div class="tab-pane show" id="solid-tab2">
                                                                <div id="regionchart_del_sort"></div>
                                                                <div id="regionchart_sort"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-xl-12">
                                <div class="card">

                                        <div class="card-header">
                                        <div class="card bg-white">
                                                <div class="card-header">
                                                <h5 class="card-title">Elchi </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="col-md-4">
                                                        <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                                            <li class="nav-item"><a class="nav-link active" href="#solid-tab3" data-toggle="tab">Tartiblanmagan </a></li>
                                                            <li class="nav-item"><a class="nav-link" href="#solid-tab4" data-toggle="tab">Tartiblangan </a></li>
                                                        </ul>
                                                    </div>
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="solid-tab3">
                                                                <div id="elchichart_del"></div>
                                                                <div id="elchichart"></div>
                                                            </div>
                                                            <div class="tab-pane show" id="solid-tab4">
                                                                <div id="elchichart_del_sort"></div>
                                                                <div id="elchichart_sort"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                        <table class="table table-stripped">
                                        <thead>
                                            <tr>
                                            <th>FIO </th>
                                            <th>Summa </th>
                                            </tr>
                                        </thead>
                                        <tbody id="userid">
                                        </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card">
                            <span class="text-center">Bugungi kun hisbot</span>

                           <div class="card-body">
                              <div class="table-responsive">
                                 <table class="table mb-0 example1">
                                    <thead>
                                       <tr>
                                          <th>Username </th>
                                          <th>FIO </th>
                                          <th>Telefon raqam </th>
                                          <th>Viloyat </th>
                                          <th>Smena boshlagan vaqti</th>
                                          <th>Smena yopilgan vaqti</th>
                                          <th>Admin tekshirishi</th>
                                          <th>Smena holati</th>
                                          <th>Ishlagan vaqti</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($hisob as $h)
                                       <tr>
                                          <td>{{$h->username}}</td>

                                          <td>{{$h->last_name}} {{$h->first_name}}</td>
                                          <td>{{$h->phone_number}}</td>
                                          <td>{{$h->name}}</td>
                                          <td>{{date('d.m.Y H:i',strtotime($h->open_date))}}</td>

                                          @if ($h->close_date == NULL)
                                            <td>Smena yopilmagan</td>
                                          @else
                                            <td>{{date('d.m.Y H:i',strtotime($h->close_date))}}</td>
                                          @endif

                                          @if ($h->admin_check == NULL)
                                            <td>Tasdiqlanmadi</td>
                                          @else
                                          @php
                                              $a = json_decode($h->admin_check);
                                          @endphp
                                            @if ($a->check == 'ok')
                                                <td>Tasdiqlandi</td>
                                            @elseif($a->check == 'code')
                                            <td>Kun soni yo'q</td>

                                            @elseif($a->check == 'card')
                                            <td>Beyjik yo'q</td>

                                            @elseif($a->check == 'robe')
                                            <td>Xalat yo'q</td>

                                            @else
                                            <td>Lokatsiya noto'g'ri</td>
                                          @endif




                                          @endif

                                          @if ($h->active == 1)
                                                <td>Smena ochiq</td>
                                            @endif
                                            @if ($h->active == 2)
                                                <td>Smena yopiq</td>
                                            @endif

                                        @if ($h->close_date == NULL)
                                        <td>{{number_format((intval(strtotime(date('Y-m-d H:i')))-intval(strtotime($h->open_date)))/(60*60),1)}} soat </td>
                                        @else
                                        <td>{{number_format((intval(strtotime($h->close_date))-intval(strtotime($h->open_date)))/(60*60),1)}} soat </td>
                                        @endif

                                       </tr>

                                       @endforeach
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-12">
                        <div class="card">
                            <span class="text-center">Ishga chiqmaganlar</span>

                           <div class="card-body">
                              <div class="table-responsive">
                                 <table class="table mb-0 example1">
                                    <thead>
                                       <tr>
                                          <th>Username </th>
                                          <th>FIO </th>
                                          <th>Telefon raqam </th>
                                          <th>Viloyat </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($nowork as $h)
                                       <tr>
                                          <td>{{$h->username}}</td>

                                          <td>{{$h->last_name}} {{$h->first_name}}</td>
                                          <td>{{$h->phone_number}}</td>
                                          <td>{{$h->name}}</td>

                                       </tr>

                                       @endforeach
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
            </div>

            <div id="fffmodalin">
            </div>
            <div id="fffmodal">
            </div>

@endif
@endisset
@endsection
@section('admin_script')
<script>
    function check()
    {
        var ckb_status = $("#checkslider").prop('checked');

        if(ckb_status){
            $('#dchart').css('display','none');
            $('#regionid').css('display','');

        }else{

            $('#regionid').css('display','none');
            $('#dchart').css('display','');

        }
    }
       $(function() {
  $('input[name="datetimes"]').daterangepicker({
   //  timePicker: true,
   //  startDate: moment().startOf('hour'),
   //  endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      format: 'DD.MM.YYYY'
    }
  });
  $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {

  var tim = picker.startDate.format('DD.MM.YYYY')+'/'+picker.endDate.format('DD.MM.YYYY');
  $("#age_button2").text(tim);
  region(tim);




  });
});
    $(document).ready(function(){
        $('#dchart').css('display','none');

        region('a_today');
   });
      function region(asd){

         var _token   = $('meta[name="csrf-token"]').attr('content');
         $.ajax({
            url: "/region/chart",
            type:"POST",
            data:{
                time:asd,
               _token: _token
            },
            success:function(response){
               if(response) {
                var countreg = 0;
                    for (var _ in response.dashboard) countreg++;
                    countreg = countreg - 1;
                  if(!response.ssumma[1])
               {
                  // $('#forvil').remove();
               }
                var region = {
                    series: [{
                    name: 'Summa',
                    data: response.summa
                    },],
                    chart: {
                    height: 350,
                    type: 'area'
                    },
                    dataLabels: {
                    enabled: false
                    },
                    stroke: {
                    curve: 'smooth'
                    },
                    xaxis: {
                    // type: 'datetime',
                    categories: response.region
                    },
                    tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                    },
                };
               //  if(isset(response.ssumma[1] ))
               //  {


                var sortregion = {
                    series: [{
                    name: 'Summa',
                    data: response.ssumma
                    },],
                    chart: {
                    height: 350,
                    type: 'area'
                    },
                    dataLabels: {
                    enabled: false
                    },
                    stroke: {
                    curve: 'smooth'
                    },
                    xaxis: {
                    // type: 'datetime',
                    categories: response.sregion
                    },
                    tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                    },
                };
               // }

                var user = {
                    series: [{
                    name: 'Summa',
                    data: response.u_summa
                    },],
                    chart: {
                    height: 350,
                    type: 'area'
                    },
                    dataLabels: {
                    enabled: false
                    },
                    stroke: {
                    curve: 'smooth'
                    },
                    xaxis: {
                    // type: 'datetime',
                    categories: response.u_name
                    },
                };
                var sortuser = {
                    series: [{
                    name: 'Summa',
                    data: response.su_summa
                    },],
                    chart: {
                    height: 350,
                    type: 'area'
                    },
                    dataLabels: {
                    enabled: false
                    },
                    stroke: {
                    curve: 'smooth'
                    },
                    xaxis: {
                    // type: 'datetime',
                    categories: response.su_name
                    },
                };

                var optionsch = {
  series: [
    {
        name:'Summa',
      data: response.ssumma,

    }
  ],
  chart: {
    type: "bar",
    height: 650,
  },
  plotOptions: {
    bar: {
      horizontal: true,
      distributed: true,
      startingShape: "rounded",
      endingShape: "rounded",
      colors: {
        backgroundBarColors: ["#eee"],
        backgroundBarOpacity: 1,
        backgroundBarRadius: 9
      }
    }
  },
  dataLabels: {
    enabled: false
    // enabled: true,

  },
  grid: {
    yaxis: {
      lines: {
        show: false
      }
    }
  },
  xaxis: {

    categories: response.sregion,

  },
//   yaxis: {
//     labels: {
//             style: {
//               fontSize: '22px'
//             }
//           }
//   },
  colors: [
    "#008FFB"
  ],
  legend: {
    show: true
  }
};


                $('.delregion').remove();
//                 $.each(response.dashboard, function(index, value){

// if(response.regid == value.id)
// {
//     var $row = $('<div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap delregion">'+
//                 '<div class="card detail-box4">'+
//                     '<div class="card-body">'+
//                         '<div class="dash-contetnt">'+
//                             '<h2 style="color:#ffffff;text-align:center;">'+ value.region +'</h2>'+
//                             '<h3 style="color:#ffffff;text-align:center;">'+value.icon + value.summa +' so\'m</h3>'+

//                         '</div>'+
//                     '</div>'+
//                 '</div>'+
//             '</div>');
// }
//     $('#myregionid').append($row);


// });
                    $('#fffmodal').remove();
                    $('#fffmodalin').append('<div id="fffmodal"></div>');
                $.each(response.dashboard, function(index, value){

                    var fgh1 = '';
                    var fgh12 = '';

                    var dfg21 = 0;
                    var dfg22 = 0;

                    $.each(value.use, function(ing, vag){
                        dfg21 = dfg21 + vag.sum;
                        dfg22 = dfg22 + vag.prog;
                        fgh1 = fgh1 + '<tr><td>'+ vag.f + vag.l+'</td><td>'+ vag.sum +'</td><td>'+vag.prog+'</td></tr>';
                    });

                        fgh12 = fgh12 + '<tr><td>Jami</td><td>'+ dfg21 +'</td><td>'+dfg22+'</td></tr>';

                    var fffmodal = '';

                        fffmodal = fffmodal + '<div class="modal fade" id="addmemberwer'+value.id +'">'+
                        '<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header">'+
                                    '</div>'+
                                    '<div class="modal-body">'+
                                        '<div class="table-responsive">'+
                                            '<table class="table mb-0">'+
                                                '<thead>'+
                                                    '<tr>'+
                                                        '<th>FIO</th>'+
                                                        '<th>FAKT</th>'+
                                                        '<th>PROGNOZ</th>'+
                                                        '</tr>'+
                                                        '</thead>'+
                                                        '<tbody>'+
                                                                fgh1+
                                                                fgh12+
                                                                '</tbody>'+
                                                                '</table>'+
                                                                '</div>'+
                                            '</div>'+
                                            '<div class="modal-footer">'+
                                                '<button type="submit" class="btn btn-primary">Saqlash</button>'+
                                                '<button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>'+
                                                '</div>'+
                                                '</div>'+
                                                '</div>'+
                                                '</div>';
                    $('#fffmodal').append(fffmodal);




                if(response.myid == value.id || response.regid == value.id)
                {
                    var bestsoldRegion = '';

                    if(value.best[0].bestsum != 0)
                    {
                        bestsoldRegion = bestsoldRegion + '<div class="d-flex justify-content-between">'+

                            '<h4 style="color:#00ffc4;height:45px;">'+ value.best[0].date +' <p>(best-month)</p></h4>'+
                            '<h3 style="color:#00ffc4;height:45px;" title="'+value.best[0].bestsumText +'">'+value.best[0].bestsum +'</h3>'+

                            '</div>';
                    }
                    var $row = $('<div class="col-12 col-md-6 col-lg-4 d-flex flex-wrap delregion">'+
                                '<div class="card detail-box1">'+
                                    '<div class="card-body">'+
                                        '<div class="dash-contetnt">'+
                                            '<h2 style="color:#05f705;text-align:center;">'+ value.region +'</h2>'+
                                            '<h3 style="color:#ffffff;text-align:left;margin-left:12px;"><span title="'+value.tols +'">'+value.summa +'</span></h3>'+
                                            bestsoldRegion +
                                            '<h6 style="margin-top:-15px;"><span style="text-align:left;"><img src="{{asset("assets/img/sumoq.png")}}" width="60px"></span></h6>'+
                                            '<h6 style="color:#ffffff;text-align:right;">'+value.icon +'</h6>'+
                                            '<h6 style="color:#ffffff;margin-top:1px;"><span style="text-align:left;">'+response.fd_begin +'-'+response.fd_end+'</span></h6>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>');
                }
                // if(response.regionid == false){
                    $('#myregionid').append($row);
                // }else{

                //     $('#regionid').append($row);
                // }

                });
                if(countreg > 0 && countreg < 4)
                {
                    if(countreg%2 == 0){var md = 6; var lg=12/countreg;}else{var md = 12; var lg=12/countreg;}

                }
                else if(countreg == 0){$('#forvil').remove();}
                else if(countreg == 6){var md = 6;var lg = 4;}
                else if(countreg == 8){var md = 6;var lg = 3;}
                else if(countreg == 9){var md = 6;var lg = 3;}
                else{var md = 6;var lg = 3;}
                $.each(response.dashboard, function(index, value){

                if(response.myid != value.id && response.regid != value.id)
                {
                    var muser = '';

                    $.each(value.muser, function(index, value){

                        if(index == 0 || index == 1)
                        {
                            muser = muser + '<h6 class="mt-2 text-center" style="color:#ffffff;text-align:left;margin-left:12px;"><span>'+
                                value.last_name + ' ' + value.first_name +
                                '</span></h6>';

                        }
                    });
                    var bestsoldRegion = '';

                    if(value.best[0].bestsum != 0)
                    {

                        bestsoldRegion = bestsoldRegion + '<span style="font-size:20px;color:white;">'+ value.best[0].date +'</span>'+
                        '<p style="color:#05f705;font-size:25px">'+value.best[0].bestsum+'</p>';
                    }
                    var dfg22 = value.prog;

                    // $.each(value.use, function(ing, vag){
                    //     dfg22 = dfg22 + vag.prog;
                    // });

                    var $row = $('<div class="col-12 col-md-'+md+' col-lg-'+lg+' d-flex flex-wrap delregion">'+
                                '<div class="card detail-box1">'+
                                    '<div class="card-body">'+
                                        '<div class="dash-contetnt">'+
                                            '<div class="d-flex justify-content-between">'+


                                            '<h3 class="mt-2" style="color:white;height:45px;cursor:pointer;" data-toggle="modal" data-target="#addmemberwer'+ value.id +'">'+ value.region +'</h3>'+
                                            '<h1 style="color:#05f705;height:45px;" title="'+value.tols +'">'+value.summa +'</h1>'+

                                            '</div>'+

                                            '<div class="text-center justify-content-between mt-3">'+
                                                '<div class="row pl-3 pr-3">'+
                                                    '<div style="background:#323584;border-radius:8px;box-shadow: 0px 0px 7px 2px #ffffff;" class="col-12 col-md-5 col-lg-5">'+
                                                        bestsoldRegion +
                                                    '</div>'+
                                                    '<div class="col-12 col-md-2 col-lg-2">'+
                                                    '</div>'+
                                                    '<div style="background:#323584;border-radius:8px;box-shadow: 0px 0px 7px 2px #ffffff;" class="col-12 col-md-5 col-lg-5">'+
                                                        '<span style="font-size:20px;color:white;">Prognoz</span>'+
                                                        '<p style="color:#05f705;font-size:25px">'+dfg22 +'</p>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="justify-content-between mt-3">'+
                                                '<div class="row pl-3 pr-3">'+
                                                    '<div style="background:#323584;border-radius:8px;box-shadow: 0px 0px 7px 2px #ffffff;" class="d-flex justify-content-between col-12 col-md-12 col-lg-12">'+
                                                        '<span style="font-size:20px;color:white;" class="mt-1">Elchilar</span>'+

                                                        '<span style="font-size:25px;color:#05f705;">'+ value.useriz +'</span>'+
                                                    '</div>'+
                                                    '<div style="background:#323584;border-radius:8px;box-shadow: 0px 0px 7px 2px #ffffff;" class="mt-2 d-flex justify-content-between col-12 col-md-12 col-lg-12">'+
                                                        '<span style="font-size:20px;color:white;" class="mt-1">Provizorlar</span>'+

                                                        '<span style="font-size:25px;color:#05f705;">'+ value.proviz +'</span>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="d-flex justify-content-between mt-3">'+

                                            '<h4 style="color:#ffffff;height:45px;">'+response.fd_begin +'-'+response.fd_end+'</h4>'+
                                            '<h4 style="color:#ffffff;height:45px;" title="'+value.tols +'">'+value.icon +'</h4>'+

                                            '</div>'+
                                            '<div style="background: #f76262;padding: 1px 1px;border-radius: 10px;">'

                                            + muser +
                                            // '<h6 class="mt-2" style="color:#ffffff;text-align:right;">'+value.icon +'</h6>'+
                                            // '<h6 style="color:#ffffff;margin-top:1px;"><span style="text-align:left;">'+response.fd_begin +'-'+nse.fd_respoend+'</span></h6>'+

                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                             '</div>');
                }
                // if(response.regionid == false){
                //     $('#myregionid').append($row);
                // }else{

                    $('#regionid').append($row);
                // }
                // if(response.regionid == false){$('#myregionid').append($row);}else{$('#regionid').append($row);}
                });


                $('.delcat').remove();
                var detail = 2;
                $.each(response.catarray, function(index, value){

                var $row = $('<div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap delcat">'+
                                '<div style="border-radius:26px;" class="card detail-box'+value.detail+'">'+
                                    '<div class="card-body">'+
                                        '<div class="dash-contetnt">'+
                                            '<h2 style="color:#ffffff;text-align:left;font-size:30px;font-family:Gilroy;">'+ value.name +'</h2>'+
                                            '<h3 style="color:#ffffff;text-align:left;margin-left:0px;"><span title="'+value.tols +'">'+value.summa +'</span></h3>'+
                                            '<h6 style="margin-top:-10px;"><span style="text-align:left;">'+value.icon +'</span></h6>'+
                                            // '<h6 style="color:#ffffff;margin-top:1px;"><span style="text-align:left;">'+response.d_begin +'-'+response.d_end+'</span></h6>'+
                                            '<h6 style="color:#ffffff;margin-top:1px;"><span style="text-align:left;">'+response.fd_begin +'-'+response.fd_end+'</span></h6>'+
                                            // '<h6 style="color:#ffffff;text-align:right;">'+value.icon +'</h6>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                             '</div>');
                $('#catid').append($row);
                detail++
                });

                $('.deltr').remove();

                $.each(response.userarry, function(index2, value2){

                var $row2 = $('<tr class="deltr">'+
                                    '<td>'+ value2.name + '</td>'+
                                    '<td>'+ value2.summa +'</td>'+
                                 '</tr>');
               $('#userid').append($row2);
            });

            $('#rchart').remove();
            $('#rchart_del').after("<div id='rchart'></div>");

            var rechart = new ApexCharts(document.querySelector("#rchart"), optionsch);
            rechart.render();

                $('#regionchart').remove();
                $('#regionchart_sort').remove();
                $('#elchichart').remove();
                $('#elchichart_sort').remove();
                $('#regionchart_del').after("<div id='regionchart'></div>");
                $('#regionchart_del_sort').after("<div id='regionchart_sort'></div>");
                $('#elchichart_del_sort').after("<div id='elchichart_sort'></div>");
                $('#elchichart_del').after("<div id='elchichart'></div>");
                var regionChart = new ApexCharts(document.querySelector("#regionchart"), region);
                regionChart.render();
                var sortregionChart = new ApexCharts(document.querySelector("#regionchart_sort"), sortregion);
                sortregionChart.render();
                var userChart = new ApexCharts(document.querySelector("#elchichart"), user);
                userChart.render();
                var sortuserChart = new ApexCharts(document.querySelector("#elchichart_sort"), sortuser);
                sortuserChart.render();
               }
            },
            error: function(error) {
               console.log(error);
            }
         });
      };
      function getDate(){
         var date = new Date($('#date-input').val());
  var day = date.getDate();
  var month = date.getMonth() + 1;
  var year = date.getFullYear();
  if(month < 10)
                           {
                              var ddate = '0'+month
                           }else{
                              var ddate = month
                           }
                           var date1 = [year, ddate, day].join('-')
                           $("#age_button2").text(date1);
         $('#age_button2').click()
         region(date1);

      }
      function timeElchi(sd){
         var text = $(`#${sd}`).text();
         $("#age_button2").text(text);
         region(sd)

      };


        // var chart = new ApexCharts(document.querySelector("#chart"), options);
        // chart.render();

        window.addEventListener('load', function () {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
}, false);


  </script>
 <script>
   function hospitalc(data,db){
      $('.click1').removeClass('active');
      $('.click2').removeClass('active');
      $('.click3').removeClass('active');
      $('.click4').removeClass('active');
      $(`.${data}`).addClass('active');
      hospital(db);
   }

 </script>
  <script type="text/javascript">
     // Add active class to the current button (highlight it)
      var header = document.getElementById("card");
      var btns = header.getElementsByClassName("btnSelect");
      for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
        });
      }
  </script>
@endsection
