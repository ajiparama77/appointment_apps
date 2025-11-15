<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark"
    data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-bs-theme="dark">

<head>
    <meta charset="utf-8" />
    <title>Appointment Apps</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="shortcut icon" href="{{ URL::asset('images/coding.png') }}">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Turf.js/6.5.0/turf.min.js"></script>
	<script src="https://unpkg.com/leaflet.maskcanvas@0.3.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @include('layouts_global.head-css')

</head>

@section('body')
    @include('layouts_global.body')
@show
<div id="layout-wrapper">
    @include('layouts_global.topbar')
    @include('layouts_global.sidebar')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
          
        </div>
        
        @include('layouts_global.footer')
    </div>
</div>


@include('layouts_global.customizer')
@include('layouts_global.vendor-scripts')

<script>
    document.addEventListener('DOMContentLoaded',function(){
        checkToken();
    })

    function checkToken(){
        let token = localStorage.getItem('token');
        
        if(!token){
            window.location.replace = '/login';
            return;
        }

        const urls = `{{ url('api/check-token') }}`;
        $.ajax({
            url : urls,
            method      : "GET",
            dataType    : "JSON",
            headers     : {
                "Authorization" : "Bearer " + token,
                "Accept": "application/json"
            },
            success :function(response){
                console.log(response)
            },
            error :function(xhr){
                if(xhr.status == 401){
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                }
            }
        })

    }

</script>

</body>

</html>
