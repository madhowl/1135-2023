@extends('layout')
@section('title', 'Page Title')
@section('content')

              <article class="entry">
                <div class="entry-img">
                  <img src="/img/uploads/{{$article['image']}}" alt="" class="img-fluid">
                </div>

                <h2 class="entry-title">
                  <a href="/article/{{$article['id']}}">{{$article['title']}}</a>
                </h2>

                <div class="entry-meta">
                  <ul>
                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="blog-single.html">Admin</a></li>
                  </ul>
                </div>

                <div class="entry-content">
                  <p>{{$article['content']}}</p>

                </div>

              </article><!-- End blog entry -->
@endsection