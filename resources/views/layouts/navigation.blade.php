<!-- Nav Item - Dashboard -->
<li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Nav Item - ranking setoran (Fajar) -->
<li class="nav-item {{ request()->routeIs('setoran.ranking') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('setoran.ranking') }}">
        <i class="fas fa-fw fa-money-bill"></i>
        <span>Rangking Setoran</span></a>
</li>

<!-- Nav Item - buku setoran nasabah (Awang) -->
<li class="nav-item {{ request()->routeIs('setoran.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('setoran.index') }}">
        <i class="fas fa-fw fa-book"></i>
        <span>Buku Setoran</span></a>
</li>

<!-- Nav Item - Buku penjualan -->
<li class="nav-item {{ request()->routeIs('sales.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('sales.index') }}">
        <i class="fas fa-fw fa-book"></i>
        <span>Buku Penjualan</span>
    </a>
</li>

<!-- Nav Item - Laporan -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
       aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Laporan</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Submenu Laporan:</h6>
            <a class="collapse-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}" href="{{ route('laporan.index') }}">Laporan</a>
            <a class="collapse-item {{ request()->routeIs('laporan.harian') ? 'active' : '' }}" href="{{ route('laporan.harian') }}">Harian</a>
            <a class="collapse-item {{ request()->routeIs('laporan.bulanan') ? 'active' : '' }}" href="{{ route('laporan.bulanan') }}">Bulanan</a>
        </div>
    </div>
</li>

@if (auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
<!-- Heading -->
<div class="sidebar-heading">
    Manajemen
</div>

<!-- Nav Item - User (only for superadmin or admin) -->
<li class="nav-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('users.index') }}">
        <i class="fas fa-fw fa-user"></i>
        <span>Pengguna</span></a>
</li>
@endif