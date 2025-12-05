<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use App\Models\KurikulumDetail;
use App\Models\MataPelajaran;
use App\Models\TahunPelajaran;
use App\Models\UnitSekolah;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KurikulumController extends Controller
{
    private $rules = [
        "unit_sekolah_id"    => "required",
        "tahun_pelajaran_id" => "required",
        "kode"               => "required",
        "nama"               => "required",
        "mata_pelajaran_id"  => "nullable",
    ];
    public function index()
    {
        $unitSekolah = UnitSekolah::all();
        return view('admin.kurikulum.index', compact('unitSekolah'));
    }
    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Kurikulum::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'kurikulum.tahun_pelajaran_id')
            ->join('unit_sekolah', 'unit_sekolah.id', '=', 'kurikulum.unit_sekolah_id')
            ->select('kurikulum.*',
                'tahun_pelajaran.nama as tahun_pelajaran_nama',
                'tahun_pelajaran.semester as tahun_pelajaran_semester',
                'unit_sekolah.nama_unit as nama_unit'
            );
        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('kurikulum.nama', 'LIKE', "%$search%");
                    $query->orWhere('tahun_pelajaran.nama', 'LIKE', "%$search%");
                    $query->orWhere('tahun_pelajaran.semester', 'LIKE', "%$search%");
                    $query->orWhere('tahun_pelajaran.kode', 'LIKE', "%$search%");
                });
                $query->when($request->unit_sekolah_id, function ($q) use ($request) {
                    $q->where('kurikulum.unit_sekolah_id', $request->unit_sekolah_id);
                });
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.kurikulum.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
            ->rawColumns(['action'])
            ->toJson();
    }
    public function dataMataPelajaran(Request $request)
    {
        $mataPelajaran = MataPelajaran::whereHas('kelas', function ($q) use ($request) {
            if ($request->filled('unit_sekolah_id')) {
                $q->where('unit_sekolah_id', $request->unit_sekolah_id);
            }
        })->get();
        return view('admin.kurikulum.form.mata-pelajaran', compact('mataPelajaran'));
    }
    public function add()
    {
        $tahunPelajaran = TahunPelajaran::all();
        $mataPelajaran  = MataPelajaran::all();
        $unitSekolah    = UnitSekolah::when(\Auth::user()->role->nama == 'unit sekolah', function ($q) {
            $q->where('id', \Auth::user()->unitSekolah->unit_sekolah_id);
        })->get();
        return view('admin.kurikulum.add', compact('tahunPelajaran', 'mataPelajaran', 'unitSekolah'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);

            \DB::beginTransaction();

            $kurikulum                     = new Kurikulum();
            $kurikulum->unit_sekolah_id    = $request->unit_sekolah_id;
            $kurikulum->tahun_pelajaran_id = $request->tahun_pelajaran_id;
            $kurikulum->kode               = $request->kode;
            $kurikulum->nama               = $request->nama;
            $kurikulum->save();

            if ($request->mata_pelajaran_id) {
                $kurikulumDetail = [];
                foreach ($request->mata_pelajaran_id as $key => $value) {
                    $kurikulumDetail[] = [
                        'kurikulum_id'      => $kurikulum->id,
                        'mata_pelajaran_id' => $value,
                    ];
                }
    
                KurikulumDetail::insert($kurikulumDetail);
            }

            \DB::commit();
            return redirect()->route('admin.kurikulum.index')->with('success', 'Mata Pelajaran berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kurikulum.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollBack();
            return redirect()->route('admin.kurikulum.add')->with('error', $th->getMessage())->withInput();
        }
    }
    public function edit(Kurikulum $kurikulum)
    {
        $tahunPelajaran = TahunPelajaran::all();
        $mataPelajaran  = MataPelajaran::all();
        $kurikulum      = $kurikulum->load('detail.jadwal');
        $unitSekolah    = UnitSekolah::when(\Auth::user()->role->nama == 'unit sekolah', function ($q) {
            $q->where('id', \Auth::user()->unitSekolah->unit_sekolah_id);
        })->get();
        return view('admin.kurikulum.edit', compact('kurikulum', 'tahunPelajaran', 'mataPelajaran', 'unitSekolah'));
    }
    public function update(Request $request, Kurikulum $kurikulum)
    {
        try {
            $this->rules = array_merge($this->rules, [
                "mata_pelajaran_id" => "nullable",
            ]);
            $request->validate($this->rules);

            \DB::beginTransaction();

            $kurikulum->unit_sekolah_id    = $request->unit_sekolah_id;
            $kurikulum->tahun_pelajaran_id = $request->tahun_pelajaran_id;
            $kurikulum->kode               = $request->kode;
            $kurikulum->nama               = $request->nama;
            $kurikulum->save();

            foreach ($kurikulum->detail as $detail) {
                if ($detail->jadwal->count() < 1) {
                    $detail->delete();
                }
            }

            $kurikulumDetail = [];

            if ($request->filled('mata_pelajaran_id')) {
                foreach ($request->mata_pelajaran_id as $key => $value) {
                    $kurikulumDetail[] = [
                        'kurikulum_id'      => $kurikulum->id,
                        'mata_pelajaran_id' => $value,
                    ];
                }
                KurikulumDetail::insert($kurikulumDetail);
            }

            \DB::commit();
            return redirect()->route('admin.kurikulum.index')->with('success', 'Mata Pelajaran berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kurikulum.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('admin.kurikulum.edit', ['kurikulum' => $kurikulum])->with('error', $th->getMessage())->withInput();
        }
    }
    public function destroy(Kurikulum $kurikulum)
    {
        try {
            KurikulumDetail::where('kurikulum_id', $kurikulum->id)->delete();
            $kurikulum->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Mata Pelajaran berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Mata Pelajaran tidak dapat dihapus karena masih ada jadwal yang masih aktif.',
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
