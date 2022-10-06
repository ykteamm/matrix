@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

        <div class="content container-fluid headbot">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('condition-question.update',$condition_question->id) }}" method="POST">
                                {{ method_field('PATCH') }}
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-2 ichkitashqi">
                                        <select class="form-control form-control-sm" name='pill_question_id'>
                                            @foreach ($pill_questions as $question)
                                                @if ($question->id == $condition_question->pill_question->id)
                                                <option selected value='{{$question->id}}'>{{$question->name}}</option>
                                                @else
                                                <option value='{{$question->id}}'>{{$question->name}}</option>
                                                @endif
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="text" value="{{$condition_question->name}}"  name="condition_question" class="form-control form-control-sm" required/>
                                    </div>

                                    <div class="form-group col-md-2">
                                            <button type="submit" class="btn btn-primary"> O'zgartirish </button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
    </div>

</div>
@endsection
@section('admin_script')
@endsection
