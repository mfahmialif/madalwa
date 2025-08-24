<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use Illuminate\Http\Request;

class LembagaController extends Controller
{
    function index(){
        $data = Lembaga::find(1);
        return view('admin.lembaga.v_index',compact('data'));
    }
    function store(Request $request) {
        $request->validate([
            'id'=>'required',
            'nsm'=>'required',
            'nspn'=>'required',
            'nama_sekolah'=>'required',
            'jenjang'=>'required',
            'status'=>'required',
            'alamat_lengkap'=> 'required',
            'provinsi'=>'required',
            'kabupaten'=>'required',
            'kecamatan'=>'required',
            'no_telp'=>'required',
            'email'=>'required',
            'website'=>'required',
            'kpl_madrasah'=>'required',
            'nip'=>'required'
        ]);


        if ($request->id) {
           $profile = Lembaga::findOrFail($request->id);
        }else {
            $profile = new Lembaga();
        }
        $profile->nsm = $request->nsm;
        $profile->nspn = $request->nspn;
        $profile->nama_sekolah = $request->nama_sekolah;
        $profile->jenjang_sekolah = $request->jenjang;
        $profile->status_sekolah = $request->status;
        $profile->alamat_lengkap = $request->alamat_lengkap;
        $profile->provinsi = $request->provinsi;
        $profile->kabupaten = $request->kabupaten;
        $profile->kecamatan = $request->kecamatan;
        $profile->no_telp = $request->no_telp;
        $profile->email = $request->email;
        $profile->website = $request->website;
        $profile->kepala_madrasah = $request->kpl_madrasah;
        $profile->nip = $request->nip;
        $profile->save();
        return response()->json([
            'status'=>true,
            'message'=>'data berhasil ditambahkan'
        ]);
    }
}
