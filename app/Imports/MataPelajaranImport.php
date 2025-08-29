<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\UnitSekolah;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MataPelajaranImport implements ToModel,WithStartRow
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
        $unit = UnitSekolah::where('nama_unit', $row[4])->first();
        if (!$unit) {
            throw new Exception("Baris ke {$this->no} unit sekolah {$row[4]} tidak ditemukan");
        }
        $kelas = Kelas::where('unit_sekolah_id', $unit->id)->where('angka', $row[3])->first();

        if (!$kelas) {
            throw new Exception("Baris ke {$this->no} kelas {$row[3]} tidak ditemukan di unit {$unit->nama_unit}");
        }
       
        // Log::info("idnya kelas ". $kelas->id);
        $mataPelajaran = new MataPelajaran();
        $mataPelajaran->kelas_id = $kelas->id;
        $mataPelajaran->nama     = $row[1];
        $mataPelajaran->kode     = $row[2];
        $mataPelajaran->save();
    }
}
