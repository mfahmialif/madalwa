<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\KelasSub;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KelasSubController extends Controller
{
    private $rules = [
        "sub"                => "required|string",
        "keterangan"         => "nullable|string",
        "tahun_pelajaran_id" => "required|exists:tahun_pelajaran,id",
        "jurusan_id"         => "required|exists:jurusan,id",
    ];

    public function index(Kelas $kelas)
    {
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $jurusan        = Jurusan::all();
        return view('admin.kelas.sub.index', compact('kelas', 'tahunPelajaran', 'jurusan'));
    }

    public function data(Kelas $kelas, Request $request)
    {
        $search = request('search.value');
        $data   = KelasSub::join('kelas', 'kelas.id', '=', 'kelas_sub.kelas_id')
            ->join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'kelas_sub.tahun_pelajaran_id')
            ->join('jurusan', 'jurusan.id', '=', 'kelas_sub.jurusan_id')
            ->where('kelas_sub.kelas_id', $kelas->id)
            ->select('kelas_sub.*', 'kelas.angka as kelas_angka', 'tahun_pelajaran.kode as tahun_pelajaran_kode', 'jurusan.nama_jurusan');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('kelas.keterangan', 'LIKE', "%$search%");
                    $query->orWhere('kelas.romawi', 'LIKE', "%$search%");
                    $query->orWhere('kelas.angka', 'LIKE', "%$search%");
                    $query->orWhere('kelas_sub.sub', 'LIKE', "%$search%");
                    $query->orWhere('jurusan.nama_jurusan', 'LIKE', "%$search%");
                });

                $query->when($request->tahun_pelajaran_id, function ($q) use ($request) {
                    $q->where('kelas_sub.tahun_pelajaran_id', $request->tahun_pelajaran_id);
                });
                $query->when($request->jurusan_id, function ($q) use ($request) {
                    $q->where('kelas_sub.jurusan_id', $request->jurusan_id);
                });
            })
            ->addColumn('action', function ($row) {
                $content = '
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.kelas.sub.siswa.index", [
                    'kelas'    => $row->kelas_id,
                    'kelasSub' => $row->id,
                ]) . '"><i class="fa-solid fa-eye m-r-5"></i> Siswa Kelas</a>
                            <a class="dropdown-item" href="' . route("admin.kelas.sub.wali.index", [
                    'kelas'    => $row->kelas_id,
                    'kelasSub' => $row->id,
                ]) . '"><i class="fa-solid fa-user m-r-5"></i> Wali Kelas</a>
                            <a class="dropdown-item" href="' . route("admin.kelas.sub.edit", [
                    'kelas'    => $row->kelas_id,
                    'kelasSub' => $row->id,
                ]) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="nama" value="' . $row->sub . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'name'])
            ->toJson();
    }

    public function add(Kelas $kelas)
    {
        $dataKelas      = Kelas::orderBy('angka', 'asc')->get();
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $jurusan        = Jurusan::all();
        return view('admin.kelas.sub.add', compact('dataKelas', 'kelas', 'tahunPelajaran', 'jurusan'));
    }

    public function store(Kelas $kelas, Request $request)
    {
        try {
            $request->validate($this->rules);

            $cek = KelasSub::where('kelas_id', $kelas->id)
                ->where('sub', $request->sub)
                ->where('tahun_pelajaran_id', $request->tahun_pelajaran_id)
                ->where('jurusan_id', $request->jurusan_id)
                ->first();

            if ($cek) {
                throw new \Exception('Data Sub Kelas sudah ada');
            }

            $kelasSub                     = new KelasSub();
            $kelasSub->tahun_pelajaran_id = $request->tahun_pelajaran_id;
            $kelasSub->jurusan_id         = $request->jurusan_id;
            $kelasSub->kelas_id           = $kelas->id;
            $kelasSub->sub                = $request->sub;
            $kelasSub->keterangan         = $request->keterangan;
            $kelasSub->save();

            return redirect()->route('admin.kelas.sub.index', ['kelas' => $kelas])->with('success')->with('success', 'KelasSub Sub berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kelas.sub.add', ['kelas' => $kelas])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kelas.sub.add', ['kelas' => $kelas])->with('error', $th->getMessage())->withInput();
        }
    }

    public function edit(Kelas $kelas, KelasSub $kelasSub)
    {
        $dataKelas      = Kelas::orderBy('angka', 'asc')->get();
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $jurusan        = Jurusan::all();
        return view('admin.kelas.sub.edit', compact('kelas', 'dataKelas', 'kelasSub', 'tahunPelajaran', 'jurusan'));
    }

    public function update(Kelas $kelas, Request $request, KelasSub $kelasSub)
    {
        try {
            $request->validate($this->rules);

            $cek = KelasSub::where('kelas_id', $kelas->id)
                ->where('sub', $request->sub)
                ->where('jurusan_id', $request->jurusan_id)
                ->where('tahun_pelajaran_id', $request->tahun_pelajaran_id)
                ->where('id', '!=', $kelasSub->id)->first();
            if ($cek) {
                throw new \Exception('Data Sub Kelas sudah ada');
            }

            $kelasSub->tahun_pelajaran_id = $request->tahun_pelajaran_id;
            $kelasSub->jurusan_id         = $request->jurusan_id;
            $kelasSub->sub                = $request->sub;
            $kelasSub->keterangan         = $request->keterangan;

            $kelasSub->save();

            return redirect()->route('admin.kelas.sub.index', ['kelas' => $kelas])->with('success', 'KelasSub berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kelas.sub.edit', ['kelasSub' => $kelasSub], ['kelas' => $kelas])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kelas.sub.edit', ['kelasSub' => $kelasSub, 'kelas' => $kelas])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Kelas $kelas, KelasSub $kelasSub)
    {
        try {
            $kelasSub->delete();
            return response()->json([
                'status'  => true,
                'message' => 'KelasSub berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'KelasSub tidak dapat dihapus karena masih digunakan oleh user.',
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
