@extends('admin.layouts.app')
@section('admin_content')
<div class="content container-fluid mt-1">
   
   <div class="row calender-col" style="background-color: rgb(246, 246, 246);position:inherit;z-index:1000;margin-top:-15px;top:0">
      <div class="col-xl-12 d-flex">
      <div class="card flex-fill">
      <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
         <h5 class="card-title">                  <img src="{{asset('nvt/logo2.png')}}" style="height: 100px;" class="img-fluid" alt="" />
         </h5>
         <div class="btn-group">
            <div class="row">
                  <div class="col-md-12" align="center">
                           Sana
                  </div>
                  <div class="col-md-12">
                     <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$dateText}} </button>
                     <div class="dropdown-menu timeclass">
                        <a href="{{route('elchi',['id' => $elchi->id,'time' => 'today'])}}" class="dropdown-item">Bugun</a>
                        <a href="{{route('elchi',['id' => $elchi->id,'time' => 'week'])}}" class="dropdown-item">Hafta</a>
                        <a href="{{route('elchi',['id' => $elchi->id,'time' => 'month'])}}" class="dropdown-item">Oy</a>
                        <a href="{{route('elchi',['id' => $elchi->id,'time' => 'year'])}}" class="dropdown-item">Yil</a>
                        <a href="{{route('elchi',['id' => $elchi->id,'time' => 'all'])}}" class="dropdown-item" id="aftertime">Hammasi</a>
                        <input type="text" name="datetimes" class="form-control"/>
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
<div class="content container-fluid">
    <div class="row">
       <div class="col-12 col-xl-4 d-flex flex-wrap">
          <div class="card">
             <div class="card-body">
                <div class="general-details text-center">
                   <img src="http://138.68.81.139:8100/media/users/users.png" style="width:150px" class="img-fluid" alt="" />
                   <h4>{{$elchi->last_name}} {{$elchi->first_name}} </h4>
                   {{-- <h6><a href="../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="0f697d6e616c4f6a776e627f636a216c6062">[email&#160;protected] </a></h6> --}}
                   {{-- <a href="chat.html" class="btn-chat">{{$elchi->v_name}}</a> --}}
                   {{-- <h4>{{$elchi->v_name}}</h4> --}}
                   {{-- <h4>{{$elchi->d_name}}</h4> --}}

                </div>
             </div>
          </div>
       </div>
       <div class="col-12 col-xl-8 d-flex flex-wrap">
          <div class="card">
             <div class="card-body pb-0" style="margin-top: 35px;">
                <div class="patient-details d-block">
                   <div class="details-list">
                     <div>
                        <h6>Username</h6>
                        <span class="ml-auto">{{$elchi->username}} </span>
                     </div>
                      <div>
                         <h6>Telefon raqami</h6>
                         <span class="ml-auto">{{$elchi->phone_number}} </span>
                      </div>
                      <div>
                        <h6>Lavozimi</h6>
                        <span class="ml-auto">{{$elchi->lv}} </span>
                     </div>
                           {{-- <td>{{date('Y',(strtotime ( today()) )) - date('Y',(strtotime ( $item->birthday) ))}} </td> --}}

                      <div>
                         <h6>Tug'ilgan sanasi</h6>
                         <span class="ml-auto">{{date('d.m.Y',(strtotime ( $elchi->birthday) ))}}</span>
                      </div>
                      <div>
                        <h6>Yoshi</h6>
                        <span class="ml-auto">{{date('Y',(strtotime ( today()) )) - date('Y',(strtotime ( $elchi->birthday) ))}}</span>
                     </div>

                      
                      <div>
                         <h6>Viloyat</h6>
                         <span class="ml-auto">{{$elchi->v_name}} </span>
                      </div>
                      <div>
                        <h6>Tuman</h6>
                        <span class="ml-auto">{{$elchi->d_name}} </span>
                     </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap" onclick="tabNone('solid-tab1')"
      onmouseover="$(this)
       .css('cursor','pointer')"  
      >
         <div class="card" style="background-color: #3b3d83">
            <div class="card-body">
               <div class="dash-contetnt">
                  <h2 style="color:#ffffff;text-align:center;">Barchasi</h2>
                  <h3 style="color:#ffffff;text-align:center;">{{ number_format($sum, 0, '', ' ')}} so'm</h3>
               </div>
            </div>
         </div>
      </div>
      @php $i=2 @endphp

      @foreach ($cateory as $key => $item)
       <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap nav-link solid-tab{{$i}} dborder" onclick="tabNone('solid-tab{{$i}}')"
       onmouseover="$(this)
       .css('cursor','pointer')" 
      style="border-bottom: 3px solid #3b3d83"

       >
         <div class="card detail-box1{{$i}}" >
            <div class="card-body">
               <div class="dash-contetnt">
                  <h2 style="color:#ffffff;text-align:center;">{{$item['name']}}</h2>
                  <h3 style="color:#ffffff;text-align:center;">{{ number_format($item['price'], 0, '', ' ')}} so'm</h3>
               </div>
            </div>
         </div>
      </div>
       
       @php $i = $i + 1 @endphp
      


      @endforeach

   </div>
    <div class="row" id="maindata">
        <div class="col-lg-12" id="da">
            <div class="card">
               <div class="card-body">
                  <div class="tab-content pt-0">
                    @php $i=2 @endphp
                    <div class="tab-pane show active dnone" id="solid-tab1">
                        <div class="tab-data">
                            <div class="col-lg-12">
                                <div class="card flex-fill">
                                   <div class="card-body">
                                      <div class="table-responsive">
                                         <table class="table mb-0" id="dtBasicExample">
                                            <thead>
                                               <tr>
                                                  <th>Mahsulot nomi</th>
                                                  <th>Soni</th>
                                                  <th>Summasi </th>
                                                  {{-- <th class="text-right">Summary </th> --}}
                                               </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $n = 0
                                                @endphp
                                            @foreach ($medic as $mkey => $mitem)
                                                <tr>
                                                    <td>{{$mitem['name']}} </td>
                                                    <td>{{$mitem['number']}} </td>
                                                    <td>{{ number_format($mitem['price'], 0, '', ' ')}}</td>
                                                    {{-- <td class="text-right"><a href="#">View Summary </a></td> --}}
                                                 </tr>
                                                 @php
                                                     $n += $mitem['number']
                                                 @endphp
                                            @endforeach
                                                 {{-- <tr>
                                                    <td>Jami</td>
                                                    <td>{{$n}} </td>
                                                    <td>{{$sum}}</td>
                                                 </tr> --}}
                                            </tbody>
                                         </table>
                                      </div>
                                   </div>
                                </div>
                             </div>
                        </div>
                     </div>
                    @foreach ($cateory as $key => $item)
                     <div class="tab-pane dnone" id="solid-tab{{$i}}" style="display:none;">
                        <div class="tab-data">
                            <div class="col-lg-12">
                                <div class="card flex-fill">
                                   <div class="card-body">
                                      <div class="table-responsive">
                                         <table class="table mb-0">
                                            <thead>
                                               <tr>
                                                  <th>Mahsulot nomi</th>
                                                  <th>Soni</th>
                                                  <th>Summasi </th>
                                                  {{-- <th class="text-right">Summary </th> --}}
                                               </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $t = 0
                                            @endphp
                                            @foreach ($medic as $mkey => $mitem)
                                                @if ($item['id'] == $mitem['cid'])
                                                <tr>
                                                    <td>{{$mitem['name']}} </td>
                                                    <td>{{$mitem['number']}} </td>
                                                    <td>{{ number_format($mitem['price'], 0, '', ' ')}}</td>

                                                    {{-- <td class="text-right"><a href="#">View Summary </a></td> --}}
                                                 </tr>
                                                 @php
                                                 $t += $mitem['number']
                                             @endphp
                                                @endif
                                               
                                            @endforeach
                                            {{-- <tr>
                                                <td>Jami</td>
                                                <td>{{$t}} </td>
                                                <td>{{$item['price']}}</td>
                                             </tr> --}}
                                             @php
                                                $t = 0
                                            @endphp
                                            </tbody>
                                         </table>
                                      </div>
                                   </div>
                                </div>
                             </div>
                        </div>
                     </div>
                     @php $i = $i + 1 @endphp
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

      $(function() {
  $('input[name="datetimes"]').daterangepicker({
   //  timePicker: true,
   //  startDate: moment().startOf('hour'),
   //  endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      format: 'DD.MM.YY'
    }
  });
  $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
      // $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  console.log(picker.startDate.format('YYYY-MM-DD'))
  window.location = $(this).data("href");
  var tim = picker.startDate.format('YYYY-MM-DD')+'_'+picker.endDate.format('YYYY-MM-DD');
var id = <?php echo json_encode($elchi->id); ?>;
	var url = "{{ route('elchi',['id' => ':id','time' => ':tim']) }}";
	url = url.replace(':tim', tim);
	url = url.replace(':id', id);
	location.href = url;

  });
});
      function tabNone(tab)
      {
         $('.dnone').css('display','none')
         $(`#${tab}`).css('display','block')

         $('.dborder').css('border-top','none')
       .css('border-left','none')
       .css('border-right','none')
       .css('border-bottom','3px solid #3b3d83');
       
         $(`.${tab}`).css('border-top','3px solid #3b3d83')
       .css('border-left','3px solid #3b3d83')
       .css('border-top-left-radius','30px')
       .css('border-top-right-radius','30px')
       .css('border-right','3px solid #3b3d83')
       .css('border-bottom','none');

       $('#maindata').css('border','3px solid #3b3d83')
       .css('border-top','none').css('border-bottom','none');
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
                           // $("#age_button2").text(date1);
         // $('#age_button2').click()
         $('#aftertime').after(`<a href='{{route('elchi',['id' => $elchi->id,'time' => 'week'])}}' class='dropdown-item'>Hammasi</a>`)

         // region(date1);    

      }
   </script>
@endsection