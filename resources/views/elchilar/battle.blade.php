@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="">
            @include('admin.components.logo')
            <div class="card flex-fill headbot">
       
               <div class="btn-group mr-5 ml-auto">
                  <div class="row">
                        <div class="col-md-12" align="center">
                                 Sana
                        </div>
                        <div class="col-md-12">
                           <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Bugun </button>
                           <div class="dropdown-menu timeclass">
                              @foreach ($get_battles as $item)
                                 <a href="{{route('get-battle',['start' => date('d.m.Y',strtotime($item->start_day)),'end' => date('d.m.Y',strtotime($item->end_day))])}}" class="dropdown-item">
                                    {{date('d.m.Y',strtotime($item->start_day))}} -
                                    {{date('d.m.Y',strtotime($item->end_day))}}
                                 </a>
                              @endforeach
       
                           </div>
                        </div>
                  </div>
       
               </div>
               
                  
               
            </div>

            <div class="row ">
               @isset($battleArray)
               @foreach ($battleArray as $user)
                <div class="col-sm-12">
                   <div class="card">
                      <div class="card-body">
                         <div class="table-responsive">
                            <table class="table mb-0">
                               <thead>
                                  <tr>
                                     <th>Elchi</th>
                                     @foreach ($arrayDate as $item)
                                     <th>{{date('d.m.Y',strtotime($item))}} </th>
                                     @endforeach
                                     <th>Summa</th>
                                     <th>Ball</th>
                                     <th>Umumiy</th>
                                  </tr>
                               </thead>
                               <tbody>
                                 <tr>
                                    <td>{{$user['user1']}}</td>
                                    @foreach ($user_array1[$user['id1']] as $item)
                                     <td>{{$item}} </td>
                                    @endforeach
                                    <td>{{$user['sum1']}}</td>
                                    <td>{{$history_array1[$user['id1']]['ball']}}</td>
                                    <td>{{$user['ball1']}}</td>
                                 </tr>
                                 <tr>
                                    <td>{{$user['user2']}}</td>
                                    @foreach ($user_array2[$user['id2']] as $item)
                                     <td>{{$item}} </td>
                                    @endforeach
                                    <td>{{$user['sum2']}}</td>
                                    <td>-{{$history_array1[$user['id2']]['ball']}}</td>
                                    <td>{{$user['ball2']}}</td>
                                 </tr>
                                {{-- @foreach ($battleArray as $item)
                                <tr>
                                    <th>{{$item['user1']}} ({{$item['ball1']}}) ({{$item['win']}})
                                        ({{$item['sum1']}})
                                    </th>
                                    <th>{{$item['user2']}} ({{$item['ball1']}}) ({{$item['lose']}})
                                        ({{$item['sum2']}})
                                    </th>
                                 </tr>
                                @endforeach --}}
                                
                               </tbody>
                            </table>
                         </div>
                      </div>
                   </div>
                </div>
               @endforeach
               @endisset
            </div>
        </div>
    </div>
    </div>
@endsection
@section('admin_script')
    <script>
    </script>
@endsection
