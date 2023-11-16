<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/assets/backend/img/favicon.png" rel="icon">
    <link href="/assets/backend/backend/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/backend/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/backend/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/backend/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/backend/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/backend/vendor/simple-datatables/style.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/backend/vendor/izitoast/css/iziToast.min.css">


    <!-- Template Main CSS File -->
    <link href="/assets/backend/css/style.css" rel="stylesheet">

    <!-- =======================================================
    * Template Name: NiceAdmin
    * Updated: Sep 18 2023 with Bootstrap v5.3.2
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="/assets/backend/img/logo.png" alt="">
            <span class="d-none d-lg-block">NiceAdmin</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="/assets/backend/img/madhowl.jpeg" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">Admin</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>Побежимов Михаил Валентинович</h6>
                        <span>Web programmer and teacher</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/admin/logout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Выйти</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
<!-- ======= Sidebar ======= -->
@include('partials.sidebar')

<!-- End Sidebar-->
<main id="main" class="main">
    @include('partials.pagetitle')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                @yield('content')
            </div>
        </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="/assets/backend/vendor/apexcharts/apexcharts.min.js"></script>
<script src="/assets/backend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/backend/vendor/chart.js/chart.umd.js"></script>
<script src="/assets/backend/vendor/echarts/echarts.min.js"></script>
<script src="/assets/backend/vendor/quill/quill.min.js"></script>
<script src="/assets/backend/vendor/simple-datatables/simple-datatables.js"></script>
<script src="/assets/backend/vendor/tinymce/tinymce.min.js"></script>
<script src="/assets/backend/vendor/php-email-form/validate.js"></script>

<script src="/assets/backend/vendor/izitoast/js/iziToast.min.js" type="text/javascript"></script>

<!-- Template Main JS File -->
<script src="/assets/backend/js/main.js"></script>
@if ($message) <> [])


<script>
    iziToast.show({
        theme: 'light',
        icon: '', //'bi bi-emoji-smile-fill',
        iconUrl:'',//'/assets/backend/img/message/sick3.gif',
        color: 'green',
        timeout: 4000,
        image: '/assets/backend/img/message/sick3.gif',
        title: 'Hey',
        message: '{{$message['message']}}',
        position: '{{$message['position']}}', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        progressBarColor: 'rgb(0, 255, 184)'
    });

</script>
@endif
@yield('script')


</body>

</html>