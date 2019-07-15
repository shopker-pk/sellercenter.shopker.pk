<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ env('ADMIN_URL').'public/assets/admin/images/profile_images/'.Session::get('user_details')['image'] }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Session::get('user_details')['name'] }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('dashboard') }}"><i class="fa fa-circle-o"></i> Dashboard</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-square"></i> <span>Products</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('manage_products') }}"><i class="fa fa-circle-o"></i> Manage Products</a>
                        <a href="{{ route('add_product') }}"><i class="fa fa-circle-o"></i> Add Products</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i> <span>Orders</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('manage_orders') }}"><i class="fa fa-circle-o"></i> Manage Orders</a>
                        <a href="{{ route('manage_invoices') }}"><i class="fa fa-circle-o"></i> Manage Invoices</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-star"></i> <span>Reviews</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('manage_order_reviews') }}"><i class="fa fa-circle-o"></i> Manage Order Reviews</a>
                        <a href="{{ route('manage_product_reviews') }}"><i class="fa fa-circle-o"></i> Manage Product Reviews</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i> <span>Finance</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('manage_account_statement') }}"><i class="fa fa-circle-o"></i> Account Statement</a>
                        <a href="{{ route('manage_orders_overview') }}"><i class="fa fa-circle-o"></i> Orders Overview</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cog"></i> <span>Settings</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('manage_profile_settings') }}"><i class="fa fa-circle-o"></i> Manage Profile</a>
                        <a href="{{ route('manage_store_settings') }}"><i class="fa fa-circle-o"></i> Manage Store</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>