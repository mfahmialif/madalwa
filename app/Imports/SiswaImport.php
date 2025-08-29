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
        $siswa->nis                         = $row[6];
        $siswa->nisn                        = $row[7];
        $siswa->nama_siswa                  = $row[0];
        $siswa->jenis_kelamin               = $row[8];
        $siswa->tempat_lahir                = $row[9];
        $siswa->tanggal_lahir               = $row[10];
        $siswa->agama                       = $row[11];
        $siswa->nik_anak                    = $row[12];
        $siswa->kk                          = $row[13];
        $siswa->no_registrasi_akta_lahir    = $row[14];
        $siswa->anak_ke                     = $row[15];
        $siswa->jumlah_saudara_kandung      = $row[16];
        $siswa->umur_anak                   = $row[17];
        $siswa->masuk_sekolah_sebagai       = $row[18];
        $siswa->asal_sekolah_tk             = $row[19];
        $siswa->tinggi_badan                = $row[20];
        $siswa->berat_badan                 = $row[21];
        $siswa->lingkar_kepala              = $row[22];
        $siswa->jarak_tempuh_kesekolah      = $row[23];
        $siswa->gol_darah                   = $row[24];
        $siswa->alamat_anak_sesuai_kk       = $row[25];
        $siswa->desa_kelurahan_anak         = $row[26];
        $siswa->kecamatan_anak              = $row[27];
        $siswa->kabupaten_anak              = $row[28];
        $siswa->kode_pos_anak               = $row[29];
        $siswa->rt_anak                     = $row[30];
        $siswa->rw_anak                     = $row[31];
        $siswa->lintang                     = $row[32];
        $siswa->bujur                       = $row[33];
        $siswa->nama_ayah                   = $row[34];
        $siswa->nik_ayah                    = $row[35];
        $siswa->tahun_lahir_ayah            = $row[36];
        $siswa->pendidikan_ayah             = $row[37];
        $siswa->pekerjaan_ayah              = $row[38];
        $siswa->penghasilan_bulanan_ayah    = $row[39];
        $siswa->nama_ibu_sesuai_ktp         = $row[40];
        $siswa->nik_ibu                     = $row[41];
        $siswa->tahun_lahir_ibu             = $row[42];
        $siswa->pendidikan_ibu              = $row[43];
        $siswa->pekerjaan_ibu               = $row[44];
        $siswa->penghasilan_bulanan_ibu     = $row[45];
        $siswa->alamat_ortu_sesuai_kk       = $row[46];
        $siswa->kelurahan_ortu              = $row[47];
        $siswa->kecamatan_ortu              = $row[48];
        $siswa->kabupaten_ortu              = $row[49];
        $siswa->no_kartu_keluarga           = $row[50];
        $siswa->tinggal_bersama             = $row[51];
        $siswa->transportasi_ke_sekolah     = $row[52];
        $siswa->no_telepon_orang_tua        = $row[53];
        $siswa->nama_wali                   = $row[54];
        $siswa->nik_wali                    = $row[55];
        $siswa->tahun_lahir_wali            = $row[56];
        $siswa->pendidikan_wali             = $row[57];
        $siswa->pekerjaan_wali              = $row[58];
        $siswa->penghasilan_bulanan_wali    = $row[59];
        $siswa->alamat_wali                 = $row[60];
        $siswa->rt_wali                     = $row[61];
        $siswa->rw_wali                     = $row[62];
        $siswa->desa_kelurahan_wali         = $row[63];
        $siswa->kecamatan_wali              = $row[64];
        $siswa->kabupaten_wali              = $row[65];
        $siswa->kode_pos_wali               = $row[66];
        $siswa->no_telepon_wali             = $row[67];
        $siswa->status_daftar               = $row[68];
        $siswa->status                      = $row[69];
        $siswa->save();
    }
}
