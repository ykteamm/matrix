<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Blackjack</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    @include('admin.partials.css')
    
    {{-- <style>
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc_disabled:after,
        table.dataTable thead .sorting_asc_disabled:before,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc_disabled:after,
        table.dataTable thead .sorting_desc_disabled:before {
        bottom: .5em;
        }
    </style> --}}
    <style>
        @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
        body{
            background-color: rgb(255, 255, 255)
        }
        .gold-box {
            background-color: #ffffff;
            position:sticky;
            top:60px;
            z-index:100;
            border-radius: 10px;
            }
        .headbot {
            margin-top:47px;
        }
        div.sticky {
        position: -webkit-sticky !important;
        position: sticky !important;
        top:40px !important;
        z-index: 4 !important;
        }
        .numberkm{
            font-size:28px;
            font-family: Gilroy;
        }
        .numberpr{
            font-size:40px;
            font-family: Gilroy;
        }
        /* Base setup */
/* @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css); */


/* Ratings widget */
.rate {
    display: inline-block;
    border: 0;
}
/* Hide radio */
.rate > input {
    display: none;
}
/* Order correctly by floating highest to the right */
.rate > label {
    float: right;
}
/* The star of the show */
.rate > label:before {
    display: inline-block;
    font-size: 2rem;
    padding: .3rem .2rem;
    margin: 0;
    cursor: pointer;
    font-family: FontAwesome;
    content: "\f005 "; /* full star */
}

/* Half star trick */
.rate .half:before {
    content: "\f089 "; /* half star no outline */
    position: absolute;
    padding-right: 0;
}
/* Click + hover color */
input:checked ~ label, /* color current and previous stars on checked */
label:hover, label:hover ~ label { color: #73B100;  } /* color previous stars on hover */

 
/* Hover highlights */
input:checked + label:hover, input:checked ~ label:hover, /* highlight current and previous stars */
input:checked ~ label:hover ~ label, /* highlight previous selected stars for new rating */
label:hover ~ input:checked ~ label /* highlight previous selected stars */ { color: #A6E72D;  } 
.colorrate{
    color:#A6E72D
}


.notification {
  background-color: rgb(17, 9, 100);
  color: white;
  text-decoration: none;
  padding: 8px 26px;
  position: relative;
  display: inline-block;
  border-radius: 2px;
}

.notification .badge {
  position: absolute;
  top: -10px;
  right: -10px;
  padding: 5px 10px;
  border-radius: 10%;
  background-color: #0eee59;
  color: white;
}
    </style>

    <link rel="stylesheet" href="https://cdn.rawgit.com/mfd/09b70eb47474836f25a21660282ce0fd/raw/e06a670afcb2b861ed2ac4a1ef752d062ef6b46b/Gilroy.css">
    
</head>
<body>
    <div class="main-wrapper">
        @include('admin.components.header')
        @include('admin.components.sidebar')
        <div class="page-wrapper" style="padding-top: 0px !important">
        @yield('admin_content')
        </div>
    </div>
    
</body>

    @include('admin.partials.js')
    @yield('admin_script')
    <script>
//         function httpGetAsync(url, callback) {
//     var xmlHttp = new XMLHttpRequest();
//     xmlHttp.onreadystatechange = function() {
//         if (xmlHttp.readyState === 4 && xmlHttp.status === 200)
//         callback(xmlHttp.responseText);
//     }
//     xmlHttp.open("GET", url, true); // true for asynchronous
//     xmlHttp.send(null);
// } 
        
      </script>

<script>
$(document).ready(function () {
  $('#dtBasicExample').DataTable();
  $('.dataTables_length').addClass('bs-select');

  $('#dtBasicExampleAdmin').DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  });

  $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "order": [[ 4, "desc" ]]

    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $("#forware").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "order": [[ 4, "desc" ]]
    }).buttons().container().appendTo('#for_ware .col-md-6:eq(0)');

    $("#example123").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        // "order": [[ 2, "desc" ]]

    }).buttons().container().appendTo('#asdasd .col-md-6:eq(0)');

    $("#example1231").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        // "order": [[ 2, "desc" ]]

    }).buttons().container().appendTo('#asdasd1 .col-md-6:eq(0)');

    $(".example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,'paginate':false,'sort':false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],

    }).buttons().container().appendTo('#asdasd2 .col-md-6:eq(0)');

    $(".forware").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,'paginate':false,'sort':false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],

    }).buttons().container().appendTo('#asdasd2 .col-md-6:eq(0)');

  $('.dtBasicExample').DataTable();
  $('.dataTables_length').addClass('bs-select');

  $('#dtBasicExample12').DataTable({
    "order": [[ 2, "desc" ]]
  });
  $('.dataTables_length').addClass('bs-select');
});
        $("#hospital_name").change(function(){
            var hospital = $("#hospital_name").val();
            var _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/branch/has",
                type:"POST",
                data:{
                data: hospital,
                _token: _token
                },
                success:function(response){
                if(response) {
                    var branch_schema = response.data;
                    $('#del_branch').remove();
                    $('#for_branch').after("<div class='form-group col-md-3' id='del_branch' style='display:none;'><label>{{ __('app.filial') }}</label><input  type='text' name='filial_schema' id='change_branch' value='default' class='form-control form-control-sm' /></div>");
                    $('#change_branch').val(branch_schema);
                    
                }
                },
                error: function(error) {
                console.log(error);
                }
                });
        });
        

        function userFunction() {
            var hospital = $("#h_name_f_user").val();
            var _token   = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                url: "/user/has",
                type:"POST",
                data:{
                data: hospital,
                _token: _token
                },
                success:function(response){
                if(response) {
                    var user_schema = response.data;
                    $('#r_name_f_user').remove();
                    $('#r_name_f').after("<div class='col-sm-6' id='r_name_f_user'><select class='form-control form-control-sm' name='rol_id' ><option value='non' disabled selected hidden id='r_name_user'></select></div>");

                    if (user_schema) {
                        $.each(user_schema, function( index, value ) {
                        $('#r_name_user').after("<option value='"+value['id']+"'>"+value['role_name']+"</option>");
                    });
                    }  
                }
                },
                error: function(error) {
                console.log(error);
                }
                });
        }
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        
        $(document).ready(function(){
            $("input[type=email]").change(function(){
                var email = $('.for_email').val();
                var _token   = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                url: "/user/has_email",
                type:"POST",
                data:{
                data: email,
                _token: _token
                },
                success:function(response){
                    if (response.data == 'false') {
                        $('#error_email').css('display','');
                        $('.for_email_button').css('display','none');

                        
                    }else{
                        $('.for_email_button').css('display','');
                        $('#error_email').css('display','none');
                    }
                },
                error: function(error) {
                }
                });
            });

            $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
        });
        
</script>   
</html>
