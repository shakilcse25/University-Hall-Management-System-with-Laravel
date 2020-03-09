<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer class="main-footer">
  <strong>Developed By Shakil Ahmed(CSE 3rd Batch)</strong>
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0.0
  </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('assets/dist/js/demo.js')}}"></script>
<script src="{{asset('assets/dist/js/jspdf.min.js')}}"></script>
<script src="{{asset('assets/dist/js/jspdf.plugin.autotable.min.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('assets/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<!-- PAGE SCRIPTS -->
{{-- <script src="{{asset('assets/dist/js/pages/dashboard2.js')}}"></script> --}}
<script src="{{asset('assets/myjs.js')}}"></script>
<script src="{{asset('assets/another.js')}}"></script>
  @include('sweetalert::alert')
</body>
</html>
