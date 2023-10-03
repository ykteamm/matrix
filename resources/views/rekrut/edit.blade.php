@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card mt-5">
            <h2>
                <a href="{{ route('rekrut-add-user') }}">Nomzodlar royhati</a>
            </h2>
            <div class="card-body">
                <form action="{{ route('rekrut-update',$rekrut->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Ismi</label>
                            <input type="text"  name="full_name" class="form-control form-control-sm" required value="{{$rekrut->full_name}}"/>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Familiyasi</label>
                            <input type="text"  name="last_name" class="form-control form-control-sm" required value="{{$rekrut->last_name}}"/>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Viloyat</label>

                            <select class="form-control form-control-sm" name='region_id' id="aioConceptName22" required onchange="districts()">
                                <option value="" disabled selected hidden>Viloyat</option>

                                @foreach ($regions as $region)
                                    @if ($region->id == $rekrut->region->id)
                                        <option value='{{$region->id}}' selected>{{$region->name}}</option>
                                    @else
                                        <option value='{{$region->id}}'>{{$region->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Tuman</label>

                            <select class="form-control form-control-sm" name='district_id' required>
                                <option value="" disabled selected hidden>Tuman</option>

                                @foreach ($districts as $district)
                                    @if ($district->region_id == $rekrut->region_id)
                                        @if ($rekrut->district_id == $district->id)
                                            <option value='{{$district->id}}' class="aioConceptNameDist22 distreg22{{$district->region_id}} " selected>{{$district->name}}</option>
                                        @else
                                            <option value='{{$district->id}}' class="aioConceptNameDist22 distreg22{{$district->region_id}} " >{{$district->name}}</option>
                                        @endif
                                    @else
                                        <option value='{{$district->id}}' class="aioConceptNameDist22 distreg22{{$district->region_id}} d-none">{{$district->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        @php
                            $xolat[1] = 'O\'ylab koradi';
                        @endphp

                        <div class="form-group col-md-4">
                            <label>Xolat</label>

                            <select class="form-control form-control-sm" name='xolat' required>
                                <option value="" disabled selected hidden>Xolat</option>

                                @foreach ($xolat as $ke => $item)
                                        @if ($ke == $rekrut->xolat)
                                            <option value="{{$ke}}" selected>{{$item}}</option>
                                        @else
                                            <option value="{{$ke}}">{{$item}}</option>
                                        @endif
                                @endforeach

                                

                            </select>
                        </div>

                        

                        <div class="form-group col-md-4">
                            <label>Telefon</label>

                            <input type="text"  name="phone"  class="form-control form-control-sm" required value="{{$rekrut->phone}}"/>
                        </div>

                        
                        
                        <div class="form-group col-md-4">
                            <label>Yosh</label>

                            <input type="number"  name="age" class="form-control form-control-sm" required value="{{$rekrut->age}}"/>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Smena</label>

                            <select class="form-control form-control-sm" name='grafik' required>
                                @if ($rekrut->grafik == 1)
                                    <option value="1" selected>Yarim smena</option>
                                    <option value="2">To'liq smena</option>
                                @elseif ($rekrut->grafik == 2)
                                    <option value="1">Yarim smena</option>
                                    <option value="2" selected>To'liq smena</option>
                                @else
                                    <option value="1">Yarim smena</option>
                                    <option value="2">To'liq smena</option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Link</label>

                            <input type="text"  name="link" class="form-control form-control-sm" required value="{{$rekrut->link}}"/>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label>Ustoz</label>

                            <select class="form-control form-control-sm" name='rm_id'>

                                    @foreach ($rms as $rm)
                                        @if ($rm->id == $rekrut->rm_id)
                                            <option value='{{$rm->id}}' selected>{{$rm->first_name}} {{$rm->last_name}}</option>
                                            
                                        @else
                                            <option value='{{$rm->id}}' >{{$rm->first_name}} {{$rm->last_name}}</option>
                                            
                                        @endif
                                    <option value='{{$rm->id}}' >{{$rm->first_name}} {{$rm->last_name}}</option>
                                @endforeach
                                @foreach ($teachers as $teach)
                                        @if ($teach->id == $rekrut->rm_id)
                                            <option value='{{$teach->user->id}}' selected>{{$teach->user->first_name}} {{$teach->user->last_name}}</option>
                                        @else
                                            <option value='{{$teach->user->id}}' >{{$teach->user->first_name}} {{$teach->user->last_name}}</option>
                                        @endif
                                @endforeach

                            </select>
                        </div>
                        

                        <div class="form-group col-md-4">
                            <label>Potok</label>

                            <select class="form-control form-control-sm" name='group_id'>

                                @foreach ($groups as $group)
                                    @if ($group->id == $rekrut->group_id)
                                        <option value='{{$group->id}}' selected>{{$group->title}}</option>
                                    @else
                                        <option value='{{$group->id}}' >{{$group->title}}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group col-md-2 reksave">
                                <button type="submit" class="btn btn-primary" onclick="$('#reksave').addClass('d-none');$('#reksave2').removeClass('d-none')"> Saqlash </button>
                        </div>

                        <div class="form-group col-md-2 reksave2 d-none">
                            <button type="button" class="btn btn-primary"> Biroz kuting </button>
                        </div>

                    </div>
                </form>

            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('admin_script')
   <script>
    function districts()
    {
       var region = $('#aioConceptName22').find(":selected").val();
       $('.aioConceptNameDist22').addClass('d-none');
       $(`.distreg22${region}`).removeClass('d-none');
    }
   </script>
@endsection
