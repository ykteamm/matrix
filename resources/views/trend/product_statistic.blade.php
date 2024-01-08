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
                        <a href="{{route('trend.product','three')}}">
                        <button type="button" class="btn btn-block btn-outline-primary"> 3 oy</button>
                        </a>
                     </div>
                  </div>
                 </div>
                 <div class="btn-group">
                      <div class="row">
                        <div class="col-md-12">
                           <a href="{{route('trend.product','six')}}">
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
{{--                 @dd($medicine)--}}
                 {{$regionID->name}}
               @foreach ($category as $cate)
               <div class="row">

                  {{$cate->name}}
               </div>
               <div class="row" id="myregionid{{$cate->id}}">

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
            var medicine = <?php echo json_encode($medicine)  ?>;
            var category = <?php echo json_encode($category)?>


                $.each(category, function (index, categoryInfo) {
                    // console.log(index)
                    // console.log(categoryInfo) // category_id
                    var filteredJson = {};

                $.each(json[categoryInfo.id], function (medId, medData) {
                    var medicineInfo = medicine.find(med => med.id == medId);

                    if (medicineInfo) {
                        filteredJson[medId] = medData;
                    }
                });

                // Diagramma ma'lumotlari
                var seriesArray = Object.keys(filteredJson).map(medId => ({
                    name: medicine.find(med => med.id == medId).name,
                    // data: filteredJson[medId].map(data => ({ x: data.month, y: data.allprice })),
                    data: filteredJson[medId].map(data => data.allprice),
                }));
                console.log(seriesArray)

                    var region = {
                        series: seriesArray,
                        chart: {
                            height: 500,
                            type: 'area'
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        xaxis: {
                            categories: date_array
                        },
                    };
                    // console.log(date_array)
                    var regionChart = new ApexCharts(document.querySelector(`#myregionid${categoryInfo.id}`), region);
                    regionChart.render();
                });
      </script>
@endsection
