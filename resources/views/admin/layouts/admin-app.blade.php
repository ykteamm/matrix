<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Matrix</title>

    @include('admin.partials.css')
    <style>
        .for-table-border {
            border: 1px solid rgb(126, 182, 220);
        }
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
        .modal-content{
            top: 30px !important;
            /* width:160% !important; */
            /* height:90% !important; */
        }
    </style>

</head>
<body>
    <div class="main-wrapper">
        @include('admin.components.admin-header')
        @include('admin.components.admin-sidebar')
        <div class="page-wrapper" style="padding-top: 0px !important">
            @yield('super_admin_content')
        </div>
    </div>
    
</body>

    @include('admin.partials.js')
    @yield('super_admin_script')

    <script>
        $("#adminexample1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,'paginate':false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "order": [[ 4, "desc" ]]

        }).buttons().container().appendTo('#adminexample1_wrapper .col-md-6:eq(0)');
    </script>

</html>
