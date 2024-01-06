@extends('admin.layouts.app')
@section('admin_content')
<div class="content mt-1 main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')
      <div class="card flex-fill">

         <div style="border-bottom-radius:30px !important;margin-left:auto">
            <div class="justify-content-between align-items-center p-2" >
                 <div class="btn-group">
                  <div class="row">
                     <div class="col-md-12">
                        <a href="{{route('trend.region','three')}}">
                        <button type="button" class="btn btn-block btn-outline-primary"> 3 oy</button>
                        </a>
                     </div>
                  </div>
                 </div>
                 <div class="btn-group">
                      <div class="row">
                        <div class="col-md-12">
                           <a href="{{route('trend.region','six')}}">
                              <button type="button" class="btn btn-block btn-outline-primary"> 6 oy</button>
                              </a>
                        </div>
                     </div>
                 </div>
                <div class="btn-group">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{route('trend.region','twelve')}}">
                                <button type="button" class="btn btn-block btn-outline-primary"> 12 oy</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
         </div>

         <div class="container mt-5">
            <h3>Elchilar</h3>

            <form action="{{route('region.statistic')}}" method="POST" class="row align-items-center">
                @csrf
               <div class="form-group col-md-6">
                  <label for="region_id">Viloyatni tanglang</label><br>
                  <select class="custom-select custom-select-lg mb-3 col-md-12" name="region_id" id="region_id" aria-label=".form-select-lg example">
                     <option value="">--Tanglang--</option>
                     @foreach($region as $reg)
                     <option value="{{$reg->id}}">{{$reg->name}}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group col-md-1">
                  <button type="submit" class="btn btn-block btn-outline-primary">
                     OK
                  </button>
               </div>
            </form>
         </div>

         <div class="container mt-5">
            <h3>
               Dorilar viloyat bo'yicha
            </h3>

             <form action="{{route('product.statistic')}}" method="POST" class="row align-items-center">
                 @csrf
                 <div class="form-group col-md-6">
                     <label for="region_id">Viloyatni tanglang</label><br>
                     <select class="custom-select custom-select-lg mb-3 col-md-12" name="region_id" id="region_id" aria-label=".form-select-lg example">
                         <option value="">--Tanglang--</option>
                         @foreach($region as $reg)
                             <option value="{{$reg->id}}">{{$reg->name}}</option>
                         @endforeach
                     </select>
                 </div>
                 <div class="form-group col-md-1">
                     <button type="submit" class="btn btn-block btn-outline-primary">
                         OK
                     </button>
                 </div>
             </form>
         </div>

     </div>
   </div>

</div>
@endsection

