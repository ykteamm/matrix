@extends('admin.layouts.app')
@section('admin_content')
    <div class="container" style="margin-top: 90px">
        <div class="card border border-1 rounded rounded-1 hover shadow">
            <div class="card-header" style="text-align:center">
                <h3 style="overflow: hidden">{{ $nw->title }}</h3>
                {{-- <img src="{{$nw->img}}" width="50" alt=""> --}}
            </div>
            <div class="card-body" id="newsBody">
                <?php echo htmlspecialchars_decode(htmlentities($nw->desc)); ?>
            </div>
            <div class="card-footer">
                <div class="modal fade" id="deleteNews" tabindex="-1" role="dialog" aria-labelledby="deleteNewsTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center justify-content-center">
                                <h4>O'chirishni hohlaysizmi ?</h4>
                            </div>
                            <div class="modal-footer d-block">
                                <form class="d-flex align-items-center justify-content-around"
                                    action="{{ route('deleteNews', ['id' => $nw->id]) }}" method="POST">
                                    @csrf
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Yo'q</button>
                                    <button type="submit" class="btn btn-danger">Ha</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end" style="text-align: end">
                    <a href="{{ route('editNews', ['id' => $nw->id]) }}" class="btn btn-sm btn-warning text-black mr-2">
                        <span class="mr-2">Tahrirlash </span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                        </svg>
                    </a>
                    <button class="btn btn-sm btn-danger mr-1" data-toggle="modal" data-target="#deleteNews">
                        <span class="mr-2">O'chirish </span>
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
    </div>
@endsection
<style>
    @media only screen and (max-width:500px) {
        #newsBody img {
            width: 100%;
        }
    }

    [data-sceditor-emoticon] {
        width: 20px !important;
    }

    #newsBody iframe {
        width: 100% !important;
    }
</style>
