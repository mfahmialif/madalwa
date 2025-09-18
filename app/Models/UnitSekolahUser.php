<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitSekolahUser extends Model
{
    use HasFactory;
    protected $table   = 'unit_sekolah_user';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function unitSekolah()
    {
        return $this->belongsTo(UnitSekolah::class);
    }

}
