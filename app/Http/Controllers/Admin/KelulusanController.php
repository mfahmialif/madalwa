<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Kurikulum;
use App\Models\UnitSekolah;
use Illuminate\Http\Request;
use App\Http\Services\Helper;
use App\Models\TahunPelajaran;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class KelulusanController extends Controller
{
    protected $rules = [
        'id'               => 'required|exists:siswa,id',
    ];

    public function index()
    {
        $jenisKelamin   = Helper::getEnumValues('siswa', 'jenis_kelamin');
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $status   = Helper::getEnumValues('siswa', 'status');
        $unitSekolah    = UnitSekolah::all();
        $kelas          = Kelas::with('unitSekolah')->orderBy('unit_sekolah_id')->orderBy('angka')->get();
        return view('admin.kelulusan.index', compact('jenisKelamin', 'tahunPelajaran', 'status', 'unitSekolah', 'kelas'));
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Siswa::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'siswa.tahun_pelajaran_id')
            ->select('siswa.*', 'tahun_pelajaran.kode as tahun_pelajaran_kode');
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
                $query->where('siswa.status_daftar', '=', 'diterima');
                $query->when($request->jenis_kelamin, function ($q) use ($request) {
                    $q->where('siswa.jenis_kelamin', $request->jenis_kelamin);
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
                            <a href="' . route("admin.siswa.show", $row) . '">' . $row->nama_siswa . '</a><br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>NISN: ' . ($row->nisn ?? '-') . '</small><br>
                            <small>Kelas: ' . ($row->kelas_sekarang ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->editColumn('status', function ($row) {
                return '<span class="badge bg-' . Helper::getColorStatus($row->status) . '">' . strtoupper($row->status) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="nama" value="' . $row->nama . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-minus m-r-5"></i> Kembalikan ke status semula
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'nama_siswa', 'status'])
            ->toJson();
    }

    public function destroy(Siswa $siswa)
    {
        try {

            if ($siswa->status != 'lulus') {
                throw new \Exception('Siswa tidak lulus');
            }

            $siswa->status = $siswa->status_sebelum_ganti;
            $siswa->status_sebelum_ganti = null;
            $siswa->save();
            return response()->json([
                'status'  => true,
                'message' => 'Siswa berhasil dihapus',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function updateStatusLulus(Request $request)
    {
        try {
            $validated = $request->validate([
                'siswa_id'      => 'required|array',
                'siswa_id.*'    => 'integer|exists:siswa,id', // pastikan setiap id valid
            ]);

            DB::beginTransaction();
            foreach ($validated['siswa_id'] as $key => $value) {
                $siswa = Siswa::find($value);
                $statusLama = $siswa->status;
                $siswa->status = 'lulus';
                $siswa->status_sebelum_ganti = $statusLama;
                $siswa->save();
            }

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Berhasil mengupdate status siswa lulus',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 422,
                'errors'  => $e->errors(), // kirim array error lengkap
                'req'     => $request->all(),
            ], 422);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
                'request' => $request->all(),
            ], 500);
        }
    }
}
