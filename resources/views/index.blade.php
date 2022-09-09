@extends('admin.layouts.app')
@section('admin_content')
@isset(Session::get('per')['dash'])
             @if(Session::get('per')['dash'] == 'true')
<div class="content container-fluid">
    <div class="page-header">
        <div class="main-wrapper">

            <div class="content container-fluid mt-1">
            <div class="row">
                <div class="col-sm-12">
                   <div class="card flex-fill">
    
                      <div>
                            <div class="d-flex justify-content-between align-items-center">
                               {{-- <div class="btn-group ml-5">
                                <a href="/"><img src="{{asset('nvt/logo2.png')}}" alt="" height="100px"></a>
                                </div> --}}
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
                               <div class="btn-group">
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
            {{-- <div class="card-header">
                      </div> --}}
                   {{-- second row --}}
                    <div class="row" id="catid">
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
        <!-- </div> -->
    </div>
</div>
@endif
@endisset
@endsection
@section('admin_script')
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
