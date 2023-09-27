@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card mt-5">
            <div class="card-body">
                <div class="col-md-4">
                    <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                        <li class="nav-item"><a class="nav-link active" href="#solid-tab1" data-toggle="tab">5 ballik</a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-tab2" data-toggle="tab">Savol </a></li>
                    </ul>
                </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="solid-tab1">
                            <div class="card-body">
                                <div class="table-responsive">
                                   <table class="table mb-0 example1">
                                      <thead>
                                         <tr>
                                            <th>FIO </th>
                                            <th>Holati</th>
                                            <th>Holati</th>
                                            <th>Holati</th>
                                         </tr>
                                      </thead>
                                      <tbody>
                                         @foreach ($grades as $elchi)
                                         <tr>
                                            <td>{{$elchi->tester->last_name}} {{$elchi->tester->first_name}}</td>
                                            <td>{{$elchi->user->last_name}} {{$elchi->user->first_name}}</td>
                                            <td>
                                                @if ($elchi->star == 1)
                                                    <span class="badge badge-danger">{{$elchi->star}}</span>
                                                @elseif($elchi->star == 2)
                                                    <span class="badge badge-danger">{{$elchi->star}}</span>
                                                @elseif($elchi->star == 3)
                                                    <span class="badge badge-warning">{{$elchi->star}}</span>
                                                @elseif($elchi->star == 4)
                                                    <span class="badge badge-primary">{{$elchi->star}}</span>
                                                @else
                                                    <span class="badge badge-success">{{$elchi->star}}</span>
                                                @endif
                                            </td>
                                            <td>{{date('d.m.Y H:i:s',strtotime($elchi->created_at))}}</td>
                                         </tr>

                                         @endforeach
                                      </tbody>
                                   </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane show" id="solid-tab2">
                            <div class="card-body">
                                <div class="table-responsive">
                                   <table class="table mb-0 example1">
                                      <thead>
                                         <tr>
                                            <th>FIO </th>
                                            <th>Holati</th>
                                            <th>Holati</th>
                                            <th>Holati</th>
                                         </tr>
                                      </thead>
                                      <tbody>
                                         @foreach ($questions as $elchi)
                                         <tr>
                                            <td>{{$elchi->tester->last_name}} {{$elchi->tester->first_name}}</td>
                                            <td>{{$elchi->user->last_name}} {{$elchi->user->first_name}}</td>
                                            <td>
                                                {{$elchi->test->name}}
                                            </td>
                                            <td>{{date('d.m.Y H:i:s',strtotime($elchi->created_at))}}</td>
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
</div>
@endsection
@section('admin_script')
   <script>
   </script>
@endsection
