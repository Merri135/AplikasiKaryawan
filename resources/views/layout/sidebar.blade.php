<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Logo -->
    <a class="sidebar-brand d-flex align-items-center justify-content-start ps-3" href="@if(Auth::user()->role === 'admin')
           {{ route('admin.dashboard') }}
       @elseif(Auth::user()->role === 'hrd')
           {{ route('hrd.dashboard') }}
       @elseif(Auth::user()->role === 'supervisor')
           {{ route('supervisor.dashboard') }}
       @else
           {{ route('hrd.karyawan.dashboard') }}
       @endif
       ">
        <img src="{{ asset('template/volex.png') }}" alt="logo" width="100%" height="auto">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

   <!-- Menu Dashboard -->
<li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}"
       href="
       @if(Auth::user()->role === 'admin')
           {{ route('admin.dashboard') }}
       @elseif(Auth::user()->role === 'hrd')
           {{ route('hrd.dashboard') }}
       @elseif(Auth::user()->role === 'supervisor')
           {{ route('supervisor.dashboard') }}
       @else
           {{ route('hrd.karyawan.dashboard') }}
       @endif
       ">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>


    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    {{-- ===================== ROLE ADMIN ===================== --}}
    @if(Auth::user()->role === 'admin')
        <!-- <div class="sidebar-heading">
            Manajemen User
        </div>
        <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
            <a class="nav-link" href="/admin/user">
                <i class="fas fa-fw fa-users"></i>
                <span>Kelola User</span>
            </a>
        </li> -->
    @endif

    {{-- ===================== ROLE HRD ===================== --}}
    @if(Auth::user()->role === 'hrd')
        <div class="sidebar-heading">
            Manajemen Data Master
        </div>
        <li class="nav-item {{ Request::is('karyawan*') ? 'active' : '' }}">
            <a class="nav-link" href="/hrd/karyawan">
                <i class="fas fa-fw fa-table"></i>
                <span>Data Karyawan</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('departemen*') ? 'active' : '' }}">
            <a class="nav-link" href="/hrd/departemen">
                <i class="fas fa-fw fa-building"></i>
                <span>Data Departemen</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('departemen*') ? 'active' : '' }}">
            <a class="nav-link" href="/hrd/jeniscuti">
                <i class="fas fa-fw fa-building"></i>
                <span>Data Jenis Cuti</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('data cuti*') ? 'active' : '' }}">
            <a class="nav-link" href="/hrd/cuti">
                <i class="fas fa-fw fa-building"></i>
                <span>Data Laporan Cuti</span>
            </a>
        </li>
    @endif

    {{-- ===================== ROLE SUPERVISOR ===================== --}}
    @if(Auth::user()->role === 'supervisor')
        <div class="sidebar-heading">
            Pengajuan Cuti
        </div>
        <li class="nav-item {{ Request::is('cuti*') ? 'active' : '' }}">
            <a class="nav-link" href="/supervisor/cuti">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Persetujuan Cuti</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('riwayat*') ? 'active' : '' }}">
            <a class="nav-link" href="/supervisor/cuti/riwayat">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Pengajuan</span>
            </a>
        </li>
    @endif

    {{-- ===================== ROLE KARYAWAN ===================== --}}
    @if(Auth::user()->role === 'karyawan')
        <div class="sidebar-heading">
            Pengajuan Cuti
        </div>
        <li class="nav-item {{ Request::is('cuti*') ? 'active' : '' }}">
            <a class="nav-link" href="/cuti">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Ajukan Cuti</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('riwayat*') ? 'active' : '' }}">
            <a class="nav-link" href="/hrd/karyawan/cuti/riwayat">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Cuti</span>
            </a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
