<div class="vertical-menu">

    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                @can('dashboard')
                <li>
                    <a href="{{route('dashboard')}}" class=" waves-effect">
                        <i class="bx bx-home-circle"></i>

                        <span key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                @endcan

                @can('users')
                <li>

                    <a href="{{route('users.index')}}" class=" waves-effect">
                        <i class="bx bx-user"></i>
                        <span key="t-users">Users</span>
                    </a>

                </li>
                @endcan
                @can('permissions')
                 <li>
                    <a href="{{route('user-permissions.index')}}" class=" waves-effect">
                        <i class="bx bx-lock"></i>
                        <span key="permissions">Permissions</span>
                    </a>


                </li>
                @endcan

                @can('roles')

                <li>
                    <a href="{{route('user-roles.index')}}" class=" waves-effect">
                        <i class="bx bx-shield"></i>
                        <span key="role">Role</span>
                    </a>

                </li>
                @endcan

                @can('categories')

                <li>
                    <a href="{{route('category.index')}}" class=" waves-effect">
                        <i class="bx bx-list-ol" ></i>
                        <span key="category">Category</span>
                    </a>


                </li>
                @endcan

                @can('products')
                <li>

                            <a href="{{route('product.index')}}" class=" waves-effect">
                                <i class="bx bx-box"></i>
                                <span key="product">Product</span>
                            </a>

                </li>
                @endcan

                <li>

                    <a href="{{route('order.index')}}" class=" waves-effect">
                        <i class="bx bx-cart"></i>
                        <span key="order">order</span>
                    </a>

                </li>





            </ul>
        </div>
    </div>
</div>
