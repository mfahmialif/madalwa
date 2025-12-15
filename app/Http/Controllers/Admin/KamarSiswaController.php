<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Models\Kamar;
use App\Models\KamarSiswa;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class KamarSiswaController extends Controller
{
    public function index(Kamar $kamar)
    {
        Helper::checkUnitSekolahAccess($kamar->unit_sekolah_id);
        return view('admin.kamar.siswa.index', compact('kamar'));
    }

    public function data(Kamar $kamar, Request $request)
    {
        $search = request('search.value');
        $data   = KamarSiswa::where('kamar_siswa.kamar_id', $kamar->id)
            ->join('siswa', 'siswa.id', '=', 'kamar_siswa.siswa_id')
            ->join('kelas', 'kelas.id', '=', 'kamar_siswa.kelas_id')
            ->leftJoin('users', 'users.id', '=', 'siswa.user_id')
            ->select(
                'kamar_siswa.*',
                'siswa.nama_siswa',
                'siswa.nis',
                'siswa.nisn',
                'kelas.angka as kelas_angka',
                'users.jenis_kelamin'
            );

        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('siswa.nama_siswa', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nis', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nisn', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama_siswa', function ($row) {
                $foto = $row->siswa->foto ? asset('foto_siswa/' . $row->siswa->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $foto . '" alt="Foto Siswa" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
                        <div>
                            <strong>' . $row->siswa->nama_siswa . '</strong><br>
                            <small>NIS: ' . ($row->siswa->nis ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->addColumn('kelas_info', function ($row) {
                return '<span class="badge bg-info">Kelas ' . $row->kelas_angka . '</span>';
            })
            ->addColumn('action', function ($row) use ($kamar) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="nama" value="' . $row->siswa->nama_siswa . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Hapus dari Kamar
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'nama_siswa', 'kelas_info'])
            ->toJson();
    }

    public function dataSiswa(Kamar $kamar, Request $request)
    {
        $search = request('search.value');

        // Get siswa yang:
        // 1. Belum ada di kamar INI (spesifik)
        // 2. Belum punya kamar di kelas mereka saat ini (untuk enforce 1 kamar per kelas)
        $data = Siswa::leftJoin('users', 'users.id', '=', 'siswa.user_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->where('siswa.status', 'aktif')
            ->where('siswa.status_daftar', 'diterima')
            // Filter 1: Siswa yang BELUM ada di kamar INI
            ->whereNotExists(function ($query) use ($kamar) {
                $query->select(\DB::raw(1))
                    ->from('kamar_siswa')
                    ->whereColumn('kamar_siswa.siswa_id', 'siswa.id')
                    ->where('kamar_siswa.kamar_id', $kamar->id);
            })
            // Filter 2: Siswa yang BELUM punya kamar APAPUN di kelas mereka saat ini
            ->whereNotExists(function ($query) {
                $query->select(\DB::raw(1))
                    ->from('kamar_siswa')
                    ->whereColumn('kamar_siswa.siswa_id', 'siswa.id')
                    ->whereColumn('kamar_siswa.kelas_id', 'siswa.kelas_id');
            })
            ->select('siswa.*', 'users.jenis_kelamin', 'kelas.angka as kelas_angka');

        // Filter by unit if kamar is specific to unit
        if ($kamar->unit_sekolah_id) {
            $data->whereHas('kelas', function ($q) use ($kamar) {
                $q->where('unit_sekolah_id', $kamar->unit_sekolah_id);
            });
        }

        return DataTables::of($data)
            ->filter(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('siswa.nama_siswa', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nis', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nisn', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama_siswa', function ($row) {
                $foto = $row->foto ? asset('foto_siswa/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $foto . '" alt="Foto Siswa" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
                        <div>
                            <strong>' . $row->nama_siswa . '</strong><br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>Kelas: ' . ($row->kelas_angka ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->addColumn('jenis_kelamin', function ($row) {
                return $row->jenis_kelamin ?? '-';
            })
            ->rawColumns(['nama_siswa'])
            ->toJson();
    }

    public function add(Kamar $kamar)
    {
        Helper::checkUnitSekolahAccess($kamar->unit_sekolah_id);
        return view('admin.kamar.siswa.add', compact('kamar'));
    }

    public function store(Kamar $kamar, Request $request)
    {
        try {
            Helper::checkUnitSekolahAccess($kamar->unit_sekolah_id);

            $validated = $request->validate([
                'siswa_id'   => 'required|array',
                'siswa_id.*' => 'integer|exists:siswa,id',
                'keterangan' => 'nullable|string',
            ]);

            DB::beginTransaction();

            // Check kapasitas kamar
            $currentCount = KamarSiswa::where('kamar_id', $kamar->id)->count();
            $siswaToAdd = count($validated['siswa_id']);

            // Jika kamar punya kapasitas (tidak null), cek apakah melebihi
            if ($kamar->kapasitas !== null) {
                $totalAfterAdd = $currentCount + $siswaToAdd;

                if ($totalAfterAdd > $kamar->kapasitas) {
                    $sisaKuota = $kamar->kapasitas - $currentCount;
                    throw new \Exception(
                        "Kapasitas kamar tidak mencukupi! " .
                            "Saat ini: {$currentCount}/{$kamar->kapasitas}, " .
                            "Anda mencoba menambah: {$siswaToAdd} siswa, " .
                            "Sisa kuota: {$sisaKuota} siswa"
                    );
                }
            }

            $successCount = 0;
            $failedStudents = [];

            foreach ($validated['siswa_id'] as $siswaId) {
                $siswa = Siswa::find($siswaId);

                // Check if student already in this room
                $existing = KamarSiswa::where('kamar_id', $kamar->id)
                    ->where('siswa_id', $siswaId)
                    ->first();

                if ($existing) {
                    $failedStudents[] = $siswa->nama_siswa . ' (sudah ada di kamar ini)';
                    continue;
                }

                // Check unique constraint: one room per student per class
                $existingInClass = KamarSiswa::where('siswa_id', $siswaId)
                    ->where('kelas_id', $siswa->kelas_id)
                    ->first();

                if ($existingInClass) {
                    $failedStudents[] = $siswa->nama_siswa . ' (sudah memiliki kamar di kelas ' . $siswa->kelas->angka . ')';
                    continue;
                }

                KamarSiswa::create([
                    'kamar_id'   => $kamar->id,
                    'siswa_id'   => $siswaId,
                    'kelas_id'   => $siswa->kelas_id,
                    'keterangan' => $validated['keterangan'],
                ]);

                $successCount++;
            }

            DB::commit();

            $message = "Berhasil menambahkan $successCount siswa ke kamar";
            if (count($failedStudents) > 0) {
                $message .= ". Gagal: " . implode(', ', $failedStudents);
            }

            return redirect()->route('admin.kamar.siswa.index', $kamar)->with('success', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->route('admin.kamar.siswa.add', $kamar)
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.kamar.siswa.add', $kamar)->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Kamar $kamar, KamarSiswa $kamarSiswa)
    {
        try {
            Helper::checkUnitSekolahAccess($kamar->unit_sekolah_id);

            $kamarSiswa->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Siswa berhasil dihapus dari kamar',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function bulkDestroy(Kamar $kamar, Request $request)
    {
        try {
            Helper::checkUnitSekolahAccess($kamar->unit_sekolah_id);

            $validated = $request->validate([
                'kamar_siswa_id'   => 'required|array',
                'kamar_siswa_id.*' => 'integer|exists:kamar_siswa,id',
            ]);

            KamarSiswa::whereIn('id', $validated['kamar_siswa_id'])
                ->where('kamar_id', $kamar->id)
                ->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Siswa berhasil dihapus dari kamar',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
