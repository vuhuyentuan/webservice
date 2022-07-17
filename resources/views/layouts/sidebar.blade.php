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
        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="img-circle elevation-2" alt="User Image">
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
        @can('admin')
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
                <a href="{{ route('order.history') }}" class="nav-link {{ URL::current() == route('order.history') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Đơn hàng</p>
                </a>
            </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('recharges.history') }}" class="nav-link {{ URL::current() == route('recharges.history') ? 'active' : '' }}">
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
        <li class="nav-item">
            <a href="{{ route('banks.index') }}" class="nav-link">
                <i class="fas fa-credit-card nav-icon"></i>
                <p>Tài khoản ngân hàng</p>
            </a>
        </li>
        @endcan
        @can('user')
        <li class="nav-item">
            <a href="{{ route('user.dashboard') }}" class="nav-link {{ URL::current() == route('user.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Trang chủ</p>
            </a>
        </li>
        @foreach ($category as $cate)
            @if($cate->status == 'show')
            <li class="nav-item">
                <a href="#" class="nav-link">
                    @if($cate->image)
                        <img src="{{ asset($cate->image) }}" width="30px" height="30px" class="img-circle elevation-2">
                    @else
                        <i class="far fa-circle nav-icon"></i>
                    @endif
                <p>
                    {{ $cate->name }}
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach ($cate->service as $service)
                    @if($service->status == 'show')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            @if($service->image)
                                <img src="{{ asset($service->image) }}" width="28px" height="28px" class="img-circle elevation-2">
                            @else
                                <i class="far fa-circle nav-icon"></i>
                            @endif
                        <p>{{ $service->name }}</p>
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </li>
            @endif
        @endforeach
        @endcan
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>