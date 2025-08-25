<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mutasi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MutasiKeluarController extends Controller
{
    protected $rules = [
        // Foreign Keys
        'siswa_id'       => 'required|exists:siswa,id',
        'sekolah_tujuan' => 'required',
        'alasan_mutasi'  => 'required',
        'no_surat'       => 'required',
        'tgl_mutasi'     => 'required',

    ];

    public function index()
    {
        return view('admin.mutasi-keluar.index');
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Mutasi::join('siswa', 'mutasi.siswa_id', '=', 'siswa.id')
            ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
            ->where('mutasi.jenis', 'keluar')
            ->select([
                'mutasi.*',
                'siswa.nama_siswa',
            ]);
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('siswa.nama_siswa', 'LIKE', "%$search%");
                    $query->orWhere('no_surat', 'LIKE', "%$search%");
                    $query->orWhere('sekolah_tujuan', 'LIKE', "%$search%");
                });
            })
            ->addColumn('nama_siswa', function ($row) {
                return $row->siswa->nama_siswa;
            })
            ->addColumn('kelas', function ($row) {
                return $row->siswa->kelas->keterangan;
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.mutasi-keluar.edit", $row->id) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="name" value="' . $row->siswa->nama_siswa . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'nama_siswa', 'alamat', 'asal'])
            ->toJson();
    }
    public function add()
    {
        $siswa = Siswa::all();
        return view('admin.mutasi-keluar.add', compact('siswa'));
    }
    public function store(Request $request)
    {
        try {

            $request->validate($this->rules);

            $mutasi                 = new Mutasi();
            $mutasi->no_surat       = $request->no_surat;
            $mutasi->siswa_id       = $request->siswa_id;
            $mutasi->tgl_mutasi     = $request->tgl_mutasi;
            $mutasi->sekolah_tujuan = $request->sekolah_tujuan;
            $mutasi->alasan_mutasi  = $request->alasan_mutasi;
            $mutasi->jenis          = 'keluar';
            $mutasi->save();
            return redirect()->route('admin.mutasi-keluar.index')->with('success', 'Mutasi Keluar berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.mutasi-keluar.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.mutasi-keluar.add')->with('error', $th->getMessage())->withInput();
        }
    }
    public function edit(Mutasi $mutasi)
    {
        $siswa = Siswa::all();
        return view('admin.mutasi-keluar.edit', compact('mutasi', 'siswa'));
    }
    public function update(Request $request, Mutasi $mutasi)
    {
        try {
            $request->validate($this->rules);
            $mutasi                 = Mutasi::find($mutasi->id);
            $mutasi->no_surat       = $request->no_surat;
            $mutasi->siswa_id       = $request->siswa_id;
            $mutasi->tgl_mutasi     = $request->tgl_mutasi;
            $mutasi->sekolah_tujuan = $request->sekolah_tujuan;
            $mutasi->alasan_mutasi  = $request->alasan_mutasi;
            $mutasi->tgl_mutasi     = $request->tgl_mutasi;
            $mutasi->jenis          = 'keluar';
            $mutasi->save();
            DB::commit();
            return redirect()->route('admin.mutasi-keluar.index')->with('success', 'Mutasi Keluar berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.mutasi-keluar.edit', ['mutasi' => $mutasi->id])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('admin.mutasi-keluar.edit', ['mutasi' => $mutasi->id])->with('error', $th->getMessage())->withInput();
        }
    }
    public function destroy(Mutasi $mutasi)
    {
        try {
            $mutasi->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Mutasi berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Mutasi Keluar tidak dapat dihapus karena masih digunakan oleh user.',
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
