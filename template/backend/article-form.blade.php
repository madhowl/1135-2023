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
                                    <input class="form-control" type="text" name="image" value="{{ $article['image'] }}">
                                </div>
                                <div class="col-12">
                                    <input type="hidden" name="id" value="{{ $article['id'] }}">
                                    <label for="inputText" class="col-sm-2 col-form-label">Изоброжение</label>
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
    <script>
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
