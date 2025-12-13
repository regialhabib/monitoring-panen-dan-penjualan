<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Nav::isRoute('home') }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Settings') }}
    </div>

    <!-- Nav Item - Profile -->
    <li class="nav-item {{ Nav::isRoute('profile') }}">
        <a class="nav-link" href="{{ route('profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>{{ __('Profile') }}</span>
        </a>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Panen') }}
    </div>

    <li class="nav-item {{ Nav::isRoute('jenis-jeruk.index') }}">
        <a class="nav-link" href="{{ route('jenis-jeruk.index') }}">
             <i class="fas fa-fw fa-user"></i>
            <span>{{ __('jenis Jeruk') }}</span>
        </a>
    </li>
    <li class="nav-item {{ Nav::isRoute('riwayat-panen.index') }}">
        <a class="nav-link" href="{{ route('riwayat-panen.index') }}">
             <i class="fas fa-fw fa-user"></i>
            <span>{{ __('Riwayat Panen') }}</span>
        </a>
    </li>

    <div class="sidebar-heading">
        {{ __('Penjualan') }}
    </div>

    <li class="nav-item {{ Nav::isRoute('riwayat-penjualan.index') }}">
        <a class="nav-link" href="{{ route('riwayat-penjualan.index') }}">
             <i class="fas fa-fw fa-user"></i>
            <span>{{ __('Riwayat Penjualan') }}</span>
        </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


    
</ul>
