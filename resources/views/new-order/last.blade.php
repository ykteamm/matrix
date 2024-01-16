@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
       <div class="card flex-fill mt-5">
           <div>
               <div class="row justify-content-between p-3">
                   <div class="col-md-12">
                     <form action="{{route('last.order.save')}}" method="POSt">
                        @csrf
                       <ul class="list-group">
                           <li class="list-group-item d-flex justify-content-between align-items-center">
                             Buyurtma raqami
                             <span>
                                 <input type="text" name="code" class="form-control form-control-sm" value="P{{$code+1}}">
                               </span>
                           </li>
                           <li class="list-group-item d-flex justify-content-between align-items-center">
                                 Buyurtma vaqti
                               <span>
                                 <select class="form-control form-control-sm" name="month">
                                    <option selected disabled></option>
                                       <option value="2023-06-15 13:13:13">Iyun (15.06.2023) </option>
                                       <option value="2023-07-15 13:13:13">Iyul (15.07.2023) </option>
                                 </select>
                             </li>
                           <li class="list-group-item d-flex justify-content-between align-items-center">
                               Buyurtmachi
                               <span>

                                 <select class="form-control form-control-sm" name="pharmacy_id">
                                    <option selected disabled></option>
                                       @foreach ($pharmacy as $item)
                                          <option value="{{$item->id}}">{{$item->name}} ({{$item->region->name}})</option>
                                       @endforeach
                                 </select>
                               </span>

                             </li>

                           <li class="list-group-item d-flex justify-content-between align-items-center">
                              Pul holati
                              <span>
                                 <select class="form-control form-control-sm" name="money_action">
                                    <option selected disabled></option>
                                       <option value="1">Qarzdorlik</option>
                                       <option value="2">Predoplata</option>
                                 </select>
                              </span>

                           </li>

                           <li class="list-group-item d-flex justify-content-between align-items-center">
                              Tolov holati
                              <span>
                                 <select class="form-control form-control-sm" name="money_status">
                                    <option selected disabled></option>
                                       @foreach ($money as $item)
                                          <option value="{{$item->id}}">{{$item->type}}.............</option>
                                       @endforeach
                                 </select>
                              </span>

                           </li>

                           <li class="list-group-item d-flex justify-content-between align-items-center">
                              Pul miqdori
                              <span>
                                 <input type="number" class="form-control form-control-sm" name="money">
                              </span>

                           </li>
                           <li class="list-group-item d-flex justify-content-between align-items-center">
                              <button type="submit" class="btn btn-block btn-primary">Saqlash</button>
                            </li>
                         </ul>
                     </form>
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