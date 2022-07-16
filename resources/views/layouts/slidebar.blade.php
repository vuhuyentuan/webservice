<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
    <img src="{{ asset('AdminLTE-3.1.0/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="{{ asset('AdminLTE-3.1.0/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        @php
            $menu = '';
            $active = '';
            if (URL::current() == route('categories.index') || URL::current() == route('services.index')) {
                $menu = 'menu-is-opening menu-open';
                $active = 'active';
            }
        @endphp
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ URL::current() == route('dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item {{ $menu }}">
            <a href="#" class="nav-link {{ $active }}">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
                Dịch vụ order
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('categories.index') }}" class="nav-link {{ URL::current() == route('categories.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh mục</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('services.index') }}" class="nav-link {{ URL::current() == route('services.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Nhóm dịch vụ</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Đơn hàng</p>
                </a>
            </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('recharges.history') }}" class="nav-link {{ URL::current() == route('users.index') ? 'active' : '' }}">
                <i class="nav-icon fa fa-money-bill"></i>
                <p>Lịch sử nạp tiền</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{ URL::current() == route('users.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Thành viên</p>
            </a>
        </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
