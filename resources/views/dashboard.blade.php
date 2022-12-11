<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Matrix') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <script src="https://kit.fontawesome.com/a0fc7cad28.js" crossorigin="anonymous"></script>


    <!-- Styles -->
     {{-- <link href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('assets/css/feather.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"> --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('nvt/img/icon.png')}}" />

    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" /> --}}
    <!-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/css/bootstrap.min.css') }}" /> -->

    <link href="{{ asset('/assets/plugins/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/plugins/simple-calendar/simple-calendar.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/css/feather.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet">

    <!-- <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('/assets/css/dash_style.css') }}" rel="stylesheet">

    <style>
      .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            color: rgb(0, 0, 0);
            background-color: #ffffff !important;
        }
        .cool-link {
    display: inline-block;
    color: #323584;
    text-decoration: none;
}

.cool-link::after {
    content: '';
    display: block;
    width: 0;
    height: 2px;
    background: #323584;
    transition: width .3s;
}

.cool-link:hover::after {
    width: 100%;
    //transition: width .3s;
}
    </style>

    
</head>
<body>
    <div class="main-wrapper">

        <div class="content container-fluid mt-1" style="position:fixed;z-index:1000;">
        <div class="row">
            <div class="col-sm-12">
               <div class="card flex-fill">

                  <div style="border-bottom-radius:30px !important;">
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="btn-group ml-5">
                            <a href="/"><img src="{{asset('nvt/logo2.png')}}" alt="" height="100px"></a>
                            </div>
                           <div class="btn-group mr-5 ml-auto">
                              <div class="row">
                                    <div class="col-md-12" align="center">
                                             Sana
                                    </div>
                                    <div class="col-md-12">
                                       <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Oy </button>
                                       <div class="dropdown-menu timeclass">
                                       <a href="#" onclick="timeElchi('a_month')" class="dropdown-item" id="a_all">Oy </a>

                                          <a href="#" onclick="timeElchi('a_today')" class="dropdown-item" id="a_today"> Bugun </a>
                                          <a href="#" onclick="timeElchi('a_week')" class="dropdown-item" id="a_week">Hafta </a>
                                          <a href="#" onclick="timeElchi('a_month')" class="dropdown-item" id="a_month">Oy  </a>
                                          <a href="#" onclick="timeElchi('a_year')" class="dropdown-item" id="a_year">Yil </a>
                                          <input type="date" class="form-control" id="date-input" onchange="getDate()">
                                       </div>
                                    </div>
                              </div>
                           </div>
                           <div class="btn-group mr-5">
                              <div class="row">
                                    <div class="col-md-12" align="center">
                                             Xisobot
                                    </div>
                                    <div class="col-md-12">
                                       <a href="/search" type="button" class="btn btn-block btn-outline-primary" > Filter </a>
                                       
                                    </div>
                              </div>
                           </div>
                        </div>
                  </div>
                </div>
            </div>
        </div>
        </div>
        <div class="content container-fluid">
        <div class="card-header">
                  </div>
               {{-- second row --}}
                <div class="row" id="catid" style="margin-top:100px;">
                </div>
               <div class="row" id="regionid">
                <!-- @foreach($array as $arr) -->
                    <!-- <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap">
                        <div class="card detail-box1 details-box">
                            <div class="card-body">
                                <div class="dash-contetnt">
                                        <h4 style="color:#05f705;">{{$arr['region']}} </h4>
                                        <h4 class="text-white">{{ number_format($arr['summa'], 0, '', ' ') }} so'm</h4>
                                    
                                </div>
                            </div>
                        </div>
                    </div> -->
                  <!-- @endforeach -->
                  <!-- <div class="col-12 col-md-6 col-lg-2 d-flex flex-wrap">
                     <div class="card detail-box2 details-box">
                        <div class="card-body">
                           <div class="dash-contetnt">
                              <div class="mb-3">
                              </div>
                              <h4 class="text-white">dasd </h4>
                              <h1 class="text-white all_chkb"></h1>
                           </div>
                        </div>
                     </div>
                  </div> -->

               </div>
               <div class="row calender-col">
                  <div class="col-xl-12">
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
    <!-- </div> -->
</body>


