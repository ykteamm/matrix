@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
            <div class="card">
                <div class="row mb-3 mt-5">
                    <form action="{{route('crystal-save')}}" method="POSt" style="display:contents;">
                        @csrf
                        <div class="col-md-3">
                            <select name="user_id" class="form-control" required>
                                <option selected disabled>Elchi tanlang</option>
                                @foreach ($users as $item)
                                    <option value="{{$item->id}}">{{$item->last_name}} {{$item->first_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="crystal" class="form-control" placeholder="Crystal sonini kiriting" required>
                        </div>
                        <div class="col-md-5">
                            <textarea name="comment" cols="60" rows="2" required placeholder="Izoh..."></textarea>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary">Saqlash</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    
                    <livewire:crystal-user />

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