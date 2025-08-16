<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitSekolah extends Model
{
    use HasFactory;

    protected $table   = 'unit_sekolah';
    protected $guarded = [];


    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'kelas_id');
    }
}
