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
                        <form action="{{ route('mega-turnir-teacher-save') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="mon">Ustoz</label>
                                    <select class="form-control" name="teacher_id">
                                        @foreach ($users as $item)
                                            <option value="{{$item->id}}">{{$item->first_name}} {{$item->last_name}}</option>
                                        @endforeach
                                    </select>
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
                                FIO
                            </td>
                            
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $item)

                        <tr>
                            <td>
                                {{$item->user->first_name}}
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
