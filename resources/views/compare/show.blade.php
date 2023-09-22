@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        
        <div class="col-sm-12">
            {{-- @if(isset($month_date) && count($month_date) == 0)
                <h2>Bu oy uchun ostatka kiritilmagan </h2>
            @else --}}
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title row "> <strong>{{$pharm->name}}</strong> &nbsp<span class="text-danger">Qoldiqlar</span>  </h4>
                <div class="col-md-2 mb-2  justify-content-end">
                    <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{date('m.Y',strtotime($month.'-01'))}}</button>
                    <div class="dropdown-menu" style="left:150px !important">
                        @foreach($months as $m)
                                <a onmouseover="$(this).css('cursor','pointer')" href="{{route('compare.pharm',['id'=>$pharmacy_id,'time'=>date('Y-m',strtotime('01.'.$m))])}}"  class="dropdown-item" > {{$m}} </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card" >
                <ul class="nav nav-pills m-3" id="pills-tab" role="tablist">
                    @foreach ($dates as $key => $item)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($key == count($dates)-1) active @endif" id="pills{{$key}}-tab" data-toggle="pill" data-target="#pill{{$key}}-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                {{date('d.m.Y',strtotime($item[0]))}} - {{date('d.m.Y',strtotime($item[1]))}}
                            </button>
                        </li>
                    @endforeach
                </ul>
                @if ($count_date == 0)
                <div class="tab-content" id="pills-tabContent">
                    @foreach ($dates as $key => $item)

                    <div class="tab-pane fade @if($key == count($dates)-1) show active @endif" id="pill{{$key}}-home" role="tabpanel" aria-labelledby="pills{{$key}}-home-tab">
                    
                        <div class="card-body">
                            <button onclick="ExportToExcel('xlsx',`{{$key}}`,`{{$pharmacy_id}}`)">Export table to excel</button>

                            <div class="table-responsive">
                                <table class="table mb-0" id="forcomparetable{{$key}}{{$pharmacy_id}}">
                                    <thead>
                                    <tr onmouseover="$(this).css('cursor','pointer')">
                                        <th><strong>No</strong> </th>
                                        <th><strong>Dori nomi</strong> </th>
                                        <th><strong>Birinchi ostatka</strong> </th>
                                        <th><strong>Kirib kelgan</strong> </th>
                                        <th><strong>Sotilgan</strong> </th>
                                        {{-- <th><strong>Avto sotuv</strong> </th> --}}
                                        <th><strong>Xulosa</strong> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sum_first = 0;
                                            $sum_accept = 0;
                                            $sum_sold = 0;
                                            $samaxod = 0;
                                        $qizil = 0;
                                        @endphp
                                    @foreach($medicine as $m)
                                    @php
                                        if(isset($m->pricem[0]))
                                        {
                                            $pr = $m->pricem[0]->price;
                                        }else{
                                            $pr = 0;
                                        }
                                    
                                        $sum_first += $first_stocks[$key][$m->id]*$pr;
                                        $sum_accept += $accepts[$key][$m->id]*$pr;
                                        $sum_sold += $solds[$key][$m->id]*$pr;

                                        

                                    @endphp
                                        <tr onmouseover="$(this).css('cursor','pointer')">
                                            <td>{{$loop->index+1}} </td>
                                            <td>{{$m->name}} </td>
                                            <td>{{$first_stocks[$key][$m->id]}} </td>
                                            <td>{{$accepts[$key][$m->id]}} </td>
                                            <td>{{$solds[$key][$m->id]}} </td>
                                            @php
                                                $count = $first_stocks[$key][$m->id]+$accepts[$key][$m->id];
                                            @endphp
                                            {{-- <td>{{ abs($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id]) }} </td> --}}

                                            <td>
                                                

                                                @if ( $count - $solds[$key][$m->id] == $second_stocks[$key][$m->id])

                                                    <span class="badge badge-success" > {{ $second_stocks[$key][$m->id] }} ta (to'g'ri)</span>
                                                @endif

                                                @if ( $count < $solds[$key][$m->id])

                                                    <span class="badge badge-danger" > 
                                                        @if ($solds[$key][$m->id]-$count > 0)
                                                            {{ $solds[$key][$m->id]-$count }} ta (yo'q joydan sotilgan)
                                                            @php
                                                                $qizil += ($solds[$key][$m->id]-$count)*mprice($m->id);
                                                            @endphp
                                                        @else
                                                            {{ -1*($solds[$key][$m->id]-$count) }} ta (yo'q joydan sotilgan)
                                                            @php
                                                                $qizil += (-1*($solds[$key][$m->id]-$count))*mprice($m->id);
                                                            @endphp
                                                        @endif
                                                    </span>
                                                    {{-- <span class="badge badge-primary" >{{ $second_stocks[$key][$m->id] }} ta(ko'p)</span> --}}


                                                @else
                                                        @if ($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id] > 0)
                                                            <span class="badge badge-warning" >{{ $count - $solds[$key][$m->id] - $second_stocks[$key][$m->id] }} ta samaxod</span>
                                                            @php
                                                                $samaxod += ($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id])*mprice($m->id);
                                                            @endphp
                                                            {{-- <span class="badge badge-warning" >samaxod</span> --}}
                                                        @elseif($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id] < 0)
                                                            {{-- <span class="badge badge-primary" >samaxod</span> --}}
                                                            @if($solds[$key][$m->id] == 0)
                                                            <span class="badge badge-primary" >{{ -1*($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id]) }} ta ostatkada xatolik</span>

                                                            @else
                                                            <span class="badge badge-danger" >{{ -1*($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id]) }} ta yoq joydan sotilgan</span>

                                                            @php
                                                                $qizil += (-1*($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id]))*mprice($m->id);
                                                            @endphp
                                                            @endif
                                                            
                                                        @endif
                                                @endif

                                                
                                            </td>


                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>{{number_format($sum_first,0,',','.')}}</td>
                                        <td>{{number_format($sum_accept,0,',','.')}}</td>
                                        <td>{{number_format($sum_sold,0,',','.')}}</td>
                                        <td>{{number_format($sum_sold,0,',','.')}}</td>

                                        <td>
                                           <span class="badge badge-warning">{{number_format($samaxod,0,',','.')}}</span> 
                                           <span class="badge badge-danger">{{number_format($qizil,0,',','.')}}</span> 
                                        </td>
                                        {{-- <td></td> --}}
                                    </tr>
                                    <tr>
                                        <td><strong>No</strong> </td>
                                        <td><strong>Dori nomi</strong> </td>
                                        <td><strong>Birinchi ostatka</strong> </td>
                                        <td><strong>Kirib kelgan</strong> </td>
                                        <td><strong>Sotilgan</strong> </td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    
                    </div>
                    @endforeach

                  </div>
                @else
                    
                  <div class="tab-content" id="pills-tabContent">
                    @foreach ($dates as $key => $item)

                    <div class="tab-pane fade @if($key == count($dates)-1) show active @endif" id="pill{{$key}}-home" role="tabpanel" aria-labelledby="pills{{$key}}-home-tab">
                    
                        <div class="card-body">

                            <button onclick="ExportToExcel('xlsx',`{{$key}}`,`{{$pharmacy_id}}`)">Export table to excel</button>

                            <div class="table-responsive">
                                <table class="table table-striped mb-0" id="forcomparetable{{$key}}{{$pharmacy_id}}">
                                    <thead>
                                    <tr onmouseover="$(this).css('cursor','pointer')">
                                        <th><strong>No</strong> </th>
                                        <th><strong>Dori nomi</strong> </th>
                                        <th><strong>Birinchi ostatka</strong> </th>
                                        <th><strong>Kirib kelgan</strong> </th>
                                        <th><strong>RM prixod</strong> </th>
                                        <th><strong>Sotilgan</strong> </th>
                                        <th><strong>Oxirgi ostatka</strong> </th>
                                        <th><strong>Xulosa</strong> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $sum_first = 0;
                                        $sum_accept = 0;
                                        $sum_sold = 0;
                                        $sum_second = 0;
                                        $samaxod = 0;
                                        $rm = 0;
                                        $qizil = 0;

                                    @endphp
                                @foreach($medicine as $m)
                                @php
                                    if(isset($m->pricem[0]))
                                    {
                                        $pr = $m->pricem[0]->price;
                                    }else{
                                        $pr = 0;
                                    }
                                
                                    $sum_first += $first_stocks[$key][$m->id]*$pr;
                                    $sum_accept += $accepts[$key][$m->id]*$pr;
                                    $sum_sold += $solds[$key][$m->id]*$pr;
                                    $sum_second += $second_stocks[$key][$m->id]*$pr;

                                    $rm += $rm_prixod[$key][$m->id]*$pr;

                                    
                                @endphp
                                        <tr onmouseover="$(this).css('cursor','pointer')">
                                            <td>{{$loop->index+1}} </td>
                                            <td>{{$m->name}} </td>
                                            <td>{{$first_stocks[$key][$m->id]}} </td>
                                            <td>{{$accepts[$key][$m->id]}} </td>
                                            <td>{{$rm_prixod[$key][$m->id]}} </td>
                                            <td>{{$solds[$key][$m->id]}} </td>
                                            <td>{{$second_stocks[$key][$m->id]}} </td>

                                            <td>
                                                @php
                                                    $count = $first_stocks[$key][$m->id]+$accepts[$key][$m->id]+$rm_prixod[$key][$m->id];
                                                @endphp

                                                @if ( $count - $solds[$key][$m->id] == $second_stocks[$key][$m->id])

                                                    <span class="badge badge-success" > {{ $second_stocks[$key][$m->id] }} ta (to'g'ri)</span>
                                                @endif

                                                @if ( $count < $solds[$key][$m->id])

                                                    <span class="badge badge-danger" > 
                                                        @if($second_stocks[$key][$m->id] > ($count - $solds[$key][$m->id]))
                                                            {{$second_stocks[$key][$m->id] > ($count - $solds[$key][$m->id])}} rm prixod
                                                        @else
                                                                @if ($solds[$key][$m->id]-$count > 0)
                                                                {{ $solds[$key][$m->id]-$count }} ta (yo'q joydan sotilgan)
                                                                @php
                                                                    $qizil +=  ($solds[$key][$m->id]-$count)*mprice($m->id);
                                                                @endphp
                                                                @else
                                                                {{ -1*($solds[$key][$m->id]-$count) }} ta (yo'q joydan sotilgan)
                                                                @php
                                                                    $qizil +=  (-1*($solds[$key][$m->id]-$count))*mprice($m->id);
                                                                @endphp
                                                                @endif
                                                        @endif

                                                        
                                                    </span>
                                                    {{-- <span class="badge badge-primary" >{{ $second_stocks[$key][$m->id] }} ta(ko'p)</span> --}}


                                                @else
                                                        @if ($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id] > 0)
                                                            {{-- <span class="badge badge-warning" >samaxod</span> --}}
                                                            <span class="badge badge-warning" >{{ $count - $solds[$key][$m->id] - $second_stocks[$key][$m->id] }} ta samaxod</span>
                                                            @php
                                                                $samaxod +=  ($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id])*mprice($m->id);
                                                            @endphp
                                                        @elseif($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id] < 0)
                                                            {{-- <span class="badge badge-primary" >samaxod</span> --}}
                                                            
                                                            @if($solds[$key][$m->id] == 0)
                                                            <span class="badge badge-primary" >{{ -1*($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id]) }} ta ostatkada xatolik</span>

                                                            @else
                                                            <span class="badge badge-danger" >{{ -1*($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id]) }} ta yo'q joydan sotilgan</span>
                                                                    @php
                                                                    $qizil +=  (-1*($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id]))*mprice($m->id);
                                                                @endphp
                                                            @endif
                                                            
                                                        @endif
                                                @endif

                                                
                                            </td>


                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>{{number_format($sum_first,0,',','.')}}</td>
                                        <td>{{number_format($sum_accept,0,',','.')}}</td>
                                        <td>{{number_format($sum_sold,0,',','.')}}</td>
                                        <td>{{number_format($sum_second,0,',','.')}}</td>
                                        <td>
                                            <span class="badge badge-warning">{{number_format($samaxod,0,',','.')}}</span> 
                                            <span class="badge badge-danger">{{number_format($qizil,0,',','.')}}</span> 
                                         </td>
                                    </tr>
                                    <tr>
                                        <td><strong>No</strong> </td>
                                        <td><strong>Dori nomi</strong> </td>
                                        <td><strong>Birinchi ostatka</strong> </td>
                                        <td><strong>Kirib kelgan</strong> </td>
                                        <td><strong>Sotilgan</strong> </td>
                                        <td><strong>Oxirgi ostatka</strong> </td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    
                    </div>
                    @endforeach

                  </div>
                @endif

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <script>



    function ExportToExcel(type,key,id, fn, dl) {
       var elt = document.getElementById(`forcomparetable${key}${id}`);
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }


        function yashir(id){
            let x='.yashir'+id;
            let a=document.querySelectorAll(x);
            a.forEach(e=>{
                if(e.style.display=='none') {
                    e.style.display = ''
                }else{
                    e.style.display='none';
                }
            })

        }
    </script>
@endsection

