@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      @foreach ($collection as $item)
          <div class="col-md-6">
               <div class="card">

               </div>
          </div>
      @endforeach
      {{-- <div class="col-sm-12">
         <div class="card mt-5">
            <div class="card-body">
               <form action="{{ route('shogird.date') }}" method="POST">
                  @csrf
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
                                 <td>
                                    <input name="{{ $elchi->id }}" type="date" value="{{$elchi->week_date}}">
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  <div>
                     <button type="submit" class="btn btn-primary w-100">
                        Saqlash
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div> --}}
   </div>
</div>
@endsection
@section('admin_script')
@endsection
