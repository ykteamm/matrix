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
                    <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" name="all" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$months[date('m',strtotime($month))-1]['name']}}</button>
                    <div class="dropdown-menu" style="left:150px !important">
                        @php $i=1 @endphp
                        @foreach($months as $m)
                            @if($i<10)
                                <a onmouseover="$(this).css('cursor','pointer')" href="{{route('compare.pharm',['id'=>$pharmacy_id,'time'=>date('Y').'-0'.$i])}}"  class="dropdown-item" > {{$m['name']}} </a>
                            @else
                                <a onmouseover="$(this).css('cursor','pointer')" href="{{route('compare.pharm',['id'=>$pharmacy_id,'time'=>date('Y').'-'.$i])}}"  class="dropdown-item" > {{$m['name']}} </a>
                            @endif
                            @php $i++ @endphp
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card" >
                <ul class="nav nav-pills m-3" id="pills-tab" role="tablist">
                    @foreach ($dates as $key => $item)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($key == 0) active @endif" id="pills{{$key}}-tab" data-toggle="pill" data-target="#pill{{$key}}-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                {{date('d.m.Y H:i',strtotime($item[0]))}} - {{date('d.m.Y H:i',strtotime($item[1]))}}
                            </button>
                        </li>
                    @endforeach
                </ul>
                @if ($count_date == 0)
                <div class="tab-content" id="pills-tabContent">
                    @foreach ($dates as $key => $item)

                    <div class="tab-pane fade @if($key == 0) show active @endif" id="pill{{$key}}-home" role="tabpanel" aria-labelledby="pills{{$key}}-home-tab">
                    
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                    <tr onmouseover="$(this).css('cursor','pointer')">
                                        <th><strong>No</strong> </th>
                                        <th><strong>Dori nomi</strong> </th>
                                        <th><strong>Birinchi ostatka</strong> </th>
                                        <th><strong>Kirib kelgan</strong> </th>
                                        <th><strong>Sotilgan</strong> </th>
                                        <th><strong>Xulosa</strong> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($medicine as $m)
                                        <tr onmouseover="$(this).css('cursor','pointer')">
                                            <td>{{$loop->index+1}} </td>
                                            <td>{{$m->name}} </td>
                                            <td>{{$first_stocks[$key][$m->id]}} </td>
                                            <td>{{$accepts[$key][$m->id]}} </td>
                                            <td>{{$solds[$key][$m->id]}} </td>

                                            <td>
                                                @php
                                                    $count = $first_stocks[$key][$m->id]+$accepts[$key][$m->id];
                                                @endphp

                                                @if ( $count - $solds[$key][$m->id] == $second_stocks[$key][$m->id])

                                                    <span class="badge badge-success" > {{ $second_stocks[$key][$m->id] }} ta (to'g'ri)</span>
                                                @endif

                                                @if ( $count < $solds[$key][$m->id])

                                                    <span class="badge badge-danger" > 
                                                        @if ($solds[$key][$m->id]-$count > 0)
                                                            {{ $solds[$key][$m->id]-$count }} ta (yo'q joydan sotilgan)
                                                        @else
                                                            {{ -1*($solds[$key][$m->id]-$count) }} ta (yo'q joydan sotilgan)
                                                        @endif
                                                    </span>
                                                    <span class="badge badge-primary" >{{ $second_stocks[$key][$m->id] }} ta(ko'p)</span>


                                                @else
                                                        @if ($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id] > 0)
                                                            <span class="badge badge-warning" >{{ $count - $solds[$key][$m->id] - $second_stocks[$key][$m->id] }} ta(kam)</span>
                                                        @elseif($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id] < 0)
                                                            <span class="badge badge-primary" >{{ -1*($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id]) }} ta(ko'p)</span>
                                                        @endif
                                                @endif

                                                
                                            </td>


                                        </tr>
                                    @endforeach
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

                    <div class="tab-pane fade @if($key == 0) show active @endif" id="pill{{$key}}-home" role="tabpanel" aria-labelledby="pills{{$key}}-home-tab">
                    
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                    <tr onmouseover="$(this).css('cursor','pointer')">
                                        <th><strong>No</strong> </th>
                                        <th><strong>Dori nomi</strong> </th>
                                        <th><strong>Birinchi ostatka</strong> </th>
                                        <th><strong>Kirib kelgan</strong> </th>
                                        <th><strong>Sotilgan</strong> </th>
                                        <th><strong>Oxirgi ostatka</strong> </th>
                                        <th><strong>Xulosa</strong> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($medicine as $m)
                                        <tr onmouseover="$(this).css('cursor','pointer')">
                                            <td>{{$loop->index+1}} </td>
                                            <td>{{$m->name}} </td>
                                            <td>{{$first_stocks[$key][$m->id]}} </td>
                                            <td>{{$accepts[$key][$m->id]}} </td>
                                            <td>{{$solds[$key][$m->id]}} </td>
                                            <td>{{$second_stocks[$key][$m->id]}} </td>

                                            <td>
                                                @php
                                                    $count = $first_stocks[$key][$m->id]+$accepts[$key][$m->id];
                                                @endphp

                                                @if ( $count - $solds[$key][$m->id] == $second_stocks[$key][$m->id])

                                                    <span class="badge badge-success" > {{ $second_stocks[$key][$m->id] }} ta (to'g'ri)</span>
                                                @endif

                                                @if ( $count < $solds[$key][$m->id])

                                                    <span class="badge badge-danger" > 
                                                        @if ($solds[$key][$m->id]-$count > 0)
                                                            {{ $solds[$key][$m->id]-$count }} ta (yo'q joydan sotilgan)
                                                        @else
                                                            {{ -1*($solds[$key][$m->id]-$count) }} ta (yo'q joydan sotilgan)
                                                        @endif
                                                    </span>
                                                    <span class="badge badge-primary" >{{ $second_stocks[$key][$m->id] }} ta(ko'p)</span>


                                                @else
                                                        @if ($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id] > 0)
                                                            <span class="badge badge-warning" >{{ $count - $solds[$key][$m->id] - $second_stocks[$key][$m->id] }} ta(kam)</span>
                                                        @elseif($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id] < 0)
                                                            <span class="badge badge-primary" >{{ -1*($count - $solds[$key][$m->id] - $second_stocks[$key][$m->id]) }} ta(ko'p)</span>
                                                        @endif
                                                @endif

                                                
                                            </td>


                                        </tr>
                                    @endforeach
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
    <script>
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

