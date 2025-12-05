<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Kurikulum;
use App\Models\TahunPelajaran;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class SiswaImport implements ToCollection, WithHeadingRow
{
    private $newData = 0;
    private $updateData = 0;
    private $total   = 0;
    private $request;

    public function __construct($request)
    {
        HeadingRowFormatter::extend('simple_snake', function ($value) {
            // jadikan lowercase
            $value = strtolower($value);
            // ganti semua selain huruf/angka jadi spasi
            $value = preg_replace('/[^a-z0-9]+/i', ' ', $value);
            // trim spasi di ujung
            $value = trim($value);
            // ganti spasi jadi underscore
            $value = preg_replace('/\s+/', '_', $value);
            return $value;
        });

        HeadingRowFormatter::default('simple_snake');

        $this->request = $request;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $data = $row->toArray();

            if (isset($data['nama_siswa']) == false || $data['nama_siswa'] == null) {
                continue;
            }

            unset($data['no']); // hapus kolom no

            $data['tanggal_lahir'] = $data['tanggal_lahir_yyyy_mm_dd'];
            unset($data['tanggal_lahir_yyyy_mm_dd']);
            $data['tanggal_lahir_ayah'] = $data['tanggal_lahir_ayah_yyyy_mm_dd'];
            unset($data['tanggal_lahir_ayah_yyyy_mm_dd']);
            $data['tanggal_lahir_ibu'] = $data['tanggal_lahir_ibu_yyyy_mm_dd'];
            unset($data['tanggal_lahir_ibu_yyyy_mm_dd']);
            $data['kewarganegaraan_wali'] = $data['warga_wali'];
            unset($data['warga_wali']);

            $role          = Role::where('nama', 'siswa')->first();

            // salin nis lokal ke nis
            $data['nis'] = $row['nis_lokal'];
            unset($data['nis_lokal']);

            // ubah kode jenis kelamin ke label
            $data['jenis_kelamin'] = $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan';

            $jurusanKode = $data['jurusan'];
            unset($data['jurusan']);

            $jurusan = Jurusan::where('kode_jurusan', $jurusanKode)->first();

            if (!$jurusan) {
                throw new \Exception('Tidak Ditemukan Jurusan '.$jurusanKode);
            }

            $data['jurusan_id'] = $jurusan->id;

            $data['kab_kota'] = $row['kabupaten_kota'];
            unset($data['kabupaten_kota']);

            $data['tahun_pelajaran_id'] = @TahunPelajaran::where('kode', $data['tahun_pelajaran'])->first()->id;
            if (!@$data['tahun_pelajaran_id']) {
                throw new \Exception('Tidak Ditemukan Tahun Pelajaran');
            }
            unset($data['tahun_pelajaran']);
            $data['kurikulum_id']       = @Kurikulum::where('unit_sekolah_id', $jurusan->unit_sekolah_id)
                ->where('kode', $data['kurikulum'])->first()->id;
            if (!@$data['kurikulum_id']) {
                throw new \Exception('Tidak Ditemukan Kurikulum - ' . $jurusan->unitSekolah->nama_unit . ' - ' . $data['tahun_pelajaran'] . ' - ' . $data['kurikulum']);
            }
            unset($data['kurikulum']);
            $data['kelas_id'] = @Kelas::where('unit_sekolah_id', $jurusan->unit_sekolah_id)
                ->where('angka', $data['kelas'])->first()->id;
            if (!@$data['kelas_id']) {
                throw new \Exception('Tidak Ditemukan Kelas - ' . $jurusan->unitSekolah->nama_unit . ' - ' . $data['tahun_pelajaran'] . ' - ' . $data['kelas']);
            }
            unset($data['kelas']);
            $data['status_daftar'] = 'diterima';
            $siswa = Siswa::where('nis', $data['nis'])->first();
            if ($siswa) {
                unset($data['email']);
                $siswa->update($data);
                $this->updateData++;
            } else {
                $password = 'password';
                $user     = User::create([
                    'username'      => $data['nis'] ?? null,
                    'name'          => $data['nama_siswa'],
                    'email'         => $data['email'] ?? null,
                    'password'      => Hash::make($password),
                    'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
                    'role_id'       => $role->id,
                ]);
                $data['user_id']    = $user->id;
                unset($data['email']);

                Siswa::create($data);

                $this->newData++;
            }

            $this->total++;
        }
    }

    public function getResponse()
    {
        return "$this->newData data baru, $this->updateData data diperbarui dari $this->total total data";
    }
}
