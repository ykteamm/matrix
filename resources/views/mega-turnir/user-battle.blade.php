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
                        <form action="{{ route('mega-turnir-user-battle-save') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="mon">Ustoz</label>
                                    <select class="form-control" name="user1id">
                                        
                                        @foreach ($users as $item)

                                            {{-- @if(!in_array($item->id,$ids)) --}}
                                                <option value="{{$item->id}}">{{$item->first_name}} {{$item->last_name}}</option>
                                            {{-- @endif --}}

                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="mon">Ustoz</label>
                                    <select class="form-control" name="user2id">
                                        @foreach ($users as $item)

                                            {{-- @if(!in_array($item->id,$ids)) --}}
                                                <option value="{{$item->id}}">{{$item->first_name}} {{$item->last_name}}</option>
                                            {{-- @endif --}}

                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="mon">Boshlanishi</label>
                                    <input type="date" name="begin">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="mon">Tugashi</label>
                                    <input type="date" name="end">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="mon">limit</label>
                                    <input type="integer" name="tour">
                                </div>

                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-primary"> Saqlash </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-sm-12">
                <table>
                    <thead>
                        <th>
                            <td>
                                Jangchi 1
                            </td>
                            <td>
                                Jangchi 1
                            </td>
                            <td>
                                Boshlanishi
                            </td>
                            <td>
                                Tugashi
                            </td>
                            <td>
                                Limit
                            </td>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($battles as $item)

                        <tr style="border: 1px solid red">
                            <td>
                                {{$item->user1->first_name}}  {{$item->user1->last_name}}
                            </td>
                            <td>
                                {{$item->user2->first_name}}  {{$item->user2->last_name}}
                            </td>
                            <td>
                                {{$item->begin}}
                            </td>
                            <td>
                                {{$item->end}}
                            </td>
                            <td>
                                {{$item->tour}}
                            </td>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
@section('admin_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css"></script>
    <script>
        $(function () {
            $("select").select2();
        });
</script>
@endsection

