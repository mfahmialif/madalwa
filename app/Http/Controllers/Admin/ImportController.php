<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\KelasImport;
use App\Imports\KurikulumImport;
use App\Imports\MataPelajaranImport;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    function showSiswa()
    {
        return view('admin.import.siswa.index');
    }
    function importSiswa(Request $request)
    {
        try {

            $request->validate([
                'import_siswa' => 'required|mimes:xls,xlsx'
            ]);

            Excel::import(new SiswaImport(), $request->import_siswa);

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
    function showKelas()
    {
        return view('admin.import.kelas.index');
    }
    function importKelas(Request $request)
    {
        try {

            $request->validate([
                'import_kelas' => 'required|mimes:xls,xlsx'
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
    function showMataPelajaran()
    {
        return view('admin.import.mata-pelajaran.index');
    }
    function importMataPelajaran(Request $request)
    {
        try {
            $request->validate([
                'import_mata_pelajaran' => 'required|mimes:xls,xlsx'
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
    function showKurikulum()
    {
        return view('admin.import.kurikulum.index');
    }
    function importKurikulum(Request $request)
    {
        try {
            $request->validate([
                'import_kurikulum' => 'required|mimes:xls,xlsx'
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
