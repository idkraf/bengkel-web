<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Cabi Admin Panel</title>
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="public/assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Icons-->
    <link href="{{ asset('public/css/free.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('public/css/flag-icon.min.css') }}" rel="stylesheet"> -->
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('css')
    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-76M97WTCEH"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      // Shared ID
      gtag('config', 'G-76M97WTCEH');
      // Bootstrap ID
      gtag('config', 'G-76M97WTCEH');
    </script>
    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">
  </head>

  <body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
      @include('dashboard.shared.nav-builder')
      @include('dashboard.shared.header')
      <div class="c-body">
        <main class="c-main">
          @yield('content') 
        </main>
        @include('dashboard.shared.footer')
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/coreui-utils.js') }}"></script>
    @yield('javascript')
  </body>
</html>
