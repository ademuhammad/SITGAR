<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyedia extends Model
{
    use HasFactory;
    protected $fillable = [

        'penyedia_name',
        'penyedia_address',
        'penyedia_information',
        'penyedia_izin',
    ];
    public function temuans()
    {
        return $this->hasMany(Temuan::class);
    }
}
