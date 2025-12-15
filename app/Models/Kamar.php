<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';
    protected $guarded = [];

    public function unitSekolah()
    {
        return $this->belongsTo(UnitSekolah::class, 'unit_sekolah_id');
    }

    public function kamarSiswa()
    {
        return $this->hasMany(KamarSiswa::class, 'kamar_id');
    }

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'kamar_siswa', 'kamar_id', 'siswa_id')
            ->withPivot('kelas_id', 'tahun_pelajaran_id', 'keterangan')
            ->withTimestamps();
    }
}
