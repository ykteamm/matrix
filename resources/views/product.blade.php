@extends('admin.layouts.app')
@section('admin_content')
<div class="content mt-1 main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')
  
        <div class="card flex-fill">
         
         <div class="card flex-fill">
         <div style="border-bottom-radius:30px !important;margin-left:auto">
            <div class="justify-content-between align-items-center p-2" >
               <form action="{{route('pro-list-search')}}" method="post">
                 <div class="btn-group">
                  <div class="row">
                     <div class="col-md-12" align="center">
                              Viloyat
                     </div>
                     <div class="col-md-12">
                        <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$regText}}</button>
                        <div class="dropdown-menu" style="left:150px !important">
                           <a href="#" onclick="region('Hammasi','all')" class="dropdown-item" id="tgregion"> Hammasi </a>
                           @foreach($regions as $region)
                           <a href="#" onclick="region(`{{$region->name}}`,`{{$region->id}}`)" class="dropdown-item" id="tgregion"> {{$region->name}} </a>
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
                           <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$dateText}} </button>
                              <div class="dropdown-menu timeclass">
                                 <a href="#" onclick="dates('today','Bugun')" class="dropdown-item">Bugun</a>
                                 <a href="#" onclick="dates('week','Hafta')" class="dropdown-item">Hafta</a>
                                 <a href="#" onclick="dates('month','Oy')" class="dropdown-item">Oy</a>
                                 <a href="#" onclick="dates('year','Yil')" class="dropdown-item">Yil</a>
                                 <a href="#" onclick="dates('all','Hammasi')" class="dropdown-item" id="aftertime">Hammasi</a>
                                 <input type="text" name="datetimes" class="form-control"/>
                              </div>
                        </div>
                     </div>
                 </div>
                 <div class="btn-group" style="margin-right:30px !important;margin-top:20px;">
                     <div class="row">
                        <div class="col-md-12" align="center">

                        </div>
                        <div class="col-md-12">
                           <button type="button" class="btn btn-block btn-outline-primary" onclick="formButton()">Qidirish</button>
                        </div>
                     </div>
                 </div>
               </form>
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

      <div class="card-body headbot" id="tartib" style="display: none;">
        <ul class="nav nav-tabs nav-tabs-solid nav-justified">
        
        @foreach ($category as $key => $citem)
        <li class="nav-item"><a class="nav-link @if($key == 1) active @endif " href="#solid-justified-tab{{$key+1}}" data-toggle="tab">{{$citem->name}}</a></li>
           
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
                                            <th>Farqi </th>
                                            {{-- <th>Telefon raqami </th> --}}
                                            {{-- <th>Email </th>
                                            <th class="text-right">Action </th> --}}
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($medic as $item)
                                        @if($citem->id == $item['cid'] && $item['nol'] == 1)
                                        @foreach ($medic2 as $item2)
                                          @if($item['mid'] == $item2['mid'] && $item['cid'] == $item2['cid'])
                                        <tr
                                            >
                                            
                                            {{-- <td class="pl-5">{{$citem->id}} </td> --}}

                                            <td><span title="{{$item['narx']}}" data-toggle="tooltip" data-placement="top">{{$item['name']}}</span> </td>
                                            {{-- <td>{{$item['narx']}}</td> --}}
                                            <td>{{$item['number']}}</td>
                                            {{-- <td>{{date('Y',(strtotime ( today()) )) - date('Y',(strtotime ( $item->birthday) ))}} </td> --}}
                                            <td class="sorting_4">
                              {{number_format($item['price'],0,",",".")}}
                           </td>
                                            @if($item['price'] > $item2['price'])
                             <td><i class="fas fa-arrow-up mr-1" style="color:#39f33c;"></i>{{number_format((($item['price'] - $item2['price'])*100)/$item['price'],1)}}%</td>
                             @elseif($item['price'] < $item2['price'])
                            <td><i class="fas fa-arrow-down mr-1" style="color:#f34539;"></i>{{number_format((($item2['price'] - $item['price'])*100)/$item2['price'],1)}}%</td>
                              @else
                            <td>0%</td>

                             @endif
                                            
                                            
                                        </tr>
                                        @endif

                                        @endforeach

                                        @endif
                                        
                                        @endforeach
                                        @foreach ($medic as $item)
                                        @if($citem->id == $item['cid'] && $item['nol'] == 0)
                                        @foreach ($medic2 as $item2)
                                          @if($item['mid'] == $item2['mid'] && $item['cid'] == $item2['cid'])
                                        <tr class="forc{{$citem->id}}" style="display: none;"
                                            >
                                            <td><span title="{{$item['narx']}}" data-toggle="tooltip" data-placement="top">{{$item['name']}}</span> </td>

                                            <td>{{$item['number']}}</td>
                                            <td>
                                             {{number_format($item['price'],0,",",".")}}
                                            </td>
                                            @if($item['price'] > $item2['price'])
                             <td><i class="fas fa-arrow-up mr-1" style="color:#39f33c;"></i>{{number_format((($item['price'] - $item2['price'])*100)/$item['price'],1)}}%</td>
                             @elseif($item['price'] < $item2['price'])
                            <td><i class="fas fa-arrow-down mr-1" style="color:#f34539;"></i>{{number_format((($item2['price'] - $item['price'])*100)/$item2['price'],1)}}%</td>
                              @else
                            <td>0%</td>

                             @endif
                                            
                                            
                                        </tr>
                                        @endif
                                        
                                        @endforeach

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

      
     <div class="row headbot" id="notartib">
        <div class="col-sm-12">
           <div class="card">
              <div class="card-body">
              <div id="dtBasicExample1212"></div>

                 <div class="table-responsive">

                    <table class="table mb-0 " id="dtBasicExample12">
                       <thead>
                          <tr>
                             {{-- <th>id</th> --}}
                             <th>Nomi</th>
                             <th>Soni</th>
                             {{-- <th>Yoshi </th> --}}
                             <th>Summasi </th>
                             <th>Farqi </th>
                             {{-- <th>Telefon raqami </th> --}}
                             {{-- <th>Email </th>
                             <th class="text-right">Action </th> --}}
                          </tr>
                       </thead>
                       
                       <tbody>
                        
                        
                          @foreach ($medic as $item)
                          @if($item['nol'] == 1)
                          @foreach ($medic2 as $item2)
                           @if($item['mid'] == $item2['mid'] && $item['cid'] == $item2['cid'])
                          <tr>
                             {{-- <td class="pl-5">{{$item['name']}} </td> --}}
                             <td><span title="{{$item['narx']}}" data-toggle="tooltip" data-placement="top">{{$item['name']}}</span> </td>

                             {{-- <td>{{$item['narx']}}</td> --}}
                             <td>{{$item['number']}}</td>
                             <td class="sorting_1">
                              {{number_format($item['price'],0,",",".")}}
                              
                           </td>
                             @if($item['price'] > $item2['price'])
                             <td><i class="fas fa-arrow-up mr-1" style="color:#39f33c;"></i>{{number_format((($item['price'] - $item2['price'])*100)/$item['price'],1)}}%</td>
                             @elseif($item['price'] < $item2['price'])
                            <td><i class="fas fa-arrow-down mr-1" style="color:#f34539;"></i>{{number_format((($item2['price'] - $item['price'])*100)/$item2['price'],1)}}%</td>
                              @else
                            <td>0%</td>

                             @endif

                          </tr>
                          @endif
                          @endforeach

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
      function dates(key,text)
      {
         $('#age_button2').text(text);
         $('#age_button2').attr('name',key);
      }
      function formButton()
      {
         var region = $('#age_button').attr('name');
         var tim = $('#age_button2').attr('name');
            var url = "{{ route('pro-list',['time' => ':tim','region' => ':region']) }}";
            url = url.replace(':tim', tim);
            url = url.replace(':region', region);
            location.href = url;
      }
      function region(text,id)
      {
         $('#age_button').text(text);
         $('#age_button').attr('name',id);
      }
      function koproq(name){
               $(`.${name}`).css('display','');
               $(this).css('display','none');
      }
      $(function() {
         $('input[name="datetimes"]').daterangepicker({
            locale: {
               format: 'DD.MM.YYYY'
            }
         });
         $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
            var tim2 = picker.startDate.format('DD.MM.YYYY')+'-'+picker.endDate.format('DD.MM.YYYY');
            var tim = picker.startDate.format('YYYY-MM-DD')+'_'+picker.endDate.format('YYYY-MM-DD');
            $('#age_button2').text(tim2);
            $('#age_button2').attr('name',tim);
         });
      });
   </script>
@endsection