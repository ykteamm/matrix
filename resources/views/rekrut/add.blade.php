@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card mt-5">
            <div class="card-body text-right">
                <div class="btn-group">
    
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ustozga Hisobot
                    </button>
                    <div class="dropdown-menu">
                        @foreach ($regions as $reg)
                            
                            <a class="dropdown-item" href="{{route('rekrut-ustoz-hisobot',['id' => $reg->id])}}" target="_blank">{{$reg->name}}</a>
                        @endforeach
                        
                            <a class="dropdown-item" href="#">
                            </a>
                        <div class="dropdown-divider"></div>
                    </div>
                </div>
             </div>
            <div class="card-body">
                <form action="{{ route('rekrut-save-user') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-4">
                            <input type="text"  name="full_name" class="form-control form-control-sm" required placeholder="Ism"/>
                        </div>

                        <div class="form-group col-md-4">
                            <input type="text"  name="last_name" class="form-control form-control-sm" required placeholder="Familiya"/>
                        </div>

                        <div class="form-group col-md-4">
                            <select class="form-control form-control-sm" name='region_id' id="aioConceptName" required onchange="districts()">
                                <option value="" disabled selected hidden>Viloyat</option>

                                @foreach ($regions as $region)
                                    <option value='{{$region->id}}'>{{$region->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <select class="form-control form-control-sm" name='district_id' required>
                                <option value="" disabled selected hidden>Tuman</option>

                                @foreach ($districts as $district)
                                    <option value='{{$district->id}}' class="aioConceptNameDist distreg{{$district->region_id}} d-none">{{$district->name}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group col-md-4">
                            <select class="form-control form-control-sm" name='xolat' required>
                                <option value="" disabled selected hidden>Xolat</option>

                                <option value="1">O'ylab koradi</option>
                                <option value="2">Telefon ko'tarmadi </option>
                                <option value="3">O'qishga keladi</option>
                                <option value="4">Ustoz bilan gaplashadi</option>
                                <option value="5">Uyi uzoq </option>
                                <option value="6">O'qishga kelolmaydi lekin ishlaydi</option>
                                <option value="7">Ishlamaydi </option>

                            </select>
                        </div>

                        

                        <div class="form-group col-md-4">
                            <input type="text"  name="phone" value="+998" class="form-control form-control-sm" required placeholder="Telefon"/>
                        </div>

                        
                        
                        <div class="form-group col-md-4">
                            <input type="number"  name="age" class="form-control form-control-sm" required placeholder="Yosh"/>
                        </div>

                        <div class="form-group col-md-4">
                            <select class="form-control form-control-sm" name='grafik' required>
                                <option value="" disabled selected hidden>Grafik</option>

                                <option value="1">Yarim smena</option>
                                <option value="2">To'liq smena</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <input type="text"  name="link" class="form-control form-control-sm" required placeholder="Link"/>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <select class="form-control form-control-sm" name='rm_id'>
                                <option value="" disabled selected hidden>RM-USTOZ</option>

                                @foreach ($rms as $rm)
                                    <option value='{{$rm->id}}' >{{$rm->first_name}} {{$rm->last_name}}</option>
                                @endforeach
                                @foreach ($teachers as $teach)
                                    <option value='{{$teach->user->id}}' >{{$teach->user->first_name}} {{$teach->user->last_name}}</option>
                                @endforeach

                            </select>
                        </div>
                        

                        <div class="form-group col-md-4">
                            <select class="form-control form-control-sm" name='group_id'>
                                <option value="" disabled selected hidden>Potok tanlang</option>

                                @foreach ($groups as $group)
                                    <option value='{{$group->id}}' >{{$group->title}}</option>
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
         
         <div class="card-body">
            
            <div id="dtBasicExample1212"></div>

            <div class="table-responsive">
                <table class="table table-striped mb-0" id="dtBasicExample12">
                    <thead>
                    <tr>
                        <th>Edit </th>
                        <th>Ism </th>
                        <th>Familiya </th>
                        <th>Yosh </th>
                        <th>Telefon</th>
                        <th>RM-USTOZ</th>
                        <th>Viloyat </th>
                        <th>Tuman </th>
                        <th>Xolat </th>
                        <th>Group </th>
                        {{-- <th>Izoh </th> --}}
                        <th>Vaqti </th>
                        {{-- <th>Status </th> --}}
                        {{-- <th>Harakat </th> --}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rekruts as $rekrut)
                        <tr>
                            <td> <a href="{{route('rekrut-edit',$rekrut->rid)}}"> <i class="fas fa-edit"></i> </a> </td>
                            <td>{{$rekrut->fname}}</td>
                            <td>{{$rekrut->lname}} </td>
                            <td>{{$rekrut->age}} </td>
                            <td>{{$rekrut->phone}} </td>
                            <td>{{$rekrut->f}} {{$rekrut->l}}</td>
                            <td>{{$rekrut->r}} </td>
                            <td>{{$rekrut->d}} </td>
                            <td style="width: 10px">
                                

                                    

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @if ($rekrut->xolat == 1)
                                                O'ylab koradi
                                            @elseif($rekrut->xolat == 2)
                                                Telefon ko'tarmadi
                                            @elseif($rekrut->xolat == 3)
                                                O'qishga keladi
                                            @elseif($rekrut->xolat == 4)
                                                Ustoz bilan gaplashadi
                                            @elseif($rekrut->xolat == 5)
                                                Uyi uzoq
                                            @elseif($rekrut->xolat == 6)
                                                Kelolmaydi,ishlaydi
                                            @elseif($rekrut->xolat == 6)
                                            Ishlamaydi

                                            @else
                                            @endif
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{route('rekrut-change-xolat',['id' => $rekrut->rid,'xolat' => 1])}}">O'ylab koradi</a>
                                            <a class="dropdown-item" href="{{route('rekrut-change-xolat',['id' => $rekrut->rid,'xolat' => 2])}}">Telefon ko'tarmadi</a>
                                            <a class="dropdown-item" href="{{route('rekrut-change-xolat',['id' => $rekrut->rid,'xolat' => 3])}}">O'qishga keladi</a>
                                            <a class="dropdown-item" href="{{route('rekrut-change-xolat',['id' => $rekrut->rid,'xolat' => 4])}}">Ustoz bilan gaplashadi</a>
                                            <a class="dropdown-item" href="{{route('rekrut-change-xolat',['id' => $rekrut->rid,'xolat' => 5])}}">Uyi uzoq</a>
                                            <a class="dropdown-item" href="{{route('rekrut-change-xolat',['id' => $rekrut->rid,'xolat' => 6])}}">Kelolmaydi,ishlaydi</a>
                                            <a class="dropdown-item" href="{{route('rekrut-change-xolat',['id' => $rekrut->rid,'xolat' => 7])}}">Ishlamaydi</a>
                                            
                                            <a class="dropdown-item" href="#">
                                            </a>
                                        <div class="dropdown-divider"></div>
                                        </div>
                                    </div>
                                
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$rekrut->title}}
                                    </button>
                                    <div class="dropdown-menu">
                                        @foreach ($groups as $p)
                                        <a class="dropdown-item" href="{{route('rekrut-change-potok',['id' => $rekrut->rid,'potok' => $p->id])}}">{{$p->title}}</a>
                                            
                                        @endforeach
                                        <a class="dropdown-item" href="#">
                                        </a>
                                    <div class="dropdown-divider"></div>
                                    </div>
                                </div>
                            </td>
                            {{-- <td >
                                <div style="width: 200px;overflow: auto;">{{$rekrut->comment}}
                                </div>
                            </td> --}}
                            <td>
                                {{date('d.m.Y',strtotime($rekrut->dat))}}
                            </td>
                            {{-- <td>
                                @if ($rekrut->status == 0)
                                    <span class="badge badge-primary">Ko'rilmagan</span>
                                @elseif ($rekrut->status == 1)
                                    <span class="badge badge-success">Tasdiqlangan</span>
                                @else
                                    <span class="badge badge-danger">Tasdiqlanmagan</span>
                                @endif
                            </td> --}}
                            {{-- <td>
                                <a href="{{route('rekrut.delete',$rekrut->rid)}}">
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </a>
                                <a href="{{route('rekrut.change',$rekrut->rid)}}">
                                    <button class="btn btn-primary"><i class="fas fa-exchange-alt"></i></button>
                                </a>
                            </td> --}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
       var region = $('#aioConceptName').find(":selected").val();
       $('.aioConceptNameDist').addClass('d-none');
       $(`.distreg${region}`).removeClass('d-none');
    }
   </script>
@endsection
