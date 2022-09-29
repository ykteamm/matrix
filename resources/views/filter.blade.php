@extends('admin.layouts.app')
@section('admin_content')
<div class="content container-fluid main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')
      <div class="card flex-fill">
    
         <div style="border-bottom-radius:30px !important;margin-left:auto">
            <div class="justify-content-between align-items-center p-2" >
                 <div class="btn-group">
                  <div class="row">
                     <div class="col-md-12" align="center">
                              Viloyat
                     </div>
                     <div class="col-md-12">
                        <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Hammasi</button>
                        <div class="dropdown-menu" style="left:150px !important">
                        <a href="#" onclick="ageChart('Hammasi','all','all')" class="dropdown-item" id="tgregion"> Hammasi </a>
                           @foreach($regions as $region)
                           <a href="#" onclick="ageChart(`{{$region->name}}`,`{{$region->id}}`,'all')" class="dropdown-item" id="tgregion"> {{$region->name}} </a>
                           @endforeach
                        </div>
                     </div>
                  </div>
                 </div>
                 <div class="btn-group">
                      <div class="row">
                        <div class="col-md-12" align="center">
                                 Sana
                        </div>
                        <div class="col-md-12">
                           <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_today"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Bugun </button>
                           <div class="dropdown-menu timeclass">
                           <a href="#" onclick="timeElchi('a_all')" class="dropdown-item" id="a_all">Hammasi </a>

                              <a href="#" onclick="timeElchi('a_today')" class="dropdown-item" id="a_today"> Bugun </a>
                              <a href="#" onclick="timeElchi('a_week')" class="dropdown-item" id="a_week">Hafta </a>
                              <a href="#" onclick="timeElchi('a_month')" class="dropdown-item" id="a_month">Oy  </a>
                              <a href="#" onclick="timeElchi('a_year')" class="dropdown-item" id="a_year">Yil </a>
                              {{-- <input type="date" class="form-control" > --}}
                       <input type="text" name="datetimes" class="form-control"/>
                              
                           </div>
                        </div>
                     </div>
                 </div>
                 <div class="btn-group">
                     <div class="row">
                         <div class="col-md-12" align="center">
                                 Mahsulot
                         </div>
                         <div class="col-md-12">
                         <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button3" title="all" name="all" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Hammasi</button>
                         <div class="dropdown-menu" style="overflow-y:scroll; height:400px;">
                         
                         <a href="#" onclick="medicine('Hammasi','all')" class="dropdown-item"> Hammasi </a>
                             @foreach($category as $cat)
                             <a href="#" style="color:red;font-size:20px" onclick="medicineCat(`{{$cat->name}}`,`{{$cat->id}}`,'all')" class="dropdown-item"><b> {{$cat->name}} </b></a>

                             @foreach($medicine as $med)
                                 @if($cat->id == $med->category_id)
                                     <a href="#" style="margin-left:5%;" onclick="medicine(`{{$med->name}}`,`{{$med->id}}`,'all')" class="dropdown-item"> {{$med->name}} </a>
                                 @endif
                             @endforeach
                             @endforeach
                         </div>
                         </div>
                     </div>
                 </div>
                 <div class="btn-group">
                     <div class="row">
                        <div class="col-md-12" align="center">
                                 Elchi
                        </div>
                        <div class="col-md-12">
                           <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button4" name="all" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Hammasi</button>
                           <div class="dropdown-menu" style="overflow-y:scroll; height:400px;">
                              <a href="#" onclick="users('Hammasi','all')" class="dropdown-item" id="addregionall"> Hammasi </a>
                              @foreach($users as $user)
                              <a href="#" onclick="users(`{{$user->last_name}} {{$user->first_name}}`,`{{$user->id}}`)" class="dropdown-item regionall"> {{$user->last_name}} {{$user->first_name}} </a>
                              @endforeach
                           </div>
                        </div>
                     </div>
                 </div>
                 <div class="btn-group" style="margin-right:30px !important;margin-top:20px;">
                     <div class="row">
                        <div class="col-md-12" align="center">
                           
                        </div>
                        <div class="col-md-12">
                           <button type="button" class="btn btn-block btn-outline-primary" onclick="refresh()"> Tozalash</button>
                           
                        </div>
                     </div>
                 </div>
            </div>
         </div>
     </div>
   </div>
    <div>
        <div class="main-wrapper headbot">
            <div class="content" style="background-color: rgb(254, 254, 254);margin-top:10px;">
               {{-- <div class="content" style="background-color: rgb(246, 246, 246);position:fixed;z-index:1000;margin-top:-15px;top:0"> --}}
                
                {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-12">
                       <div style="text-align: center;">
                            <a href="/"><img src="{{asset('nvt/logo2.png')}}" alt="" height="100px"></a>
        
                            </div>
                    </div>  --}}
                    {{-- <div class="col-sm-12" > --}}
                        
                        
                    {{-- </div> --}}
                {{-- </div> --}}
            </div>
            <div class="content mt-1">
                <div class="row">
                        <div div class="col-sm-12" >
                    
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-stripped">
                                        <thead>
                                            <tr id="">
                                            <th>FIO </th>
                                            <th>Mahsulot </th>
                                            <th>Order </th>
                                            <th>Soni </th>
                                            <th>Viloyat </th>
                                            <th>Sana </th>
                                            <th>Soat </th>
                                            </tr>
                                        </thead>
                                        <tbody id="fortbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-lg-4" id="mainallcat" style="display:none;">
                                  <div class="card flex-fill">
                                     <div class="card-header">
                                        <h4 class="card-title" id="allcat"></h4>
                                     </div>
                                     <div class="card-body">
                                        <ul class="activity-feed" id="allul">
    
                                           
                                        </ul>
                                     </div>
                                  </div>
                               </div>
                               <div class="col-lg-4" id="mainallpro" style="display:none;">
                                  <div class="card flex-fill">
                                     <div class="card-header">
                                        <h4 class="card-title" id="allpro"></h4>
                                     </div>
                                     <div class="card-body">
                                        <ul class="activity-feed" id="proil">
                                        </ul>
                                     </div>
                                  </div>
                               </div>
                               
                            </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin_script')
