
@include('partials.head')

<!-- ======= Header ======= -->
@include('partials.header')
<!-- End Header -->

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
@include('partials.breadcrumbs')
    <!-- End Breadcrumbs -->

    <!-- ======= Blog Single Section ======= -->
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">

            <div class="row">

                <div class="col-lg-8 entries">
                    @foreach ($articles as $article)
                        <article class="entry">
                            <div class="entry-img">
                                <img src="/img/uploads/{{$article['image']}}" alt="" class="img-fluid">
                            </div>

                            <h2 class="entry-title">
                                <a href="/article/{{$article['id']}}">{{$article['id']}}#{{$article['title']}}</a>
                            </h2>

                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="blog-single.html">Admin</a></li>
                                </ul>
                            </div>

                            <div class="entry-content">
                                <div class="read-more">
                                    <a href="/article/{{$article['id']}}">Read More</a>
                                </div>
                            </div>

                        </article><!-- End blog entry -->
                    @endforeach

                    <div class="blog-pagination">
                        <ul class="justify-content-center">
                            {!! $pagination !!}
                        </ul>

                    </div>

                </div><!-- End blog entries list -->

                <div class="col-lg-4">

                    @include('partials.sidebar')<!-- End sidebar -->

                </div><!-- End blog sidebar -->

            </div>

        </div>
    </section><!-- End Blog Single Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
@include('partials.footer')