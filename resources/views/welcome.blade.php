<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>HYDRAUCRUZ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/inicio/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/inicio/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="assets/inicio/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/inicio/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/inicio/vendor/venobox/venobox.css" rel="stylesheet">
    <link href="assets/inicio/vendor/aos/aos.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/inicio/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Techie - v2.2.1
  * Template URL: https://bootstrapmade.com/techie-free-skin-bootstrap-3/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-xl-9 d-flex align-items-center">
                    <h1 class="logo mr-auto"><a href="{{ route('login') }}">HYDRAUCRUZ<a href="{{ route('login') }}" class="logo mr-auto"><img src="{{asset('assets/dashboard/images/HC2.png')}}" alt="" class="img-fluid"></a></a></h1>
                    <!-- Uncomment below if you prefer to use an image logo -->
                     

                   
                    @auth
                    <a href="{{ url('/home') }}" class="get-started-btn scrollto">{{auth()->user()->name}}</a>
                    @endauth
                </div>
            </div>

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="container-fluid" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 pt-3 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <h1>SISTEMA DE GESTION y CONTROL DE INVENTARIOS</h1>
                    <h2>Registro de productos y articulos, asignación de roles y control general.</h2>
                    @if (Route::has('login'))
                    @auth
                        <div><a href="{{ url('/home') }}" class="btn-get-started scrollto">Volver al Sistema</a></div>
                    @else
                        <div><a href="{{ route('login') }}" class="btn-get-started scrollto">Iniciar Sesión</a></div>
                    @endauth
                    @endif
                </div>
                <div class="col-xl-4 col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="150">
                    <img src="assets/inicio/img/hero-img.png" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section><!-- End Hero -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="container">

            <div class="copyright-wrap d-md-flex py-4">
                <div class="mr-md-auto text-center text-md-left">
                    <div class="copyright">
                        &copy; Copyright <strong><span>ALVARO</span></strong>. All Rights Reserved
                    </div>
                    <div class="credits">
                        <!-- All the links in the footer should remain intact. -->
                        <!-- You can delete the links only if you purchased the pro version. -->
                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/techie-free-skin-bootstrap-3/ -->
                        Designed by <a href="https://www.facebook.com/alvaro.ortega.7773/">Alvaro Ortega D.</a>
                    </div>
                </div>
                <div class="social-links text-center text-md-right pt-3 pt-md-0">
                    <a href="https://www.instagram.com/alvaro.ortega.12313/" class="twitter"><i class="bx bxl-twitter"></i></a>
                    <a href="https://www.facebook.com/alvaro.ortega.7773/" class="facebook"><i class="bx bxl-facebook"></i></a>
                    <a href="https://www.instagram.com/alvaro.ortega.12313/" class="instagram"><i class="bx bxl-instagram"></i></a>
                </div>
            </div>

        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/inicio/vendor/jquery/jquery.min.js"></script>
    <script src="assets/inicio/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/inicio/vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="assets/inicio/vendor/php-email-form/validate.js"></script>
    <script src="assets/inicio/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="assets/inicio/vendor/counterup/counterup.min.js"></script>
    <script src="assets/inicio/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="assets/inicio/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/inicio/vendor/venobox/venobox.min.js"></script>
    <script src="assets/inicio/vendor/aos/aos.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/inicio/js/main.js"></script>

</body>

</html>