@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="row gold-box">
            @include('admin.components.logo')

            <div class="content container-fluid headbot">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('elchi-battle-select.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="">Birinchi jangchi</label>
                                            {{-- <input type="date" class="form-control form-control-sm" name="end_day" required> --}}
                                            <select class="form-control form-control-sm" name='user1'>
                                                <option value="" disabled selected hidden></option>
                                                @foreach ($userid as $item)
                                                    <option value="{{$item->id}}">{{$item->last_name}} {{$item->first_name}}</option>
                                                @endforeach
                                            </select>
                                        </div> 
                                        <div class="form-group col-md-3">
                                            <label for="">Ikkinchi jangchi</label>
                                            {{-- <input type="date" class="form-control form-control-sm" name="end_day" required> --}}
                                            <select class="form-control form-control-sm" name='user2'>
                                                <option value="" disabled selected hidden></option>
                                                @foreach ($userid as $item)
                                                    <option value="{{$item->id}}">{{$item->last_name}} {{$item->first_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="">Jang qilish vaqti</label>
                                            <input type="number" class="form-control form-control-sm" name="day" required>
                                        </div>
                                        <div class="form-group col-md-2 mt-4">
                                                <button type="submit" class="btn btn-primary"> Saqlash </button>
                                        </div>
                                        
                                    </div>
                                </form>
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
