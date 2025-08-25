<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use Illuminate\Http\Request;

class LembagaController extends Controller
{
    public function index()
    {
        $data = Lembaga::firstOrCreate(
            ['id' => 1],
        );
        return view('admin.lembaga.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id'             => 'required',
            'nsm'            => 'nullable',
            'nspn'           => 'nullable',
            'nama_sekolah'   => 'nullable',
            'jenjang'        => 'nullable',
            'status'         => 'nullable',
            'alamat_lengkap' => 'nullable',
            'provinsi'       => 'nullable',
            'kabupaten'      => 'nullable',
            'kecamatan'      => 'nullable',
            'no_telp'        => 'nullable',
            'email'          => 'nullable',
            'website'        => 'nullable',
            'kpl_madrasah'   => 'nullable',
            'nip'            => 'nullable',
        ]);

        if ($request->id) {
            $profile = Lembaga::findOrFail($request->id);
        } else {
            $profile = new Lembaga();
        }
        $profile->nsm             = $request->nsm;
        $profile->npsn            = $request->npsn;
        $profile->nama_sekolah    = $request->nama_sekolah;
        $profile->jenjang_sekolah = $request->jenjang;
        $profile->status_sekolah  = $request->status;
        $profile->alamat_lengkap  = $request->alamat_lengkap;
        $profile->provinsi        = $request->provinsi;
        $profile->kabupaten       = $request->kabupaten;
        $profile->kecamatan       = $request->kecamatan;
        $profile->no_telp         = $request->no_telp;
        $profile->email           = $request->email;
        $profile->website         = $request->website;
        $profile->kepala_madrasah = $request->kpl_madrasah;
        $profile->nip             = $request->nip;
        $profile->save();

        return redirect()->back()->with('success', 'Data lembaga berhasil ditambahkan');

    }
}
