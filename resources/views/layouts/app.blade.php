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


    <!-- Styles -->
     {{-- <link href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('assets/css/feather.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" /> --}}

    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" /> --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/css/bootstrap.min.css') }}" />

    <link href="{{ asset('/assets/plugins/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/plugins/simple-calendar/simple-calendar.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/css/feather.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">

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
        {{-- @include('components.flash'); --}}
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        @include('components.header');
        @include('components.sidebar');
        {{-- <div id="patient_reg" class="page-wrapper" style="display: none;">
        @yield('patient_reg')
        </div> --}}
        {{-- <div id="patient_list" class="page-wrapper">
        @yield('patient_list')
        </div> --}}
        <div class="page-wrapper">
        @yield('content')
        </div>
    </div>
</body>
<script type="text/javascript" src="{{asset('/assets/js/jquery-3.6.0.min.js')}}"></script>

 <script type="text/javascript" src="{{asset('/assets/js/bootstrap.bundle.min.js')}}"></script>

 <script type="text/javascript" src="{{asset('/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

 <script type="text/javascript" src="{{asset('/assets/plugins/apexchart/apexcharts.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('/assets/plugins/apexchart/dsh-apaxcharts.js')}}"></script>

 <script type="text/javascript" src="{{asset('/assets/plugins/simple-calendar/jquery.simple-calendar.js')}}"></script>
 
 <script type="text/javascript" src="{{asset('/assets/js/calander.js')}}"></script>

 <script type="text/javascript" src="{{asset('/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('/assets/plugins/datatables/datatables.min.js')}}"></script>


 <script type="text/javascript" src="{{ asset('/assets/js/script.js') }}"></script>
 <!--<script type="text/javascript" src="{{ asset('/assets/js/jquery.maskedinput.min.js') }}"></script>-->
 <!--<script type="text/javascript" src="{{ asset('/assets/js/mask.js') }}"></script>-->
 @yield('scripts')
 <script>
  $("#province").change(function(){
            var province = $("#province").val();
            // alert(province);

            var _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
            url: "/district/get_districts",
            type:"POST",
            data:{
               data:province,
               _token: _token
            },
            success:function(response){
               if(response) {
                  // alert(response.district[0]['id'])
               }
               $("#place_dist").val('');
               $("#for_district").css("display","none");
               $("#district").css("display","");
               // array.forEach(response.district => {
               //    $( "#add_option" ).after( "<option style='display: none' value=''></option>" );
               // });
               $(`#place_dist2`).remove();
               $( "#add_select2" ).after(`<select class='form-control form-control-sm' name='district_id' id='place_dist2' required>
                                 <option value='' disabled selected hidden id='add_option'></option>
                              </select>`);
               $.each(response.district, function(index, value){
                  $( "#add_option" ).after(`<option value='${value.id}' id='province_delete'>${value.district_name}</option>`);
               });
            },
            error: function(error) {
               console.log(error);
            }
            });
        });
   function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

   function rKinetika(label_kinetik)
        {
         $('#for_kinetik').remove();
         $(`#${label_kinetik}`).after("<div id='for_kinetik'><div class='col-md-12'><label><input type='radio' value='app.front_wall' name='kinetik' /> {{__('app.front_wall')}}</label></div><div class='col-md-12'><label><input type='radio' value='app.lateral_wall' name='kinetik' /> {{__('app.lateral_wall')}}</label></div><div class='col-md-12'><label><input type='radio' value='app.bottom_wall' name='kinetik' required/> {{__('app.bottom_wall')}}</label></div></div>");
        }
   function rEkg(label_st_id)
        {
         $('#for_st').remove();
         $(`#${label_st_id}`).after("<div id='for_st'><div class='col-md-12'><label><input type='radio' value='app.front_wall' name='st' required/> {{__('app.front_wall')}}</label></div><div class='col-md-12'><label><input type='radio' value='app.lateral_wall' name='st' /> {{__('app.lateral_wall')}}</label></div><div class='col-md-12'><label><input type='radio' value='app.bottom_wall' name='e-st' /> {{__('app.bottom_wall')}}</label></div></div>");
        }
   function rMarker(label_marker)
        {
         $('#input_marker').remove();
         $(`#${label_marker}`).after("<div class='form-group col-md-6' id='input_marker'><input type='text' name='text_marker' style='border:solid 1px #ddd;padding:5px 5px;' class='ml-2 w-100 rounded' required/></div>");
        }
     function filterFunctionEkg2() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("for_diagnos_ekg_add");
        filter = input.value.toUpperCase();
        div = document.getElementById("to_diagnos_ekg_add");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
        }
        function filterFunctionExo2() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("for_diagnos_exo_add");
        filter = input.value.toUpperCase();
        div = document.getElementById("to_diagnos_exo_add");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
        }
        function filterFunctionExit() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("for_patient");
        filter = input.value.toUpperCase();
        div = document.getElementById("to_patient");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
        }
        $(document).ready(function(){

            $("#date").change(function(){
              var patient_date = $("#date").val();
            var patient_year = patient_date.substring(6, patient_date.length);
            var current_year = new Date().getFullYear()
            var age = current_year-patient_year;
            $("#age").val(age);
            });
        $('#message').delay(500).fadeOut();
       
        $("#rost").keyup(function(){
            var rost = $("#rost").val();
            var ves = $("#ves").val();
            var imt = ves/(rost*rost);
            $("#imt").val(imt.toFixed(2));
        });
        $("#ves").keyup(function(){
            var rost = $("#rost").val();
            var ves = $("#ves").val();
            var imt = ves/(rost*rost);
            $("#imt").val(imt.toFixed(2));
        });
        $('#check_infarct').click(function() {
            $('#check_infarct').val('');
            $("#infarct").toggle(this.radio);
            $("#add_diagnoz").prop('type', 'button');
        });
        $('#add_diagnoz').click(function() {
            if(!$('#check_infarct').val()){
            $("#oks_begin").css("color", "red");
            }
        });
        $('#check_infarct2').click(function() {
            $("#infarct2").toggle(this.checked);
        });
        $('#check_infarct3').click(function() {
            $("#infarct3").toggle(this.checked);
        });
        $('#check_infarct4').click(function() {
            $("#infarct4").toggle(this.checked);
        });
        $('#check_infarct5').click(function() {
            $("#infarct5").toggle(this.checked);
        });
        $('#check_infarct6').click(function() {
            $("#infarct6").toggle(this.checked);
        });
        $('#check_lech').click(function() {
            $("#lech").toggle(this.checked);
        });
        $('#check_dostup').click(function() {
            $("#dostup").toggle(this.checked);
        });
        $('#check_radial').click(function() {
            $("#radial").toggle(this.checked);
        });
        $('#check_radial2').click(function() {
            $("#radial2").toggle(this.checked);
        });
        $('#check_radial3').click(function() {
            $("#radial3").toggle(this.checked);
        });
        $('#toggleButton').click(function() {
            $("#for_toggleButton").slideToggle("slow");
        });
        $('#for_h1').click(function() {
            $("#for_h_h1").slideToggle("slow");
        });
        $('#check_iv').click(function() {
            $("#iv").toggle(this.checked);
        });
        $('#check_oslo').click(function() {
            $("#oslo").toggle(this.checked);
        });
        $('#check_oslo2').click(function() {
            $("#oslo2").toggle(this.checked);
        });
        $('#check_other').click(function() {
            $("#other").toggle(this.checked);
        });
        $('#for_troponin_t').click(function() {
            $("#troponin_t").toggle(this.checked);
        });
        $('#for_troponin_i').click(function() {
            $("#troponin_i").toggle(this.checked);
        });
        $('#for_kfk').click(function() {
            $("#kfk").toggle(this.checked);
        });
        $('#check_other2').click(function() {
            $("#other2").toggle(this.checked);
        });
        $('#check_other3').click(function() {
            $("#other3").toggle(this.checked);
        });
        $('#check_drg').click(function() {
            $("#drg").toggle(this.checked);
        });
        $('#check_drg2').click(function() {
            $("#drg2").toggle(this.checked);
        });
        $('#check_drgg').click(function() {
            $("#drgg").toggle(this.checked);
        });
        $('#check_tlt').click(function() {
            $("#tlt").toggle(this.checked);
        });
        $('#check_strep').click(function() {
            $("#strep").toggle(this.checked);
        });
        $('#add_data').click(function() {
            $('.case_number').removeAttr("disabled");
        });     
        var _token   = $('meta[name="csrf-token"]').attr('content');
        var complex = <?php echo json_encode(Session::get('hospital_id')); ?>;
      $.ajax({
        url: "/patient/main_age",
        type:"POST",
        data:{
          db: complex,
          _token: _token
        },
        success:function(response){
          if(response) {
            var res_male = response.male
            var res_female = response.female
var options = {
    colors: ['#4a4da0','#d12d2d'],
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
          db: complex,
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

            var options = {
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
  colors: ["#20c997","#dc3545"],
  labels: [{!! json_encode(__('app.all_p_male')) !!}, {!! json_encode(__('app.all_p_female')) !!}],
  series: res_pie,
  fill: {
    // colors: ["#447b40", "#cc7870", "#e74ce4"]
  }
        };

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
    });
    
 </script>
  <script>
      
      function ageChart(a_text){
   
      var text = $(`#${a_text}`).text();
      $("#age_button").text(text);
      var data = a_text;
      console.log(data)
      var _token   = $('meta[name="csrf-token"]').attr('content');
      var complex = <?php echo json_encode(Session::get('hospital_id')); ?>;

      $.ajax({
        url: "/patient/age",
        type:"POST",
        data:{
          data: data,
          db: complex,
          _token: _token
        },
        success:function(response){
          if(response) {
              $("#chart_age").css('display','none');
            var res_male = response.male
            var res_female = response.female
            $('#chart_age_2').remove();
            $('#chart_age').remove();
            $('#disp_none').after("<div id='chart_age_2'></div>");
var options = {
    colors: ['#4a4da0','#d12d2d'],
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

        var chart_age_2 = new ApexCharts(document.querySelector("#chart_age_2"), options);
        chart_age_2.render();
          }
        },
        error: function(error) {
         console.log(error);
        }
       });
      
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

</html>
