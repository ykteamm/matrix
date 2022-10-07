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
                            <form action="{{ route('knowledge-question.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <select class="form-control form-control-sm" name='pill_question_id'>
                                            @if(Session::has('p_q_id'))
                                            @foreach ($pill_questions as $question)
                                                @if (Session::get('p_q_id') == $question->id)
                                                    <option value='{{$question->id}}' selected>{{$question->name}}</option>
                                                @else
                                                    <option value='{{$question->id}}'>{{$question->name}}</option>
                                                @endif
                                            @endforeach
                                            @else
                                            <option value="" disabled selected hidden>{{ Session::get('p_q_id') }}</option>
                                            @foreach ($pill_questions as $question)
                                                    <option value='{{$question->id}}'>{{$question->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <select class="form-control form-control-sm" name='condition_question_id'>
                                            <option value="" disabled selected hidden class="condition-selected"></option>
                                            @if(Session::has('p_q_id'))
                                            @foreach ($condition_questions as $question)
                                                @if (Session::get('p_q_id') == $question->pill_question->id)
                                                    <option value='{{$question->id}}' class="pill-question-{{$question->pill_question->id}} all-pill-question">{{$question->name}}</option>
                                                @else
                                                <option value='{{$question->id}}' class="pill-question-{{$question->pill_question->id}} all-pill-question" style="display:none;">{{$question->name}}</option>
                                                @endif
                                            @endforeach 
                                            @else
                                            @foreach ($condition_questions as $question)
                                                <option value='{{$question->id}}' class="pill-question-{{$question->pill_question->id}} all-pill-question" style="display:none;">{{$question->name}}</option>
                                            @endforeach 
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="text" placeholder="Savolni kiriting"  name="knowledge_question" class="form-control form-control-sm" required/>
                                    </div>

                                    <div class="form-group col-md-2">
                                            <button type="submit" class="btn btn-primary"> Saqlash </button>
                                    </div>
                                    
                                </div>
                            </form>
                            
                                <div class="table-responsive">
                                    <table class="table mb-0" id="dtBasicExample">
                                        <thead>
                                            <tr>
                                                <th> № </th>
                                                <th> Nomi </th>
                                                <th> Harakat </th>
        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($knowledge_questions)
                                            @foreach($knowledge_questions as $key => $question)
                                            <tr>
                                                <td> {{ $key+1 }} </td>
                                                <td> {{ $question->name }} </td>
                                                <td> {{ $question->condition_question->name }} </td>
                                                <td class="text-right">
                                                    {{-- <a href="{{ route('patient.show',$value->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-eye mr-1"></i></a> --}}
                                                  {{-- @isset(Session::get('per')['rol_update']) --}}
                                                    {{-- <a href="{{ route('pill-question.edit',$question->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-edit mr-1"></i></a> --}}
                                                  {{-- @endisset --}}
                                                  {{-- @isset(Session::get('per')['rol_delete']) --}}
                                                    {{-- <a href="{{ route('pill-question.delete',$question->id)}}" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i></a> --}}
                                                  {{-- @endisset --}}
                                                 </td>
                    
                                            </tr>
                                            @endforeach
                                            @endisset
                                        </tbody>
                                    </table>
                                </div>
                                
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
    </div>

</div>
@endsection
@section('admin_script')
    <script>
        $('select[name="pill_question_id"]').change(function(){
            $('.all-pill-question').css('display','none');
            $(`.pill-question-${$(this).val()}`).css('display','');
            $('select[name="condition_question_id"]').val('');
        });
    </script>
@endsection
