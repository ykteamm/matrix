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
               <form action="{{ route('shogird.date') }}" method="POST">
                  @csrf
                  <div class="table-responsive">
                     <table class="table mb-0 example1">
                        <thead>
                           <tr>
                              <th>Ustoz </th>
                              <th>Shogird </th>
                              <th>Status </th>
                              <th>Sinov vaqti (Hafta) </th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($teachers_user as $elchi)
                              <tr>
                                 <td>{{$elchi->teacher->last_name}} {{$elchi->teacher->first_name}}</td>
                                 <td>{{$elchi->user->last_name}} {{$elchi->user->first_name}}</td>
                                 <td>
                                    @if ($elchi->ustoz == 1)
                                       USTOZ
                                    @elseif($elchi->ustoz == 2)
                                        STAJER
                                    @else
                                    @endif
                                 </td>
                                 <td>
                                    <input name="{{ $elchi->id }}" type="date" value="{{$elchi->week_date}}">
                                 </td>
                                 @if ($elchi->game == 0)
                                    <td><a href="{{route('ustoz-game',$elchi->id)}}" style="color:blue">Oyinga qoshish</a></td>
                                 @else
                                    <td><a href="{{route('ustoz-game',$elchi->id)}}" style="color:rgb(216, 22, 22)">Oyindan chiqarish</a></td>
                                 @endif

                                 @if ($elchi->ustoz == 0)
                                    <td>
                                       <a href="{{route('ustoz-add',$elchi->id)}}" style="color:blue">Ustoz</a>
                                       <a href="{{route('stajer-add',$elchi->id)}}" style="color:blue">Stajer</a>
                                    </td>
                                 @elseif($elchi->ustoz == 1)
                                 <td>

                                       <a href="{{route('stajer-add',$elchi->id)}}" style="color:blue">Stajer</a>
                                       <a href="{{route('ustoz-stajer-minus',$elchi->id)}}" style="color:blue">Oddiy</a>
                                    </td>

                                 @else
                                 <td>

                                       <a href="{{route('ustoz-add',$elchi->id)}}" style="color:blue">Ustoz</a>

                                       <a href="{{route('ustoz-stajer-minus',$elchi->id)}}" style="color:blue">Oddiy</a>
                                    </td>


                                 @endif
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
