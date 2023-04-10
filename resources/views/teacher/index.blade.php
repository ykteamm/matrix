@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card mt-5">
            <form action="{{ route('teacher.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <select class="form-control form-control-sm" name='user_id' required>
                                <option value="" disabled selected hidden></option>
                                @foreach ($teachers as $teach)
                                    <option value='{{$teach->id}}'>{{$teach->last_name}} {{$teach->first_name}}</option>
                                @endforeach 
                            </select>
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
                           <th>FIO </th>
                           <th>Holati</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($teachers_user as $elchi)
                        <tr>
                           <td>{{$elchi->user->last_name}} {{$elchi->user->first_name}}</td>
                           <td>
                            @if ($elchi->active == 1)
                                Aktiv
                            @else
                                Aktiv emas
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
</div>
@endsection
@section('admin_script')
   <script>
   </script>
@endsection
