@extends('admin.layouts.app')
@section('admin_content')
<div class="content mt-1 main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')
  
        <div class="card flex-fill">
         
          <div class="btn-group mr-5 ml-auto">
            <div class="row">
               <div class="col-md-12" align="center">
                        Sana
               </div>
               <div class="col-md-12">
                  <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$dateText}} </button>
                  <div class="dropdown-menu timeclass">
                     <a href="{{route('pro-list',['time' => 'today'])}}" class="dropdown-item">Bugun</a>
                     <a href="{{route('pro-list',['time' => 'week'])}}" class="dropdown-item">Hafta</a>
                     <a href="{{route('pro-list',['time' => 'month'])}}" class="dropdown-item">Oy</a>
                     <a href="{{route('pro-list',['time' => 'year'])}}" class="dropdown-item">Yil</a>
                     <a href="{{route('pro-list',['time' => 'all'])}}" class="dropdown-item" id="aftertime">Hammasi</a>
                     <input type="text" name="datetimes" class="form-control"/>
                  </div>
               </div>
            </div>
          </div>
       </div>
       <div class="card flex-fill">
    
        <div style="border-bottom-radius:30px !important;margin-left:auto">
           <div class="justify-content-between align-items-center p-2 pr-5" >
                
                
                <div class="btn-group">
                          <button type="button" class="btn btn-block btn-outline-primary" onclick="$('#tartib').css('display','');$('#notartib').css('display','none')"> Guruhlangan </button>
                </div>
                <div class="btn-group">
                          <button type="button" class="btn btn-block btn-outline-primary" onclick="$('#notartib').css('display','');$('#tartib').css('display','none')"> Guruhlanmagan</button>
                </div>
           </div>
        </div>
    </div>
       
      </div>

      <div class="card-body headbot" id="tartib">
        <ul class="nav nav-tabs nav-tabs-solid nav-justified">
        
        @foreach ($category as $key => $citem)
        <li class="nav-item"><a class="nav-link @if($key == 0) active @endif " href="#solid-justified-tab{{$key+1}}" data-toggle="tab">{{$citem->name}}</a></li>
           
        @endforeach
        
        </ul>
        <div class="tab-content">
            @foreach ($category as $key => $citem)

                <div class="tab-pane show @if($key == 0) active @endif" id="solid-justified-tab{{$key+1}}">
                    <div class="row headbot">
                        <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        
                                    <thead>
                                        <tr>
                                            <th>Nomi</th>
                                            {{-- <th>Tannarxi</th> --}}
                                            <th>Soni</th>
                                            {{-- <th>Yoshi </th> --}}
                                            <th>Summasi </th>
                                            {{-- <th>Telefon raqami </th> --}}
                                            {{-- <th>Email </th>
                                            <th class="text-right">Action </th> --}}
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($medic as $item)
                                        @if($citem->id == $item['cid'] && $item['nol'] == 1)
                                        <tr
                                            >
                                            
                                            {{-- <td class="pl-5">{{$citem->id}} </td> --}}

                                            <td><span title="{{$item['narx']}}" data-toggle="tooltip" data-placement="top">{{$item['name']}}</span> </td>
                                            {{-- <td>{{$item['narx']}}</td> --}}
                                            <td>{{$item['number']}}</td>
                                            {{-- <td>{{date('Y',(strtotime ( today()) )) - date('Y',(strtotime ( $item->birthday) ))}} </td> --}}
                                            <td class="sorting_4">{{$item['price']}}</td>
                                            
                                            
                                        </tr>
                                        @endif
                                        
                                        @endforeach
                                        @foreach ($medic as $item)
                                        @if($citem->id == $item['cid'] && $item['nol'] == 0)
                                        <tr class="forc{{$citem->id}}" style="display: none;"
                                            >
                                            

                                            <td><span title="{{$item['narx']}}" data-toggle="tooltip" data-placement="top">{{$item['name']}}</span> </td>

                                            <td>{{$item['number']}}</td>
                                            <td>{{$item['price']}}</td>
                                            
                                            
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                    </table>
                                </div>
                                <div class="mt-2" style="text-align: center;"> <button type="button" class="btn btn-block btn-primary" onclick="koproq('forc'+{{$citem->id}})">Ko'proq ko'rish</button></div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            @endforeach
        
        </div>
      </div>

      
     <div class="row headbot" id="notartib" style="display: none;">
        <div class="col-sm-12">
           <div class="card">
              <div class="card-body">
                 <div class="table-responsive">
                    <table class="table mb-0" id="dtBasicExample12">
                        
                       <thead>
                          <tr>
                             {{-- <th>id</th> --}}
                             <th>Nomi</th>
                             <th>Soni</th>
                             {{-- <th>Yoshi </th> --}}
                             <th>Summasi </th>
                             {{-- <th>Telefon raqami </th> --}}
                             {{-- <th>Email </th>
                             <th class="text-right">Action </th> --}}
                          </tr>
                       </thead>
                       
                       <tbody>
                        
                        
                          @foreach ($medic as $item)
                          @if($item['nol'] == 1)

                          <tr>
                             {{-- <td class="pl-5">{{$item['name']}} </td> --}}
                             <td><span title="{{$item['narx']}}" data-toggle="tooltip" data-placement="top">{{$item['name']}}</span> </td>

                             {{-- <td>{{$item['narx']}}</td> --}}
                             <td>{{$item['number']}}</td>
                             <td class="sorting_1">{{$item['price']}}</td>
                          </tr>
                          @endif
                          @endforeach
                       </tbody>
                    </table>
                 </div>
              </div>
           </div>
        </div>
     </div>
</div>
@endsection
@section('admin_script')
   <script>
    function koproq(name){
        // console.log(name)
        // if(name == 'Choy')
        // {
            $(`.${name}`).css('display','');
            $(this).css('display','none');
        // }
    }
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
	var url = "{{ route('pro-list',['time' => ':tim']) }}";
	url = url.replace(':tim', tim);
	location.href = url;

  });
});
$(document).on('click','#filter2_search',function(){$('#filter2_inputs').slideToggle("slow");});
   </script>
@endsection