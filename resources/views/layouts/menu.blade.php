<div class="vertical-menu">

    <div data-simplebar="" class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Quản lý</li>

                <li>
                    <a href="{{ route('dashboard') }}" class=" waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>

                @can('Xem danh sách lương')
                <li>
                    <a href="{{ route('salaries.index') }}" class=" waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span>Quản lý lương</span>
                    </a>
                </li>
                @endcan

                @can('Xem danh sách tài khoản')
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="bx bx-cog"></i><span class="badge badge-pill badge-info float-right">03</span>
                        <span>Cài đặt</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('Xem danh sách tài khoản')
                        <li><a href="{{ route('users.index') }}">Tài khoản</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>