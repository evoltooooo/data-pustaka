<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Starter</title>

  <!-- Google Font: Source Sans Pro -->
 
  <!-- Font Awesome Icons -->
  
  <!-- Theme style -->
    @include('layouts.partials.style')
    

 <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
  <link rel="stylesheet" href="{{ asset('css/searchbar.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

   @stack('styles')
</head>

<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  @include('layouts.partials.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

   @yield ('content')
    <!-- /.content -->
  </div>
</div>  
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('layouts.partials.footer')


  @stack('scripts')

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

<!-- Bootstrap 4 -->

<!-- AdminLTE App -->
@include('layouts.partials.script')
</body>
</html>
