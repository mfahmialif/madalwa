<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;
    protected $table   = "mutasi";
    protected $guarded = [];
    public function siswa(){
        return $this->belongsTo(Siswa::class);
    }

   


}
