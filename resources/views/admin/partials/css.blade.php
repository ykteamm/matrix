    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/css/bootstrap.min.css') }}" /> --}}
    <link href="{{ asset('/assets/plugins/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/simple-calendar/simple-calendar.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/feather.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">


    <link href="{{ asset('/assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
