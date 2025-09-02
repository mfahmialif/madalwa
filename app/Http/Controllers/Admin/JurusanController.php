<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class JurusanController extends Controller
{
    private $rules = [
        "kode_jurusan" => "required|string",
        "nama_jurusan" => "required|string",
        "kuota"        => "required|string",
        "status"       => "required|string",
    ];
    public function index()
    {
        return view('admin.jurusan.index');
    }
    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Jurusan::select('*')
                  ->when(Auth::user()->role->nama_unit == 'unit sekolah',function($query) {
                        $query->where('unit_sekolah_id',Auth::user()->unitSekolah->id);
                });
                
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('kode_jurusan', 'LIKE', "%$search%");
                    $query->orWhere('nama_jurusan', 'LIKE', "%$search%");
                    $query->orWhere('kuota', 'LIKE', "%$search%");
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
        return view('admin.jurusan.add');
    }
    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);
            $jurusan               = new Jurusan();
            $jurusan->kode_jurusan = $request->kode_jurusan;
            $jurusan->nama_jurusan = $request->nama_jurusan;
            $jurusan->kuota        = $request->kuota;
            $jurusan->status       = $request->status;
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
        return view('admin.jurusan.edit', compact('jurusan'));
    }
    public function update(Request $request, Jurusan $jurusan)
    {
        try {

            $rules       = $this->rules;
            $rules["id"] = "required";
            $request->validate($this->rules);

            $jurusan->kode_jurusan = $request->kode_jurusan;
            $jurusan->nama_jurusan = $request->nama_jurusan;
            $jurusan->kuota        = $request->kuota;
            $jurusan->status       = $request->status;
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
