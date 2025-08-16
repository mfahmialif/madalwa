<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\UnitSekolah;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KelasController extends Controller
{
    private $rules = [
        "unit_sekolah_id" => "required|exists:unit_sekolah,id",
        "romawi"          => "required|string",
        "angka"           => "required|string",
        "keterangan"      => "nullable|string",
    ];
    public function index()
    {
        $unitSekolah = UnitSekolah::all();
        return view('admin.kelas.index', compact('unitSekolah'));
    }
    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Kelas::join('unit_sekolah', 'unit_sekolah.id', '=', 'kelas.unit_sekolah_id')
            ->select('kelas.*', 'unit_sekolah.nama_unit');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('kelas.romawi', 'LIKE', "%$search%");
                    $query->orWhere('kelas.angka', 'LIKE', "%$search%");
                    $query->orWhere('kelas.keterangan', 'LIKE', "%$search%");
                    $query->orWhere('unit_sekolah.nama_unit', 'LIKE', "%$search%");
                });
                $query->when($request->unit_sekolah_id, function ($q) use ($request) {
                    $q->where('kelas.unit_sekolah_id', $request->unit_sekolah_id);
                });
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.kelas.sub.index", $row) . '"><i class="fa-solid fa-eye  m-r-5"></i> Sub Kelas</a>
                            <a class="dropdown-item" href="' . route("admin.kelas.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="name" value="' . $row->name . '">
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
    public function add()
    {
        $unitSekolah = UnitSekolah::all();
        return view('admin.kelas.add', compact('unitSekolah'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);
            $cek = Kelas::where('unit_sekolah_id', $request->unit_sekolah_id)
                ->where('romawi', $request->romawi)
                ->where('angka', $request->angka)
                ->first();
            if ($cek) {
                throw new \Exception('Data kelas sudah ada');
            }

            $kelas                  = new Kelas();
            $kelas->unit_sekolah_id = $request->unit_sekolah_id;
            $kelas->romawi          = $request->romawi;
            $kelas->angka           = $request->angka;
            $kelas->keterangan      = $request->keterangan;
            $kelas->save();
            return redirect()->route('admin.kelas.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kelas.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kelas.add')->with('error', $th->getMessage())->withInput();
        }
    }
    public function edit(Kelas $kelas)
    {
        $unitSekolah = UnitSekolah::all();
        return view('admin.kelas.edit', compact('kelas', 'unitSekolah'));
    }
    public function update(Request $request, Kelas $kelas)
    {
        try {

            $rules       = $this->rules;
            $rules["id"] = "required";
            $request->validate($this->rules);

            $cek = Kelas::where('unit_sekolah_id', $request->unit_sekolah_id)
                ->where('romawi', $request->romawi)
                ->where('angka', $request->angka)
                ->where('id', '!=', $kelas->id)
                ->first();
            if ($cek) {
                throw new \Exception('Data kelas sudah ada');
            }

            $kelas->unit_sekolah_id = $request->unit_sekolah_id;
            $kelas->romawi          = $request->romawi;
            $kelas->angka           = $request->angka;
            $kelas->keterangan      = $request->keterangan;
            $kelas->save();
            return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kelas.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kelas.edit', ['kelas' => $kelas])->with('error', $th->getMessage())->withInput();
        }
    }
    public function destroy(Kelas $kelas)
    {
        try {
            $kelas->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Kelas berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Kelas tidak dapat dihapus karena masih digunakan oleh user.',
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
