<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
    {{-- <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" /> --}}
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
                            <div class="btn-group mr-2 ml-auto">
                              <div class="row">
                                 <div class="col-md-12" align="center">
                                          Viloyat
                                 </div>
                                 <div class="col-md-12">
                                    <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Hammasi</button>
                                    <div class="dropdown-menu" style="left:150px !important">
                                    <a href="#" onclick="ageChart('Hammasi','all','all')" class="dropdown-item" id="tgregion"> Hammasi </a>
                                       @foreach($regions as $region)
                                       <a href="#" onclick="ageChart(`{{$region->name}}`,`{{$region->id}}`,'all')" class="dropdown-item" id="tgregion"> {{$region->name}} </a>
                                       @endforeach
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="btn-group mr-2">
                              <div class="row">
                                    <div class="col-md-12" align="center">
                                             Sana
                                    </div>
                                    <div class="col-md-12">
                                       <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Hammasi </button>
                                       <div class="dropdown-menu timeclass">
                                       <a href="#" onclick="timeElchi('a_all')" class="dropdown-item" id="a_all">Hammasi </a>

                                          <a href="#" onclick="timeElchi('a_today')" class="dropdown-item" id="a_today"> Bugun </a>
                                          <a href="#" onclick="timeElchi('a_week')" class="dropdown-item" id="a_week">Hafta </a>
                                          <a href="#" onclick="timeElchi('a_month')" class="dropdown-item" id="a_month">Oy  </a>
                                          <a href="#" onclick="timeElchi('a_year')" class="dropdown-item" id="a_year">Yil </a>
                                          <input type="date" class="form-control" id="date-input" onchange="getDate()">
                                       </div>
                                    </div>
                              </div>
                           </div>
                           <div class="btn-group mr-2">
                                <div class="row">
                                 <div class="col-md-12" align="center">
                                          Mahsulot
                                 </div>
                                 <div class="col-md-12">
                                    <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button3" title="all" name="all" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Hammasi</button>
                                    <div class="dropdown-menu" style="overflow-y:scroll; height:400px;">
                                    
                                    <a href="#" onclick="medicine('Hammasi','all')" class="dropdown-item"> Hammasi </a>
                                       @foreach($category as $cat)
                                       <a href="#" style="color:red;font-size:20px" onclick="medicineCat(`{{$cat->name}}`,`{{$cat->id}}`,'all')" class="dropdown-item"><b> {{$cat->name}} </b></a>

                                        @foreach($medicine as $med)
                                          @if($cat->id == $med->category_id)
                                             <a href="#" style="margin-left:5%;" onclick="medicine(`{{$med->name}}`,`{{$med->id}}`,'all')" class="dropdown-item"> {{$med->name}} </a>
                                          @endif
                                        @endforeach
                                       @endforeach
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="btn-group mr-2">
                              <div class="row">
                                    <div class="col-md-12" align="center">
                                             Elchi
                                    </div>
                                    <div class="col-md-12">
                                       <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button4" name="all" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Hammasi</button>
                                       <div class="dropdown-menu" style="overflow-y:scroll; height:400px;">
                                          <a href="#" onclick="users('Hammasi','all')" class="dropdown-item"> Hammasi </a>
                                          @foreach($users as $user)
                                          <a href="#" onclick="users(`{{$user->last_name}} {{$user->first_name}}`,`{{$user->id}}`)" class="dropdown-item"> {{$user->last_name}} {{$user->first_name}} </a>
                                          @endforeach
                                       </div>
                                    </div>
                                 </div>
                            </div>
                           <div class="btn-group" style="margin-right:30px !important;margin-top:20px;">
                              <div class="row">
                                    <div class="col-md-12" align="center">
                                       
                                    </div>
                                    <div class="col-md-12">
                                       <button type="button" class="btn btn-block btn-outline-primary" onclick="refresh()"> Tozalash</button>
                                       
                                    </div>
                                 </div>
                            </div>
                        </div>
                  </div>
                </div>
            </div>
        </div>
        </div>
        
        <div class="content container-fluid mt-1">
        <div class="row">
            <div class="col-sm-12" >
               
                  <div class="card" style="margin-top:130px;">
                     <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-stripped">
                           <thead>
                              <tr id="">
                              <th>FIO </th>
                              <th>Mahsulot </th>
                              <th>Order </th>
                              <th>Soni </th>
                              <th>Viloyat </th>
                              <th>Sana </th>
                              <th>Soat </th>
                              </tr>
                           </thead>
                           <tbody>
                           </tbody>
                        </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </div>
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
      ageChart('Hammasi','all','all');
   });
      function ageChart(name,id,ids,cate){
         if(cate){
         var cate = $("#age_button3").attr('title');
         var medic = 'cate';
            
         }
         else{
            var medic = $("#age_button3").attr('name');
            var cate = 'med';


         }
         $("#age_button").attr('name',id);
         $("#age_button").text(name);
         var t_time = $("#age_button2").attr('name');
         var user = $("#age_button4").attr('name');
         var _token   = $('meta[name="csrf-token"]').attr('content');
         $.ajax({
            url: "/region/elchi",
            type:"POST",
            data:{
               id: id,
               time: t_time,
               medi: medic,
               user: user,
               order: ids,
               cate: cate,
               _token: _token
            },
            success:function(response){
               if(response) {
                  $('tbody tr').remove();
                  $.each(response.data, function(index, value){
                     var d = new Date(value.m_data);

                           var curr_day = d.getDate();
                           var curr_month = d.getMonth();
                           var curr_year = d.getFullYear();
                           var curr_hour = d.getHours();
                           var curr_minutes = d.getMinutes();

                           curr_month++
                           if(curr_month < 10)
                           {
                              var ddate = '0'+curr_month
                           }else{
                              var ddate = curr_month
                           }
                     var $row = $('<tr>'+
                                    '<td>'+ value.ul_name + ' ' + value.uf_name +'</td>'+
                                    '<td onclick="orderId('+value.t_id+')"><button type="button" class="btn btn-block btn-outline-primary">'+ 'order'+value.t_id +'</button></td>'+
                                    '<td>'+ value.m_name +'</td>'+
                                    '<td>'+ value.m_number +'</td>'+
                                    '<td>'+ value.r_name +'</td>'+
                                    '<td>'+ curr_day +'.'+ddate+'.'+curr_year +'</td>'+
                                    '<td>'+ curr_hour +':'+curr_minutes+'</td>'+
                                 '</tr>'); 
               $('table> tbody:last').append($row);
               });
               }
            },
            error: function(error) {
               console.log(error);
            }
         });
      };
      function timeElchi(sd){
         var text = $(`#${sd}`).text();
         $("#age_button2").text(text);
         $("#age_button2").attr('name',sd);
         var id = $("#age_button").attr('name');
         var text = $("#age_button").text();

         ageChart(text,id,'all');

      };
      function medicine(name,id){
         $("#age_button3").attr('name',id);
         $("#age_button3").text(name);
         var id = $("#age_button").attr('name');
         var text = $("#age_button").text();

         ageChart(text,id,'all');
      }
      function medicineCat(name,id){
         $("#age_button3").attr('title',id);
         $("#age_button3").text(name);
         var id = $("#age_button").attr('name');
         var text = $("#age_button").text();

         ageChart(text,id,'all','cat');
      }

      function users(name,id){
         $("#age_button4").attr('name',id);
         $("#age_button4").text(name);
         var id = $("#age_button").attr('name');
         var text = $("#age_button").text();

         ageChart('Hammasi','all','all');
      }
      function orderId(ids){
         var id = $("#age_button").attr('name');
         var text = $("#age_button").text();

         ageChart(text,id,ids);
      }
      function refresh()
      {
         location.reload();
      }

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
         $("#age_button2").attr('name',date1);
         var id = $("#age_button").attr('name');
         var text = $("#age_button").text();
         $('#age_button2').click()
         ageChart(text,id,'all');

      }
  

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
      $("#age_button").text('Hammasi');
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
