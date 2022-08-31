@extends('admin.layouts.app')

@section('admin_content')
<div class="content container-fluid">
   @if ($errors->any())
   <div class="alert alert-danger" id="message">
       <ul>
           @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
   </div>
   @endif
   @if (Session::has('message'))
   <div class="alert alert-primary" id="message">
       <ul>
            <li>{{ Session::get('message') }}</li>
       </ul>
   </div>
   @endif
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col-md-12">
            <div class="d-flex align-items-center">
               <ul class="breadcrumb ml-2">
                  <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item active">{{ __('app.add_filial') }} </li>
               </ul>
               @isset(Session::get('per')['branch_create'])
               <div class="ml-auto" > <button type="button" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-outline-primary"> {{ __('app.add_user')}} </button> </div>
               @endisset
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-sm-12">
            <div class="card">
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="datatable table table-stripped">
                        <thead>
                           <tr>
                              <th> № </th>
                              <th> {{ __('app.filial') }} </th>
                              <th> {{ __('app.hospital') }} </th>
                              @if(isset(Session::get('per')['branch_update']) || isset(Session::get('per')['branch_delete']))
                              <th class="text-right"> {{ __('app.action') }} </th>
                             @endif
                           </tr>
                        </thead>
                        <tbody>
                              @isset($branchs)
                              @foreach($branchs as $key => $value)
                              <tr>
                              <td> {{ $key+1 }} </td>
                              <td> {{ $value->branch_name }} </td>
                              <td> {{ $value->hospital->hospital_name }} </td>
                              <td class="text-right">
                              @isset(Session::get('per')['branch_update'])
                                 <a href="#" class="btn btn-sm btn-white text-success mr-2"><i class="fas fa-edit mr-1"></i></a>
                              @endisset

                              @isset(Session::get('per')['branch_delete'])
                                 <a href="{{ route('branch.delete',$value->id) }}" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i></a>
                              @endisset
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
<div class="modal fade show" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-body">
                     <form action="{{ route('branch.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="form-group col-md-12">
                           <label> {{ __('app.hospital') }} </label>
                              <select class="form-control form-control-sm" name="hospital_id" id="get-branchs">
                                 @isset($hospitals)
                                 <option value="" disabled selected hidden></option>
   
                                 @foreach($hospitals as $key => $value)
                                 <option value="{{ $value->id }}">{{ $value->hospital_name }}
                                 </option>
                              @endforeach
                                 @endisset
                                 
                              </select>
                        </div>
                        <div class="form-group col-md-12">
                           <label> {{ __('app.filial') }} </label>
                           <input type="text" name="branch_name" class="form-control form-control-sm" />
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-primary"> {{ __('app.add_data') }} </button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
       {{-- <div class="modal-footer">
         <button type="button" class="btn btn-primary">Save changes</button>
       </div> --}}
     </div>
   </div>
</div>
@endsection
@section('admin_script')
<script type="text/javascript">
   $(document).ready(function(){
      $('#toggleBranch').click(function() {
         $("#fortoggleBranch").slideToggle("slow");
      });
   });
</script>
@endsection