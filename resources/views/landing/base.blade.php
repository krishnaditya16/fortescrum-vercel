<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title')</title>

    <link rel="icon" href="{{ asset('landing/img/favicon.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('landing/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
  
    <!-- Template Main CSS File -->
    <link href="{{ asset('landing/css/style.css') }}" rel="stylesheet">
</head>

<body>

  @yield('content')

  <!-- Vendor JS Files -->
  <script src="{{ asset('landing/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('landing/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('landing/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('landing/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('landing/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('landing/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('landing/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('landing/js/main.js') }}"></script>

  <!-- PWA  -->
  <script src="{{ asset('/sw.js') }}"></script>
  <script>
      if (!navigator.serviceWorker.controller) {
          navigator.serviceWorker.register("/sw.js").then(function (reg) {
              console.log("Service worker has been registered for scope: " + reg.scope);
          });
      }
  </script>

</body>

</html>