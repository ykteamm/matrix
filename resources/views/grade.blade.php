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
                                    @foreach ($departments as $depitem)
                                    @isset(Session::get('per')['d'.$depitem->id])
                                    @if(Session::get('per')['d'.$depitem->id] == 'true')
                                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dep{{$item->id}}{{$depitem->id}}{{$elchi->id}}">
                                        {{$depitem->name}}
                                      </button>
                                    @endif
                                    @endisset
                                    @endforeach
                                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#intizom{{$elchi->id}}">
                                        Intizom
                                      </button>
                                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bilim{{$elchi->id}}">
                                        Bilim
                                      </button> --}}
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
   @foreach ($regions as $item)
   @foreach ($elchilar as $elchi)
   @foreach ($departments as $dep)

   <div class="modal fade" id="dep{{$item->id}}{{$dep->id}}{{$elchi->id}}">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">{{$dep->name}} savollari</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <ul class="list-group">
                @php
                    $i=1;
                @endphp
                @foreach ($questions as $key => $quest)
                    @if ($dep->id == $quest->department_id)
                        
                @if(isset($grades[$quest->id]) && $grades[$quest->id]['uid'] == $elchi->id)
                <li class="list-group-item ">
                    <div>{{$i++}}. {{$quest->name}}</div>
                    <div style="text-align:center;">
                    <fieldset class="rate">
                        <input type="radio" id="rating10" name="rating" value="10" />
                        <label class="@if($grades[$quest->id]['grade'] >= 5) colorrate @endif" for="rating10" title="5 ball"></label>
                        <input type="radio" id="rating9" name="rating" value="9" />
                        <label class="half @if($grades[$quest->id]['grade'] >= 4.5) colorrate @endif" for="rating9" title="4.5 ball"></label>
                        <input type="radio" id="rating8" name="rating" value="8" />
                        <label class="@if($grades[$quest->id]['grade'] >= 4) colorrate @endif" for="rating8" title="4 ball"></label>
                        <input type="radio" id="rating7" name="rating" value="7" />
                        <label class="half @if($grades[$quest->id]['grade'] >= 3.5) colorrate @endif" for="rating7" title="3.5 ball"></label>
                        <input type="radio" id="rating6" name="rating" value="6" />
                        <label class="@if($grades[$quest->id]['grade'] >= 3) colorrate @endif" for="rating6" title="3 ball"></label>
                        <input type="radio" id="rating5" name="rating" value="5" />
                        <label class="half @if($grades[$quest->id]['grade'] >= 2.5) colorrate @endif" for="rating5" title="2.5 ball"></label>
                        <input type="radio" id="rating4" name="rating" value="4" />
                        <label  class="@if($grades[$quest->id]['grade'] >= 2) colorrate @endif" for="rating4" title="2 ball"></label>
                        <input type="radio" id="rating3" name="rating" value="3" />
                        <label class="half @if($grades[$quest->id]['grade'] >= 1.5) colorrate @endif" for="rating3" title="1.5 ball"></label>
                        <input type="radio" id="rating2" name="rating" value="2" />
                        <label class="@if($grades[$quest->id]['grade'] >= 1) colorrate @endif" for="rating2" title="1 ball"></label>
                        <input type="radio" id="rating1" name="rating" value="1" />
                        <label class="half  @if($grades[$quest->id]['grade'] >= 0.5) colorrate @endif" for="rating1" title="0.5 ball"></label>
                    </fieldset>
                </div>
                </li>

                @else
                <li class="list-group-item ">
                    <div>{{$i++}}. {{$quest->name}}</div>
                    <div style="text-align:center;">
                    <fieldset class="rate" name="" id="q{{$elchi->id}}{{$dep->id}}{{$quest->id}}">
                        <input type="radio" id="rating10" name="rating" value="10" /><label class="q{{$elchi->id}}{{$dep->id}}{{$quest->id}}" for="rating10" title="5 ball" onclick="rateHover(5,`q{{$elchi->id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->id}},{{$quest->id}})"></label>
                        <input type="radio" id="rating9" name="rating" value="9" /><label class="half q{{$elchi->id}}{{$dep->id}}{{$quest->id}}" for="rating9" title="4.5 ball" onclick="rateHover(4.5,`q{{$elchi->id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->id}},{{$quest->id}})"></label>
                        <input type="radio" id="rating8" name="rating" value="8" /><label class="q{{$elchi->id}}{{$dep->id}}{{$quest->id}}" for="rating8" title="4 ball" onclick="rateHover(4,`q{{$elchi->id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->id}},{{$quest->id}})"></label>
                        <input type="radio" id="rating7" name="rating" value="7" /><label class="half q{{$elchi->id}}{{$dep->id}}{{$quest->id}}" for="rating7" title="3.5 ball" onclick="rateHover(3.5,`q{{$elchi->id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->id}},{{$quest->id}})"></label>
                        <input type="radio" id="rating6" name="rating" value="6" /><label class="q{{$elchi->id}}{{$dep->id}}{{$quest->id}}" for="rating6" title="3 ball" onclick="rateHover(3,`q{{$elchi->id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->id}},{{$quest->id}})"></label>
                        <input type="radio" id="rating5" name="rating" value="5" /><label class="half q{{$elchi->id}}{{$dep->id}}{{$quest->id}}" for="rating5" title="2.5 ball" onclick="rateHover(2.5,`q{{$elchi->id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->id}},{{$quest->id}})"></label>
                        <input type="radio" id="rating4" name="rating" value="4" /><label class="q{{$elchi->id}}{{$dep->id}}{{$quest->id}}" for="rating4" title="2 ball" onclick="rateHover(2,`q{{$elchi->id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->id}},{{$quest->id}})"></label>
                        <input type="radio" id="rating3" name="rating" value="3" /><label class="half q{{$elchi->id}}{{$dep->id}}{{$quest->id}}" for="rating3" title="1.5 ball" onclick="rateHover(1.5,`q{{$elchi->id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->id}},{{$quest->id}})"></label>
                        <input type="radio" id="rating2" name="rating" value="2" /><label class="q{{$elchi->id}}{{$dep->id}}{{$quest->id}}" for="rating2" title="1 ball" onclick="rateHover(1,`q{{$elchi->id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->id}},{{$quest->id}})"></label>
                        <input type="radio" id="rating1" name="rating" value="1" /><label class="half q{{$elchi->id}}{{$dep->id}}{{$quest->id}}" for="rating1" title="0.5 ball" onclick="rateHover(0.5,`q{{$elchi->id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->id}},{{$quest->id}})"></label>
                    </fieldset>
                </div>
                </li>
                @endif
                @endif

                @endforeach
              </ul>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="gradeSave(true)">Saqlash</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
        </div>
        
      </div>
    </div>
