@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title row "> <strong>{{$pharm->name}}</strong> &nbsp<span class="text-primary ml-4">Taqqoslash</span>  </h4>
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
                {{-- @foreach($meidcine as $m) --}}
                    <div class="row calender-col">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                            <tr onmouseover="$(this).css('cursor','pointer')">
                                                <th><strong>No</strong> </th>
                                                <th><strong>Dori nomi</strong> </th>
                                                <th><strong>Qoldiqlar</strong> </th>
                                                <th><strong>Kirib kelganlar</strong> </th>
                                                <th><strong>Sotilganlar</strong> </th>
                                                <th><strong>Xulosa</strong> </th>
                                                {{-- <th onmouseover="$(this).css('cursor','pointer')"  style="background-color: #1a73e8"  class=""><strong style="color: #fff">Qoldiq</strong> </th> --}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($medicine as $m)
                                                <tr onmouseover="$(this).css('cursor','pointer')">
                                                    <td>{{$loop->index+1}} </td>
                                                    <td>{{$m->name}} </td>
                                                    <td>{{$stocks[$m->id]}} </td>
                                                    <td>{{$accepts[$m->id]}} </td>
                                                    <td>{{$solds[$m->id]}} </td>
                                                    <td>
                                                        @php
                                                            $count = $stocks[$m->id]+$accepts[$m->id];
                                                        @endphp
                                                        @if ( $count < $solds[$m->id])
                                                        <span class="badge badge-danger" >-{{ $solds[$m->id]-$count }}</span>

                                                        @else
                                                            <span class="badge badge-primary" >{{ $count-$solds[$m->id] }}</span>

                                                        @endif
                                                    </td>


                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                {{-- @endforeach --}}
                </div>
            </div>
        </div>
    </div>
@endsection

