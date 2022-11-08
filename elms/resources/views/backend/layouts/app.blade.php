<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('backend.layouts.head')

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">
    @include('backend.layouts.header')

     @if(Auth::guard('web')->check()==true)
    @include('backend.layouts.sidebar')
     @elseif(Auth::guard('orgs')->check()==true)
         @include('organization.sidebar')
     @elseif(Auth::guard('emitter')->check()==true)
         @include('emitter.sidebar')
         @endif
    @yield('content')
    @include('backend.layouts.footer')
    @yield('js')
    @stack('custom-scripts')

    <!-- Control Sidebar -->
    <!-- /.control-sidebar -->
</div>



</body>

</html>
