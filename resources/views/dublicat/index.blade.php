@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card mt-5">
            <form action="{{ route('dublicat.store') }}" method="POST">
                @csrf
                
            </form>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table mb-0 example1">
                     <thead>
                        <tr>
                           <th>ID </th>
                           <th>Username </th>
                           <th>Parol </th>
                           <th>FIO </th>
                           <th>Harakat</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($users as $elchi)
                        <tr>
                           <td>{{$elchi->id}}</td>
                           <td>{{$elchi->username}}</td>
                           <td>{{$elchi->pr}}</td>
                           <td>{{$elchi->last_name}} {{$elchi->first_name}}</td>
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
