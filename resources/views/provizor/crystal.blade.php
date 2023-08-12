@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box">
            @include('admin.components.logo')

            <div class="content container-fluid headbot">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Sotuvchi</th>
                                            <th>Crystal</th>
                                            <th>Izoh</th>
                                        </th>
                                    </thead>
                                   <tbody>
                                        <form action="{{ route('pro-crystal-history-save') }}" method="POST">
                                        @csrf
                                         <tr>
                                            <td>
                                                <select class="form-control form-control-sm" name='provizor_id' required>
                                                    <option value="" disabled selected hidden></option>
                                                        @foreach ($provizors as $provizor)
                                                            <option value='{{$provizor['id']}}'>{{$provizor['last_name']}} {{$provizor['first_name']}}</option>
                                                        @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-md" name="crystal" required placeholder="Pul miqdori">
                                            </td>
                                            <td>
                                                <textarea  name="comment" id="" cols="100" rows="2" required></textarea>
                                                {{-- <input type="number" class="form-control form-control-md" name="money" required placeholder="Pul miqdori"> --}}
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-primary"> Saqlash </button>
                                            </td>
                                         </tr>
                                        </form>
                                   </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="table-responsive">
                                <table class="table mb-0" id="example1">
                                    <thead>
                                        <tr>
                                            <th>Sotuvchi</th>
                                            <th>Crystal</th>
                                            <th>Izoh</th>
                                            <th>Tarix</th>
                                        </th>
                                    </thead>
                                   <tbody>
                                        @foreach ($crystal as $key => $item)
                                            @php
                                                
                                            @endphp
                                            <tr>
                                                <td>
                                                    {{$item['user']['last_name']}} {{$item['user']['first_name']}}
                                                </td>
                                                <td>
                                                    {{$item['promo']}}
                                                </td>
                                                <td>
                                                    {{$item['history']}}
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary" onclick="$(`.crystalhis{{$key}}`).toggle()">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            @foreach ($histories as $his)
                                                @if ($key == $his['user_id'])
                                                    
                                                    <tr style="display: none;" class="table-info crystalhis{{$key}}">
                                                        <td>
                                                        </td>
                                                        <td>

                                                        </td>
                                                        <td>
                                                            {{$his['crystal']}}
                                                        </td>
                                                        <td>
                                                            {{$his['comment']}}
                                                        </td>
                                                    </tr>

                                                @endif

                                            @endforeach

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
@endsection
@section('admin_script')
    <script>
        $(function () {
            $("select").select2();
        });
    </script>
@endsection
