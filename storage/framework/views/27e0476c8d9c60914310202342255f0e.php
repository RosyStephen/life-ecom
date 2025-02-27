<?php $__env->startPush('styles'); ?>
    <!-- DataTables -->
    <link href="<?php echo e(asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        .permissions-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px; /* Adds space between checkboxes */
        }

            /* Make table container scrollable */
        .table-responsive {
            overflow-x: auto; /* Enables horizontal scrolling */
            max-height: 500px; /* Optional: Limit max height */
        }

        /* Ensure long text wraps properly */
        #role-table td {
            white-space: normal !important;
            word-wrap: break-word;
        }

        /* Reduce column width for better fit */
        #role-table th, #role-table td {
            min-width: 120px;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<div class="page-content">
    <div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Role</h4>

                <div class="page-title-right">
                    <button type="button" class="btn btn-primary waves-effect waves-light roleModal">
                        <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add Role
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="card-title-desc">User Role</p>

                    <?php echo $__env->make('users.roles.list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>
</div>
<?php echo $__env->make('users.roles.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
 <!-- Required datatable js -->
 <script src="<?php echo e(asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
 <script src="<?php echo e(asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
 <script src="<?php echo e(asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
 <!-- Buttons examples -->
 <script src="<?php echo e(asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')); ?>"></script>
 <script src="<?php echo e(asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')); ?>"></script>
 <script src="<?php echo e(asset('assets/libs/jszip/jszip.min.js')); ?>"></script>
 <script src="<?php echo e(asset('assets/libs/pdfmake/build/pdfmake.min.js')); ?>"></script>
 <script src="<?php echo e(asset('assets/libs/pdfmake/build/vfs_fonts.js')); ?>"></script>
 <script src="<?php echo e(asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')); ?>"></script>
 <script src="<?php echo e(asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')); ?>"></script>
 <script src="<?php echo e(asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')); ?>"></script>


 <!-- Datatable init js -->
 <script src="<?php echo e(asset('assets/js/pages/datatables.init.js')); ?>"></script>

  <script src="<?php echo e(asset('/js/role/role.js')); ?>"></script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\servcer\htdocs\linkedin\life-ecom\resources\views/users/roles/index.blade.php ENDPATH**/ ?>