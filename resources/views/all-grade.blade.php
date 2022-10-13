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
                           <th>Viloyat</th>
                           <th>Baholash</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($all_elchi as $elchi)
                        <tr>
                           <td>{{$elchi->username}}</td>

                           <td>{{$elchi->last_name}} {{$elchi->first_name}}</td>
                           <td>{{$elchi->v_name}}</td>
                           <td>
                            @foreach ($departments as $department)
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dep{{$elchi->user_id}}{{$department->id}}">
                                {{$department->name}}
                              </button>
                            @endforeach
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bilim{{$elchi->user_id}}">
                                Bilim
                              </button>
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

@foreach ($all_elchi as $elchi)
    @foreach ($departments as $dep)
        <div class="modal fade" id="dep{{$elchi->user_id}}{{$dep->id}}">
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
                        <form id="form{{$elchi->user_id}}{{$dep->id}}" action="{{route('all-grade.store')}}" method="post">
                            @csrf
                        @foreach ($questions as $key => $quest)
                            @if ($dep->id == $quest->did)
                            @php
                                $ids = $elchi->user_id.$dep->id.$quest->id;
                            @endphp
                            @if(isset($grades[$ids]))
                            <li class="list-group-item ">
                                <div>{{$i++}}. {{$quest->qname}}</div>
                                <div style="text-align:center;">
                                <fieldset class="rate">
                                    <input type="radio" name="rating" value="5" />
                                    <label class="@if($grades[$ids]->grade >= 5) colorrate @endif" for="rating10" title="5 ball"></label>
                                    <input type="radio" name="rating" value="4" />
                                    <label class="@if($grades[$ids]->grade >= 4) colorrate @endif" for="rating8" title="4 ball"></label>
                                    <input type="radio" name="rating" value="3" />
                                    <label class="@if($grades[$ids]->grade >= 3) colorrate @endif" for="rating6" title="3 ball"></label>
                                    <input type="radio" name="rating" value="2" />
                                    <label  class="@if($grades[$ids]->grade >= 2) colorrate @endif" for="rating4" title="2 ball"></label>
                                    <input type="radio"" name="rating" value="1" />
                                    <label class="@if($grades[$ids]->grade >= 1) colorrate @endif" for="rating2" title="1 ball"></label>
                                </fieldset>
                            </div>
                            </li>
            
                            @else

                        <li class="list-group-item ">
                            <div>{{$i++}}. {{$quest->qname}}d</div>
                            <div style="text-align:center;">
                            <fieldset class="rate">
                                <input type="radio" name="rating" value="5" /><label class="q{{$elchi->user_id}}{{$dep->id}}{{$quest->id}}" for="rating10" title="5 ball" onclick="rateHover(5,`q{{$elchi->user_id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                                <input type="radio" name="rating" value="4" /><label class="q{{$elchi->user_id}}{{$dep->id}}{{$quest->id}}" for="rating8" title="4 ball" onclick="rateHover(4,`q{{$elchi->user_id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                                <input type="radio" name="rating" value="3" /><label class="q{{$elchi->user_id}}{{$dep->id}}{{$quest->id}}" for="rating6" title="3 ball" onclick="rateHover(3,`q{{$elchi->user_id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                                <input type="radio" name="rating" value="2" /><label class="q{{$elchi->user_id}}{{$dep->id}}{{$quest->id}}" for="rating4" title="2 ball" onclick="rateHover(2,`q{{$elchi->user_id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                                <input type="radio" name="rating" value="1" /><label class="q{{$elchi->user_id}}{{$dep->id}}{{$quest->id}}" for="rating2" title="1 ball" onclick="rateHover(1,`q{{$elchi->user_id}}{{$dep->id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                            </fieldset>
                            <input class="stepclass" style="display: none;" type="textarea"  name="name_q{{$elchi->user_id}}{{$dep->id}}{{$quest->id}}" id="name_q{{$elchi->user_id}}{{$dep->id}}{{$quest->id}}">

                        </div>
                        </li>
                        {{-- @endif --}}
                        @endif
                        @endif

                        @endforeach
                        </form>

                    </ul>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="gradeSave(`form{{$elchi->user_id}}{{$dep->id}}`)">Saqlash</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                </div>
                
            </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="bilim{{$elchi->user_id}}">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Bilim savollari</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <ul class="list-group">
                    @php
                        $i=1;
                    @endphp
                    <form id="form{{$elchi->user_id}}" action="{{route('all-grade-step1.store')}}" method="post">
                        @csrf
                    @foreach ($question_step1 as $key => $quest)
                        @php
                            $ids = $elchi->user_id.$quest->id;
                        @endphp
                        @if ($key == $ids)
                            
                        
                        <li class="list-group-item ">
                            <div>{{$i++}}. {{$quest->name}}</div>
                            <div style="text-align:center;">
                            <fieldset class="rate">
                                <input type="radio" name="rating" value="5" /><label class="q{{$elchi->user_id}}{{$quest->id}}" for="rating10" title="5 ball" onclick="rateHover(5,`q{{$elchi->user_id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                                <input type="radio" name="rating" value="4" /><label class="q{{$elchi->user_id}}{{$quest->id}}" for="rating8" title="4 ball" onclick="rateHover(4,`q{{$elchi->user_id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                                <input type="radio" name="rating" value="3" /><label class="q{{$elchi->user_id}}{{$quest->id}}" for="rating6" title="3 ball" onclick="rateHover(3,`q{{$elchi->user_id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                                <input type="radio" name="rating" value="2" /><label class="q{{$elchi->user_id}}{{$quest->id}}" for="rating4" title="2 ball" onclick="rateHover(2,`q{{$elchi->user_id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                                <input type="radio" name="rating" value="1" /><label class="q{{$elchi->user_id}}{{$quest->id}}" for="rating2" title="1 ball" onclick="rateHover(1,`q{{$elchi->user_id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                            </fieldset>
                            <input class="stepclass" style="display: none;" type="textarea"  name="name_q{{$elchi->user_id}}{{$quest->id}}" id="name_q{{$elchi->user_id}}{{$quest->id}}">

                        </div>
                        </li>
                        @endif

                    @endforeach
                    {{-- </form> --}}
                    {{-- <form id="forms{{$elchi->user_id}}" action="{{route('all-grade-step3.store')}}" method="post"> --}}
                        @csrf
                    @foreach ($know_questions as $key => $quest)
                        @php
                            $ids = $elchi->user_id.$quest->id;
                        @endphp
                        @if ($key == $ids)
                            
                        
                        <li class="list-group-item ">
                            <div>{{$i++}}. {{$quest->name}}</div>
                            <div style="text-align:center;">
                            <fieldset class="rate">
                                <input type="radio" name="rating" value="5" /><label class="q{{$elchi->user_id}}{{$quest->id}}" for="rating10" title="5 ball" onclick="rateHoverStep(5,`q{{$elchi->user_id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                                <input type="radio" name="rating" value="4" /><label class="q{{$elchi->user_id}}{{$quest->id}}" for="rating8" title="4 ball" onclick="rateHoverStep(4,`q{{$elchi->user_id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                                <input type="radio" name="rating" value="3" /><label class="q{{$elchi->user_id}}{{$quest->id}}" for="rating6" title="3 ball" onclick="rateHoverStep(3,`q{{$elchi->user_id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                                <input type="radio" name="rating" value="2" /><label class="q{{$elchi->user_id}}{{$quest->id}}" for="rating4" title="2 ball" onclick="rateHoverStep(2,`q{{$elchi->user_id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                                <input type="radio" name="rating" value="1" /><label class="q{{$elchi->user_id}}{{$quest->id}}" for="rating2" title="1 ball" onclick="rateHoverStep(1,`q{{$elchi->user_id}}{{$quest->id}}`,{{$elchi->user_id}},{{$quest->id}})"></label>
                            </fieldset>
                            <input class="stepclass" style="display: none;" type="textarea"  name="name_q{{$elchi->user_id}}{{$quest->id}}" id="name_q{{$elchi->user_id}}{{$quest->id}}">

                        </div>
                        </li>
                        @endif

                    @endforeach
                    </form>

                </ul>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="gradeSave(`form{{$elchi->user_id}}`)">Saqlash</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
            </div>
            
        </div>
        </div>
    </div>
@endforeach
@endsection
@section('admin_script')
   <script>
    function rateHover(grade,step,elchi,quest)
      {
        $(`.${step}`).removeAttr('style');

        $("input:checked ~ label,label:hover, label:hover ~ label").css("color","#73B100");

        var myItems = [{"user_id":elchi,"quest_id":quest,"grade":grade}];

        // console.log(myItems)
        $(`#name_${step}`).val(JSON.stringify(myItems));

         
      }
      function rateHoverStep(grade,step,elchi,quest)
      {
        $(`.${step}`).removeAttr('style');

        $("input:checked ~ label,label:hover, label:hover ~ label").css("color","#73B100");

        var myItems = [{"user_id":elchi,"know_quest_id":quest,"grade":grade}];

        // console.log(myItems)
        $(`#name_${step}`).val(JSON.stringify(myItems));

         
      }
      function gradeSave(form,forms)
      {
            $(`#${form}`).submit();
      }
//       jQuery(document).ready(function($) {
//     $(".clickable-row").click(function() {
//         window.location = $(this).data("href");
//     });
// });

//       function tdhover()
//       {
//          $(this).css('display','none');
//       }
   </script>
@endsection