</div>
   @endforeach
   @endforeach
   @endforeach
@endsection
@section('admin_script')
   <script>
    // $(window).click(function(e) {
    //     if($('body').hasClass('modal-open'))
    //     {
    //     alert(31231);

    //     }
    // });
    $(document).ready(function(){

    $('.modal').on('hidden.bs.modal', function () {
        gradeSave(false);
    });
});
    function filterReg(item)
    {
        $(`#${item}`).slideToggle("slow");
    }
    function rateHover(ball,text,eid,qid)
    {
        // $("label:hover ~ label").css("color","black");
        // input:checked ~ label,label:hover, label:hover ~ label { color: #73B100;  }
        $(`.${text}`).removeAttr('style');
        $("input:checked ~ label,label:hover, label:hover ~ label").css("color","#73B100");
        $(`#${text}`).attr('name',ball);

        var _token   = $('meta[name="csrf-token"]').attr('content');
         $.ajax({
            url: "/grade/ball",
            type:"POST",
            data:{
                eid:eid,
                qid:qid,
                ball:ball,
               _token: _token
            },
            success:function(response){
             
            }
        });
    } 
    function gradeSave(bool)
    {
        var _token   = $('meta[name="csrf-token"]').attr('content');
         $.ajax({
            url: "/grade/save",
            type:"POST",
            data:{
                save:bool,
               _token: _token
            },
            success:function(response){
                if (response.status == 200) {
                    window.location.reload()
                    
                }
                if (response.status == 300) {
                    $('.modal').modal('hide');
                    
                }
            }
        });
    }
   </script>
@endsection
