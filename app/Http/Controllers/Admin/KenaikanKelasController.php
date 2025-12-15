<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\UnitSekolah;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use App\Http\Services\Helper;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KenaikanKelasController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kenaikan Kelas',
            'list'  => ['Home', 'Kenaikan Kelas']
        ];

        $page = (object) [
            'title' => 'Kenaikan Kelas'
        ];

        $activeMenu     = 'kenaikan-kelas';
        $tahunPelajaran = TahunPelajaran::orderBy('id', 'desc')->get();
        $unitSekolah    = UnitSekolah::all();
        $kelas          = Kelas::with('unitSekolah')->orderBy('unit_sekolah_id')->orderBy('angka')->get();

        return view('admin.kenaikan-kelas.index', compact('breadcrumb', 'page', 'activeMenu', 'tahunPelajaran', 'unitSekolah', 'kelas'));
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Siswa::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'siswa.tahun_pelajaran_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->leftJoin('unit_sekolah', 'unit_sekolah.id', '=', 'kelas.unit_sekolah_id')
            ->where('status_daftar', 'diterima')
            ->where('siswa.status', 'aktif') // Only active students can be promoted
            ->when(Auth::user()->role->nama_unit == 'unit sekolah', function ($query) {
                $query->where('kelas.unit_sekolah_id', Auth::user()->unitSekolah->unit_sekolah_id);
            })
            ->select('siswa.*', 'tahun_pelajaran.kode as tahun_pelajaran_kode', 'kelas.angka as kelas_angka', 'unit_sekolah.nama_unit as unit_nama');

        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->when($request->tahun_pelajaran_id, function ($q) use ($request) {
                    $q->where('siswa.tahun_pelajaran_id', $request->tahun_pelajaran_id);
                });
                $query->when($request->unit_sekolah_id, function ($q) use ($request) {
                    $q->whereHas('kelas', function ($q) use ($request) {
                        $q->where('kelas.unit_sekolah_id', $request->unit_sekolah_id);
                    });
                });
                $query->when($request->kelas_id, function ($q) use ($request) {
                    $q->where('siswa.kelas_id', $request->kelas_id);
                });
                $query->where(function ($query) use ($search) {
                    $query->orWhere('siswa.nama_siswa', 'LIKE', "%$search%");
                    $query->orWhere('siswa.jenis_kelamin', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nis', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nisn', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nik', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama_siswa', function ($row) {
                $row->foto = $row->foto ? asset('foto_siswa/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Siswa" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <strong>' . $row->nama_siswa . '</strong><br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>NISN: ' . ($row->nisn ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->addColumn('kelas_sekarang', function ($row) {
                return '<span class="badge bg-info">' . ($row->kelas_sekarang ?? '-') . '</span>';
            })
            ->addColumn('kelas_tujuan', function ($row) {
                $kelasSekarang = $row->kelas;
                if (!$kelasSekarang) {
                    return '<span class="badge bg-warning">Belum ada kelas</span>';
                }

                // Find next class in the same unit
                $kelasTujuan = Kelas::where('unit_sekolah_id', $kelasSekarang->unit_sekolah_id)
                    ->where('angka', $kelasSekarang->angka + 1)
                    ->first();

                if ($kelasTujuan) {
                    return '<span class="badge bg-success">Kelas ' . $kelasTujuan->angka . ' - ' . $kelasTujuan->unitSekolah->nama_unit . '</span>';
                } else {
                    return '<span class="badge bg-danger">Tidak ada kelas lanjutan</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $kelasSekarang = $row->kelas;
                $canPromote = false;

                if ($kelasSekarang) {
                    $kelasTujuan = Kelas::where('unit_sekolah_id', $kelasSekarang->unit_sekolah_id)
                        ->where('angka', $kelasSekarang->angka + 1)
                        ->first();
                    $canPromote = $kelasTujuan ? true : false;
                }

                if ($canPromote) {
                    return '<button type="button" class="btn btn-sm btn-success" onclick="naikkanKelas(' . $row->id . ', \'' . $row->nama_siswa . '\')">
                                <i class="fas fa-arrow-up me-1"></i>Naikkan
                            </button>';
                } else {
                    return '<button type="button" class="btn btn-sm btn-secondary" disabled>
                                <i class="fas fa-times me-1"></i>Tidak Bisa
                            </button>';
                }
            })
            ->rawColumns(['action', 'nama_siswa', 'kelas_sekarang', 'kelas_tujuan'])
            ->toJson();
    }

    public function naikkanKelas(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'siswa_id' => 'required|integer|exists:siswa,id',
            ]);

            $siswa = Siswa::findOrFail($validated['siswa_id']);
            $kelasSekarang = $siswa->kelas;

            if (!$kelasSekarang) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Siswa belum memiliki kelas',
                ], 400);
            }

            // Find next class in the same unit
            $kelasTujuan = Kelas::where('unit_sekolah_id', $kelasSekarang->unit_sekolah_id)
                ->where('angka', $kelasSekarang->angka + 1)
                ->first();

            if (!$kelasTujuan) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Kelas lanjutan tidak tersedia. Silakan tambahkan kelas ' . ($kelasSekarang->angka + 1) . ' terlebih dahulu untuk unit ' . $kelasSekarang->unitSekolah->nama_unit,
                ], 400);
            }

            // Update kelas_id
            $siswa->update([
                'kelas_id' => $kelasTujuan->id,
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Berhasil menaikkan ' . $siswa->nama_siswa . ' ke kelas ' . $kelasTujuan->angka,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function naikkanKelasBatch(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'siswa_id'   => 'required|array',
                'siswa_id.*' => 'integer|exists:siswa,id',
            ]);

            $successCount = 0;
            $failedStudents = [];

            foreach ($validated['siswa_id'] as $siswaId) {
                $siswa = Siswa::find($siswaId);
                $kelasSekarang = $siswa->kelas;

                if (!$kelasSekarang) {
                    $failedStudents[] = $siswa->nama_siswa . ' (belum memiliki kelas)';
                    continue;
                }

                // Find next class in the same unit
                $kelasTujuan = Kelas::where('unit_sekolah_id', $kelasSekarang->unit_sekolah_id)
                    ->where('angka', $kelasSekarang->angka + 1)
                    ->first();

                if (!$kelasTujuan) {
                    $failedStudents[] = $siswa->nama_siswa . ' (kelas ' . ($kelasSekarang->angka + 1) . ' belum tersedia)';
                    continue;
                }

                // Update kelas_id
                $siswa->update([
                    'kelas_id' => $kelasTujuan->id,
                ]);

                $successCount++;
            }

            DB::commit();

            $message = "Berhasil menaikkan $successCount siswa";
            if (count($failedStudents) > 0) {
                $message .= ". Gagal: " . implode(', ', $failedStudents);
            }

            return response()->json([
                'status'  => true,
                'message' => $message,
                'success_count' => $successCount,
                'failed_count' => count($failedStudents),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
