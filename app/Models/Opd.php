<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;
    protected $fillable = [
        'opd_name',
        'description',
    ] ;
    public function temuans()
    {
        return $this->hasMany(Temuan::class);
    }
    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }
}
