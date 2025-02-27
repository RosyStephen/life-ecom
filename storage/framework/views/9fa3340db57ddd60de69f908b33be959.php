<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">

            <a href="<?php echo e(route('dashboard')); ?>" class="logo logo-light">
                <span class="logo-lg">
                    <p style="font-size: 24px; font-weight: bold; color: #4CAF50;">Life Ecom</p>
                </span>
            </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>




        </div>

        <div class="d-flex">

      <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="<?php echo e(asset('assets/images/users/user-default-image.jpg')); ?>"
                        alt="Header Avatar">
                        <?php if(auth()->check() && auth()->user()->roles->first()): ?>
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?php echo e(Auth::user()->name); ?> (<?php echo e(Auth::user()->roles->first()->name); ?>)</span>
                    <?php else: ?>
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?php echo e(Auth::user()->name); ?></span>
                     <?php endif; ?>

                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>

                    

                    <div class="dropdown-divider"></div>

                <a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>"  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">

                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                    <?php echo csrf_field(); ?>
                </form>
                <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                </div>
            </div>



        </div>
    </div>
</header>

<?php /**PATH D:\servcer\htdocs\linkedin\life-ecom\resources\views/layouts/header.blade.php ENDPATH**/ ?>