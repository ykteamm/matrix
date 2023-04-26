@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card mt-5">
            <form action="{{ route('shogird.store') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="form-group col-md-3">
                        <select class="form-control form-control-sm" name='teacher_id' required>
                                <option value="" disabled selected hidden>Ustoz</option>
                                @foreach ($teachers as $teach)
                                    <option value='{{$teach->user->id}}'>{{$teach->user->last_name}} {{$teach->user->first_name}}</option>
                                @endforeach 
                            </select>
                    </div>

                    <div class="form-group col-md-3">
                     <select class="form-control form-control-sm" name='user_id' required>
                             <option value="" disabled selected hidden>Shogird</option>
                             @foreach ($users as $user)
                                 <option value='{{$user->id}}'>{{$user->last_name}} {{$user->first_name}}</option>
                             @endforeach 
                         </select>
                     </div>

                     <div class="form-group col-md-2">
                        <input type="date" class="form-control form-control-lg" placeholder="Sinov vaqti" name="week_date">
                     </div>

                    <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-primary"> Saqlash </button>
                    </div>
                    
                </div>
            </form>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table mb-0 example1">
                     <thead>
                        <tr>
                           <th>Ustoz </th>
                           <th>Shogird </th>
                           <th>Sinov vaqti (Hafta) </th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($teachers_user as $elchi)
                           <tr>
                              <td>{{$elchi->teacher->last_name}} {{$elchi->teacher->first_name}}</td>
                              <td>{{$elchi->user->last_name}} {{$elchi->user->first_name}}</td>
                              <td>{{$elchi->week_date}}</td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css"></script>
<script>
    $(function () {
        $("select").select2();
    });
   </script>
@endsection
