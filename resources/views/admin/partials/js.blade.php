 <script type="text/javascript" src="{{ asset('/assets/js/jquery-3.6.0.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>--}}
 <script type="text/javascript" src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/plugins/select2/js/select2.min.js') }}"></script>

 <script type="text/javascript" src="{{ asset('/assets/js/depdrop.js') }}"></script>

 <script type="text/javascript" src="{{ asset('/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/plugins/apexchart/dsh-apaxcharts.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/plugins/simple-calendar/jquery.simple-calendar.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/js/calander.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/plugins/datatables/datatables.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/js/script.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/js/jquery.maskedinput.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/assets/js/mask.js') }}"></script>

 {{-- <script src="{{asset('/assets/plugins/datatables/datatables/jquery.dataTables.min.js')}}"></script> --}}
 <script src="{{ asset('/assets/plugins/datatables/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('/assets/plugins/datatables/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
 <script src="{{ asset('/assets/plugins/datatables/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('/assets/plugins/datatables/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
 <script src="{{ asset('/assets/plugins/datatables/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('/assets/plugins/jszip/jszip.min.js') }}"></script>
 <script src="{{ asset('/assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
 <script src="{{ asset('/assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
 <script src="{{ asset('/assets/plugins/datatables/datatables-buttons/js/buttons.html5.min.js') }}"></script>
 <script src="{{ asset('/assets/plugins/datatables/datatables-buttons/js/buttons.print.min.js') }}"></script>
 <script src="{{ asset('/assets/plugins/datatables/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

 {{-- <script type="text/javascript" src="{{ asset('/assets/js/calendar2.js') }}"></script> --}}
 {{-- <script type="text/javascript" src="{{ asset('/assets/js/popper.js') }}"></script> --}}


 <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 <script type="text/javascript" src="{{ asset('/assets/plugins/daterangepicker/daterangepicker.min.js') }}"></script>
 {{-- <script src="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"></script> --}}

 {{-- EDITOR --}}
 <script src="{{ asset('sceditor/sceditor.min.js') }}"></script>
 <script src="{{ asset('sceditor/icons/monocons.js') }}"></script>
 <script src="{{ asset('sceditor/formats/xhtml.js') }}"></script>
 <script>
     var textarea = document.getElementById('sceditor');
     var sty = window.location.protocol + "//" + window.location.host + '/sceditor/themes/content/default.min.css';
     sceditor.create(textarea, {
         format: 'xhtml',
         icons: 'monocons',
         style: sty
     });

     var themeInput = document.getElementById('sceditortheme');
     themeInput.onchange = function() {
         var stys = window.location.protocol + "//" + window.location.host + '/sceditor/themes'
         var theme = stys + "/" + themeInput.value + '.min.css';
         document.getElementById('theme-style').href = theme;
     };

     function showNw(id) {
         $("#showNw" + id).click()
     }
     function showInfo(id) {
        console.log(id);
            $("#showInfo" + id).click()
        }
        function showVid(id) {
            $("#showVid" + id).click()
        }
 </script>
