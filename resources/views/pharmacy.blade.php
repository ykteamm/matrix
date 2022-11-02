@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper">
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
                    <a href="{{route('pharmacy-list',['time' => 'today'])}}" class="dropdown-item">Bugun</a>
                    <a href="{{route('pharmacy-list',['time' => 'week'])}}" class="dropdown-item">Hafta</a>
                    <a href="{{route('pharmacy-list',['time' => 'month'])}}" class="dropdown-item">Oy</a>
                    <a href="{{route('pharmacy-list',['time' => 'year'])}}" class="dropdown-item">Yil</a>
                    <a href="{{route('pharmacy-list',['time' => 'all'])}}" class="dropdown-item" id="aftertime">Hammasi</a>
                    <input type="text" name="datetimes" class="form-control"/>
                 </div>
              </div>
           </div>
         </div>
      </div>
   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table mb-0" id="dtBasicExample">
                     <thead>
                        <tr>
                           <th>Nomi</th>
                           {{-- <th>Rasmi</th> --}}
                           <th>Telefon raqami</th>
                           <th>Joyi m<sup>2</sup></th>
                           <th>Viloyat</sup></th>
                           <th>Summasi </th>
                           {{-- <th>Fakt </th> --}}
                           {{-- <th>Prognoz </th> --}}
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($farm_sum_json as $item)
                        <tr
                           >
                           
                           <td><a href="{{route('pharmacy',$item['id'])}}">{{$item['name']}}</a></td>
                           {{-- @isset($item['image']) --}}
                           {{-- <td> <img src="{{$item['img']}}" height="80px" alt=""> </td> --}}
                               
                           {{-- @endisset --}}
                           {{-- <td> <img src="{{$item['image']}}" height="80px" alt=""> </td> --}}
                           <td>{{$item['phone']}}</td>
                           <td>{{$item['size']}}</td>
                           <td>{{$item['region']}}</td>
                           <td>{{$item['sum']}}</td>
                           {{-- <td style="text-align: center">{{$item->last_name}} {{$item->first_name}} ( RM )</td> --}}
                           {{-- <td style="color:white;">{{$item->v_name}}</td> --}}
                        </tr>
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
      jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});

      function tdhover()
      {
         $(this).css('display','none');
      }
   </script>
@endsection
