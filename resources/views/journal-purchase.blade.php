@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table mb-0 example1">
                     <thead>
                        <tr>
                           <th>Username </th>
                           <th>FIO </th>
                           <th>Mahsulot</th>
                           <th>O'zgarish</th>
                           <th>Vaqt</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($purchases as $elchi)
                        <tr>
                           <td>{{$elchi->username}}</td>

                           <td>{{$elchi->last_name}} {{$elchi->first_name}}</td>
                           <td>{{$elchi->name}}</td>
                           <td>{{$elchi->old}} -> {{$elchi->new}}</td>
                           <td>{{$elchi->created_at}}</td>
                           
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
