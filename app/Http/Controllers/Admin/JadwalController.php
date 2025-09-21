<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use App\Models\TahunPelajaran;
use App\Models\UnitSekolah;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $unitSekolah    = UnitSekolah::all();
        return view('admin.jadwal.index', compact('tahunPelajaran', 'unitSekolah'));
    }

    public function data(Request $request)
    {
        $kurikulum = Kurikulum::with([
            'detail' => function ($q) {
                $q->select('kurikulum_detail.*')
                    ->join('mata_pelajaran', 'kurikulum_detail.mata_pelajaran_id', '=', 'mata_pelajaran.id')
                    ->join('kelas', 'mata_pelajaran.kelas_id', '=', 'kelas.id')
                    ->orderBy('kelas.angka');
            },
            'detail.mataPelajaran.kelas',
        ])->get();

        $kurikulum = Kurikulum::when($request->filled('unit_sekolah_id'), function ($q) use ($request) {
            $q->where('unit_sekolah_id', $request->unit_sekolah_id);
        })
            ->with('detail.mataPelajaran.kelas')->get();

        $tahunPelajaran = TahunPelajaran::find($request->tahun_pelajaran_id);
        $unitSekolah    = UnitSekolah::find($request->unit_sekolah_id);
        return view('admin.jadwal.kurikulum', compact('kurikulum', 'tahunPelajaran', 'unitSekolah'));
    }
}
