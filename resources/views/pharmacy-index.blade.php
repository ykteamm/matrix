@extends('admin.layouts.app')
@section('admin_content')
<div class="content mt-1 main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')

      </div>


<div class="content headbot">
    <div class="row">
       <div class="col-12 col-xl-4 d-flex flex-wrap">
          <div class="card">
             <div class="card-body">
                <div class="text-center">
                   <img src="{{$pharma->image_url}}" style="border-radius:50%" height="200px">
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
   </script>
@endsection
