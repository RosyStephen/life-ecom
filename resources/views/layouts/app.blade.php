<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('assets/libs/toastr/build/toastr.min.css')}}"  rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{asset('assets/css/sweetalert2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/admin.css')}}" id="app-style" rel="stylesheet" type="text/css" />


    @stack('styles')


</head>
<body data-sidebar="dark" data-layout-mode="light" >

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
        @guest
        <!-- Guest content here -->
        @yield('content')
        @else
        <!-- Begin page -->
        <div id="layout-wrapper">


            @include('layouts.header')

            <!-- ========== Left Sidebar Start ========== -->

            @include('layouts.sidebar')
                    <!-- Sidebar -->

            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">


                 @yield('content')
                <!-- End Page-content -->


               <!-- container-fluid -->
            @include('layouts.footer')

            <!-- end main content-->
            @endguest
           </div>
         </div>

        <!-- END layout-wrapper -->




        <!-- JAVASCRIPT -->
        <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

        <!-- apexcharts -->
        <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
        <script src="{{asset('assets/libs/toastr/build/toastr.min.js')}}">  </script>
        <!-- Saas dashboard init -->
        <script src="{{asset('assets/js/pages/saas-dashboard.init.js')}}"></script>
        <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>

        <script src="{{asset('assets/js/app.js')}}"></script>


		<script type="text/javascript">
            let base_url = "{{ url('/admin') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>


        @stack('scripts')


    </body>
</html>