<script src="{{asset('/assets/js/jquery-3.6.0.min.js')}}"></script>
   
 <script src="{{asset('/assets/js/bootstrap.bundle.min.js')}}"></script>

 <script src="{{asset('/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

 <script src="{{asset('/assets/plugins/apexchart/apexcharts.min.js')}}"></script>
 <script src="{{asset('/assets/plugins/apexchart/dsh-apaxcharts.js')}}"></script>

 <script src="{{asset('/assets/plugins/simple-calendar/jquery.simple-calendar.js')}}"></script>
 
 <script src="{{asset('/assets/js/calander.js')}}"></script>

 <script src="{{asset('/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
 <script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
 <script src="{{asset('/assets/plugins/datatables/datatables.min.js')}}"></script>


 <script src="{{ asset('/assets/js/script.js') }}"></script>
 <script src="{{ asset('/assets/js/jquery.maskedinput.min.js') }}"></script>
 <script src="{{ asset('/assets/js/mask.js') }}"></script>
 {{-- <script src="assets/js/jquery.maskedinput.min.js"></script> --}}

<script>
    $(document).ready(function(){
        region('a_month');
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
                $('.delregion').remove();

                $.each(response.dashboard, function(index, value){

                var $row = $('<div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap delregion">'+
                                '<div class="card detail-box1">'+
                                    '<div class="card-body">'+
                                        '<div class="dash-contetnt">'+
                                            '<h2 style="color:#05f705;text-align:center;">'+ value.region +'</h2>'+
                                            '<h3 style="color:#ffffff;text-align:center;">'+value.icon + value.summa +' so\'m</h3>'+

                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                             '</div>'); 
                $('#regionid').append($row);

                });

                $('.delcat').remove();

                $.each(response.catarray, function(index, value){

                var $row = $('<div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap delcat">'+
                                '<div class="card detail-box2">'+
                                    '<div class="card-body">'+
                                        '<div class="dash-contetnt">'+
                                            '<h2 style="color:#05f705;text-align:center;">'+ value.name +'</h2>'+
                                            '<h3 style="color:#ffffff;text-align:center;">'+value.icon + value.summa +' so\'m</h3>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                             '</div>'); 
                $('#catid').append($row);

                });

                $('.deltr').remove();

                $.each(response.userarry, function(index2, value2){

                var $row2 = $('<tr class="deltr">'+
                                    '<td>'+ value2.name + '</td>'+
                                    '<td>'+ value2.summa +'</td>'+
                                 '</tr>'); 
               $('#userid').append($row2);
            });


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
   function hospital(data){
      $("#age_button").text('Все');
      $(".auto_click").click();
      var _token   = $('meta[name="csrf-token"]').attr('content');
      $('#chart_age').remove();
      $('#chart_age_2').after("<div id='chart_age'></div>");
      $('#chart_pie').remove();
      $('#chart_pie_del').after("<div id='chart_pie'></div>");
      $('#chart_pie2').remove();
      $('#chart_pie2_del').after("<div id='chart_pie2'></div>");
      $.ajax({
        url: "/patient/main_age",
        type:"POST",
        data:{
          _token: _token,
          db: data
        },
         success:function(response){
            if(response) {
               var res_male = response.male
               var res_female = response.female
               var options = {
                  colors: ['#042475','#ff0000'],
                        series: [{
                        name: [{!! json_encode(__('app.male')) !!}],
                        data: res_male
                     },{
                        name: [{!! json_encode(__('app.female')) !!}],  
                        data: res_female
                     }],
                        chart: {
                        type: 'bar',
                        height: 350
                     },
                     plotOptions: {
                        bar: {
                           horizontal: false,
                           columnWidth: '35%',
                           endingShape: 'rounded'
                        },
                     },
                     dataLabels: {
                        enabled: false
                     },
                     stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                     },
                     xaxis: {
                        categories: ['--29','30-45', '45-55', '55-67', '67-75', '75--'],
                     },
                     yaxis: {
                        title: {
                           text: ''
                        }
                     },
                     fill: {
                        opacity: 1
                     },
                     tooltip: {
                        y: {
                           formatter: function (val) {
                           return val
                           }
                        }
                     }
               };
               var chart_age = new ApexCharts(document.querySelector("#chart_age"), options);
               chart_age.render();
            }
         },
         error: function(error) {
            console.log(error);
         }
      });
      $.ajax({
        url: "/patient/all_patient",
        type:"POST",
        data:{
            db: data,
          _token: _token
        },
         success:function(response){
            if(response) {
               // alert(response.all_p_tlt)
               var res_all_p_tlt = response.all_p_tlt
               var res_all_p_chkb = response.all_p_chkb
               var res_chkb_no_dead_array = response.chkb_no_dead_array
               var res_tlt_no_dead_array = response.tlt_no_dead_array
               var res_chkb_dead_array = response.chkb_dead_array
               var res_tlt_dead_array = response.tlt_dead_array
               var res_pie = response.pie
               var res_pie_death = response.pie_death

               var options = {
                  colors: ['#042475','#ff0000'],    
                     series: [{
                     name: {!! json_encode(__('app.tlt')) !!},
                     data: res_all_p_chkb
                  }, {
                     name: {!! json_encode(__('app.chkb')) !!},
                     data: res_all_p_tlt
                  }],
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
                     type: 'datemonth',
                     categories: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь",]
                  },
                  tooltip: {
                     x: {
                        format: 'dd/MM/yy HH:mm'
                     },
                  },
               };  

               var options_dead = {
                  colors: ['#042475','#ff0000'],
                  series: [{
                     name: {!! json_encode(__('app.chkb')) !!},
                     data: res_chkb_no_dead_array
                  }, {
                     name: {!! json_encode(__('app.tlt')) !!},
                     data: res_tlt_no_dead_array
                  }],
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
                     type: 'datemonth',
                     categories: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь",]
                  },
                  tooltip: {
                     x: {
                        format: 'dd/MM/yy HH:mm'
                     },
                  },
               }; 
               var options_no_dead = {
                  colors: ['#042475','#ff0000'],
                  series: [{
                     name: {!! json_encode(__('app.chkb')) !!},
                     data: res_chkb_dead_array
                  }, {
                     name: {!! json_encode(__('app.tlt')) !!},
                     data: res_tlt_dead_array
                  }],
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
                     type: 'datemonth',
                     categories: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь",]
                  },
                  tooltip: {
                     x: {
                        format: 'dd/MM/yy HH:mm'
                     },
                  },
               }; 
               var options_pie = {
                  chart: {
                  height: 350,
                  type: 'pie',
                  },
                  legend: {
                     position: 'bottom'
                  },
                  colors: ["#00758F", "#FFA500"],
                  labels: [{!! json_encode(__('app.all_p_male')) !!}, {!! json_encode(__('app.all_p_female')) !!}],
                  series: res_pie,
               };
               var options_pie2 = {
                     series: res_pie_death,
                     chart: {
                     height: 350,

                     type: 'pie',
                  },
                     legend: {
                        position: 'bottom'
                     },
                  colors: ["#009933", "#ff0000"],
                  labels: [{!! json_encode(__('app.all_no_dead_chkb_t')) !!}, {!! json_encode(__('app.all_dead_chkb_l_t')) !!}],
                  responsive: [{
                     breakpoint: 480,
                     options: {
                        chart: {
                        width: 378
                        },
                        legend: {
                        position: 'bottom'
                        }
                     }
                  }]
               };
                  var chart_pie2 = new ApexCharts(document.querySelector("#chart_pie2"), options_pie2);
                  chart_pie2.render();
                  var chart_pie = new ApexCharts(document.querySelector("#chart_pie"), options_pie);
                  chart_pie.render();
                  // var all_3 = new ApexCharts(document.querySelector("#all_3"), options_all);
                  // all_3.render();
                  var all_chart = new ApexCharts(document.querySelector("#all_chart"), options);
                  all_chart.render();
                  var all_dead = new ApexCharts(document.querySelector("#all_dead"), options_dead);
                  all_dead.render();
                  var all_no_dead = new ApexCharts(document.querySelector("#all_no_dead"), options_no_dead);
                  all_no_dead.render();
            }
         },
         error: function(error) {
         console.log(error);
        }
      });
      $.ajax({
            url: "/patient/patient_data",
            type:"POST",
            data:{
               db: data,
               _token: _token
            },
            success:function(response){
               if(response) {
                  $('.all_patient').text(response.all_patient)
                  $('.all_chkb').text(response.all_chkb)
                  $('.all_true').text(response.all_true)
                  $('.chkb_true').text(response.chkb_true)
                  $('.all_false').text(response.all_false)
                  $('.chkb_false').text(response.chkb_false)
               }
            },
            error: function(error) {
               console.log(error);
            }
         });
   }
   $(document).ready(function(){
      var _token   = $('meta[name="csrf-token"]').attr('content');
      hospital('all');
   });
    
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

</html>
