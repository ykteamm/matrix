@extends('admin.layouts.app')
@section('admin_content')
    <div class="container" style="margin-top: 50px">
        <div class="card-body">
            <div id="copyImageUrl" class="row" style="display: none">
                <div class="alert alert-success alert-xs col-12 col-md-6 offset-md-3 d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                    <span class="ml-2">
                        Image url copied to clipboard
                    </span>
                    <div>(<span id="copyImageUrlName" style="font-size:9px"></span>)</div>
                </div>
            </div>
            <div>Rasmlar yuklash</div>
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center justify-content-between mr-5">
                    <label class="btn btn-primary btn-sm m-0 p-1" for="uploadImage">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-images" viewBox="0 0 16 16">
                            <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                            <path
                                d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z" />
                        </svg>
                    </label>
                    <input name="uploadImage[]" id="uploadImage" type="file" multiple class="d-none">
                    <button onclick="newsUploadImages()" class="btn btn-sm btn-primary ml-3" type="button">Yuklash</button>
                    <button onclick="oldUploadedImages()" class="btn btn-sm btn-primary ml-3"
                        type="button">Barchasi</button>
                </div>
                <div style="overflow-x:scroll ">
                    <div id="newsUploadedImages" class="images d-flex">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('updateNews', ['id' => $nw->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="newsTitle">
                        Sarlavha
                    </label>
                    <input name="title" value="{{ $nw->title }}" class="form-control form-control-sm" type="text">
                </div>
                <div class="form-group">
                    <label for="img" class="btn btn-primary btn-sm p-1">
                        <span>Rasm</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-images" viewBox="0 0 16 16">
                            <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                            <path
                                d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z" />
                        </svg>
                    </label>
                    <input name="img" id="img" type="file" class="d-none">
                </div>
                <div class="form-group w-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <label for="newsText" class="d-flex align-items-center justify-content-center m-0">
                           <span> Matn</span>
                        </label>
                        <div class="d-flex align-items-center justify-content-center">
                            <select id="sceditortheme" class="form-control form-control-sm p-1">
                                <option value="default">Theme</option>
                                <option value="defaultdark">Default dark</option>
                                <option value="modern">Modern</option>
                                <option value="office-toolbar">Office Toolbar</option>
                                <option value="office">Office</option>
                                <option value="square">Square</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-100 w-lg-100 mt-1">
                        <textarea id="sceditor" name="desc"  style="height:300px;width:100.5%;">{{ $nw->desc }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary btn-sm" type="submit">
                        Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
<script>
    function func(elem) {
        navigator.clipboard.writeText(elem.id);
        document.getElementById("copyImageUrl").style.display='block'
        document.getElementById("copyImageUrlName").innerHTML=elem.id
    }

    function oldUploadedImages() {
        $("#newsUploadedImages").empty()
        $.ajax({
            url: '/old-news-images',
            method: 'get',
            contentType: false,
            processData: false,
            success: (response) => {
                let len = response.images.length;
                document.getElementById("newsUploadedImages").style.width = (len * 100) + "px"
                response.images.forEach(item => {
                    $("#newsUploadedImages").append(`
                    <div onclick="func(this)"
                        id="${item.imgpath}"
                        class="btn p-0 mr-4 bg-primary text-white d-flex align-items-center justify-content-between border border-2 rounded rounded-1"
                        style="height:50px;overflow:hidden">
                        <img class="mr-1" width="50px" height="50px"
                            src="${item.imgpath}"
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

    function newsUploadImages() {
        $("#newsUploadedImages").empty()
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
                let len = response.images.length;
                document.getElementById("newsUploadedImages").style.width = (len * 100) + "px"
                response.images.forEach(item => {
                    $("#newsUploadedImages").append(`
                    <div onclick="func(this)"
                        id="${item.imgpath}"
                        class="btn p-0 mr-4 bg-primary text-white d-flex align-items-center justify-content-between border border-2 rounded rounded-1"
                        style="height:50px;overflow:hidden">
                        <img class="mr-1" width="50px" height="50px"
                            src="${item.imgpath}"
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
