<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;
    protected $table   = "kurikulum";
    protected $guarded = [];

    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function detail()
    {
        return $this->hasMany(KurikulumDetail::class);
    }

    public function unitSekolah()
    {
        return $this->belongsTo(UnitSekolah::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kurikulum_id', 'id');
    }
}
