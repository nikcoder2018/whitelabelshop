<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="img/favicon.png">

    <title>CapCap.rs | Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-reset.css')}}" rel="stylesheet">
    <link href="{{asset('assets/font-awesome/css/font-awesome.cs')}}s" rel="stylesheet" />

    @yield('external_css')

    <!--right slidebar-->
    <link href="{{asset('css/slidebars.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet" />

    @yield('stylesheets')
  </head>

  <body class="light-sidebar-nav">

  <section id="container">
      @include('admin.includes.header')
      @include('admin.includes.left-sidebar')
      
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              
                @yield('content')

          </section>
      </section>
      <!--main content end-->

      @include('admin.includes.footer')

      @yield('modals')
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script class="include" type="text/javascript" src="{{asset('js/jquery.dcjqaccordion.2.7.js')}}"></script>
    <script src="{{asset('js/jquery.scrollTo.min.js')}}"></script>
    <script src="{{asset('js/jquery.nicescroll.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/owl.carousel.js')}}" ></script>
    <script src="{{asset('js/respond.min.js')}}" ></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    @yield('external_js')
    <!--right slidebar-->
    <script src="{{asset('js/slidebars.min.js')}}"></script>

    <!--common script for all pages-->
    <script src="{{asset('js/common-scripts.js')}}"></script>

    @yield('scripts')

  </body>
</html>
