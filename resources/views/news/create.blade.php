@extends('admin.layouts.app')
@section('admin_content')
    <div class="container" style="margin-top: 50px">
        <div class="card-body">
            <div>Rasmlar yuklash</div>
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center justify-content-between">
                    <label class="btn btn-primary btn-sm m-0" for="uploadImage">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-images" viewBox="0 0 16 16">
                            <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                            <path
                                d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z" />
                        </svg>
                    </label>
                    <input name="uploadImage[]" id="uploadImage" type="file" multiple class="d-none">
                    <button onclick="newsUploadImages()" class="btn btn-sm btn-primary ml-3" type="button">Yuklash</button>
                </div>
                <div id="newsUploadedImages" class="images d-flex align-items-center justify-content-between">
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('storeNews') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="newsTitle">
                        Sarlavha
                    </label>
                    <input name="title" class="form-control form-control-sm" type="text">
                </div>
                <div class="form-group">
                    <label for="newsText">
                        Matn
                    </label>
                    <textarea name="body" id="newsText" class="ckeditor form-control"></textarea>
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary btn-sm" type="submit">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
<script>
    function func(elem) {
        navigator.clipboard.writeText(elem.id);
    }

    function newsUploadImages() {
        let imgs = document.getElementById("uploadImage").files;
        let images = new FormData();
        let i = 0;
        for (let img of imgs) {
            images.append("image" + i, img)
            i++;
        }
                
        $.ajax({
            url: '/store-news-images',
            method: 'post',
            data: images,
            contentType: false,
            processData: false,
            success: (response) => {
                response.images.forEach(item => {
                    item = String(item)
                    $("#newsUploadedImages").append(`
                    <div onclick="func(this)"
                        id="${item}"
                        class="btn p-0 mr-1 bg-primary text-white d-flex align-items-center justify-content-between border rounded rounded-1"
                        style="height:50px;overflow:hidden">
                        <img class="mr-1" width="50px" height="50px"
                            src="${item}"
                            alt="">
                        <svg class="pr-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-clipboard-check" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                            <path
                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                            <path
                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                        </svg>
                    </div>
                    `)
                })
            }
        })
    }
</script>
