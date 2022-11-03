@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

        <div class="content container-fluid headbot">
            <div class="row">
                @foreach ($pharmacy as $item)
                @if (isset($item->pharmacy[0]))
                <div class="col-12 col-md-12 col-lg-12 d-flex flex-wrap">
                    <div class="card detail-box1">
                        <div class="card-body">
                            <div class="dash-contetnt">
                                <h4 class="text-white" style="text-align: center"> {{$item->name}} </h4>
                                <div class="row">
                                @foreach ($item->pharmacy as $pharma)
                                    {{-- @if ($pharma->region == $item) --}}
                                    <div class="col-4 col-md-4 col-lg-4 d-flex flex-wrap">
                                        <div class="card detail-box2 details-box">
                                            <div class="card-body">
                                                <div class="dash-contetnt">
                                                    <h4 class="text-white" style="text-align: center"> {{$pharma->name}} </h4>
                                                    @foreach ($pusers as $user)
                                                        @if ($user->pharma_id == $pharma->id)
                                                            <h2 class="text-white">{{$user->last_name}} {{$user->first_name}}</h2>
                                                        @endif     
                                                    @endforeach
                                                    @isset(Session::get('per')['farm_pm'])
                                                    @if(Session::get('per')['farm_pm'] == 'true')  
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <button type="submit" style="width:100%;" class="btn btn-primary" data-toggle="modal" data-target="#addmember{{$pharma->id}}"> 
                                                                <i class="fas fa-plus"></i> 
                                                            </button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="submit" style="width:100%;" class="btn btn-danger" data-toggle="modal" data-target="#minusmember{{$pharma->id}}"> 
                                                                <i class="fas fa-minus"></i> 
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @endisset
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- @endif --}}
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @foreach ($teams as $item) --}}
        @foreach ($pharmacy as $item)
        @foreach ($item->pharmacy as $pharma)

        <div class="modal fade" id="addmember{{$pharma->id}}">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">{{$pharma->name}} 
                    {{-- <button type="submit" class="btn btn-outline-primary btn-sm ml-3"> 
                        <i class="fas fa-plus"></i> 
                    </button> --}}
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <form action="{{ route('user-add-pharma.store') }}" method="POST">
        
                <div class="modal-body">
                    <ul class="list-group">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <select class="form-control form-control-sm" name='user_id' required>
                                        <option value="" disabled selected hidden>Elchini tanlang</option>
                                        @foreach ($users as $item)
                                            <option value="{{$item->id}}"">{{$item->last_name}} {{$item->first_name}}</option>
                                        @endforeach 
                                    </select>
                                </div>
                                <div class="form-group col-md-12" style="display: none">
                                    <input type="number" value="{{$pharma->id}}" name="team_id">
                                </div>
                            
                            </div>
        
                    </ul>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Saqlash</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                </div>
                </form>
        
                
            </div>
            </div>
        </div>
        <div class="modal fade" id="minusmember{{$pharma->id}}">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">{{$pharma->name}} 
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <form action="{{ route('user-delete-pharma.store') }}" method="POST">
        
                <div class="modal-body">
                    <ul class="list-group">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <select class="form-control form-control-sm" name='user_id' required>
                                        <option value="" disabled selected hidden>Elchini tanlang</option>
                                        @foreach ($pusers as $user)
                                            @if($user->pharma_id == $pharma->id)
                                                    <option value='{{$user->user_id}}'>{{$user->last_name}} {{$user->first_name}}</option>                                           
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12" style="display: none">
                                    <input type="number" value="{{$pharma->id}}" name="team_id">
                                </div>
                            
                            </div>
        
                    </ul>
                </div>
            
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Saqlash</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                </div>
                </form>
        
                
            </div>
            </div>
        </div>
        @endforeach
        @endforeach
{{-- @endforeach --}}
@endsection
@section('admin_script')
   <script>
   </script>
@endsection
