<div class="vertical-menu">

    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard')): ?>
                <li>
                    <a href="<?php echo e(route('dashboard')); ?>" class=" waves-effect">
                        <i class="bx bx-home-circle"></i>

                        <span key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users')): ?>
                <li>

                    <a href="<?php echo e(route('users.index')); ?>" class=" waves-effect">
                        <i class="bx bx-user"></i>
                        <span key="t-users">Users</span>
                    </a>

                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permissions')): ?>
                 <li>
                    <a href="<?php echo e(route('user-permissions.index')); ?>" class=" waves-effect">
                        <i class="bx bx-lock"></i>
                        <span key="permissions">Permissions</span>
                    </a>


                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles')): ?>

                <li>
                    <a href="<?php echo e(route('user-roles.index')); ?>" class=" waves-effect">
                        <i class="bx bx-shield"></i>
                        <span key="role">Role</span>
                    </a>

                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('categories')): ?>

                <li>
                    <a href="<?php echo e(route('category.index')); ?>" class=" waves-effect">
                        <i class="bx bx-list-ol" ></i>
                        <span key="category">Category</span>
                    </a>


                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products')): ?>
                <li>

                            <a href="<?php echo e(route('product.index')); ?>" class=" waves-effect">
                                <i class="bx bx-box"></i>
                                <span key="product">Product</span>
                            </a>

                </li>
                <?php endif; ?>

                <li>

                    <a href="<?php echo e(route('order.index')); ?>" class=" waves-effect">
                        <i class="bx bx-cart"></i>
                        <span key="order">order</span>
                    </a>

                </li>





            </ul>
        </div>
    </div>
</div>
<?php /**PATH D:\servcer\htdocs\linkedin\life-ecom\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>