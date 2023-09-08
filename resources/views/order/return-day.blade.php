@extends('admin.layouts.app')
@section('admin_content')
   <div class="mt-5">
        <div class="card-body">
         <div class="table-responsive">
             <table class="table table-striped mb-0">
                 <thead>
                 <tr class="table-secondary">
                     <th>Viloyat</th>
                     <th>Kun</th>
                     <th>Saqlash</th>
                 </tr>
                 </thead>
                 <tbody>
                     
                     @foreach ($regions as $key => $item)
                        <form action="{{route('mc-return-day-region',$item->id)}}" method="POST">
                            @csrf
                         <tr>
                             <td>{{$item->name}}</td>
                             <td>
                                <input type="number" name="day">
                             </td>
                             <td>
                                <button type="submit">save</button>
                             </td>
                         </tr>
                        </form>
                     @endforeach
                 </tbody>
             </table>
         </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                    <tr class="table-secondary">
                        <th>Apteka</th>
                        <th>Kun</th>
                        <th>Saqlash</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <form action="{{route('mc-return-day-pharmacy')}}" method="POST">
                                @csrf
                                <td>
                                    <select name="pharmacy_id" class="form-control">
                                        @foreach ($pharmacy as $key => $item)
                                            {{-- @foreach ($item->pharmacy as $k => $p) --}}
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            {{-- @endforeach --}}
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="day">
                                </td>
                                <td>
                                    <button type="submit">save</button>
                                </td>
                           </form>

                        </tr>

                        {{-- @foreach ($regions as $key => $item)
                           <form action="{{route('mc-return-day-region',$item->id)}}" method="POST">
                               @csrf
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>
                                   <input type="number" name="day">
                                </td>
                                <td>
                                   <button type="submit">save</button>
                                </td>
                            </tr>
                           </form>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
           </div>
   </div>
@endsection
