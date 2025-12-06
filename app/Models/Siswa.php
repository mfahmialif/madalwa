<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table   = 'siswa';
    protected $guarded = [];
    protected $appends = ['kelas_sekarang'];

    public function getKelasSekarangAttribute()
    {
        // get last kelasSiswa
        $kelasSiswa = $this->kelasSiswa()->orderBy('id', 'desc')->first();
        $kelas      = $this->kelas;
        $jurusan    = $this->jurusan;
        $unitSekolah = $kelas->unitSekolah;

        $response   = $kelasSiswa ? $kelas->angka .' '.$kelasSiswa->kelasSub->sub." - $unitSekolah->nama_unit - $jurusan->nama_jurusan" :
            "$kelas->angka - $unitSekolah->nama_unit - $jurusan->nama_jurusan";
        return $response;
    }

    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'siswa_id');
    }

    public function absensiDetail()
    {
        return $this->hasMany(AbsensiDetail::class, 'siswa_id');
    }

    public function nilaiDetail()
    {
        return $this->hasMany(NilaiDetail::class, 'siswa_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }
    public function mutasi()
    {
        return $this->hasMany(Mutasi::class);
    }
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
