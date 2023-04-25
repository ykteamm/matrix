    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Secular One' rel='stylesheet'>
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/css/bootstrap.min.css') }}" /> --}}
    <link href="{{ asset('/assets/plugins/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/simple-calendar/simple-calendar.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/feather.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">


    {{-- <link href="{{ asset('/assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('/assets/plugins/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/datatables/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/datatables/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/calendar.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/plugins/daterangepicker/daterangepicker.css') }}" />
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> --}}
    
    <style>
        .select2-dropdown .select2-dropdown--below
        {
            width: 100% !important;
        }
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
        .calender-col {
            margin-top: 45px !important;
        }
        @media(min-width:1092px) {

            .logtop {
                margin-top: 250px;
                /* color: rgb(210, 108, 13) !important; */
            }
        }
        @media(min-width:1213px) {

            .logtop {
                margin-top: 333px;
                /* color: rgb(210, 108, 13) !important; */
            }
            }
             @media(min-width:1365px) {

            .logtop {
                margin-top: 420px;
                /* color: rgb(210, 108, 13) !important; */
            }
            }
            @media(min-width:1456px) {

            .logtop {
                margin-top: 478px;
                /* color: rgb(210, 108, 13) !important; */
            }
            }
            @media(min-width:1638px) {

            .logtop {
                margin-top: 588px;
                /* color: rgb(210, 108, 13) !important; */
            }
            }
            @media(min-width:2184px) {

.logtop {
    margin-top: 915px;
    /* color: rgb(210, 108, 13) !important; */
}
}
@media(min-width:412px) {

.logtop {
    margin-top: 500px;
    /* color: rgb(210, 108, 13) !important; */
}
}
@media(max-width:375px) {

.logtop {
    margin-top: 275px;
    /* color: rgb(210, 108, 13) !important; */
}
}
    </style>
