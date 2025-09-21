<?php
namespace App\Imports;

use App\Models\Jurusan;
use App\Models\Kurikulum;
use App\Models\Role;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class SiswaImport implements ToCollection, WithHeadingRow
{
    private $newData = 0;
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

            $this->newData++;
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

            $unitSekolahId = $this->request['unit_sekolah_id'];
            $role          = Role::where('nama', 'siswa')->first();

            // salin nis lokal ke nis
            $data['nis'] = $row['nis_lokal'];
            unset($data['nis_lokal']);

            // ubah kode jenis kelamin ke label
            $data['jenis_kelamin'] = $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan';

            // random password
            $password = 'password';
            $user     = User::create([
                'username'      => $data['nis'] ?? null,
                'name'          => $data['nama_siswa'],
                'email'         => $data['email'] ?? null,
                'password'      => Hash::make($password),
                'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
                'role_id'       => $role->id,
            ]);

            unset($data['email']);
            unset($data['jurusan']);

            $jurusan = Jurusan::firstOrCreate(
                ['kode_jurusan' => 'MIPA'], // cari berdasarkan kode_jurusan
                [
                    'unit_sekolah_id' => $unitSekolahId,
                    'nama_jurusan'    => 'Matematika',
                    'kuota'           => 1000,
                    'status'          => 'aktif',
                ]
            );

            $data['jurusan_id'] = $jurusan->id;
            $data['user_id']    = $user->id;

            $data['kab_kota'] = $row['kabupaten_kota'];
            unset($data['kabupaten_kota']);

            $data['tahun_pelajaran_id'] = TahunPelajaran::where('status', 'aktif')->first()->id;
            $data['kurikulum_id']       = Kurikulum::where('unit_sekolah_id', $this->request['unit_sekolah_id'])->latest()->first()->id;

            Siswa::create($data);

            $this->total++;
        }

    }

    public function getResponse()
    {
        return "$this->newData data baru dari $this->total total data";
    }
}
