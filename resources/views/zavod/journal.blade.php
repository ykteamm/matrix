@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

        <div class="content container-fluid headbot">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                       <div class="card-body">
                          <div class="table-responsive">
                             <table class="table mb-0" id="forware">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Mahsulot</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Miqdor</th>
                                        <th scope="col">Vaqt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($journals as $key => $item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->product->p_name}}</td>
                                            <td>{{$item->user->last_name}} {{$item->user->first_name}}</td>
                                            <td>
                                                @if($item->action == 1)
                                                    <span class="badge bg-success-light">
                                                        {{$item->old}} <i class="fas fa-plus" aria-hidden="true"></i> {{$item->new}}
                                                    </span>
                                                @endif
                                                @if($item->action == 2)
                                                    <span class="badge bg-danger-light">
                                                        {{$item->old}} <i class="fas fa-minus" aria-hidden="true"></i> {{$item->new}}
                                                    </span>
                                                @endif
                                                
                                            </td>
                                            <td>
                                                {{date('d.m.Y H:i', strtotime($item->created_at))}}
                                            </td>

                                    
                                        </tr>
                                    @endforeach
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
