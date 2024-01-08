@extends('admin.layouts.app')
@section('admin_content')
<div class="content mt-1 main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')
      <div class="card flex-fill">

         <div style="border-bottom-radius:30px !important;margin-left:auto">
            <div class="justify-content-between align-items-center p-2" >
                 <div class="btn-group">
                  <div class="row">
                     <div class="col-md-12">
                        <a href="{{route('trend.region','three')}}">
                        <button type="button" class="btn btn-block btn-outline-primary"> 3 oy</button>
                        </a>
                     </div>
                  </div>
                 </div>
                 <div class="btn-group">
                      <div class="row">
                        <div class="col-md-12">
                           <a href="{{route('trend.region','six')}}">
                              <button type="button" class="btn btn-block btn-outline-primary"> 6 oy</button>
                              </a>
                        </div>
                     </div>
                 </div>
            </div>
         </div>
     </div>
   </div>


<div class="content headbot">
    <div class="row">
       <div class="col-12 col-xl-12 d-flex flex-wrap">
          <div class="card">
             <div class="card-body">
               @foreach ($regions as $item)
               <div class="row">
                  {{$item->name}}
               </div>
               <div class="row" id="myregionid{{$item->id}}">

               </div>
               @endforeach
             </div>
          </div>
       </div>
    </div>
</div>

</div>
@endsection
@section('admin_script')
      <script>
            var json = <?php echo json_encode( $json ) ?>;
            var date_array = <?php echo json_encode( $date_array ) ?>;
            $.each(json, function(index, value){

               var region = {
                    series: [{
                    name: 'Summa',
                    data: json[index]
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
                     // show: false,
                     // labels: {
                     //    show: false
                     // },
                     // axisBorder: {
                     //    show: false
                     // },
                     // axisTicks: {
                     //    show: false
                     // },
                    categories: date_array
                    },
                };
                var regionChart = new ApexCharts(document.querySelector(`#myregionid${index}`), region);
                regionChart.render();
            });

      </script>
@endsection
