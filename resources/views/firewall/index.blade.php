@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row headbot">
      @foreach ($fire_arrays as $key => $fires)
          <div class="col-md-6">
               <div class="card" style="background: rgb(161, 202, 236)">
                  <ul>
                     <li>Elchi: {{$fires[0]->user->last_name}} {{$fires[0]->user->first_name}}</li>
                     <li>Dorixona: {{$fires[0]->pharmacy->name}}</li>
                     <li>Vaqti: {{$fires[0]->created_at}}</li>

                     @php
                         $sum = 0;
                     @endphp
                     @foreach ($fires as $item)
                     @php
                         $sum += $item->number*$item->price;
                     @endphp
                     <li>{{$item->medicine->name}} ({{$item->number}}x{{$item->price}})</li>
                     @endforeach

                     <li style="color:brown">Jami: {{$sum}}</li>

                     <div class="mt-3 mb-3">
                        <button class="btn btn-success"><a href="{{route('firewall-confirm',['id' => $key,'status' => 1])}}">Qabul qilish</a></button>
                        <button class="btn btn-danger"><a href="{{route('firewall-confirm',['id' => $key,'status' => 2])}}">Rad qilish</a></button>
                     </div>
                     
                     
                     

                  </ul>
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
