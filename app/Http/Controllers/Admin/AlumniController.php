<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Kurikulum;
use App\Models\NilaiDetail;
use App\Http\Services\Helper;
use App\Models\KomponenNilai;
use App\Models\TahunPelajaran;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;



class AlumniController extends Controller
{
    public function index()
    {
        $jenisKelamin   = Helper::getEnumValues('siswa', 'jenis_kelamin');
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $status         = Helper::getEnumValues('siswa', 'status');

        return view('admin.alumni.index', compact('jenisKelamin', 'tahunPelajaran', 'status'));
    }
    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Siswa::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'siswa.tahun_pelajaran_id')
            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->where('siswa.status', 'lulus')
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
                    $query->orWhere('siswa.nik_anak', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama_siswa', function ($row) {
                $row->foto = $row->foto ? asset('foto_siswa/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Siswa" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <a href="' . route("admin.siswa.edit", $row) . '">' . $row->nama_siswa . '</a><br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>NISN: ' . ($row->nisn ?? '-') . '</small>
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
                            <a class="dropdown-item" href="' . route("admin.siswa.show", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Tampilkan</a>
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
            //   Log::info($response->toJson());
    }
    function show($tahunPelajaranId)
    {
        // $jenisKelamin   = Helper::getEnumValues('siswa', 'jenis_kelamin');
        // $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        // $status         = Helper::getEnumValues('siswa', 'status');

        // return view('admin.alumni.show', compact('jenisKelamin', 'tahunPelajaran', 'status'));
        return view('admin.alumni.show',compact('tahunPelajaranId'));
    }
    function alumniPerTahun($tahunPelajaranId,Request $request)
    {
        Log::info($tahunPelajaranId);
        
        try {
             header('Content-Type: application/json');
            $search = request('search.value');
            Log::info($tahunPelajaranId);
        $data = Siswa::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'siswa.tahun_pelajaran_id')
            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->where('siswa.status', 'lulus')
            ->where('siswa.tahun_pelajaran_id',$tahunPelajaranId)
            ->select(
                'siswa.*',
                'tahun_pelajaran.kode as tahun_pelajaran_kode',
                'kelas.angka as kelas_angka'
            );

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
                    $query->orWhere('siswa.nik_anak', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama_siswa', function ($row) {
                $row->foto = $row->foto ? asset('foto_siswa/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Siswa" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <a href="' . route("admin.siswa.edit", $row) . '">' . $row->nama_siswa . '</a><br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>NISN: ' . ($row->nisn ?? '-') . '</small>
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
                            <a class="dropdown-item" href="' . route("admin.siswa.show", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Tampilkan</a>
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
            ->make(true);

        } catch (\Throwable $th) {
             Log::error('DataTables Error: ' . $th->getMessage());
        }

        
    }
}
