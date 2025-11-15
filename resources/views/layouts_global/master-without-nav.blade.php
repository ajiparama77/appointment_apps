<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-topbar="light" data-sidebar-image="none">

    <head>
    <meta charset="utf-8" />
    <title>Appointment Apps</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <!-- App favicon -->
  
        @include('layouts_global.head-css')
  </head>

    @yield('body')

    @yield('content')

    @include('layouts_global.vendor-scripts')
    </body>
</html>
