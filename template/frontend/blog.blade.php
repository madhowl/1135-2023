@extends('layout')
@section('title', 'Page Title')
@section('content')
            @foreach ($articles as $article)
              <article class="entry">
                <div class="entry-img">
                  <img src="/img/uploads/{{$article['image']}}" alt="" class="img-fluid">
                </div>

                <h2 class="entry-title">
                  <a href="/article/{{$article['id']}}">{{$article['title']}}</a>
                </h2>

                <div class="entry-meta">
                  <ul>
                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="#">Admin</a></li>
                  </ul>
                </div>

                <div class="entry-content">
                  <div class="read-more">
                    <a href="/article/{{$article['id']}}">Читать <i class="bi bi-arrow-right"></i></a>
                  </div>
                </div>

              </article><!-- End blog entry -->
            @endforeach

            <div class="blog-pagination">
              <ul class="justify-content-center">
                {!! $pagination !!}
              </ul>
            </div>
@endsection