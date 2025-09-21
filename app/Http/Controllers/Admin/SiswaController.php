<?php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Jurusan;
use App\Models\Kurikulum;
use App\Models\NilaiDetail;
use App\Models\UnitSekolah;
use Illuminate\Http\Request;
use App\Http\Services\Helper;
use App\Models\KomponenNilai;
use App\Models\TahunPelajaran;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    protected $rules = [
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
        return view('admin.siswa.index', compact('jenisKelamin', 'tahunPelajaran', 'status', 'unitSekolah'));
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Siswa::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'siswa.tahun_pelajaran_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->where('status_daftar', 'diterima')
            ->when(Auth::user()->role->nama_unit == 'unit sekolah', function ($query) {
                $query->where('kelas.unit_sekolah_id', Auth::user()->unitSekolah->unit_sekolah_id);
            })
            ->select('siswa.*', 'tahun_pelajaran.kode as tahun_pelajaran_kode', 'kelas.angka as kelas_angka');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->when($request->tahun_pelajaran_id, function ($q) use ($request) {
                    $q->where('siswa.tahun_pelajaran_id', $request->tahun_pelajaran_id);
                });
                $query->when($request->unit_sekolah_id, function ($q) use ($request) {
                    $q->whereHas('kelas', function ($q) use ($request) {
                        $q->where('kelas.unit_sekolah_id', $request->unit_sekolah_id);
                    });
                });
                $query->when($request->jenis_kelamin, function ($q) use ($request) {
                    $q->where('siswa.jenis_kelamin', $request->jenis_kelamin);
                });
                $query->when($request->kelas_id, function ($q) use ($request) {
                    $q->where('siswa.kelas_id', $request->kelas_id);
                });
                $query->where(function ($query) use ($search) {
                    $query->orWhere('siswa.nama_siswa', 'LIKE', "%$search%");
                    $query->orWhere('siswa.jenis_kelamin', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nis', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nisn', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nik', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama_siswa', function ($row) {
                $row->foto = $row->foto ? asset('foto_siswa/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Siswa" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <a href="' . route("admin.siswa.edit", $row) . '">' . $row->nama_siswa . '</a><br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>NISN: ' . ($row->nisn ?? '-') . '</small><br>
                            <small>Kelas: ' . ($row->kelas_sekarang ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->editColumn('status', function ($row) {
                return '<span class="badge bg-' . Helper::getColorStatus($row->status) . '">' . strtoupper($row->status) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.siswa.show", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Tampilkan</a>
                            <a class="dropdown-item" href="' . route("admin.siswa.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="nama" value="' . $row->nama . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'nama_siswa', 'status'])
            ->toJson();
    }

    // public function add()
    // {
    //     $jenisKelamin   = Helper::getEnumValues('users', 'jenis_kelamin');
    //     $agama          = Helper::getEnumValues('siswa', 'agama');
    //     $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
    //     $status         = Helper::getEnumValues('siswa', 'status');
    //     return view('admin.siswa.add', compact('jenisKelamin', 'agama', 'tahunPelajaran', 'status'));
    // }

    public function edit(Siswa $siswa)
    {
        $jenisKelamin   = Helper::getEnumValues('users', 'jenis_kelamin');
        $agama          = Helper::getEnumValues('siswa', 'agama');
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $status         = Helper::getEnumValues('siswa', 'status');
        $kelas          = Kelas::orderBy('angka')->get();
        $kurikulum      = Kurikulum::all();

        $jurusan = Jurusan::when(\Auth::user()->role->nama == 'unit sekolah', function ($q) {
            $q->where('unit_sekolah_id', \Auth::user()->unitSekolah->unit_sekolah_id);
        })->get();

        $siswa = $siswa->load('user');
        return view('admin.siswa.edit', compact('siswa', 'agama', 'jenisKelamin', 'tahunPelajaran', 'status', 'kelas', 'kurikulum', 'jurusan'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        try {
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
            return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.siswa.edit', ['siswa' => $siswa])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('admin.siswa.edit', ['siswa' => $siswa])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Siswa $siswa)
    {
        try {
            if ($siswa->foto) {
                Helper::deleteFile($siswa->foto, 'foto');
            }
            if ($siswa->akta_lahir_path) {
                Helper::deleteFile($siswa->akta_lahir_path, 'akta_lahir_path');
            }

            $siswa->delete();
            $siswa->user()->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Siswa berhasil dihapus',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $validated = $request->validate([
                'siswa_id'   => 'required|array',
                'siswa_id.*' => 'integer|exists:siswa,id', // pastikan setiap id valid
                'status'     => 'required|string',         // tambahkan validasi untuk status
            ]);

            Siswa::whereIn('id', $validated['siswa_id'])
                ->update([
                    'status' => $validated['status'],
                ]);

            return response()->json([
                'status'  => true,
                'message' => 'Berhasil mengupdate status',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 422,
                'errors'  => $e->errors(), // kirim array error lengkap
                'req'     => $request->all(),
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
                'request' => $request->all(),
            ], 500);
        }
    }

    public function show(Siswa $siswa)
    {
        $kelasSiswa = $siswa->kelasSiswa;
        return view('admin.siswa.show', compact('siswa', 'kelasSiswa'));
    }

    public function absensi(Siswa $siswa, Jadwal $jadwal)
    {
        $absensi = $jadwal->absensi;
        $color   = [
            'hadir'       => 'success',
            'izin'        => 'warning',
            'sakit'       => 'info',
            'alpha'       => 'danger',
            'Belum Absen' => 'secondary',
        ];
        return view('admin.siswa.absensi', compact('siswa', 'jadwal', 'absensi', 'color'));
    }

    public function nilai(Siswa $siswa, Jadwal $jadwal)
    {
        $jenis         = Helper::getEnumValues('komponen_nilai', 'jenis');
        $komponenNilai = KomponenNilai::orderBy('jenis', 'asc')->get();
        $nilai         = Nilai::where('siswa_id', $siswa->id)->where('jadwal_id', $jadwal->id)->get()->keyBy('jenis');
        $nilaiDetail   = NilaiDetail::join('komponen_nilai', 'komponen_nilai.id', '=', 'nilai_detail.komponen_nilai_id', )
            ->where('nilai_detail.siswa_id', $siswa->id)
            ->where('nilai_detail.jadwal_id', $jadwal->id)
            ->select('nilai_detail.*', 'komponen_nilai.nama as komponen_nilai_nama', 'komponen_nilai.jenis as komponen_nilai_jenis')
            ->get();

        $dataNilaiDetail = [];
        foreach ($nilaiDetail as $key => $value) {
            $dataNilaiDetail[$value->komponen_nilai_jenis][$value->komponen_nilai_id] = $value;
        }

        $dataNilai = [];
        foreach ($jenis as $value) {
            if ($value !== "sikap") {
                $dataNilai[$value]["nilai_akhir"] = $nilai[$value]->nilai_akhir ?? 0;
            }
            $dataNilai[$value]["nilai_detail"] = $komponenNilai->where('jenis', $value)->map(function ($item) use ($dataNilaiDetail, $value) {
                return [
                    'komponen_nilai_nama' => $item->nama,
                    'nilai'               => $dataNilaiDetail[$value][$item->id]->nilai ?? 0,
                ];
            });
        }
        return view('admin.siswa.nilai', compact('siswa', 'jadwal', 'nilai', 'jenis', 'dataNilai'));
    }
}
