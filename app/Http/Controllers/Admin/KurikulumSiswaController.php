<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\KelasSub;
use App\Models\Kurikulum;
use App\Models\KelasSiswa;
use Illuminate\Http\Request;
use App\Http\Services\Helper;
use App\Http\Controllers\Controller;
use App\Models\TahunPelajaran;
use App\Models\UnitSekolah;
use Yajra\DataTables\Facades\DataTables;

class KurikulumSiswaController extends Controller
{
    private $rules = [
        "siswa_id" => "required|exists:siswa,id",
    ];

    public function index(Kurikulum $kurikulum)
    {
        $tahunPelajaran = TahunPelajaran::all();
        $unitSekolah = UnitSekolah::all();
        return view('admin.kurikulum.siswa.index', compact('kurikulum', 'tahunPelajaran', 'unitSekolah'));
    }

    public function data(Kurikulum $kurikulum, Request $request)
    {
        $search = request('search.value');
        $data   = Siswa::join('kurikulum', 'kurikulum.id', '=', 'siswa.kurikulum_id')
            ->join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'siswa.tahun_pelajaran_id')
            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->join('unit_sekolah', 'unit_sekolah.id', '=', 'kelas.unit_sekolah_id')
            ->select('siswa.*', 'kurikulum.nama as kurikulum_nama', 'tahun_pelajaran.kode as tahun_pelajaran_kode', 'unit_sekolah.nama_unit')
            ->where('siswa.kurikulum_id', $kurikulum->id);

        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('siswa.nama_siswa', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nik', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nis', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nisn', 'LIKE', "%$search%");
                    $query->orWhere('siswa.jenis_kelamin', 'LIKE', "%$search%");
                    $query->orWhere('tahun_pelajaran.kode', 'LIKE', "%$search%");
                });
                $query->when($request->tahun_pelajaran_id, function($q) use ($request){
                    $q->where('siswa.tahun_pelajaran_id', $request->tahun_pelajaran_id);
                });
                $query->when($request->unit_sekolah_id, function($q) use ($request){
                    $q->where('jurusan.unit_sekolah_id', $request->unit_sekolah_id);
                });
            })
            ->editColumn('nama_siswa', function ($row) {
                $row->foto = $row->foto ? asset('foto_siswa/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Siswa" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <a href="' . route("admin.siswa.show", ['siswa' => $row->id]) . '">' . $row->nama_siswa . '</a><br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>' . ($row->jenis_kelamin ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="nama" value="' . $row->nama_siswa . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'nama_siswa'])
            ->toJson();
    }

    // ->whereNull('kelas_siswa.id')
    public function dataSiswa(Kurikulum $kurikulum, Request $request)
    {
        $enrolledSiswa = Siswa::whereNotNull('kurikulum_id')->get()->pluck('id');

        $search = request('search.value');
        $data   = Siswa::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'siswa.tahun_pelajaran_id')
            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->join('unit_sekolah', 'unit_sekolah.id', '=', 'kelas.unit_sekolah_id')
            ->where('status_daftar', 'diterima')
            ->whereNotIn('siswa.status', ['lulus', 'cuti', 'pindah'])
            ->whereNotIn('siswa.id', $enrolledSiswa)
            ->where('unit_sekolah.id', $kurikulum->unit_sekolah_id)
            ->select('siswa.*', 'tahun_pelajaran.kode as tahun_pelajaran_kode', 'kelas.angka as kelas_angka');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->when($request->tahun_pelajaran_id, function ($q) use ($request) {
                    $q->where('siswa.tahun_pelajaran_id', $request->tahun_pelajaran_id);
                });
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
                            <small>Kelas: ' . ($row->kelas_sekarang) . '</small><br>
                            <small>' . ($row->jenis_kelamin ?? '-') . '</small>
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
                            <a class="dropdown-item" href="' . route("admin.siswa.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="nama" value="' . $row->nama . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'nama_siswa', 'status'])
            ->toJson();
    }

    public function add(Kurikulum $kurikulum)
    {
        return view('admin.kurikulum.siswa.add', compact('kurikulum'));
    }

    public function store(Kurikulum $kurikulum, Request $request)
    {
        try {
            $request->validate($this->rules);

            \DB::beginTransaction();
            foreach ($request->siswa_id as $key => $value) {
                $siswa = Siswa::find($value);

                if ($siswa->kurikulum_id) {
                    throw new \Exception('Siswa sudah mempunyai kurikulum');
                }

                $siswa->kurikulum_id     = $kurikulum->id;
                $siswa->save();
            }
            \DB::commit();
            return redirect()->route('admin.kurikulum.siswa.index', ['kurikulum' => $kurikulum])->with('success')->with('success', 'Siswa Kelas berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kurikulum.siswa.add', ['kurikulum' => $kurikulum])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('admin.kurikulum.siswa.add', ['kurikulum' => $kurikulum])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Kurikulum $kurikulum, Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:siswa,id'
            ]);

            Siswa::where('id', $request->id)->update([
                'kurikulum_id' => null,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Kurikulum siswa ini berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Kurikulum siswa ini tidak dapat dihapus karena masih ada data yang digunakan di tabel lain',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan pada database: ' . $e->getMessage(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function bulkDestroy(Kurikulum $kurikulum, Request $request)
    {
        try {
            Siswa::whereIn('id', $request->id)->update([
                'kurikulum_id' => null
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Kurikulum siswa ini berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Kurikulum siswa ini tidak dapat dihapus karena masih ada data yang digunakan di tabel lain',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan pada database: ' . $e->getMessage(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
