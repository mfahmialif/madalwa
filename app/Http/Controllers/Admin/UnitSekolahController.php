<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UnitSekolah;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UnitSekolahController extends Controller
{
    private $rules = [
        "nama_unit"  => "required|string",
        "alamat"     => "nullable|string",
        "keterangan" => "nullable|string",
    ];
    public function index()
    {
        return view('admin.unit-sekolah.index');
    }
    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = UnitSekolah::select('*');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('nama_unit', 'LIKE', "%$search%");
                    $query->orWhere('alamat', 'LIKE', "%$search%");
                    $query->orWhere('keterangan', 'LIKE', "%$search%");
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
                            <a class="dropdown-item" href="' . route("admin.unit-sekolah.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="name" value="' . $row->nama_unit . '">
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
        return view('admin.unit-sekolah.add');
    }
    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);
            $unitSekolah             = new UnitSekolah();
            $unitSekolah->nama_unit  = $request->nama_unit;
            $unitSekolah->alamat     = $request->alamat;
            $unitSekolah->keterangan = $request->keterangan;
            $unitSekolah->save();
            return redirect()->route('admin.unit-sekolah.index')->with('success', 'Unit Sekolah berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.unit-sekolah.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.unit-sekolah.add')->with('error', $th->getMessage())->withInput();
        }
    }
    public function edit(UnitSekolah $unitSekolah)
    {
        return view('admin.unit-sekolah.edit', compact('unitSekolah'));
    }
    public function update(Request $request, UnitSekolah $unitSekolah)
    {
        try {

            $rules       = $this->rules;
            $rules["id"] = "required";
            $request->validate($this->rules);

            $unitSekolah->nama_unit  = $request->nama_unit;
            $unitSekolah->alamat     = $request->alamat;
            $unitSekolah->keterangan = $request->keterangan;
            $unitSekolah->save();
            return redirect()->route('admin.unit-sekolah.index')->with('success', 'Unit Sekolah berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.unit-sekolah.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.unit-sekolah.edit', ['jurusan' => $unitSekolah])->with('error', $th->getMessage())->withInput();
        }
    }
    public function destroy(UnitSekolah $unitSekolah)
    {
        try {
            $unitSekolah->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Unit Sekolah berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Unit Sekolah tidak dapat dihapus karena masih digunakan oleh user.',
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
