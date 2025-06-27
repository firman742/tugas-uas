<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-trash"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Bank Sampah</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Manajemen
</div>

<!-- Nav Item - User -->
<li class="nav-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('users.index') }}">
        <i class="fas fa-fw fa-user"></i>
        <span>Pengguna</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
