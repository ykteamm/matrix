@extends('admin.layouts.app')
@section('admin_content')
    <div class="pointer" style="margin-top:110px;">
        <div class="container mt-5">
            @if (Session::get('newsError'))
                <div class="alert alert-danger">
                    {{ Session::get('newsError') }}
                </div>
            @endif
            <div class="my-3 text-end" style="text-align: end">
                <a class="btn btn-primary" href="{{ route('createNews') }}">
                    Yangilik qo'shish
                </a>
            </div>
            {{--  --}}
            @include('news.showNw')
            {{--  --}}
            @foreach ($news as $nw)
                <div class="card border border-left-primary">
                    <div class="p-4 d-flex align-items-center justify-content-between"
                        style="border-left:5px solid red;border-top-left-radius: 10px;border-bottom-left-radius: 10px">
                        <div>
                            <img src="{{ $nw->img }}" width="50" alt="">
                        </div>
                        <a href="{{ route('showNews', ['id' => $nw->id]) }}">
                            <div style="font-size:18px;font-weight:600;overflow:hidden" class="pr-3">
                                {{ $nw->title }}
                            </div>
                        </a>
                        <div class="modal fade" id="deleteNews" tabindex="-1" role="dialog"
                            aria-labelledby="deleteNewsTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center justify-content-center">
                                        <h4>O'chirishni hohlaysizmi ?</h4>
                                    </div>
                                    <div class="modal-footer d-block">
                                        <form class="d-flex align-items-center justify-content-around"
                                            action="{{ route('deleteNews', ['id' => $nw->id]) }}" method="POST">
                                            @csrf
                                            <button type="button" class="btn btn-primary"
                                                data-dismiss="modal">Yo'q</button>
                                            <button type="submit" class="btn btn-danger">Ha</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <a onclick="showNw({{ $nw->id }})" data-toggle="modal" data-target="#showNws" class="btn btn-sm btn-success mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-eye" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                    <path
                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                </svg>
                            </a>
                            <a href="{{ route('editNews', ['id' => $nw->id]) }}"
                                class="btn btn-sm btn-warning text-black mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path
                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd"
                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                </svg>
                            </a>
                            <button class="btn btn-sm btn-danger mr-1" data-toggle="modal" data-target="#deleteNews">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                    <path
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
