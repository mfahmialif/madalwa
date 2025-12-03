<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Mutasi;
use App\Models\Jurusan;
use App\Models\KelasSub;
use App\Models\KelasWali;
use App\Models\Kurikulum;
use App\Models\KelasSiswa;
use App\Models\UnitSekolah;
use Illuminate\Http\Request;
use App\Http\Services\Helper;
use App\Models\TahunPelajaran;
use Illuminate\Validation\Rule;
use App\Models\Role as ModelsRole;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class MutasiMasukController extends Controller
{
    protected $rules = [

        'tgl_mutasi'                 => 'required|date',
        'sekolah_tujuan'             => 'required|string|max:255',
        'alasan_mutasi'              => 'nullable|string|max:255',
        'no_surat'                   => 'required|string|max:255',

        'kurikulum_id'               => 'required|exists:kurikulum,id',
        'kelas_id'                   => 'nullable|exists:kelas,id',
        'tahun_pelajaran_id'         => 'required|exists:tahun_pelajaran,id',
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

        'no_kk'                      => 'nullable|string|max:255',
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

        // Status
        'status_daftar'              => 'nullable|in:daftar,diterima,tidak diterima',
        'status'                     => 'nullable|in:aktif,tidak aktif,cuti,lulus',
    ];

    public function index()
    {
        $jenisKelamin   = Helper::getEnumValues('siswa', 'jenis_kelamin');
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $status         = Helper::getEnumValues('siswa', 'status');
        $unitSekolah    = UnitSekolah::all();
        return view('admin.mutasi-masuk.index', compact('jenisKelamin', 'tahunPelajaran', 'status', 'unitSekolah'));
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data = Mutasi::join('siswa', 'mutasi.siswa_id', '=', 'siswa.id')
            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->where('mutasi.jenis', 'masuk')
            ->when(Auth::user()->role->nama_unit == 'unit sekolah', function ($query) {
                $query->where('kelas.unit_sekolah_id', Auth::user()->unitSekolah->unit_sekolah_id);
            })
            ->select([
                'mutasi.*',
                'siswa.nama_siswa',
                'siswa.alamat_anak_sesuai_kk',
                'siswa.foto',
                'siswa.nis',
                'siswa.nisn',
                'siswa.status_daftar',
                'siswa.jenis_kelamin',
            ]);
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('siswa.nama_siswa', 'LIKE', "%$search%");
                    $query->orWhere('siswa.alamat_anak_sesuai_kk', 'LIKE', "%$search%");
                    $query->orWhere('no_surat', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama_siswa', function ($row) {
                $row->foto = $row->foto ? asset('foto_siswa/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Siswa" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <a href="' . route("admin.mutasi-masuk.edit", $row) . '">' . $row->nama_siswa . '</a><br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>NISN: ' . ($row->nisn ?? '-') . '</small><br>
                            <small>Kelas: ' . ($row->siswa->kelas_sekarang ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->editColumn('status_daftar', function ($row) {
                return '<span class="badge bg-' . Helper::getColorStatus($row->status_daftar) . '">' . strtoupper($row->status_daftar) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.mutasi-masuk.edit", $row->id) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="name" value="' . $row->siswa->nama_siswa . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'nama_siswa', 'status_daftar'])
            ->toJson();
    }

    public function add()
    {
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $kelas          = Kelas::when(\Auth::user()->role->nama == 'unit sekolah', function ($q) {
            $q->where('unit_sekolah_id', \Auth::user()->unitSekolah->unit_sekolah_id);
        })->orderBy('angka')->get();
        $kurikulum = Kurikulum::all();

        $jurusan = Jurusan::when(\Auth::user()->role->nama == 'unit sekolah', function ($q) {
            $q->where('unit_sekolah_id', \Auth::user()->unitSekolah->unit_sekolah_id);
        })->get();

        return view('admin.mutasi-masuk.add', compact('tahunPelajaran', 'kelas', 'kurikulum', 'jurusan'));
    }

    public function store(Request $request)
    {
        try {
            $dataValidated = $request->validate($this->rules);

            \DB::beginTransaction();
            $role = Role::where('nama', 'siswa')->first();

            //random password
            $password = 'password';
            $user     = User::create([
                'username'      => $request->nis,
                'name'          => $request->nama_siswa,
                'email'         => $request->email,
                'password'      => Hash::make($password),
                'jenis_kelamin' => $request->jenis_kelamin,
                'role_id'       => $role->id,
            ]);

            $umur = $request->tanggal_lahir ? Helper::hitungUmur($request->tanggal_lahir) : null;

            $data = $dataValidated;
            unset($data['email']);
            unset($data['tgl_mutasi']);
            unset($data['sekolah_tujuan']);
            unset($data['alasan_mutasi']);
            unset($data['no_surat']);

            $data['user_id'] = $user->id;

            if ($request->hasFile('foto')) {
                $data["foto"] = Helper::uploadFile($request->file('foto'), $request->nama_siswa, 'foto_siswa');
            }
            if ($request->hasFile('kk')) {
                $data['kk'] = Helper::uploadFile($request->file('kk'), $request->nama_siswa, 'kk');
            }
            if ($request->hasFile('akta_kelahiran')) {
                $data['akta_kelahiran'] = Helper::uploadFile($request->file('akta_kelahiran'), $request->nama_siswa, 'akta_kelahiran');
            }
            if ($request->hasFile('ijazah')) {
                $data['ijazah'] = Helper::uploadFile($request->file('ijazah'), $request->nama_siswa, 'ijazah');
            }
            if ($request->hasFile('pakta_integritas')) {
                $data['pakta_integritas'] = Helper::uploadFile($request->file('pakta_integritas'), $request->nama_siswa, 'pakta_integritas');
            }

            $data['status_daftar'] = 'diterima';
            $siswa = Siswa::create($data);

            \DB::commit();

            $mutasi = new Mutasi();
            $mutasi->no_surat = $request->no_surat;
            $mutasi->siswa_id = $siswa->id;
            $mutasi->tgl_mutasi = $request->tgl_mutasi;
            $mutasi->alasan_mutasi = $request->alasan_mutasi;
            $mutasi->sekolah_tujuan = $request->sekolah_tujuan;
            $mutasi->jenis      = 'masuk';
            $mutasi->save();
            DB::commit();
            return redirect()->route('admin.mutasi-masuk.index')->with('success', 'Mutasi Masuk berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return redirect()->route('admin.mutasi-masuk.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('admin.mutasi-masuk.add')->with('error', $th->getMessage())->withInput();
        }
    }

    public function edit(Mutasi $mutasi)
    {
        $jenisKelamin   = Helper::getEnumValues('users', 'jenis_kelamin');
        $agama          = Helper::getEnumValues('siswa', 'agama');
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $statusDaftar   = Helper::getEnumValues('siswa', 'status_daftar');
        $kelas          = Kelas::when(\Auth::user()->role->nama == 'unit sekolah', function ($q) {
            $q->where('unit_sekolah_id', \Auth::user()->unitSekolah->unit_sekolah_id);
        })->orderBy('angka')->get();
        $kurikulum = Kurikulum::all();

        $siswa = $mutasi->siswa;
        $siswa = $siswa->load('user');

        $jurusan = Jurusan::when(\Auth::user()->role->nama == 'unit sekolah', function ($q) {
            $q->where('unit_sekolah_id', \Auth::user()->unitSekolah->unit_sekolah_id);
        })->get();

        return view('admin.mutasi-masuk.edit', compact(
            'siswa',
            'mutasi',
            'kelas',
            'agama',
            'kurikulum',
            'jenisKelamin',
            'statusDaftar',
            'tahunPelajaran',
            'jurusan'
        ));
    }

    public function update(Request $request, Mutasi $mutasi)
    {
        try {
            $siswa = $mutasi->siswa;
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
            unset($data['tgl_mutasi']);
            unset($data['sekolah_tujuan']);
            unset($data['alasan_mutasi']);
            unset($data['no_surat']);

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

            $mutasi->no_surat = $request->no_surat;
            $mutasi->tgl_mutasi = $request->tgl_mutasi;
            $mutasi->alasan_mutasi = $request->alasan_mutasi;
            $mutasi->sekolah_tujuan = $request->sekolah_tujuan;
            $mutasi->save();

            \DB::commit();
            return redirect()->route('admin.mutasi-masuk.index')->with('success', 'Mutasi Masuk berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.mutasi-masuk.edit', ['mutasi' => $mutasi->id])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('admin.mutasi-masuk.edit', ['mutasi' => $mutasi->id])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Mutasi $mutasi)
    {
        try {
            $siswa = $mutasi->siswa;
            $siswa->delete();
            $mutasi->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Mutasi berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Mutasi Masuk tidak dapat dihapus karena masih digunakan oleh user.',
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
