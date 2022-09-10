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
</head>
<body>
    <div class="main-wrapper">
        {{-- @include('components.flash'); --}}
        {{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif --}}
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
$(document).ready(function () {
  $('#dtBasicExample').DataTable();
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
