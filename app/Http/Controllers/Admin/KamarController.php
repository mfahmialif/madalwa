<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kamar;
use App\Models\UnitSekolah;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use App\Http\Services\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KamarController extends Controller
{
    private $rules = [
        "nama_kamar"          => "required|string|max:255",
        "unit_sekolah_id"     => "required|exists:unit_sekolah,id",
        "tahun_pelajaran_id" => "required|exists:tahun_pelajaran,id",
        "kapasitas"           => "nullable|integer|min:1",
        "keterangan"          => "nullable|string",
    ];

    public function index()
    {
        $unitSekolah = UnitSekolah::all();
        $tahunPelajaran = TahunPelajaran::orderBy('id', 'desc')->get();
        return view('admin.kamar.index', compact('unitSekolah', 'tahunPelajaran'));
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Kamar::join('unit_sekolah', 'unit_sekolah.id', '=', 'kamar.unit_sekolah_id')
            ->join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'kamar.tahun_pelajaran_id')
            ->select('kamar.*', 'unit_sekolah.nama_unit', 'tahun_pelajaran.nama as tahun_nama', 'tahun_pelajaran.semester')
            ->when(Auth::user()->role->nama_unit == 'unit sekolah', function ($query) {
                $query->where('kamar.unit_sekolah_id', Auth::user()->unitSekolah->unit_sekolah_id);
            });

        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('kamar.nama_kamar', 'LIKE', "%$search%");
                    $query->orWhere('kamar.keterangan', 'LIKE', "%$search%");
                    $query->orWhere('unit_sekolah.nama_unit', 'LIKE', "%$search%");
                });
                $query->when($request->unit_sekolah_id, function ($q) use ($request) {
                    $q->where('kamar.unit_sekolah_id', $request->unit_sekolah_id);
                });
            })
            ->addColumn('tahun_info', function ($row) {
                return '<span class="badge bg-primary">' . $row->tahun_nama . ' ' . $row->semester . '</span>';
            })
            ->addColumn('jumlah_siswa', function ($row) {
                $count = $row->kamarSiswa()->count();
                $kapasitas = $row->kapasitas ?? '∞';
                return '<span class="badge bg-info">' . $count . ' / ' . $kapasitas . '</span>';
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.kamar.siswa.index", $row) . '"><i class="fa-solid fa-users m-r-5"></i> Siswa Kamar</a>
                            <a class="dropdown-item" href="' . route("admin.kamar.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="name" value="' . $row->nama_kamar . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'tahun_info', 'jumlah_siswa'])
            ->toJson();
    }

    public function add()
    {
        $unitSekolah = UnitSekolah::when(\Auth::user()->role->nama == 'unit sekolah', function ($q) {
            $q->where('id', \Auth::user()->unitSekolah->unit_sekolah_id);
        })->get();
        $tahunPelajaran = TahunPelajaran::orderBy('id', 'desc')->get();
        return view('admin.kamar.add', compact('unitSekolah', 'tahunPelajaran'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);

            // Check if kamar with same name exists in same unit
            $cek = Kamar::where('unit_sekolah_id', $request->unit_sekolah_id)
                ->where('nama_kamar', $request->nama_kamar)
                ->first();
            if ($cek) {
                throw new \Exception('Kamar dengan nama sama sudah ada di unit ini');
            }

            Kamar::create([
                'nama_kamar'          => $request->nama_kamar,
                'unit_sekolah_id'     => $request->unit_sekolah_id,
                'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
                'kapasitas'           => $request->kapasitas,
                'keterangan'          => $request->keterangan,
            ]);

            return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kamar.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kamar.add')->with('error', $th->getMessage())->withInput();
        }
    }

    public function edit(Kamar $kamar)
    {
        Helper::checkUnitSekolahAccess($kamar->unit_sekolah_id);

        $unitSekolah = UnitSekolah::when(\Auth::user()->role->nama == 'unit sekolah', function ($q) {
            $q->where('id', \Auth::user()->unitSekolah->unit_sekolah_id);
        })->get();
        $tahunPelajaran = TahunPelajaran::orderBy('id', 'desc')->get();
        return view('admin.kamar.edit', compact('kamar', 'unitSekolah', 'tahunPelajaran'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        try {
            Helper::checkUnitSekolahAccess($kamar->unit_sekolah_id);

            $request->validate($this->rules);

            // Check if kamar with same name exists in same unit (excluding current kamar)
            $cek = Kamar::where('unit_sekolah_id', $request->unit_sekolah_id)
                ->where('nama_kamar', $request->nama_kamar)
                ->where('id', '!=', $kamar->id)
                ->first();
            if ($cek) {
                throw new \Exception('Kamar dengan nama sama sudah ada di unit ini');
            }

            $kamar->update([
                'nama_kamar'          => $request->nama_kamar,
                'unit_sekolah_id'     => $request->unit_sekolah_id,
                'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
                'kapasitas'           => $request->kapasitas,
                'keterangan'      => $request->keterangan,
            ]);

            return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kamar.edit', $kamar)
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kamar.edit', $kamar)->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Kamar $kamar)
    {
        try {
            $kamar->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Kamar berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Kamar tidak dapat dihapus karena masih memiliki siswa.',
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
