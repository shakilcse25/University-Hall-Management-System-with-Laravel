@include('inc.header')
@include('inc.topnav')
@include('inc.sidebar')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('section')
  </div>
  <!-- /.content-wrapper -->
@include('inc.footer')
