@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-9">
         {{-- <div class="card"> --}}
            <div class="card-body">
               <form id="step_button" action="{{route('know-grade.store')}}" method="post">
                  @csrf
               <div class="table-responsive">
                  <table class="table mb-0">
                     {{-- <thead>
                        <tr>
                           <th></th>
                           <th>FIO </th>
                           <th>Viloyat </th>
                        </tr>
                     </thead> --}}
                     <tbody>

                        @foreach ($question_step1 as $item)
                        <tr>
                           
                           <td>{{$item->name}} </td>
                           <td>
                            <div style="text-align:center;">
                                <fieldset class="rate">
                                    <input type="radio"  name="rating" value="10" /><label onclick="rateHover(5,`step1_{{$item->id}}`)" class="step1_{{$item->id}}" for="rating10" title="5 ball"></label>
                                    <input type="radio"  name="rating" value="8" /><label onclick="rateHover(4,`step1_{{$item->id}}`)" class="step1_{{$item->id}}" for="rating8" title="4 ball"></label>
                                    <input type="radio"  name="rating" value="6" /><label onclick="rateHover(3,`step1_{{$item->id}}`)" class="step1_{{$item->id}}" for="rating6" title="3 ball"></label>
                                    <input type="radio"  name="rating" value="4" /><label onclick="rateHover(2,`step1_{{$item->id}}`)" class="step1_{{$item->id}}" for="rating4" title="2 ball"></label>
                                    <input type="radio"  name="rating" value="2" /><label onclick="rateHover(1,`step1_{{$item->id}}`)" class="step1_{{$item->id}}" for="rating2" title="1 ball"></label>
                                </fieldset>
                                    <input class="stepclass" style="display: none;" type="number" name="step1_{{$item->id}}" id="step1_{{$item->id}}">
                            </div>
                           </td>
                        </tr>
                        @endforeach
                        @foreach ($questions as $item)
                        <tr>
                           
                           <td>{{$item->name}} </td>
                           <td>
                              <div style="text-align:center;">
                                  <fieldset class="rate">
                                      <input type="radio"  name="rating" value="5" /><label onclick="rateHover(5,`step3_{{$item->id}}`)" class="step3_{{$item->id}}" for="rating10" title="5 ball"></label>
                                      <input type="radio"  name="rating" value="4" /><label onclick="rateHover(4,`step3_{{$item->id}}`)" class="step3_{{$item->id}}" for="rating8" title="4 ball"></label>
                                      <input type="radio" name="rating" value="3" /><label onclick="rateHover(3,`step3_{{$item->id}}`)" class="step3_{{$item->id}}" for="rating6" title="3 ball"></label>
                                      <input type="radio"  name="rating" value="2" /><label onclick="rateHover(2,`step3_{{$item->id}}`)" class="step3_{{$item->id}}" for="rating4" title="2 ball"></label>
                                      <input type="radio"  name="rating" value="1" /><label onclick="rateHover(1,`step3_{{$item->id}}`)" class="step3_{{$item->id}}" for="rating2" title="1 ball"></label>
                                  </fieldset>
                                      <input class="stepclass" style="display: none;" type="number" name="step3_{{$item->id}}" id="step3_{{$item->id}}" required>
                              </div>
                             </td>
                        </tr>
                        @endforeach
                        

                     </tbody>
                     
                  </table>
                  
               </div>
               <div class="form-group col-md-3 mt-4">
                  <button type="button" onclick="submitForm()" class="btn btn-primary"> {{ __('app.add_data') }} </button>
              </div>
            </form>

            </div>
         {{-- </div> --}}
      </div>
      <div class="col-sm-1">
    </div>
   </div>
</div>
@endsection
@section('admin_script')
   <script>
      function rateHover(id,step)
      {
        $(`.${step}`).removeAttr('style');

        $("input:checked ~ label,label:hover, label:hover ~ label").css("color","#73B100");

         $(`#${step}`).val(id);
         
      }
      function submitForm()
      {
         var a = [];
         $(".stepclass").each(function(){
            var step_id = $(this).val();
            if (step_id == '') {
               a.push(0);
            }else {
               a.push($(this).val());
            }
             // This is the jquery object of the input, do what you will
         });
         // alert(a)
         // console.log(jQuery.inArray(0,a))
         if(jQuery.inArray(0,a) == -1){
            $( "#step_button" ).submit();
            
         }else {
            alert('Barcha savollarga ball qoying')
         

         }
      }
   </script>
@endsection
