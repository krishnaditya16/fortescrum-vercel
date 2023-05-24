<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title')</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('stisla/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('stisla/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/css/components.css') }}">
  <link rel="icon" href="{{ asset('landing/img/favicon.png') }}">

  <!-- PWA  -->
  <meta name="theme-color" content="#6777ef"/>
  <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
  <link rel="manifest" href="{{ asset('/manifest.json') }}">
</head>

<body>

  @yield('content')

  <!-- General JS Scripts -->
  <script src="{{ asset('stisla/js/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('stisla/js/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script defer src="{{ asset('stisla/js/modules/popper.js') }}"></script>
  <script defer src="{{ asset('stisla/js/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script defer src="{{ asset('stisla/js/modules/moment.min.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('stisla/js/stisla.js') }}"></script>
  <script src="{{ asset('stisla/js/custom.js') }}"></script>
  <script src="{{ asset('stisla/js/scripts.js') }}"></script>

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