@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card mt-5">
            <div class="card-body">
                <form action="{{ route('rekrut-save-user') }}" method="POST">
                    @csrf
                    <div class="row">
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
                            <select class="form-control form-control-sm" name='rm_id' required>
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
                            <input type="text"  name="full_name" class="form-control form-control-sm" required placeholder="FIO"/>
                        </div>

                        <div class="form-group col-md-4">
                            <input type="text"  name="phone" value="+998" class="form-control form-control-sm" required placeholder="Telefon"/>
                        </div>

                        <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-primary"> Saqlash </button>
                        </div>

                    </div>
                </form>

            </div>
         </div>
         <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                    <tr>
                        <th>FIO </th>
                        <th>Telefon</th>
                        <th>RM </th>
                        <th>Viloyat </th>
                        <th>Tuman </th>
                        <th>Xolati </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rekruts as $rekrut)
                        <tr>
                            <td>{{$rekrut->fname}} </td>
                            <td>{{$rekrut->phone}} </td>
                            <td>{{$rekrut->f}} {{$rekrut->l}}</td>
                            <td>{{$rekrut->r}} </td>
                            <td>{{$rekrut->d}} </td>
                            <td>
                                @if ($rekrut->status == 0)
                                    <span class="badge badge-primary">Ko'rilmagan</span>
                                @elseif ($rekrut->status == 1)
                                    <span class="badge badge-success">Tasdiqlangan</span>
                                @else
                                    <span class="badge badge-danger">Tasdiqlanmagan</span>
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
