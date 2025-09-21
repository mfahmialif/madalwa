<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\UnitSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class JurusanController extends Controller
{
    private $rules = [
        "unit_sekolah_id" => "required|string",
        "kode_jurusan"    => "required|string",
        "nama_jurusan"    => "required|string",
        "kuota"           => "required|string",
        "status"          => "required|string",
    ];
    public function index()
    {
        $unitSekolah = UnitSekolah::all();
        return view('admin.jurusan.index', compact('unitSekolah'));
    }
    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Jurusan::join('unit_sekolah', 'unit_sekolah.id', '=', 'jurusan.unit_sekolah_id')
            ->select('jurusan.*', 'unit_sekolah.nama_unit as nama_unit_sekolah');

        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('jurusan.kode_jurusan', 'LIKE', "%$search%");
                    $query->orWhere('jurusan.nama_jurusan', 'LIKE', "%$search%");
                });

                $query->when($request->unit_sekolah_id, function ($q) use ($request) {
                    $q->where('jurusan.unit_sekolah_id', $request->unit_sekolah_id);
                });
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'aktif') {
                    return '<span class="badge bg-success">Aktif</span>';
                } else {
                    return '<span class="badge bg-danger">Tidak Aktif</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.jurusan.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="name" value="' . $row->nama_jurusan . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'name', 'status'])
            ->toJson();
    }
    public function add()
    {
        $unitSekolah = UnitSekolah::when(\Auth::user()->role->nama == 'unit sekolah', function ($q) {
            $q->where('id', \Auth::user()->unitSekolah->unit_sekolah_id);
        })->get();
        return view('admin.jurusan.add', compact('unitSekolah'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);
            $jurusan                  = new Jurusan();
            $jurusan->unit_sekolah_id = $request->unit_sekolah_id;
            $jurusan->kode_jurusan    = $request->kode_jurusan;
            $jurusan->nama_jurusan    = $request->nama_jurusan;
            $jurusan->kuota           = $request->kuota;
            $jurusan->status          = $request->status;
            $jurusan->save();
            return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.jurusan.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.jurusan.add')->with('error', $th->getMessage())->withInput();
        }
    }
    public function edit(Jurusan $jurusan)
    {
        $unitSekolah = UnitSekolah::when(\Auth::user()->role->nama == 'unit sekolah', function ($q) {
            $q->where('id', \Auth::user()->unitSekolah->unit_sekolah_id);
        })->get();
        return view('admin.jurusan.edit', compact('jurusan', 'unitSekolah'));
    }
    public function update(Request $request, Jurusan $jurusan)
    {
        try {

            $rules       = $this->rules;
            $rules["id"] = "required";
            $request->validate($this->rules);

            $jurusan->unit_sekolah_id = $request->unit_sekolah_id;
            $jurusan->kode_jurusan    = $request->kode_jurusan;
            $jurusan->nama_jurusan    = $request->nama_jurusan;
            $jurusan->kuota           = $request->kuota;
            $jurusan->status          = $request->status;
            $jurusan->save();
            return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.jurusan.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.jurusan.edit', ['jurusan' => $jurusan])->with('error', $th->getMessage())->withInput();
        }
    }
    public function destroy(Jurusan $jurusan)
    {
        try {
            $jurusan->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Jurusan berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Jurusan tidak dapat dihapus karena masih digunakan oleh user.',
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
