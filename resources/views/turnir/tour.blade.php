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
                        <form action="{{ route('turnir-tour-store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="mon">Hozirgi oy</label>
                                    <input id="mon" type="date" value="{{ date('Y-m') . '-01' }}" name="month"
                                        class="form-control form-control-sm" required />
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="mon">Turning boshlanishi</label>
                                    <input type="date" name="date_begin" class="form-control form-control-sm" required />
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="mon">Turning tugashi</label>
                                    <input type="date" name="date_end" class="form-control form-control-sm" required />
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="mon">Nechanchi tur ?</label>
                                    <input type="number" name="tour" placeholder="Tur"
                                        class="form-control form-control-sm" required />
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="mon">Title </label>
                                    <input type="number" name="title" placeholder="Title"
                                        class="form-control form-control-sm" required />
                                </div>
                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-primary"> Saqlash </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @foreach ($tours as $tour)
                    <form action="{{ route('turnir-tour-update') }}" method="POST">
                        @csrf
                        <div class="d-none">
                            <input value="{{ $tour->id }}" type="text" name="tour_id">
                        </div>
                        <div class="card border rounded">
                            <div class="card-header p-0"></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-1">
                                        {{ $tour->tour }} - tur
                                    </div>
                                    <div class="col-2">
                                        <div class="tour-prop-{{ $tour->id }}">
                                            {{ $tour->title ?? 'Tur' }}
                                        </div>
                                        <div class="tour-input-{{ $tour->id }} d-none">
                                            <input value="{{ $tour->title }}" class="form-control form-control-sm"
                                                type="text" name="title">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="tour-prop-{{ $tour->id }}">
                                            {{ $tour->date_begin }}
                                        </div>
                                        <div class="tour-input-{{ $tour->id }} d-none">
                                            <input value="{{ $tour->date_begin }}" class="form-control form-control-sm"
                                                type="date" name="begin">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="tour-prop-{{ $tour->id }}">
                                            {{ $tour->date_end }}
                                        </div>
                                        <div class="tour-input-{{ $tour->id }} d-none">
                                            <input value="{{ $tour->date_end }}" class="form-control form-control-sm"
                                                type="date" name="end">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div onclick="showEdit({{ $tour->id }})" style="border:none;outline:none">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                        </div>
                                        <script>
                                            function showEdit(id) {
                                                let props = document.querySelectorAll('.tour-prop-' + id);
                                                let inputs = document.querySelectorAll('.tour-input-' + id);
                                                if (inputs[0].classList.contains('d-none')) {
                                                    inputs.forEach(element => {
                                                        element.classList.remove('d-none')
                                                    });
                                                    props.forEach(element => {
                                                        element.classList.add('d-none')
                                                    });
                                                } else {
                                                    props.forEach(element => {
                                                        element.classList.remove('d-none')
                                                    });
                                                    inputs.forEach(element => {
                                                        element.classList.add('d-none')
                                                    });
                                                }
                                            }
                                        </script>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-sm btn-primary">
                                            Saqlash
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer p-0"></div>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('admin_script')
    <script></script>
@endsection
