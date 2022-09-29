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
                            <form action="{{ route('question.update',$question->id) }}" method="POST">
                                {{ method_field('PATCH') }}
                                @csrf
                                
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <select class="form-control form-control-sm" name='bolimid'>
                                            @foreach ($depart as $item)
                                                @if($item->id == $question->department_id)
                                                {
                                                <option value='{{$item->id}}' selected>{{$item->name}}</option>

                                                }
                                                @else
                                                <option value='{{$item->id}}'>{{$item->name}}</option>

                                                @endif
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="text" value="{{$question->name}}"  name="bname" class="form-control form-control-sm" required/>
                                    </div>
                                    @if ($question->grade !=0)
                                    <div class="form-group col-md-3">
                                        <input type="text" value="{{$question->grade}}"  name="bball" class="form-control form-control-sm" required/>
                                    </div>
                                    @endif
                                    <div class="form-group col-md-2">
                                            <button type="submit" class="btn btn-primary"> O'zgartirish</button>
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
   <script>
   </script>
@endsection
