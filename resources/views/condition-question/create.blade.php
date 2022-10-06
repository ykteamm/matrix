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
                            <form action="{{ route('condition-question.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-2 ichkitashqi">
                                        <select class="form-control form-control-sm" name='pill_question_id'>
                                        {{-- <option value="" disabled selected hidden></option> --}}

                                            @foreach ($pill_questions as $question)
                                                <option value='{{$question->id}}'>{{$question->name}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="text" placeholder="Ichki kategoriyani kiriting"  name="condition_question" class="form-control form-control-sm" required/>
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
                                                <th> Asosiy kategoriya </th>
                                                <th> Harakat </th>
        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($condition_questions)
                                            @foreach($condition_questions as $key => $question)
                                            <tr>
                                                <td> {{ $key+1 }} </td>
                                                <td> {{ $question->name }} </td>
                                                <td> {{ $question->pill_question->name }} </td>
                                                <td class="text-right">
                                                    {{-- <a href="{{ route('patient.show',$value->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-eye mr-1"></i></a> --}}
                                                  {{-- @isset(Session::get('per')['rol_update']) --}}
                                                    <a href="{{ route('condition-question.edit',$question->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-edit mr-1"></i></a>
                                                  {{-- @endisset --}}
                                                  {{-- @isset(Session::get('per')['rol_delete']) --}}
                                                    <a href="{{ route('condition-question.delete',$question->id)}}" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i></a>
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
@endsection
