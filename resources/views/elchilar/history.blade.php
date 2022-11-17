@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="">
            @include('admin.components.logo')
            <div class="row headbot">
                <div class="col-sm-12">
                   <div class="card">
                      <div class="card-body">
                         <div class="table-responsive">
                            <table class="table mb-0">
                               <thead>
                                  <tr>
                                     <th>Eski ball</th>
                                     <th>Ball</th>
                                     <th>Yangi ball</th>
                                     <th>Jang sanasi</th>
                                  </tr>
                               </thead>
                               <tbody>
                                @foreach ($getter as $item)
                                    @if ($item->lose_user_id == $id)
                                        <tr>
                                            <td>{{$item->uball1-$item->ball1}}  </td>
                                            <td>{{$item->ball1}}</td>
                                            <td>{{$item->uball1}}</td>
                                            <td>{{date('d.m.Y',strtotime($item->start_day))}}-{{date('d.m.Y',strtotime($item->end_day))}}</td>
                                        </tr>
                                    @else
                                    <tr>
                                        <td>{{$item->uball2+$item->ball2}}  </td>
                                        <td>-{{$item->ball2}}</td>
                                        <td>{{$item->uball2}}</td>
                                        <td>{{date('d.m.Y',strtotime($item->start_day))}}-{{date('d.m.Y',strtotime($item->end_day))}}</td>
                                    </tr>
                                    @endif
                                    
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
