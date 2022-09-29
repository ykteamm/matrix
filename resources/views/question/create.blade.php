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
                            <form action="{{ route('question.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-2">
                                           <select class="form-control form-control-sm" name='bolim' id='depbolim'>
                                                <option valeu='ichki'>Ichki</option>
                                                <option value='tashqi'>Tashqi</option>
                                           </select>
                                    </div>
                                    <div class="form-group col-md-2 ichkitashqi" id="ichkibolim">
                                        <select class="form-control form-control-sm" name='bolimid' id='depbolim'>
                                            @foreach ($departichki as $item)
                                                <option value='{{$item->id}}'>{{$item->name}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div style="display: none" class="form-group col-md-2 ichkitashqi" id="tashqibolim">
                                        <select class="form-control form-control-sm" name='bolimid2' id='depbolim'>
                                            @foreach ($departtashqi as $item)
                                            <option value='{{$item->id}}'>{{$item->name}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="text" placeholder="Savolni kiriting"  name="bname" class="form-control form-control-sm" required/>
                                    </div>
                                    {{-- <div > --}}
                                    <div class="form-group col-md-2">
                                        <input style="display: none" id="gradetashqi" type="number" placeholder="Ballni kiriting"  name="bball" class="form-control form-control-sm"/>

                                    </div>
                                    {{-- </div> --}}
                                    <div class="form-group col-md-2">
                                            <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                                    </div>
                                    
                                </div>
                            </form>
                            
                                <div class="table-responsive">
                                    <table class="table mb-0" id="dtBasicExample">
                                        <thead>
                                            <tr>
                                                <th> № </th>
                                                <th> Nomi </th>
                                                <th> Guruhi </th>
                                                <th> Harakat </th>
        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($question)
                                            @foreach($question as $key => $position)
                                            <tr>
                                                <td> {{ $key+1 }} </td>
                                                <td> {{ $position->name }} </td>
                                                @if($position->grade == 0)
                                                <td> Ichki </td>
                                                @else
                                                <td> Tashqi </td>
                                                @endif
                                                <td class="text-right">
                                                    {{-- <a href="{{ route('patient.show',$value->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-eye mr-1"></i></a> --}}
                                                  {{-- @isset(Session::get('per')['rol_update']) --}}
                                                    <a href="{{ route('question.edit',$position->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-edit mr-1"></i></a>
                                                  {{-- @endisset --}}
                                                  {{-- @isset(Session::get('per')['rol_delete']) --}}
                                                    <a href="{{ route('question.delete',$position->id)}}" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i></a>
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
    $(document).ready(function () {
        $('#depbolim').change(function (e) { 
        // e.preventDefault();

        $('.ichkitashqi').css('display','none')
        if(this.value == 'tashqi')
        {
            $('#gradetashqi').css('display','')
            $('#tashqibolim').css('display','')
        }else{

        // if(this.value == 'ichki')
        // {   
            // alert(this.value)
            $('#gradetashqi').css('display','none')
            $('#ichkibolim').css('display','')
        // }
    }
        
    }); 
    });
    
   </script>
@endsection
