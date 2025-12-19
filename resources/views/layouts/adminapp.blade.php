<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Library | Admin Page</title>

  <!-- Google Font: Source Sans Pro -->
 
  <!-- Font Awesome Icons -->
  
  <!-- Theme style -->
    @include('layouts.partials.style')
</head>

<body class="hold-transition sidebar-mini">
  @include('sweetalert2::index')
    {{-- @include('layouts.adminpartials.preloader') --}}
<div class="wrapper">

  <!-- Navbar -->
  @include('layouts.adminpartials.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.adminpartials.sidebar')
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg-secondary">

   @yield ('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('layouts.adminpartials.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

<!-- Bootstrap 4 -->

<!-- AdminLTE App -->
@include('layouts.partials.script')
</body>
</html>
