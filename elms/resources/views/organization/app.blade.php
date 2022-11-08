<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('backend.layouts.head')

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">
@include('backend.layouts.header')
@include('backend.layouts.sidebar')
@yield('content')
@include('backend.layouts.footer')
@yield('js')

<!-- Control Sidebar -->
    <!-- /.control-sidebar -->
</div>



</body>

</html>
