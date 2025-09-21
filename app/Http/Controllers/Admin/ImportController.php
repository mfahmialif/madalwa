<?php
namespace App\Http\Controllers\Admin;

use App\Models\UnitSekolah;
use App\Imports\KelasImport;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use App\Imports\KurikulumImport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Imports\MataPelajaranImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function showSiswa()
    {
        $unitSekolah = UnitSekolah::all();
        return view('admin.import.siswa.index', compact('unitSekolah'));
    }
    public function importSiswa(Request $request)
    {
        try {

            $request->validate([
                'import_siswa' => 'required|mimes:xls,xlsx',
            ]);

            $import = new SiswaImport($request->all());
            Excel::import($import, $request->import_siswa);

            $responseImport = $import->getResponse();
            return redirect()->back()->with('success', 'Data berhasil diimport! '. $responseImport);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Kalau error validasi
            return redirect()->back()
                ->withErrors($e->errors()) // tetap simpan untuk form error
                ->with('error', 'Validasi gagal: pastikan file xls/xlsx sudah dipilih.');
        } catch (\Throwable $th) {
            // Kalau error lain
            dd($th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function showKelas()
    {
        return view('admin.import.kelas.index');
    }
    public function importKelas(Request $request)
    {
        try {

            $request->validate([
                'import_kelas' => 'required|mimes:xls,xlsx',
            ]);

            Excel::import(new KelasImport(), $request->import_kelas);
            return redirect()->back()->with('success', 'Data berhasil diimport!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Kalau error validasi
            return redirect()->back()
                ->withErrors($e->errors()) // tetap simpan untuk form error
                ->with('error', 'Validasi gagal: pastikan file xls/xlsx sudah dipilih.');
        } catch (\Throwable $th) {
            // Kalau error lain
            Log::error($th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function showMataPelajaran()
    {
        return view('admin.import.mata-pelajaran.index');
    }
    public function importMataPelajaran(Request $request)
    {
        try {
            $request->validate([
                'import_mata_pelajaran' => 'required|mimes:xls,xlsx',
            ]);

            Excel::import(new MataPelajaranImport(), $request->file('import_mata_pelajaran'));
            Log::info('Import berhasil');

            return redirect()->back()->with('success', 'Data berhasil diimport!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Kalau error validasi
            return redirect()->back()
                ->withErrors($e->errors()) // tetap simpan untuk form error
                ->with('error', 'Validasi gagal: pastikan file xls/xlsx sudah dipilih.');
        } catch (\Throwable $th) {
            // Kalau error lain
            Log::error($th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function showKurikulum()
    {
        return view('admin.import.kurikulum.index');
    }
    public function importKurikulum(Request $request)
    {
        try {
            $request->validate([
                'import_kurikulum' => 'required|mimes:xls,xlsx',
            ]);

            Excel::import(new KurikulumImport(), $request->import_kurikulum);
            return redirect()->back()->with('success', 'Data berhasil diimport!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Kalau error validasi
            return redirect()->back()
                ->withErrors($e->errors()) // tetap simpan untuk form error
                ->with('error', 'Validasi gagal: pastikan file xls/xlsx sudah dipilih.');
        } catch (\Throwable $th) {
            // Kalau error lain
            Log::error($th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
