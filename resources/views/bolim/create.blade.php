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
                            {{-- <form action="{{ route('bolim.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="text" placeholder="Bo'lim nomini kiriting"  name="bname" class="form-control form-control-sm" required/>
                                    </div>
                                    <div class="form-group col-md-4">
                                    </div>
                                    <div class="form-group col-md-2">
                                            <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                                    </div>
                                    
                                </div>
                            </form> --}}
                            
                                <div class="table-responsive">
                                    <table class="table mb-0" id="dtBasicExample">
                                        <thead>
                                            <tr>
                                                <th> № </th>
                                                <th> Nomi </th>
                                                <th> Guruhi </th>
        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($depart)
                                            @foreach($depart as $key => $position)
                                            <tr>
                                                <td> {{ $key+1 }} </td>
                                                <td> {{ $position->name }} </td>
                                                @if($position->status == 1)
                                                <td> Ichki </td>
                                                @else
                                                <td> Tashqi </td>
                                                @endif
                                                <td class="text-right">
                                                    {{-- <a href="{{ route('patient.show',$value->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-eye mr-1"></i></a> --}}
                                                  {{-- @isset(Session::get('per')['rol_update']) --}}
                                                    <a href="{{ route('bolim.edit',$position->id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-edit mr-1"></i></a>
                                                  {{-- @endisset --}}
                                                  {{-- @isset(Session::get('per')['rol_delete']) --}}
                                                    {{-- <a href="{{ route('position.delete',$value->id)}}" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i></a> --}}
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
   </script>
@endsection
