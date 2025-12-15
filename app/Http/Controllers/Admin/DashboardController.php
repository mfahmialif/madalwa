<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Models\AbsensiDetail;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\KelasSub;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa         = Siswa::count();
        $siswaNonAktif =
            [
                'L' => Siswa::where('status', 'tidak aktif')->whereHas('user', function ($query) {
                    $query->where('jenis_kelamin', 'Laki-laki');
                })->count(),
                'P' => Siswa::where('status', 'tidak aktif')->whereHas('user', function ($query) {
                    $query->where('jenis_kelamin', 'Perempuan');
                })->count(),
            ];
        $siswaAktif =
            [
                'L' => Siswa::where('status', 'aktif')->whereHas('user', function ($query) {
                    $query->where('jenis_kelamin', 'Laki-laki');
                })->count(),
                'P' => Siswa::where('status', 'aktif')->whereHas('user', function ($query) {
                    $query->where('jenis_kelamin', 'Perempuan');
                })->count(),
            ];

        $kelasSub = KelasSub::count();
        $guru     = Guru::count();
        $jadwal   = Jadwal::count();

        // Get all kelas with unit information and student count by gender and status
        $kelasDataAktif = \App\Models\Kelas::with('unitSekolah')
            ->get()
            ->map(function ($kelas) {
                $siswaLakiLaki = Siswa::where('kelas_id', $kelas->id)
                    ->where('status', 'aktif')
                    ->where('status_daftar', 'diterima')
                    ->whereHas('user', function ($query) {
                        $query->where('jenis_kelamin', 'Laki-laki');
                    })
                    ->count();

                $siswaPerempuan = Siswa::where('kelas_id', $kelas->id)
                    ->where('status', 'aktif')
                    ->where('status_daftar', 'diterima')
                    ->whereHas('user', function ($query) {
                        $query->where('jenis_kelamin', 'Perempuan');
                    })
                    ->count();

                return [
                    'id' => $kelas->id,
                    'nama_kelas' => $kelas->angka,
                    'unit' => $kelas->unitSekolah->nama_unit ?? '-',
                    'laki_laki' => $siswaLakiLaki,
                    'perempuan' => $siswaPerempuan,
                    'total' => $siswaLakiLaki + $siswaPerempuan
                ];
            })
            ->sortBy('nama_kelas')
            ->values();

        $kelasDataNonAktif = \App\Models\Kelas::with('unitSekolah')
            ->get()
            ->map(function ($kelas) {
                $siswaLakiLaki = Siswa::where('kelas_id', $kelas->id)
                    ->where('status', 'tidak aktif')
                    ->where('status_daftar', 'diterima')
                    ->whereHas('user', function ($query) {
                        $query->where('jenis_kelamin', 'Laki-laki');
                    })
                    ->count();

                $siswaPerempuan = Siswa::where('kelas_id', $kelas->id)
                    ->where('status', 'tidak aktif')
                    ->where('status_daftar', 'diterima')
                    ->whereHas('user', function ($query) {
                        $query->where('jenis_kelamin', 'Perempuan');
                    })
                    ->count();

                return [
                    'id' => $kelas->id,
                    'nama_kelas' => $kelas->angka,
                    'unit' => $kelas->unitSekolah->nama_unit ?? '-',
                    'laki_laki' => $siswaLakiLaki,
                    'perempuan' => $siswaPerempuan,
                    'total' => $siswaLakiLaki + $siswaPerempuan
                ];
            })
            ->sortBy('nama_kelas')
            ->values();

        $statuses = Helper::getEnumValues('absensi_detail', 'status');

        $colors = [
            'hadir' => '#2E37A4',
            'sakit' => '#00D3C7',
            'izin'  => '#FFC107',
            'alpha' => '#DC3545',
        ];

        $series        = [];
        $tahunSekarang = date('Y'); // Tahun aktif saat ini

        foreach ($statuses as $status) {
            $data = AbsensiDetail::where('status', $status)
                ->whereYear('updated_at', $tahunSekarang)
                ->selectRaw('MONTH(updated_at) as bulan, COUNT(*) as total')
                ->groupBy(DB::raw('MONTH(updated_at)'))
                ->pluck('total', 'bulan')
                ->toArray();

            $monthly = [];
            for ($i = 1; $i <= 12; $i++) {
                $monthly[] = isset($data[$i]) ? $data[$i] : 0;
            }

            $series[] = [
                'name'  => $status,
                'color' => isset($colors[$status]) ? $colors[$status] : '#999',
                'data'  => $monthly,
            ];
        }

        $xaxis = [
            'categories' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
        ];

        return view('admin.dashboard.index', compact('siswa', 'kelasSub', 'guru', 'jadwal', 'series', 'xaxis', 'siswaNonAktif', 'siswaAktif', 'kelasDataAktif', 'kelasDataNonAktif'));
    }
}
