<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Kurikulum;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $rules = [
        'kurikulum_id'               => 'nullable|exists:kurikulum,id',
        'kelas_id'                   => 'required|exists:kelas,id',
        'tahun_pelajaran_id'         => 'nullable|exists:tahun_pelajaran,id',
        'email'                      => 'nullable|email|unique:users,email',
        'jurusan_id'                 => 'required|integer|exists:jurusan,id',

        // Informasi siswa
        'nama_siswa'                 => 'required|string|max:255',
        'kewarganegaraan'            => 'required|in:WNI,WNA',
        'nis'                        => 'nullable|string|max:255|unique:siswa,nis',
        'nisn'                       => 'nullable|string|max:255|unique:siswa,nisn',
        'nik'                        => 'nullable|string',
        'tempat_lahir'               => 'required|string|max:255',
        'tanggal_lahir'              => 'required|date',
        'jenis_kelamin'              => 'required|in:Laki-laki,Perempuan',
        'asal_sekolah'               => 'nullable|string|max:255',
        'anak_ke'                    => 'nullable|integer',
        'jml_saudara'                => 'nullable|integer|min:0',
        'agama'                      => 'required|in:Islam,Kristen,Khatolik,Hindu,Budha,Kong Hu Cu',
        'cita_cita'                  => 'nullable|in:PNS,TNI/Polri,Guru/Dosen,Dokter,Politikus,Wiraswasta,Seniman/Artis,Ilmuwan,Agamawan,Lainnya',
        'no_hp'                      => 'nullable|string|max:20',
        'hobi'                       => 'nullable|in:Olahraga,Kesenian,Membaca,Menulis,Jalan-jalan,Lainnya',

        // Alamat siswa
        'tempat_tinggal_siswa'       => 'nullable|in:Tinggal dengan Ortu/Wali,Ikut Saudara/Kerabat,Asrama Madrasah,Kontrak/kost,Tinggal di asrama pesantren,Panti asuhan,Rumah singgah,Lainnya',
        'alamat_anak_sesuai_kk'      => 'nullable|string',
        'jalan_dusun'                => 'nullable|string|max:255',
        'desa_kelurahan'             => 'nullable|string|max:255',
        'kecamatan'                  => 'nullable|string|max:255',
        'kab_kota'                   => 'nullable|string|max:255',
        'provinsi'                   => 'nullable|string|max:255',
        'kordinat_rumah'             => 'nullable|string|max:255',
        'kodepos'                    => 'nullable|string|max:10',
        'transportasi'               => 'nullable|in:Jalan kaki,Sepeda,Sepeda motor,Mobil pribadi,Antar jemput sekolah,Angkutan umum,Perahu/sampan,Lainnya',
        'jarak'                      => 'nullable|in:Kurang dari 5 km,Antara 5-10 km,Antara 11-20 km,Antara 21-30 km,Lebih dari 30 km',
        'waktu'                      => 'nullable|in:1-10 menit,10-19 menit,20-29 menit,30-39 menit,1-2 jam,>2 jam',
        'nsm'                        => 'nullable|string|max:50',
        'npsn'                       => 'nullable|string|max:50',

        'biaya_sekolah'              => 'nullable|in:Orangtua,Wali/orangtua asuh,Tanggungan Sendiri,Lainnya',
        'keb_khusus'                 => 'nullable|in:Tidak ada,Lamban belajar,Kesulitan belajar spesifik,Gangguan komunikasi,Berbakat/memiliki kemampuan,Lainnya',
        'keb_disabilitas'            => 'nullable|in:Tidak ada,Tuna Netra,Tuna Rungu,Tuna Daksa,Tuna Grahita,Tuna Laras,Lainnya',

        // Imunisasi
        'tk_ra'                      => 'nullable|in:Y,T',
        'paud'                       => 'nullable|in:Y,T',
        'hepatitis_b'                => 'nullable|in:Y,T',
        'polio'                      => 'nullable|in:Y,T',
        'bcg'                        => 'nullable|in:Y,T',
        'campak'                     => 'nullable|in:Y,T',
        'dpt'                        => 'nullable|in:Y,T',
        'covid'                      => 'nullable|in:Y,T',

        'no_kip'                     => 'nullable|string|max:255',
        'kepala_keluarga'            => 'nullable|string|max:255',
        'foto'                       => 'nullable|image|mimes:jpeg,png,jpg|max:10240',

        // Ayah
        'nama_ayah'                  => 'nullable|string|max:255',
        'status_ayah'                => 'nullable|in:Masih Hidup,Sudah Meninggal,Tidak Diketahui',
        'kewarganegaraan_ayah'       => 'nullable|in:WNI,WNA',
        'nik_ayah'                   => 'nullable|string|digits:16',
        'tempat_lahir_ayah'          => 'nullable|string|max:255',
        'tanggal_lahir_ayah'         => 'nullable|date',
        'pendidikan_ayah'            => 'nullable|in:SD/Sederajat,SMP/Sederajat,SMA/Sederajat,D1,D2,D3,D4/S1,S2,S3,Tidak Bersekolah',
        'pekerjaan_ayah'             => 'nullable|in:Tidak Bekerja,Pensiunan,PNS,TNI/Polisi,Guru/Dosen,Pegawai Swasta,Wiraswasta,Pengacara/Jaksa/Hakim/No,Seniman/Pelukis/Artis/Seje,Dokter/Bidan/Perawat,Pilot/Pramugara,Pedagang,Petani/Peternak,Nelayan,Buruh (Tani/Pabrik/Banguna,Sopir/Masinis/Kondektur,Politikus,Lainnya',
        'penghasilan_ayah'           => 'nullable|in:Kurang dari 500.000,500.000 - 1.000.000,1.000.001 - 2.000.000,2.000.001 - 3.000.000,3.000.001 - 5.000.000,Lebih dari 5.000.000,Tidak ada',
        'no_hp_ayah'                 => 'nullable|string|max:20',
        'domisili_ayah'              => 'nullable|in:Dalam Negeri,Luar Negeri',
        'status_tempat_tinggal_ayah' => 'nullable|in:Milik Sendiri,Rumah Orangtua,Rumah Saudara/Kerabat,Rumah Dinas,Sewa/Kontrak,Lainnya',
        'desa_keluarahan_ayah'       => 'nullable|string|max:255',
        'kecamatan_ayah'             => 'nullable|string|max:255',
        'kab_kota_ayah'              => 'nullable|string|max:255',
        'provinsi_ayah'              => 'nullable|string|max:255',
        'kodepos_ayah'               => 'nullable|string|max:10',
        'alamat_ayah'                => 'nullable|string|max:500',
        'alamat_ibu'                => 'nullable|string|max:500',
        'alamat_wali'                => 'nullable|string|max:500',

        // Ibu
        'nama_ibu'                   => 'nullable|string|max:255',
        'status_ibu'                 => 'nullable|in:Masih Hidup,Sudah Meninggal,Tidak Diketahui',
        'kewarganegaraan_ibu'        => 'nullable|in:WNI,WNA',
        'nik_ibu'                    => 'nullable|string|digits:16',
        'tempat_lahir_ibu'           => 'nullable|string|max:255',
        'tanggal_lahir_ibu'          => 'nullable|date',
        'pendidikan_ibu'             => 'nullable|in:SD/Sederajat,SMP/Sederajat,SMA/Sederajat,D1,D2,D3,D4/S1,S2,S3,Tidak Bersekolah',
        'pekerjaan_ibu'              => 'nullable|in:Tidak Bekerja,Pensiunan,PNS,TNI/Polisi,Guru/Dosen,Pegawai Swasta,Wiraswasta,Pengacara/Jaksa/Hakim/No,Seniman/Pelukis/Artis/Seje,Dokter/Bidan/Perawat,Pilot/Pramugara,Pedagang,Petani/Peternak,Nelayan,Buruh (Tani/Pabrik/Banguna,Sopir/Masinis/Kondektur,Politikus,Lainnya',
        'penghasilan_ibu'            => 'nullable|in:Kurang dari 500.000,500.000 - 1.000.000,1.000.001 - 2.000.000,2.000.001 - 3.000.000,3.000.001 - 5.000.000,Lebih dari 5.000.000,Tidak ada',
        'no_hp_ibu'                  => 'nullable|string|max:20',
        'status_tinggal_ibu'         => 'nullable|in:Beda Dengan Ayah,Sama Dengan Ayah',
        'domisili_ibu'               => 'nullable|in:Dalam Negeri,Luar Negeri',
        'status_tempat_tinggal_ibu'  => 'nullable|in:Milik Sendiri,Rumah Orangtua,Rumah Saudara/Kerabat,Rumah Dinas,Sewa/Kontrak,Lainnya',
        'desa_keluarahan_ibu'        => 'nullable|string|max:255',
        'kecamatan_ibu'              => 'nullable|string|max:255',
        'kab_kota_ibu'               => 'nullable|string|max:255',
        'provinsi_ibu'               => 'nullable|string|max:255',
        'kodepos_ibu'                => 'nullable|string|max:10',

        // Wali
        'nama_wali'                  => 'nullable|string|max:255',
        'status_wali'                => 'nullable|in:Sama Dengan Ayah,Sama Dengan Ibu,Lainnya',
        'kewarganegaraan_wali'       => 'nullable|in:WNI,WNA',
        'nik_wali'                   => 'nullable|string|digits:16',
        'tempat_lahir_wali'          => 'nullable|string|max:255',
        'tanggal_lahir_wali'         => 'nullable|date',
        'pendidikan_wali'            => 'nullable|in:SD/Sederajat,SMP/Sederajat,SMA/Sederajat,D1,D2,D3,D4/S1,S2,S3,Tidak Bersekolah',
        'pekerjaan_wali'             => 'nullable|in:Tidak Bekerja,Pensiunan,PNS,TNI/Polisi,Guru/Dosen,Pegawai Swasta,Wiraswasta,Pengacara/Jaksa/Hakim/No,Seniman/Pelukis/Artis/Seje,Dokter/Bidan/Perawat,Pilot/Pramugara,Pedagang,Petani/Peternak,Nelayan,Buruh (Tani/Pabrik/Banguna,Sopir/Masinis/Kondektur,Politikus,Lainnya',
        'penghasilan_wali'           => 'nullable|in:Kurang dari 500.000,500.000 - 1.000.000,1.000.001 - 2.000.000,2.000.001 - 3.000.000,3.000.001 - 5.000.000,Lebih dari 5.000.000,Tidak ada',
        'no_hp_wali'                 => 'nullable|string|max:20',
        'domisili_wali'              => 'nullable|in:Dalam Negeri,Luar Negeri',
        'status_tempat_tinggal_wali' => 'nullable|in:Milik Sendiri,Rumah Orangtua,Rumah Saudara/Kerabat,Rumah Dinas,Sewa/Kontrak,Lainnya',
        'desa_keluarahan_wali'       => 'nullable|string|max:255',
        'kecamatan_wali'             => 'nullable|string|max:255',
        'kab_kota_wali'              => 'nullable|string|max:255',
        'provinsi_wali'              => 'nullable|string|max:255',
        'kodepos_wali'               => 'nullable|string|max:10',

        'kk'                         => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:10240',
        'akta_kelahiran'             => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:10240',
        'ijazah'                     => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:10240',
        'pakta_integritas'           => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:10240',

        // Status
        'status_daftar'              => 'nullable|in:daftar,diterima,tidak diterima',
        'status'                     => 'nullable|in:aktif,tidak aktif,cuti,lulus',

    ];

    public function index()
    {
        $siswa      = \Auth::user()->siswa;
        $kelasSiswa = $siswa->kelasSiswa;
        return view('siswa.dashboard.index', compact('siswa', 'kelasSiswa'));
    }

    public function edit()
    {
        $siswa          = \Auth::user()->siswa;
        $jenisKelamin   = Helper::getEnumValues('users', 'jenis_kelamin');
        $agama          = Helper::getEnumValues('siswa', 'agama');
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $status         = Helper::getEnumValues('siswa', 'status');
        $kelas          = Kelas::orderBy('angka')->get();
        $kurikulum      = Kurikulum::all();

        $jurusan = Jurusan::all();
        $siswa   = $siswa->load('user');
        return view('siswa.dashboard.edit', compact('siswa', 'agama', 'jenisKelamin', 'tahunPelajaran', 'status', 'kelas', 'kurikulum', 'jurusan'));
    }

    public function update(Request $request)
    {
        try {
            $siswa       = \Auth::user()->siswa;
            $this->rules = array_merge($this->rules, [
                'email' => 'nullable|unique:users,email,' . $siswa->user->id,
                'nis'   => 'nullable|string|max:255|unique:siswa,nis,' . $siswa->id,
                'nisn'  => 'nullable|string|max:255|unique:siswa,nisn,' . $siswa->id,
                'nik'   => 'nullable|string|max:255|unique:siswa,nik,' . $siswa->id,
            ]);

            $dataValidated = $request->validate($this->rules);

            \DB::beginTransaction();

            $user                = $siswa->user;
            $user->name          = $request->nama_siswa;
            $user->email         = $request->email;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->save();

            $umur = $request->tanggal_lahir ? Helper::hitungUmur($request->tanggal_lahir) : null;

            $data = $dataValidated;
            unset($data['email']);

            if ($request->hasFile('foto')) {
                if ($siswa->foto) {
                    Helper::deleteFile($siswa->foto, 'foto_siswa');
                }
                $data['foto'] = Helper::uploadFile($request->file('foto'), $request->nama_siswa, 'foto_siswa');
            }
            if ($request->hasFile('kk')) {
                if ($siswa->kk) {
                    Helper::deleteFile($siswa->kk, 'kk');
                }
                $data['kk'] = Helper::uploadFile($request->file('kk'), $request->nama_siswa, 'kk');
            }
            if ($request->hasFile('akta_kelahiran')) {
                if ($siswa->akta_kelahiran) {
                    Helper::deleteFile($siswa->akta_kelahiran, 'akta_kelahiran');
                }
                $data['akta_kelahiran'] = Helper::uploadFile($request->file('akta_kelahiran'), $request->nama_siswa, 'akta_kelahiran');
            }
            if ($request->hasFile('ijazah')) {
                if ($siswa->ijazah) {
                    Helper::deleteFile($siswa->ijazah, 'ijazah');
                }
                $data['ijazah'] = Helper::uploadFile($request->file('ijazah'), $request->nama_siswa, 'ijazah');
            }
            if ($request->hasFile('pakta_integritas')) {
                if ($siswa->pakta_integritas) {
                    Helper::deleteFile($siswa->pakta_integritas, 'pakta_integritas');
                }
                $data['pakta_integritas'] = Helper::uploadFile($request->file('pakta_integritas'), $request->nama_siswa, 'pakta_integritas');
            }

            $siswa->update($data);
            \DB::commit();
            return redirect()->route('siswa.dashboard.index')->with('success', 'Siswa berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('siswa.dashboard.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('siswa.dashboard.edit')->with('error', $th->getMessage())->withInput();
        }
    }
}
