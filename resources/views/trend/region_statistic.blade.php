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
                <div class="btn-group">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{route('trend.region','twelve')}}">
                                <button type="button" class="btn btn-block btn-outline-primary"> 12 oy</button>
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
{{--               @foreach ($regions as $item)--}}
                 {{$regions->name}}
                 @foreach ($users as $item)
                   <div class="row">
                       {{$item->first_name}} {{$item->last_name}}
    {{--                   @dd($json)--}}
    {{--                   @dd($regions->id)--}}
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
            var region_id = <?php echo json_encode( $regions->id ) ?>;
            var users = <?php echo json_encode($users)  ?>;

            let filteredJson = [];
            $.each(json, function (user_id,Data) {
                    var user = users.find(user => user.id == user_id);
                    // console.log(user)
                    if (user) {
                        filteredJson[user_id] = Data;
                    }
                    // console.log(user_id)
                    // console.log(Data)

                var seriesArray = [{
                   name:`${users.find(user => user.id == user_id).first_name} ${users.find(user => user.id == user_id).last_name}`,
                   data: filteredJson[user_id].map(data => data.allprice),
                }];
                // console.log(seriesArray)

                var userChartOptions = {
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

                var userChart = new ApexCharts(document.querySelector(`#myregionid${user_id}`), userChartOptions);
                userChart.render();
            });

      </script>
@endsection
