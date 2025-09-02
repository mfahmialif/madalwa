<?php

namespace App\Imports;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\KelasSub;
use App\Models\TahunPelajaran;
use App\Models\UnitSekolah;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KelasImport implements ToModel,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $no = 2;
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        $this->no;
        Log::info("tahun ajaran ".$row[2]);
        $tahun   = TahunPelajaran::where('kode',$row[2])->first();
        $jurusan = Jurusan::where('nama_jurusan',$row[3])->first();
        $unit = UnitSekolah::where('nama_unit',$row[1])->first();

         if (!$tahun) {
            throw new Exception("Baris ke {$this->no} tahun ajaran {$row[2]} tidak ditemukan");
        }

        if (!$jurusan) {
            throw new Exception("Baris ke {$this->no} Jurusan {$row[3]} tidak ditemukan");
        }

        if (!$unit) {
            throw new Exception("Baris ke {$this->no} Unit sekolah {$row[1]} tidak ditemukan");
        }

        if ($row[0] == 10) {
            $romawi     = 'X';
            $keterangan = 'Kelas 10 ';
        }elseif ($row[0] == 11) {
             $romawi     = 'XI';
             $keterangan = 'Kelas 11 ';
        }else {
             $romawi = 'XII';
             $keterangan ='Kelas 12 ';
        }

        $kelas = Kelas::where('unit_sekolah_id',$unit->id)->where('angka',$row[0])->first();
        if (!$kelas) {
            $kelas = new Kelas();
        }

        $kelas->unit_sekolah_id = $unit->id;
        $kelas->angka           = $row[0];
        $kelas->romawi          = $romawi;
        $kelas->keterangan      = $keterangan;
        $kelas->save();

        $kelasSub = KelasSub::where('kelas_id',$kelas->id)->where('sub',$row[4])->first();
        if (!$kelasSub) {
           $kelasSub                       = new KelasSub();
        }
        
        $kelasSub->kelas_id             = $kelas->id;
        $kelasSub->jurusan_id           = $jurusan->id;
        $kelasSub->tahun_pelajaran_id   = $tahun->id;
        $kelasSub->sub                  = $row[4];
        $kelasSub->keterangan           = $keterangan.$row[4];
        $kelasSub->save();

    }
}
