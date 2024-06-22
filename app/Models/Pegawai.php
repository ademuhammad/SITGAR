<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $fillable = [
        'nip',
        'name',
        'jabatan',
        'golongan',
        'opd_id',
    ];
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
    public function temuans()
    {
        return $this->hasMany(Temuan::class);
    }
}
