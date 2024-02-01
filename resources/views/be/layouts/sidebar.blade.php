<div id="sidebar" class='active'>
    <div class="sidebar-wrapper active">
        <div class="sidebar-header mb-0">
            <img src={{ asset('be/assets/images/ppidbonebol.png') }} alt="logo" srcset="">
        </div>
        <hr>
        <div class="sidebar-menu">
            <ul class="menu">
                @role('admin')
                    <li class="sidebar-title pt-0">
                        <div class="bg-grad">
                            Administrator Area
                        </div>
                    </li>
                @endrole
                <li class='sidebar-title'>Menu Utama</li>
                <li class="sidebar-item @if (request()->routeIs('admin.dashboard')) active @endif">
                    <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->is('admin/klasifikasi', 'admin/klasifikasi/*') ? ' active' : '' }}">
                    <a href="{{ route('admin.klasifikasi.index') }}" class='sidebar-link'>
                        <i data-feather="list" width="20"></i>
                        <span>Master Klasifikasi</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/infopub', 'admin/infopub/*') ? ' active' : '' }}">
                    <a href={{ route('admin.infopub.index') }} class='sidebar-link'>
                        <i data-feather="triangle" width="20"></i>
                        <span>Informasi Publik</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->is('admin/permohonaninformasi', 'admin/permohonaninformasi/*') ? ' active' : '' }}">
                    <a href="{{ route('admin.permohonaninformasi.index') }}" class='sidebar-link'>
                        <i data-feather="file-text" width="20"></i>
                        <span>Permohonan Informasi</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->is('admin/pengajuankeberatan', 'admin/pengajuankeberatan/*') ? ' active' : '' }}">
                    <a href="{{ route('admin.pengajuankeberatan.index') }}" class='sidebar-link'>
                        <i data-feather="alert-circle" width="20"></i>
                        <span>Pengajuan Keberatan</span>
                    </a>
                </li>

                @role('admin')
                    <li class='sidebar-title'>Pengguna</li>
                    <li class="sidebar-item @if (request()->routeIs('admin.petugas')) active @endif">
                        <a href="{{ route('admin.petugas') }}" class='sidebar-link'>
                            <i data-feather="user" width="20"></i>
                            <span>Petugas</span>
                        </a>
                    </li>
                    <li class="sidebar-item @if (request()->routeIs('admin.pemohon')) active @endif">
                        <a href="{{ route('admin.pemohon') }}" class='sidebar-link'>
                            <i data-feather="user" width="20"></i>
                            <span>Pemohon</span>
                        </a>
                    </li>
                    <li class='sidebar-title'>Lainnya</li>
                    <li class="sidebar-item @if (request()->routeIs('admin.profilkantor')) active @endif">
                        <a href="{{ route('admin.profilkantor') }}" class='sidebar-link'>
                            <i data-feather="square" width="20"></i>
                            <span>Profil Kantor</span>
                        </a>
                    </li>
                    <li class="sidebar-item @if (request()->routeIs('admin.kotakpesan')) active @endif">
                        <a href="{{ route('admin.kotakpesan') }}" class='sidebar-link'>
                            <i data-feather="archive" width="20"></i>
                            <span>Kotak Pesan</span>
                        </a>
                    </li>
                    <li class="sidebar-item @if (request()->routeIs('admin.laporan')) active @endif">
                        <a href="{{ route('admin.laporan') }}" class='sidebar-link'>
                            <i data-feather="printer" width="20"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                @endrole
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
