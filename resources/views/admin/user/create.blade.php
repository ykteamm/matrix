@extends('admin.layouts.app')
@section('admin_content')
<div class="content container-fluid">
   @if ($errors->any())
   <div class="alert alert-danger" id="message">
       <ul>
           @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
   </div>
   @endif
   @if (Session::has('message'))
   <div class="alert alert-primary" id="message">
       <ul>
            <li>{{ Session::get('message') }}</li>
       </ul>
   </div>
   @endif
    <div class="page-header">
       <div class="row align-items-center">
          <div class="col-md-12">
             <div class="d-flex align-items-center">
                {{-- <h5 class="page-title">Dashboard </h5> --}}
                <ul class="breadcrumb ml-2">
                   <li class="breadcrumb-item"><a href="{{ route('super_admin') }}"><i class="fas fa-home"></i></a></li>
                   {{-- <li class="breadcrumb-item"><a href="">Dashboard </a></li> --}}
                   <li class="breadcrumb-item active">{{ __('app.add_user') }}</li>
                </ul>
             </div>
          </div>
       </div>
    </div>
    <div class="row">
       <div class="col-xl-12 col-md-12">
          <div class="card">
             <div class="card-header">
                <h5 class="card-title">{{ __('app.basic_info') }}</h5>
             </div>
             <div class="card-body">
                <form action="{{ route('user.store') }}" method="POST" autocomplete="off">
                    @csrf
                 <div class="row form-group">
                  <label class="col-sm-3 col-form-label input-label ml-5">{{ __('app.hospital_a') }}</label>
                  <div class="col-sm-6">
                     <select class="form-control form-control-sm" name="hospital_id" id="h_name_f_user">
                        @isset($hospitals)
                        <option value="" disabled selected hidden></option>

                        @foreach($hospitals as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->hospital_name }}
                        </option>
                        @endforeach
                        @endisset
                        
                    </select>
                  </div>
               </div>
               <div class="row form-group">
                  <label class="col-sm-3 col-form-label input-label ml-5" id="b_name_f"> {{ __('app.filial') }} </label>
                  <div class="col-sm-6" id="b_name_f_user">
                     <select id='select_branch' class="form-control form-control-sm" name="branch_id">
                        <option value="" disabled selected hidden id="b_name_user"></option>
                     </select>
                  </div>
               </div>
               <div class="row form-group">
                  <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.position') }} </label>
                  <div class="col-sm-6">
                     <select class="form-control form-control-sm" name="rol_id" required>
                        @isset($positions)
                        <option value="" disabled selected hidden></option>

                        @foreach($positions as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->rol_name }}
                        </option>
                        @endforeach
                        @endisset
                     </select>
                  </div>
               </div>
                   <div class="row form-group">
                      <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.first_name') }} </label>
                      <div class="col-sm-6">
                         <input type="text" class="form-control form-control-sm" name="user_name" required/>
                      </div>
                   </div>
                   <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.adres') }}  </label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="user_adress" required/>
                     </div>
                  </div>
                  <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.patient_phone') }}  </label>
                     <div class="col-sm-6">
                        <input type="text" id="phone" class="form-control form-control-sm" name="user_phone" required/>
                     </div>
                  </div>
                   <div class="row form-group">
                      <label class="col-sm-3 col-form-label input-label ml-5"> {{ __('app.email') }}</label>
                      <div class="col-sm-6">
                         <input type="email" class="form-control form-control-sm for_email" id="email" name="email" required/>
                      </div>
                   </div>
                   {{-- <div class="row form-group"> --}}

                  {{-- </div> --}}

                   <div class="row form-group">
                    <label class="col-sm-3 col-form-label input-label ml-5"> Парол </label>
                    <div class="col-sm-6">
                       <input type="password" class="form-control form-control-sm" id="password" name="password" minlength="8" required/>
                       <span class="fas fa-eye toggle-password mr-2" onclick="myFunction()"></span>
                    </div>
                 </div>
                   {{-- <div class="row form-group">
                      <label for="phone" class="col-sm-3 col-form-label input-label">Phone  <span class="text-muted">(Optional) </span></label>
                      <div class="col-sm-9">
                         <input type="text" class="form-control" id="phone" placeholder="+x(xxx)xxx-xx-xx" value="+1 (304) 499-13-66" />
                      </div>
                   </div> --}}
                   <div class="text-right">
                      <button type="submit" class="btn btn-primary for_email_button"> {{ __('app.add_data') }} </button>
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
   $("#h_name_f_user").change(function(){
           $('#r_name_f_user').remove();
         $('#r_name_f').after("<div class='col-sm-6' id='r_name_f_user'><select class='form-control form-control-sm' name='rol_id' ><option value='non' disabled selected hidden id='r_name_user'></select></div>");
           var hospital_id = $("#h_name_f_user").val();
           var hospital2 = $( "#h_name_f_user option:selected" ).text();
           var _token   = $('meta[name="csrf-token"]').attr('content');
           $.ajax({
               url: "/get-branch",
               type:"POST",
               data:{
               hospital_id: hospital_id,
               _token: _token
               },
               success:function(response){
               if(response) {
                  // console.log(response);
                   var branch_schema = response.branchs;
                   $('#b_name_f_user').remove();
                   $('#b_name_f').after("<div class='col-sm-6' id='b_name_f_user'><select id='select_branch' onchange='userFunction()' class='form-control form-control-sm' name='branch_id' ><option value='non' disabled selected hidden id='b_name_user'></option><option value='null'>"+hospital2+"</option></select></div>");

                   if (branch_schema) {
                       $.each(branch_schema, function( index, value ) {
                       $('#b_name_user').after("<option value='"+value.id+"'>"+value.branch_name+"</option>");
                   });
                   }
                   
               }
               },
               error: function(error) {
               console.log(error);
               }
               });
       });
</script>
 @endsection
       