<script>
   $(function() {
  $('input[name="datetimes"]').daterangepicker({
   //  timePicker: true,
   //  startDate: moment().startOf('hour'),
   //  endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      format: 'DD.MM.YYYY'
    }
  });
  $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {

  var tim = picker.startDate.format('DD.MM.YYYY')+'/'+picker.endDate.format('DD.MM.YYYY');
  console.log(tim)

  $("#age_button2").text(tim);
          $("#age_button2").attr('name',tim);
          var id = $("#age_button").attr('name');
          var text = $("#age_button").text();
          ageChart(text,id,'all');



  });
});
    $(document).ready(function(){
         // $("#age_button2").text('Bugun');
         // $("#age_button2").attr('name','dasdas');


       ageChart('Hammasi','all','all');
    });
       function ageChart(name,id,ids,cate){
          if(cate){
          var cate = $("#age_button3").attr('title');
          var medic = 'cate';
             
          }
          else{
             var medic = $("#age_button3").attr('name');
             var cate = 'med';
 
 
          }
          $("#age_button").attr('name',id);
          $("#age_button").text(name);
          var t_time = $("#age_button2").attr('name');
          var user = $("#age_button4").attr('name');
          var _token   = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
             url: "/region/elchi",
             type:"POST",
             data:{
                id: id,
                time: t_time,
                medi: medic,
                user: user,
                order: ids,
                cate: cate,
                _token: _token
             },
             success:function(response){
                if(response) {
                  $('.regionall').remove();

                  $.each(response.reid, function(index, value){

                     var $row = $('<a onclick="users(`'+value.last_name+' '+ value.first_name+'`,`'+value.id+'`)" href="#" class="dropdown-item regionall" >'
                                       + value.last_name + value.first_name +
                                  '</a>'); 
                     $('#addregionall').after($row);
                     
                  });


                   $('.fortr').remove();
                   $.each(response.data, function(index, value){
                      var d = new Date(value.m_data);
 
                            var curr_day = d.getDate();
                            var curr_month = d.getMonth();
                            var curr_year = d.getFullYear();
                            var curr_hour = d.getHours();
                            var curr_minutes = d.getMinutes();
 
                            curr_month++
                            if(curr_month < 10)
                            {
                               var ddate = '0'+curr_month
                            }else{
                               var ddate = curr_month
                            }

                      var $row = $('<tr class="fortr">'+
                                     '<td style="cursor:pointer;" onclick="users(`'+value.ul_name+' '+ value.uf_name+'`,`'+value.uid+'`)">'+ value.ul_name + ' ' + value.uf_name +'</td>'+
                                     '<td onclick="orderId('+value.t_id+')"><button type="button" class="btn btn-block btn-outline-primary">'+ 'order'+value.t_id +'</button></td>'+
                                     '<td>'+ value.m_name +'</td>'+
                                     '<td>'+ value.m_number +'</td>'+
                                     '<td>'+ value.r_name +'</td>'+
                                     '<td>'+ curr_day +'.'+ddate+'.'+curr_year +'</td>'+
                                     '<td>'+ curr_hour +':'+curr_minutes+'</td>'+
                                  '</tr>'); 
                     // console.log($row)

                $('#fortbody').append($row);
                });
                $('.delil').remove();
 
                if(response.user == 'no')
                {
                   $('#mainallcat').css('display','none');
                   $('#mainallpro').css('display','none');
 
 
                }
 
                if(response.sum)
                {
                   $('.delil').remove();
                   $('#mainallcat').css('display','');
                   $('#allcat').text('Hammasi');
                   var $row123 = $('<li class="feed-item delil">'+
                                     '<div class="feed-date">Umumiy summa</div>'+
                                     '<span class="feed-text">'+ response.sum +'</span>'+
                                  '</li>');
                $('#allul').append($row123);
 
                   $.each(response.cateory, function(index, value){
                      var $row123 = $('<li class="feed-item delil">'+
                                     '<div class="feed-date">'+ value.name + '</div>'+
                                     '<span class="feed-text">'+ value.price +'</span>'+
                                  '</li>'); 
                $('#allul').append($row123);
 
                   });
 
 
 
                }
                if(response.medic)
                {
                   $('.delilil').remove();
                   $('#mainallpro').css('display','');
                   $('#allpro').text('Mahsulotlar');
 
                   $.each(response.medic, function(index, value){
                      var $row123 = $('<li class="feed-item delilil">'+
                                     '<div class="feed-date">'+ value.name + ' ( '+ value.number +' )</div>'+
                                     '<span class="feed-text">'+ value.price +'</span>'+
                                  '</li>'); 
                $('#proil').append($row123);
 
                   });
 
 
 
                }
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
          var id = $("#age_button").attr('name');
          var text = $("#age_button").text();
 
          ageChart(text,id,'all');
 
       };
       function medicine(name,id){
          $("#age_button3").attr('name',id);
          $("#age_button3").text(name);
          var id = $("#age_button").attr('name');
          var text = $("#age_button").text();
 
          ageChart(text,id,'all');
       }
       function medicineCat(name,id){
          $("#age_button3").attr('title',id);
          $("#age_button3").text(name);
          var id = $("#age_button").attr('name');
          var text = $("#age_button").text();
 
          ageChart(text,id,'all','cat');
       }
 
       function users(name,id){
          $("#age_button4").attr('name',id);
          $("#age_button4").text(name);
          var id = $("#age_button").attr('name');
          var text = $("#age_button").text();
            // alert(id)
          ageChart(text,id,'all');
       }
       function orderId(ids){
          var id = $("#age_button").attr('name');
          var text = $("#age_button").text();
 
          ageChart(text,id,ids);
       }
       function refresh()
       {
          location.reload();
       }
 
       function getDate(){
          var date = new Date($('#date-input').val());
   var day = date.getDate();
   var month = date.getMonth() + 1;
   var year = date.getFullYear();
   if(month < 10)
                            {
                               var ddate = '0'+month
                            }else{
                               var ddate = month
                            }
                            var date1 = [year, ddate, day].join('-')
                            $("#age_button2").text(date1);
          $("#age_button2").attr('name',date1);
          var id = $("#age_button").attr('name');
          var text = $("#age_button").text();
          $('#age_button2').click()
          ageChart(text,id,'all');
 
       }
   
 
         // var chart = new ApexCharts(document.querySelector("#chart"), options);
         // chart.render();
 
         window.addEventListener('load', function () {
     // Fetch all the forms we want to apply custom Bootstrap validation styles to
     var forms = document.getElementsByClassName('needs-validation');
     // Loop over them and prevent submission
     var validation = Array.prototype.filter.call(forms, function (form) {
         form.addEventListener('submit', function (event) {
             if (form.checkValidity() === false) {
                 event.preventDefault();
                 event.stopPropagation();
             }
             form.classList.add('was-validated');
         }, false);
     });
 }, false);
 
 
   </script>
@endsection