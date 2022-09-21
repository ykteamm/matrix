@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

      <div class="content container-fluid headbot">
      @foreach ($regions as $item)
        
      <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <div class="d-flex align-items-center">
                    <h5 class="page-title">{{$item->name}} </h5>
                </div>
            </div>
                <div class="col-auto text-right">
                    <a class="btn btn-white filter-btn" href="javascript:void(0);" onclick="filterReg('filter{{$item->id}}')"><i class="feather-filter"></i>
                    </a>
                </div>
        </div>
        <div class="row mt-3" id="filter{{$item->id}}" style="display: none;">
        @foreach ($elchilar as $elchi)
            @if ($elchi->tid == $item->id)
            <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap" data-toggle="collapse" href="#collapseWidthExample{{$elchi->id}}" aria-expanded="false" aria-controls="collapseWidthExample{{$elchi->id}}">
                <div class="card detail-box4">
                    <div class="card-body">
                        <div class="dash-contetnt">
                            <div class="mb-3" style="text-align: center">
                            <img src="{{asset('assets/img/users/users.png')}}" style="width:60px" class="img-fluid" alt="" />
                            </div>
                            <h4 class="text-white" style="text-align: center">{{$elchi->last_name.' '.$elchi->first_name}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 collapse multi-collapse" id="collapseWidthExample{{$elchi->id}}">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-contetnt">
                            {{-- <div class="mb-3" style="text-align: center">
                            <img src="{{asset('assets/img/users/users.png')}}" style="width:60px" class="img-fluid" alt="" />
                            </div> --}}
                            <h4  style="text-align:center;color:black;">{{$elchi->last_name.' '.$elchi->first_name}}</h4>
                            <div class="card" style="border:1px solid rgb(30, 8, 102);;">
                                <div class="card-body">
                                    {{-- <h4 style="color:black">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#intizom{{$elchi->id}}">
                                            Launch demo modal
                                          </button>
                                    </h4> --}}
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#intizom{{$elchi->id}}">
                                        Intizom
                                      </button>
                                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bilim{{$elchi->id}}">
                                        Bilim
                                      </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @endif
        @endforeach
    </div>
      </div>
     @endforeach
    </div>
    </div>

   </div>
   @foreach ($elchilar as $elchi)
   <div class="modal fade" id="intizom{{$elchi->id}}">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Intizom savollari</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <ul class="list-group">
                <li class="list-group-item ">1. Savol1 
                    <fieldset class="rate">
                        <input type="radio" id="rating10" name="rating" value="10" /><label for="rating10" title="5 stars"></label>
                        <input type="radio" id="rating9" name="rating" value="9" /><label class="half" for="rating9" title="4 1/2 stars"></label>
                        <input type="radio" id="rating8" name="rating" value="8" /><label for="rating8" title="4 stars"></label>
                        <input type="radio" id="rating7" name="rating" value="7" /><label class="half" for="rating7" title="3 1/2 stars"></label>
                        <input type="radio" id="rating6" name="rating" value="6" /><label for="rating6" title="3 stars"></label>
                        <input type="radio" id="rating5" name="rating" value="5" /><label class="half" for="rating5" title="2 1/2 stars"></label>
                        <input type="radio" id="rating4" name="rating" value="4" /><label for="rating4" title="2 stars"></label>
                        <input type="radio" id="rating3" name="rating" value="3" /><label class="half" for="rating3" title="1 1/2 stars"></label>
                        <input type="radio" id="rating2" name="rating" value="2" /><label for="rating2" title="1 star"></label>
                        <input type="radio" id="rating1" name="rating" value="1" /><label class="half" for="rating1" title="1/2 star"></label>
                    
                    </fieldset>
                    {{-- <div class="rating">

                        <input type="radio" name="rating" value="5" id="5"><label for="5" onclick="">☆</label>
                        <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                        <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                        <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                        <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                      </div> --}}
                    {{-- <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="2">
                    <p>
                        <i class='far fa-star'></i>
                        <i class='far fa-star'></i>
                        <i class='far fa-star'></i>
                        <i class='far fa-star'></i>
                        <i class='far fa-star'></i>
                    </p> --}}
                </li>
                <li class="list-group-item ">2. Savol2 </li>
                <li class="list-group-item ">3. Savol3 </li>
                <li class="list-group-item ">4. Savol4 </li>
                <li class="list-group-item ">5. Savol5 </li>
                <li class="list-group-item ">6. Savol6 </li>
                <li class="list-group-item ">7. Savol7 </li>
              </ul>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
</div>
   @endforeach
@endsection
@section('admin_script')
   <script>
    function filterReg(item)
    {
        $(`#${item}`).slideToggle("slow");
    }
    
    // $(document).on('click','#filter_search',function(){$('#filter_inputs').slideToggle("slow");});
        
   </script>
@endsection
