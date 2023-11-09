
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
                    @yield('content')


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