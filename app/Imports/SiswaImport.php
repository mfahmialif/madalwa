<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Kurikulum;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Models\UnitSekolah;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class SiswaImport implements ToModel,WithStartRow
{
    private $no = 2;
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        // user create
        $this->no;
        $user = new User();
        $user->username      = $row[0];
        $user->name          = $row[0];
        $user->email         = $row[1];
        $user->role_id       = 4;
        $user->password      = Hash::make('123456');
        $user->jenis_kelamin = $row[8];
        $user->save();

        $unit = UnitSekolah::where('nama_unit', $row[2])->first();
        $kelas = Kelas::where('angka', $row[3])->where('unit_sekolah_id', $unit->id)->first();
        $tahun = TahunPelajaran::where('kode', $row[4])->first();
        $kurikulum = Kurikulum::where('tahun_pelajaran_id', $tahun->id)->first();

        if (!$unit) {
            throw new Exception("Baris ke {$this->no} unit sekolah tidak ditemukan");
        }
        if (!$kelas) {
            throw new Exception("Baris ke {$this->no} Kelas tidak ditemukan");
        }
        if (!$tahun) {
            throw new Exception("Baris ke {$this->no} tahun ajaran tidak ditemukan");
        }
        if (!$kurikulum) {
            throw new Exception("Baris ke {$this->no} kurikulum tidak ditemukan");
        }


        $siswa = new Siswa();
        $siswa->kelas_id                    = $kelas->id;
        $siswa->tahun_pelajaran_id          = $tahun->id;
        $siswa->user_id                     = $user->id;
        $siswa->kurikulum_id                = $kurikulum->id;
        $siswa->nis                         = $row[6] ?? null;
        $siswa->nisn                        = $row[7] ?? null;
        $siswa->nama_siswa                  = $row[0];
        $siswa->jenis_kelamin               = $row[8];
        $siswa->tempat_lahir                = $row[9];
        $siswa->tanggal_lahir               = self::parseTanggal($row[10]);
        $siswa->agama                       = $row[11];
        $siswa->nik_anak                    = $row[12] ?? null;
        $siswa->kk                          = $row[13] ?? null;
        $siswa->no_registrasi_akta_lahir    = $row[14] ?? null;
        $siswa->anak_ke                     = $row[15] ?? null;
        $siswa->jumlah_saudara_kandung      = $row[16] ?? null;
        $siswa->umur_anak                   = $row[17] ?? null;
        $siswa->masuk_sekolah_sebagai       = $row[18] ?? null;
        $siswa->asal_sekolah_tk             = $row[19] ?? null;
        $siswa->tinggi_badan                = $row[20] ?? null;
        $siswa->berat_badan                 = $row[21] ?? null;
        $siswa->lingkar_kepala              = $row[22] ?? null;
        $siswa->jarak_tempuh_ke_sekolah     = $row[23] ?? null;
        $siswa->gol_darah                   = $row[24] ?? null;
        $siswa->alamat_anak_sesuai_kk       = $row[25] ?? null;
        $siswa->desa_kelurahan_anak         = $row[26] ?? null;
        $siswa->kecamatan_anak              = $row[27] ?? null;
        $siswa->kabupaten_anak              = $row[28] ?? null;
        $siswa->kode_pos_anak               = $row[29] ?? null;
        $siswa->rt_anak                     = $row[30] ?? null;
        $siswa->rw_anak                     = $row[31] ?? null;
        $siswa->lintang                     = $row[32] ?? null;
        $siswa->bujur                       = $row[33] ?? null;
        $siswa->nama_ayah                   = $row[34] ?? null;
        $siswa->nik_ayah                    = $row[35] ?? null;
        $siswa->tahun_lahir_ayah            = $row[36] ?? null;
        $siswa->pendidikan_ayah             = $row[37] ?? null;
        $siswa->pekerjaan_ayah              = $row[38] ?? null;
        $siswa->penghasilan_bulanan_ayah    = $row[39] ?? null;
        $siswa->nama_ibu_sesuai_ktp         = $row[40] ?? null;
        $siswa->nik_ibu                     = $row[41] ?? null;
        $siswa->tahun_lahir_ibu             = $row[42] ?? null;
        $siswa->pendidikan_ibu              = $row[43] ?? null;
        $siswa->pekerjaan_ibu               = $row[44] ?? null;
        $siswa->penghasilan_bulanan_ibu     = $row[45] ?? null;
        $siswa->alamat_ortu_sesuai_kk       = $row[46] ?? null;
        $siswa->kelurahan_ortu              = $row[47] ?? null;
        $siswa->kecamatan_ortu              = $row[48] ?? null;
        $siswa->kabupaten_ortu              = $row[49] ?? null;
        $siswa->no_kartu_keluarga           = $row[50] ?? null;
        $siswa->tinggal_bersama             = $row[51] ?? null;
        $siswa->transportasi_ke_sekolah     = $row[52] ?? null;
        $siswa->nomor_telepon_orang_tua     = $row[53] ?? null;
        $siswa->nama_wali                   = $row[54] ?? null;
        $siswa->nik_wali                    = $row[55] ?? null;
        $siswa->tahun_lahir_wali            = $row[56] ?? null;
        $siswa->pendidikan_wali             = $row[57] ?? null;
        $siswa->pekerjaan_wali              = $row[58] ?? null;
        $siswa->penghasilan_bulanan_wali    = $row[59] ?? null;
        $siswa->alamat_wali                 = $row[60] ?? null;
        $siswa->rt_wali                     = $row[61] ?? null;
        $siswa->rw_wali                     = $row[62] ?? null;
        $siswa->desa_kelurahan_wali         = $row[63] ?? null;
        $siswa->kecamatan_wali              = $row[64] ?? null;
        $siswa->kabupaten_wali              = $row[65] ?? null;
        $siswa->kode_pos_wali               = $row[66] ?? null;
        $siswa->nomor_telepon_wali          = $row[67] ?? null;
        $siswa->status_daftar               = $row[68];
        $siswa->status                      = $row[69];
        $siswa->save();
    }
     private function parseTanggal($value): ?string
    {
        if (empty($value)) return null;

        // Jika berupa angka serial Excel
        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($value))
                ->format('Y-m-d');
        }

        // Jika berupa string (contoh: 17-08-2020, 17/08/2020, 17 agustus 2020)
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null; // kalau gagal parsing, simpan NULL
        }
    }
}
