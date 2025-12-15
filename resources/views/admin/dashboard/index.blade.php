@extends('layouts.admin.template')
@section('title', 'Dashboard')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Admin </a></li>
                <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="good-morning-blk">
    <div class="row">
        <div class="col-md-6">
            <div class="morning-user">
                <h2>Selamat Pagi, <span>Admin</span></h2>
                <p>Selamat datang di Sistem Informasi Manajemen Siswa</p>
            </div>
        </div>
        <div class="col-md-6 position-blk">
            <div class="morning-img">
                <img src="{{ asset('template') }}/assets/img/morning-img-01.png" alt="">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="dash-widget">
            <div class="dash-boxs comman-flex-center">
                <img src="{{ asset('template') }}/assets/img/icons/calendar.svg" alt="">
            </div>
            <div class="dash-content dash-count">
                <h4>Total Siswa</h4>
                <h2><span class="counter-up">{{ $siswa }}</span></h2>
                <p><span class="passive-view">Siswa</span> {{ env('NAMA_SEKOLAH') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="dash-widget">
            <div class="dash-boxs comman-flex-center">
                <img src="{{ asset('template') }}/assets/img/icons/profile-add.svg" alt="">
            </div>
            <div class="dash-content dash-count">
                <h4>Total Guru</h4>
                <h2><span class="counter-up">{{ $guru }}</span></h2>
                <p><span class="passive-view">Guru</span> pengajar</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="dash-widget">
            <div class="dash-boxs comman-flex-center">
                <img src="{{ asset('template') }}/assets/img/icons/scissor.svg" alt="">
            </div>
            <div class="dash-content dash-count">
                <h4>Total Kelas</h4>
                <h2><span class="counter-up">{{ $kelasSub }}</span></h2>
                <p><span class="passive-view">Sub</span> Kelas</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="dash-widget">
            <div class="dash-boxs comman-flex-center">
                <img src="{{ asset('template') }}/assets/img/icons/empty-wallet.svg" alt="">
            </div>
            <div class="dash-content dash-count">
                <h4>Jadwal</h4>
                <h2><span class="counter-up">{{ $jadwal }}</span></h2>
                <p><span class="passive-view">Jadwal</span> mata pelajaran</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="dash-widget">
            <div class="dash-boxs comman-flex-center bg-success">
                <img src="{{ asset('template') }}/assets/img/icons/profile-add.svg" alt="">
            </div>
            <div class="dash-content dash-count">
                <h4>Siswa Aktif Laki-laki</h4>
                <h2><span class="counter-up">{{ $siswaAktif['L'] }}</span></h2>
                <p><span class="passive-view">Siswa aktif</span> laki-laki</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="dash-widget">
            <div class="dash-boxs comman-flex-center bg-danger">
                <img src="{{ asset('template') }}/assets/img/icons/profile-add.svg" alt="">
            </div>
            <div class="dash-content dash-count">
                <h4>Siswa Non Aktif Laki-laki</h4>
                <h2><span class="counter-up">{{ $siswaNonAktif['L'] }}</span></h2>
                <p><span class="passive-view">Siswa non aktif</span> laki-laki</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="dash-widget">
            <div class="dash-boxs comman-flex-center bg-success">
                <img src="{{ asset('template') }}/assets/img/icons/profile-add.svg" alt="">
            </div>
            <div class="dash-content dash-count">
                <h4>Siswa Aktif Perempuan</h4>
                <h2><span class="counter-up">{{ $siswaAktif['P'] }}</span></h2>
                <p><span class="passive-view">Siswa aktif</span> Perempuan</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="dash-widget">
            <div class="dash-boxs comman-flex-center bg-danger">
                <img src="{{ asset('template') }}/assets/img/icons/profile-add.svg" alt="">
            </div>
            <div class="dash-content dash-count">
                <h4>Siswa Non Aktif Perempuan</h4>
                <h2><span class="counter-up">{{ $siswaNonAktif['P'] }}</span></h2>
                <p><span class="passive-view">Siswa non aktif</span> Perempuan</p>
            </div>
        </div>
    </div>

    {{-- Distribusi Siswa Aktif per Kelas Berdasarkan Jenis Kelamin --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="card-title text-white mb-0">
                        <i class="fas fa-user-check me-2"></i>Distribusi Siswa Aktif per Kelas (Status: Diterima)
                    </h4>
                </div>
                <div class="card-body" style="background-color: #f8f9fa;">
                    <div class="row g-3">
                        @forelse ($kelasDataAktif as $kelas)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm hover-card" style="border: none; border-radius: 15px; transition: all 0.3s ease;">
                                <div class="card-body p-3">
                                    <!-- Header Kelas -->
                                    <div class="text-center mb-3" style="border-bottom: 2px solid #e9ecef; padding-bottom: 12px;">
                                        <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                            <span class="badge bg-light text-dark" style="font-size: 11px; padding: 5px 10px;">
                                                <i class="fas fa-building me-1"></i>{{ $kelas['unit'] }}
                                            </span>
                                        </div>
                                        <h5 class="mb-0" style="font-weight: 700; color: #2d3748; font-size: 24px;">
                                            {{ $kelas['nama_kelas'] }}
                                        </h5>
                                        <p class="text-muted mb-0" style="font-size: 11px;">Kelas</p>
                                    </div>

                                    <!-- Laki-laki -->
                                    <div class="d-flex align-items-center justify-content-between mb-3 p-2" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); 
                                                    border-radius: 10px;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                                            border-radius: 8px; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);">
                                                <i class="fas fa-male text-white" style="font-size: 16px;"></i>
                                            </div>
                                            <span style="font-size: 13px; font-weight: 500; color: #4a5568;">Laki-laki</span>
                                        </div>
                                        <span class="badge bg-primary" style="font-size: 15px; padding: 8px 15px; font-weight: 700; border-radius: 8px;">
                                            {{ $kelas['laki_laki'] }}
                                        </span>
                                    </div>

                                    <!-- Perempuan -->
                                    <div class="d-flex align-items-center justify-content-between mb-3 p-2" style="background: linear-gradient(135deg, rgba(240, 147, 251, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%); 
                                                    border-radius: 10px;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); 
                                                            border-radius: 8px; box-shadow: 0 2px 8px rgba(245, 87, 108, 0.3);">
                                                <i class="fas fa-female text-white" style="font-size: 16px;"></i>
                                            </div>
                                            <span style="font-size: 13px; font-weight: 500; color: #4a5568;">Perempuan</span>
                                        </div>
                                        <span class="badge bg-danger" style="font-size: 15px; padding: 8px 15px; font-weight: 700; border-radius: 8px;">
                                            {{ $kelas['perempuan'] }}
                                        </span>
                                    </div>

                                    <!-- Total -->
                                    <div class="text-center pt-3" style="border-top: 2px solid #e9ecef;">
                                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 600;">TOTAL SISWA</p>
                                        <span class="badge" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); 
                                                                        font-size: 18px; padding: 10px 20px; font-weight: 700; 
                                                                        border-radius: 10px; color: #fff; box-shadow: 0 3px 10px rgba(253, 160, 133, 0.3);">
                                            {{ $kelas['total'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada data siswa aktif</p>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Summary Total Aktif -->
                    @if($kelasDataAktif->count() > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 15px;">
                                <div class="card-body p-3">
                                    <div class="row text-center text-white">
                                        <div class="col-4">
                                            <i class="fas fa-male mb-2" style="font-size: 24px;"></i>
                                            <h4 class="mb-0" style="font-weight: 700;">{{ $kelasDataAktif->sum('laki_laki') }}</h4>
                                            <p class="mb-0" style="font-size: 12px; opacity: 0.9;">Laki-laki</p>
                                        </div>
                                        <div class="col-4">
                                            <i class="fas fa-female mb-2" style="font-size: 24px;"></i>
                                            <h4 class="mb-0" style="font-weight: 700;">{{ $kelasDataAktif->sum('perempuan') }}</h4>
                                            <p class="mb-0" style="font-size: 12px; opacity: 0.9;">Perempuan</p>
                                        </div>
                                        <div class="col-4">
                                            <i class="fas fa-users mb-2" style="font-size: 24px;"></i>
                                            <h4 class="mb-0" style="font-weight: 700;">{{ $kelasDataAktif->sum('total') }}</h4>
                                            <p class="mb-0" style="font-size: 12px; opacity: 0.9;">Total Siswa Aktif</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Distribusi Siswa Non Aktif per Kelas Berdasarkan Jenis Kelamin --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h4 class="card-title text-white mb-0">
                        <i class="fas fa-user-times me-2"></i>Distribusi Siswa Non Aktif per Kelas (Status: Diterima)
                    </h4>
                </div>
                <div class="card-body" style="background-color: #f8f9fa;">
                    <div class="row g-3">
                        @forelse ($kelasDataNonAktif as $kelas)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm hover-card" style="border: none; border-radius: 15px; transition: all 0.3s ease;">
                                <div class="card-body p-3">
                                    <!-- Header Kelas -->
                                    <div class="text-center mb-3" style="border-bottom: 2px solid #e9ecef; padding-bottom: 12px;">
                                        <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                            <span class="badge bg-light text-dark" style="font-size: 11px; padding: 5px 10px;">
                                                <i class="fas fa-building me-1"></i>{{ $kelas['unit'] }}
                                            </span>
                                        </div>
                                        <h5 class="mb-0" style="font-weight: 700; color: #2d3748; font-size: 24px;">
                                            {{ $kelas['nama_kelas'] }}
                                        </h5>
                                        <p class="text-muted mb-0" style="font-size: 11px;">Kelas</p>
                                    </div>

                                    <!-- Laki-laki -->
                                    <div class="d-flex align-items-center justify-content-between mb-3 p-2" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); 
                                                    border-radius: 10px;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                                            border-radius: 8px; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);">
                                                <i class="fas fa-male text-white" style="font-size: 16px;"></i>
                                            </div>
                                            <span style="font-size: 13px; font-weight: 500; color: #4a5568;">Laki-laki</span>
                                        </div>
                                        <span class="badge bg-primary" style="font-size: 15px; padding: 8px 15px; font-weight: 700; border-radius: 8px;">
                                            {{ $kelas['laki_laki'] }}
                                        </span>
                                    </div>

                                    <!-- Perempuan -->
                                    <div class="d-flex align-items-center justify-content-between mb-3 p-2" style="background: linear-gradient(135deg, rgba(240, 147, 251, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%); 
                                                    border-radius: 10px;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); 
                                                            border-radius: 8px; box-shadow: 0 2px 8px rgba(245, 87, 108, 0.3);">
                                                <i class="fas fa-female text-white" style="font-size: 16px;"></i>
                                            </div>
                                            <span style="font-size: 13px; font-weight: 500; color: #4a5568;">Perempuan</span>
                                        </div>
                                        <span class="badge bg-danger" style="font-size: 15px; padding: 8px 15px; font-weight: 700; border-radius: 8px;">
                                            {{ $kelas['perempuan'] }}
                                        </span>
                                    </div>

                                    <!-- Total -->
                                    <div class="text-center pt-3" style="border-top: 2px solid #e9ecef;">
                                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 600;">TOTAL SISWA</p>
                                        <span class="badge" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); 
                                                                        font-size: 18px; padding: 10px 20px; font-weight: 700; 
                                                                        border-radius: 10px; color: #fff; box-shadow: 0 3px 10px rgba(253, 160, 133, 0.3);">
                                            {{ $kelas['total'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada data siswa non aktif</p>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Summary Total Non Aktif -->
                    @if($kelasDataNonAktif->count() > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border: none; border-radius: 15px;">
                                <div class="card-body p-3">
                                    <div class="row text-center text-white">
                                        <div class="col-4">
                                            <i class="fas fa-male mb-2" style="font-size: 24px;"></i>
                                            <h4 class="mb-0" style="font-weight: 700;">{{ $kelasDataNonAktif->sum('laki_laki') }}</h4>
                                            <p class="mb-0" style="font-size: 12px; opacity: 0.9;">Laki-laki</p>
                                        </div>
                                        <div class="col-4">
                                            <i class="fas fa-female mb-2" style="font-size: 24px;"></i>
                                            <h4 class="mb-0" style="font-weight: 700;">{{ $kelasDataNonAktif->sum('perempuan') }}</h4>
                                            <p class="mb-0" style="font-size: 12px; opacity: 0.9;">Perempuan</p>
                                        </div>
                                        <div class="col-4">
                                            <i class="fas fa-users mb-2" style="font-size: 24px;"></i>
                                            <h4 class="mb-0" style="font-weight: 700;">{{ $kelasDataNonAktif->sum('total') }}</h4>
                                            <p class="mb-0" style="font-size: 12px; opacity: 0.9;">Total Siswa Non Aktif</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Kehadiran Siswa --}}
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="chart-title patient-visit">
                        <h4>Statistik Kehadiran Siswa</h4>
                    </div>
                    <div id="statistik"></div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('styles')
    <style>
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

    </style>
    @endpush

    @push('script')
    <script>
        const series = @json($series);
        const xaxis = @json($xaxis);
        if ($('#statistik').length > 0) {
            var sColStacked = {
                chart: {
                    height: 230
                    , type: 'bar'
                    , stacked: true
                    , toolbar: {
                        show: false
                    , }
                },
                // colors: ['#4361ee', '#888ea8', '#e3e4eb', '#d3d3d3'],
                responsive: [{
                    breakpoint: 480
                    , options: {
                        legend: {
                            position: 'bottom'
                            , offsetX: -10
                            , offsetY: 0
                        }
                    }
                }]
                , plotOptions: {
                    bar: {
                        horizontal: false
                        , columnWidth: '15%'
                    }
                , }
                , dataLabels: {
                    enabled: false
                }
                , series: series
                , xaxis: xaxis,

            }

            var chart = new ApexCharts(
                document.querySelector("#statistik")
                , sColStacked
            );

            chart.render();
        }

    </script>
    @endpush
