<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table   = 'jurusan';
    protected $guarded = [];


    public function kelasSub()
    {
        return $this->hasMany(KelasSub::class, 'jurusan_id');
    }

    public function unitSekolah()
    {
        return $this->belongsTo(UnitSekolah::class, 'unit_sekolah_id');
    }
}
