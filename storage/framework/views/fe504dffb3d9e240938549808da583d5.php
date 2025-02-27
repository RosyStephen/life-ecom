<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo e(asset('assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />

    <link href="<?php echo e(asset('assets/libs/toastr/build/toastr.min.css')); ?>"  rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="<?php echo e(asset('assets/css/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />

    <link href="<?php echo e(asset('assets/css/sweetalert2.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('css/admin.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />


    <?php echo $__env->yieldPushContent('styles'); ?>


</head>
<body data-sidebar="dark" data-layout-mode="light" >

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
        <?php if(auth()->guard()->guest()): ?>
        <!-- Guest content here -->
        <?php echo $__env->yieldContent('content'); ?>
        <?php else: ?>
        <!-- Begin page -->
        <div id="layout-wrapper">


            <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- ========== Left Sidebar Start ========== -->

            <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <!-- Sidebar -->

            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">


                 <?php echo $__env->yieldContent('content'); ?>
                <!-- End Page-content -->


               <!-- container-fluid -->
            <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- end main content-->
            <?php endif; ?>
           </div>
         </div>

        <!-- END layout-wrapper -->




        <!-- JAVASCRIPT -->
        <script src="<?php echo e(asset('assets/libs/jquery/jquery.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/libs/metismenu/metisMenu.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/libs/simplebar/simplebar.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/libs/node-waves/waves.min.js')); ?>"></script>

        <!-- apexcharts -->
        <script src="<?php echo e(asset('assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/libs/toastr/build/toastr.min.js')); ?>">  </script>
        <!-- Saas dashboard init -->
        <script src="<?php echo e(asset('assets/js/pages/saas-dashboard.init.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/sweetalert.min.js')); ?>"></script>

        <script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>


		<script type="text/javascript">
            let base_url = "<?php echo e(url('/admin')); ?>";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>


        <?php echo $__env->yieldPushContent('scripts'); ?>


    </body>
</html>




<?php /**PATH D:\servcer\htdocs\linkedin\life-ecom\resources\views/layouts/app.blade.php ENDPATH**/ ?>