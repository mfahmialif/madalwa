<?php

namespace App\Imports;
use App\Models\Kurikulum;
use App\Models\TahunPelajaran;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KurikulumImport implements ToModel,WithStartRow
{
    private $no = 2;
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        $this->no;
        $tahun = TahunPelajaran::where('kode',$row[1])->first();
        if (!$tahun) {
            throw new Exception("Baris ke {$this->no} tahun ajaran tidak ditemukan");
            
        }

        $kurikulum                     = new Kurikulum();
        $kurikulum->nama               = $row[0];
        $kurikulum->tahun_pelajaran_id = $tahun->id;
        $kurikulum->save(); 

    }
}
