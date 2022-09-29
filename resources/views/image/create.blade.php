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
                            <form action="{{ route('imagegrade.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="">Savol</label>
                                           <select class="form-control form-control-sm" name='bolim' id='depbolim'>
                                            @foreach ($question as $item)
                                                <option value='{{$item->id}}'>{{$item->name}}</option>
                                            @endforeach 
                                           </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Rangli rasm</label>
                                        <input type="file" name="filerangli" class="form-control form-control-sm" required/>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Rangsiz rasm</label>
                                        <input type="file" name="filerangsiz" class="form-control form-control-sm" required/>
                                    </div>
                                    <div class="form-group col-md-2 mt-4">

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
                                                <th> Rangli </th>
                                                <th> Rangsiz </th>
        
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
                                                <td> <img src="{{asset('assets/grade/rangli'.$position->id.'.png')}}" width="20px" alt=""> </td>
                                                <td> <img src="{{asset('assets/grade/rangsiz'.$position->id.'.png')}}" width="20px" alt=""> </td>
                        
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
        
    });
    
   </script>
@endsection
