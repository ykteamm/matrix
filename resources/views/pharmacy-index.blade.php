@extends('admin.layouts.app')
@section('admin_content')
<div class="content mt-1 main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')
      <div class="card flex-fill mt-5">

         <div class="btn-group mr-5 ml-auto">
           <div class="row">
              <div class="col-md-12" align="center">
                       Sana
              </div>
              <div class="col-md-12">
                 <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$dateText}} </button>
                 <div class="dropdown-menu timeclass">
                    <a href="{{route('pharmacy',['id' => $pharma->id,'time' => 'today'])}}" class="dropdown-item">Bugun</a>
                    <a href="{{route('pharmacy',['id' => $pharma->id,'time' => 'week'])}}" class="dropdown-item">Hafta</a>
                    <a href="{{route('pharmacy',['id' => $pharma->id,'time' => 'month'])}}" class="dropdown-item">Oy</a>
                    <a href="{{route('pharmacy',['id' => $pharma->id,'time' => 'year'])}}" class="dropdown-item">Yil</a>
                    <a href="{{route('pharmacy',['id' => $pharma->id,'time' => 'all'])}}" class="dropdown-item" id="aftertime">Hammasi</a>
                    <input type="text" name="datetimes" class="form-control"/>
                 </div>
              </div>
           </div>
         </div>
      </div>
      </div>


<div class="content headbot">
    <div class="row">
       <div class="col-12 col-xl-4 d-flex flex-wrap">
          <div class="card">
             <div class="card-body">
                <div class="text-center">
                   <img src="{{$pharma->image}}" style="border-radius:10%" height="200px">
                   <h2><span class="ml-auto">{{$pharma->name}} </span></h2>
               </div>
             </div>
          </div>
       </div>
       <div class="col-12 col-xl-4 d-flex flex-wrap">
          <div class="card">
             <div style="margin-top: 35px;">
                <div class="patient-details d-block">
                   <div class="details-list">
                      <div class="mr-5">
                         <h2>Telefon raqami</h2>
                         <span class="ml-auto">{{$pharma->phone_number}} </span>
                      </div>
                      <div>
                        <h2>Maydoni</h2>
                        <span class="ml-auto">{{$pharma->volume}} m<sup>2</sup></span>
                     </div>
                     <div>
                        @php
                            $json = json_decode($pharma->location);
                        @endphp
                        <h2>Maydoni</h2>
                        <span class="ml-auto">{{$pharma->region->name}} </span>
                     </div>
                     
                   </div>
                   
                </div>
             </div>
          </div>  
       </div>
       <div class="col-4 col-xl-4 d-flex flex-wrap">  
        <div class="card">
         <div class="card-body">
            <div class="text-center">
               <div id="map" style="width: 300px; height: 300px"></div>    

           </div>
         </div>
      </div>
      </div>
       
    </div>
    <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <div class="table-responsive" id="asdasd">
               <table class="table mb-0" id="example12366">
                  <thead>
                     <tr>
                        <th>Id</th>
                        <th>Mahsulot nomi1</th>
                        <th>Soni</th>
                        <th>Summasi</th>
                     </tr>
                  </thead>
                  <tbody>
                      @php
                          $n = 0
                      @endphp
                  @foreach ($user_sold as $mkey => $mitem)
                      <tr>
                           <td>{{$mitem->id}}</td>
                          <td>{{$mitem->name}} </td>
                          <td>{{$mitem->count}} </td>
                          <td>{{ number_format($mitem->price, 0, '', ' ')}}</td>
                          {{-- <td class="text-right"><a href="#">View Summary </a></td> --}}
                       </tr>
                       @php
                           $n += $mitem->count
                       @endphp
                  @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
    {{-- <div class="col-sm-12">
      <div class="card">
         <div class="card-body">
            <div class="table-responsive">
               <table class="table mb-0" id="dtBasicExample">
                  <thead>
                     <tr>
                        <th>№</th>
                        <th>FIO</th>
                        <th>Summa</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($user_sold as $item)
                     <tr
                        >
                        <td>{{$item->last_name}}</td>
                        <td>{{$item->first_name}}</td>
                        <td>{{$item->allprice}}</td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div> --}}

</div>

</div>
@endsection
@section('admin_script')
<script>
   $(function() {
  $('input[name="datetimes"]').daterangepicker({
    locale: {
      format: 'DD.MM.YY'
    }
  });
  $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
         window.location = $(this).data("href");
         var tim = picker.startDate.format('YYYY-MM-DD')+'_'+picker.endDate.format('YYYY-MM-DD');
         var id = <?php echo json_encode($pharma->id); ?>;
            var url = "{{ route('pharmacy',['id' => ':id','time' => ':tim']) }}";
            url = url.replace(':tim', tim);
            url = url.replace(':id', id);
            location.href = url;

  });

});
</script>
      <script type="text/javascript">
         ymaps.ready(init);
         function init(){
         var lat = <?php echo json_encode($json->lat); ?>;
         var long = <?php echo json_encode($json->long); ?>;
            var myMap = new ymaps.Map("map", {
                  center: [lat,long],
                  zoom: 10
            });
            var placemark = new ymaps.Placemark([lat, long], {}, {
               preset: "islands#yellowStretchyIcon",
               iconColor: '#ff0000'
            });
            myMap.geoObjects.add(placemark);
         };
         
      </script>
   <script>
      
      $(document).ready(function(){
       farmChart('a_today');
      });
      function farmChart(t_time,user){
         var id = <?php echo json_encode($pharma->id); ?>;
          var _token   = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
             url: "/farm/chart",
             type:"POST",
             data:{
                id:id,
                time: t_time,
                _token: _token
             },
             success:function(response){
                if(response) {
                  console.log(response)
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
          var text = $("#age_button2").attr('name');
          farmChart(text);
      };
   </script>
@endsection
