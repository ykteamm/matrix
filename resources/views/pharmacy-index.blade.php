@extends('admin.layouts.app')
@section('admin_content')
<div class="content mt-1 main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')
      <div class="card flex-fill">

         <div style="border-bottom-radius:30px !important;margin-left:auto">
            <div class="justify-content-between align-items-center p-2">
                 <div class="btn-group">
                      <div class="row">
                        <div class="col-md-12" align="center">
                                 Sana
                        </div>
                        <div class="col-md-12">
                           <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_today"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Bugun </button>
                           <div class="dropdown-menu timeclass">
                           <a href="#" onclick="timeElchi('a_all')" class="dropdown-item" id="a_all">Hammasi </a>

                              <a href="#" onclick="timeElchi('a_today')" class="dropdown-item" id="a_today"> Bugun </a>
                              <a href="#" onclick="timeElchi('a_week')" class="dropdown-item" id="a_week">Hafta </a>
                              <a href="#" onclick="timeElchi('a_month')" class="dropdown-item" id="a_month">Oy  </a>
                              <a href="#" onclick="timeElchi('a_year')" class="dropdown-item" id="a_year">Yil </a>
                              {{-- <input type="date" class="form-control" > --}}
                       <input type="text" name="datetimes" class="form-control"/>

                           </div>
                        </div>
                     </div>
                 </div>
                 <div class="btn-group">
                     <div class="row">
                        <div class="col-md-12" align="center">
                                 Elchi
                        </div>
                        <div class="col-md-12">
                           <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button4" name="all" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Hammasi</button>
                           <div class="dropdown-menu" style="overflow-y:scroll; height:400px;">
                              <a href="#" onclick="users('Hammasi','all')" class="dropdown-item" id="addregionall"> Hammasi </a>
                              @foreach($users as $user)
                              <a href="#" onclick="users(`{{$user->last_name}}{{$user->first_name}}`,`{{$user->id}}`)" class="dropdown-item regionall"> {{$user->last_name}}{{$user->first_name}}</a>
                              @endforeach
                           </div>
                        </div>
                     </div>
                 </div>
                 <div class="btn-group" style="margin-right:30px !important;margin-top:20px;">
                     <div class="row">
                        <div class="col-md-12" align="center">

                        </div>
                        <div class="col-md-12">
                           <button type="button" class="btn btn-block btn-outline-primary" onclick="refresh()"> Tozalash</button>

                        </div>
                     </div>
                 </div>
            </div>
         </div>
     </div>
      </div>


<div class="content headbot">
    <div class="row">
       <div class="col-12 col-xl-4 d-flex flex-wrap">
          <div class="card">
             <div class="card-body">
                <div class="text-center">
                   <img src="{{$pharma->image}}" style="border-radius:50%" height="200px">
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
                        <h6>Nomi</h6>
                        <span class="ml-auto">{{$pharma->name}} </span>
                     </div>
                      <div>
                         <h6>Telefon raqami</h6>
                         <span class="ml-auto">{{$pharma->phone_number}} </span>
                      </div>
                      <div>
                        <h6>Lavozimi</h6>
                        <span class="ml-auto">{{$pharma->volume}} </span>
                     </div>
                     
                   </div>
                   
                </div>
             </div>
          </div>
          <div class="content container-fluid headbot">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('user-pharma.store',$pharma->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <select class="form-control form-control-sm" name='user_id' required>
                                          <option value="" disabled selected hidden></option>
                                            @foreach ($users as $user)
                                                <option value='{{$user->id}}'>{{$user->first_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                            <button type="submit" class="btn btn-primary"> Saqlash </button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
         </div>
       </div>
    </div>

</div>

</div>
@endsection
@section('admin_script')
   <script>
      $(document).ready(function(){
       farmChart('a_today','all');
      });
      function farmChart(t_time,user){
         var id = <?php echo json_encode($pharma->id); ?>;
          var _token   = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
             url: "/farm/chart",
             type:"POST",
             data:{
                id:id,
                time: t_time,
                user: user,
                _token: _token
             },
             success:function(response){
                if(response) {
                  console.log(response)
                }
             },
             error: function(error) {
                console.log(error);
             }
          });
       };
      function timeElchi(sd){
          var text = $(`#${sd}`).text();
          $("#age_button2").text(text);
          $("#age_button2").attr('name',sd);
          var id = $("#age_button4").attr('name');
          var text = $("#age_button2").attr('name');

          farmChart(text,id);

       };

      function users(name,id){
         $("#age_button4").attr('name',id);
          $("#age_button4").text(name);
          var id = $("#age_button4").attr('name');
          var text = $("#age_button2").attr('name');
          farmChart(text,id);
       }
   </script>
@endsection
