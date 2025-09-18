<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            @include('layouts.admin.sidebar-unit-sekolah.dashboard')
            <ul>
                <li class="menu-title">MADALWA</li>
                @include('layouts.admin.sidebar-unit-sekolah.ppdb')
                {{-- @include('layouts.admin.sidebar-unit-sekolah.sekolah') --}}
                @include('layouts.admin.sidebar-unit-sekolah.kelembagaan')
                @include('layouts.admin.sidebar-unit-sekolah.akademik')
                @include('layouts.admin.sidebar-unit-sekolah.siswa')
                @include('layouts.admin.sidebar-unit-sekolah.alumni')
                @include('layouts.admin.sidebar-unit-sekolah.laporan')
                @include('layouts.admin.sidebar-unit-sekolah.import')
                <li class="menu-title">Pengaturan</li>

            </ul>
            @include('layouts.admin.sidebar-unit-sekolah.profil')
            @include('layouts.admin.sidebar-unit-sekolah.logout')
        </div>
    </div>
</div>
