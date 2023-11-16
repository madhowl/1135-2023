@extends('layout')
@section('title')

    <li class="breadcrumb-item active">{{ $title }}</li>
@endsection

@section('content')
<div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Статья</h5>
                        <form action="{{ $action }}" method="post">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="inputText" class="col-sm-2 col-form-label"> Заголовок </label>
                                    <input class="form-control" type="text" name="title" value="{{ $article['title'] }}">
                                </div>
                                <div class="col-12">
                                    <label for="inputText" class="col-sm-2 col-form-label">Изоброжение</label>
                                    <input class="form-control" type="hidden" id="image" name="image" value="{{ $article['image'] }}" >
                                    <div id="loading" style="font-size:12px">Loading file manager...</div>
                                    <div id="images">
                                        @if ($article['image'] === '')
                                            <img src="/img/nophoto.jpg" alt="" style="max-width: 300px;">
                                            <p>Изоброжение не выбрано</p>
                                        @else
                                            <img src="{{ $article['image'] }}" alt="" style="max-width: 300px;">
                                                <p>{{ $article['image'] }}</p>
                                        @endif
                                    </div>
                                    <div id="btnSelectImage" class="btn btn-success">Выбрать изображение</div>
                                </div>
                                <div class="col-12">
                                    <input type="hidden" name="id" value="{{ $article['id'] }}">
                                    <!-- TinyMCE Editor -->
                                    <textarea id="editor"  name="content">
                            {{ $article['content'] }}
                        </textarea><!-- End TinyMCE Editor -->
                                </div>
                            </div>
                            <div class="text-center p-3">
                                <input type="submit" class="btn btn-primary" value="Сохранить">
                                <a href="/admin/articles"  class="btn btn-secondary">Закрыть</a>
                            </div>
                        </form>
                    </div>
                </div>
@endsection

@section('script')
    <script src="https://cloud.flmngr.com/cdn/{{ $apiKey }}/flmngr.js"></script>
    <script src="https://cloud.flmngr.com/cdn/{{ $apiKey }}/imgpen.js"></script>
    <script>
        window.onFlmngrAndImgPenLoaded = function() {
            var elBtn = document.getElementById("btnSelectImage");
            // Style button as ready to be pressed
            elBtn.style.opacity = 1;
            elBtn.style.cursor = "pointer";
            var elLoading = document.getElementById("loading");
            elLoading.parentElement.removeChild(elLoading);
            // Add a listener for selecting files
            elBtn.addEventListener("click", function() {
                selectFiles();
            });
        }

        function selectFiles() {
            let flmngr = window.flmngr.create({
                urlFileManager: '/admin/filemanager',
                urlFiles: '/img'
            });
            flmngr.pickFiles({
                isMultiple: false,
                acceptExtensions: ["png", "jpeg", "jpg", "webp", "gif"],
                onFinish: function(files) {
                    showSelectedImage(files);
                }
            });
        }

        function showSelectedImage(files) {
            let elImages = document.getElementById("images");
            elImages.innerHTML = "";
            var file = files[0];
            let el = document.createElement("div");
            el.className = "image";
            elImages.appendChild(el);
            let elImg = document.createElement("img");
            elImg.src = file.url;
            elImg.alt = "";
            elImg.style = "max-width:300px";
            el.appendChild(elImg);
            let elP = document.createElement("p");
            elP.textContent = file.url;
            el.appendChild(elP);
            let elInput = document.getElementById("image");
            elInput.value=file.url;
        }



        // ----- Tinymce init -----
        tinymce.init({
            selector: "#editor",
            plugins: "file-manager table link lists code fullscreen",
            relative_urls: true,
            extended_valid_elements: "*[*]",
            height: "600px",
            Flmngr: {
                apiKey: "{{ $apiKey }}", // See in Dashboard:  https://flmngr.com/dashboard
            },
            toolbar: [
                "cut copy | undo redo | searchreplace | bold italic strikethrough | forecolor backcolor | blockquote | removeformat | code",
                "formatselect | link | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent"
            ],
            promotion: false
        });
    </script>
@endsection
